#!/usr/bin/env python3
"""Fast pass: decode-fix DB paths + parallel download missing images from fjsti.uz."""

from __future__ import annotations

import json
import re
import subprocess
import tempfile
import unicodedata
from concurrent.futures import ThreadPoolExecutor, as_completed
from pathlib import Path
from urllib.parse import unquote, urljoin
from urllib.request import Request, urlopen

ROOT = Path(r"C:\Users\User\Desktop\LastFjsti")
WEB = ROOT / "frontend" / "web"
LIVE = "https://fjsti.uz"
MYSQL = r"C:\xampp\mysql\bin\mysql.exe"
DB = "ttaff_fjsti"
MYSQL_ARGS = ["-uroot", "--max_allowed_packet=512M", DB]
IMAGE_EXT = {".jpg", ".jpeg", ".png", ".gif", ".webp", ".svg", ".bmp"}

TABLES = {
    "about": ["img"],
    "corusel": ["img"],
    "departments": ["img"],
    "faculty": ["img"],
    "img": ["img"],
    "leader": ["rasm"],
    "logo": ["img"],
    "post": ["img"],
    "useful_sites": ["img"],
    "video": ["video"],
}

IMG_SRC_RE = re.compile(
    r"""(?:src|href)=["'](?P<url>(?:/uploads/|/img/)[^"']+)["']""",
    re.I,
)


def mysql_query(sql: str) -> str:
    p = subprocess.run(
        [MYSQL, *MYSQL_ARGS, "-N", "-B", "-e", sql],
        capture_output=True,
        text=True,
        encoding="utf-8",
        errors="replace",
    )
    if p.returncode != 0:
        raise RuntimeError(p.stderr or p.stdout)
    return p.stdout


def exec_sql_batch(stmts: list[str]) -> None:
    if not stmts:
        return
    with tempfile.NamedTemporaryFile("w", encoding="utf-8", suffix=".sql", delete=False) as f:
        f.write("\n".join(stmts))
        path = f.name
    p = subprocess.run(
        [MYSQL, *MYSQL_ARGS, "-e", f"source {path.replace(chr(92), '/')}"],
        capture_output=True,
        text=True,
        encoding="utf-8",
        errors="replace",
    )
    Path(path).unlink(missing_ok=True)
    if p.returncode != 0:
        raise RuntimeError(p.stderr or p.stdout)


def esc(s: str) -> str:
    return s.replace("\\", "\\\\").replace("'", "''")


def norm(s: str) -> str:
    s = unquote(s.strip().strip("/"))
    s = unicodedata.normalize("NFKC", s).lower().replace("\\", "/")
    return re.sub(r"\s+", " ", s)


def path_variants(p: str) -> list[str]:
    raw = [p, unquote(p)]
    out = set()
    for r in raw:
        r = r.split("?")[0].strip().rstrip("/")
        if not r.startswith("/"):
            r = "/" + r
        out.add(r)
        out.add(unquote(r))
    return list(out)


def build_index() -> dict[str, Path]:
    idx: dict[str, Path] = {}
    for f in WEB.rglob("*"):
        if f.is_file():
            idx[norm(f.relative_to(WEB).as_posix())] = f
    return idx


def resolve(path: str, idx: dict[str, Path]) -> tuple[str | None, str]:
    if not path or path.startswith(("http", "data:")):
        return path, "skip"
    for v in path_variants(path):
        rel = v.lstrip("/")
        fp = WEB / rel.replace("/", "\\")
        if fp.is_file():
            return "/" + rel.replace("\\", "/"), "ok"
        k = norm(rel)
        if k in idx:
            return "/" + idx[k].relative_to(WEB).as_posix(), "index"
    return None, "missing"


def download_one(web_path: str) -> tuple[str, bool]:
    clean = unquote(web_path.split("?")[0].strip()).rstrip("/")
    if not clean.startswith("/"):
        clean = "/" + clean
    ext = Path(clean).suffix.lower()
    if ext and ext not in IMAGE_EXT:
        return web_path, False
    local = WEB / clean.lstrip("/").replace("/", "\\")
    if local.is_file():
        return web_path, True
    local.parent.mkdir(parents=True, exist_ok=True)
    from urllib.parse import quote

    url = LIVE + "/".join(quote(seg, safe="") if seg else "" for seg in clean.split("/"))
    try:
        with urlopen(Request(url, headers={"User-Agent": "FjstiSync/2"}), timeout=20) as r:
            data = r.read()
        if len(data) < 64:
            return web_path, False
        local.write_bytes(data)
        return web_path, True
    except Exception:
        return web_path, False


def main():
    idx = build_index()
    print(f"Indexed {len(idx)} local files")

    # 1) Fix column paths
    col_updates: list[str] = []
    missing: set[str] = set()
    fixed_cols = 0

    for table, cols in TABLES.items():
        sel = ", ".join(["id", *cols])
        for line in mysql_query(f"SELECT {sel} FROM `{table}`").splitlines():
            if not line.strip():
                continue
            parts = line.split("\t")
            rid = parts[0]
            for i, col in enumerate(cols, 1):
                val = parts[i] if i < len(parts) else ""
                if not val:
                    continue
                new, st = resolve(val, idx)
                if st == "missing":
                    missing.add(val)
                elif new and new != val:
                    fixed_cols += 1
                    col_updates.append(f"UPDATE `{table}` SET `{col}`='{esc(new)}' WHERE id={rid};")

    print(f"Column path fixes: {fixed_cols}")
    exec_sql_batch(col_updates)

    # 2) Download missing images in parallel
    print(f"Downloading up to {len(missing)} missing assets...")
    downloaded = 0
    with ThreadPoolExecutor(max_workers=12) as pool:
        futures = {pool.submit(download_one, p): p for p in sorted(missing)}
        for n, fut in enumerate(as_completed(futures), 1):
            _, ok = fut.result()
            if ok:
                downloaded += 1
            if n % 100 == 0:
                print(f"  tried {n}/{len(missing)}, saved {downloaded}")

    idx = build_index()
    print(f"Downloaded {downloaded} files; local total ~{len(idx)}")

    # 3) Fix HTML img src in content columns (encoding only)
    html_tables = {
        "about": ["content_uz", "content_ru", "content_en"],
        "departments": ["content_uz", "content_ru", "content_en"],
        "faculty": ["content_uz", "content_ru", "content_en"],
        "img": ["content_uz", "content_ru", "content_en"],
        "page": ["content_uz", "content_ru", "content_en"],
        "post": ["content_uz", "content_ru", "content_en"],
    }
    html_updates: list[str] = []
    html_rows = 0

    for table, cols in html_tables.items():
        for rid in mysql_query(f"SELECT id FROM `{table}`").splitlines():
            if not rid.strip():
                continue
            for col in cols:
                row = mysql_query(
                    f"SELECT `{col}` FROM `{table}` WHERE id={rid}"
                ).strip()
                if not row:
                    continue

                col_changed = False

                def sub(m: re.Match) -> str:
                    nonlocal col_changed
                    url = m.group("url")
                    new, st = resolve(url, idx)
                    if new and new != url and st != "missing":
                        col_changed = True
                        return m.group(0).replace(url, new)
                    return m.group(0)

                updated = IMG_SRC_RE.sub(sub, row)
                if col_changed:
                    html_rows += 1
                    html_updates.append(
                        f"UPDATE `{table}` SET `{col}`='{esc(updated)}' WHERE id={rid};"
                    )

    print(f"HTML rows to update: {html_rows}")
    for i in range(0, len(html_updates), 15):
        exec_sql_batch(html_updates[i : i + 15])

    stats = {
        "column_fixes": fixed_cols,
        "downloaded": downloaded,
        "html_rows": html_rows,
        "local_files": len(idx),
    }
    out = ROOT / "tools" / "image_fix_report.json"
    out.write_text(json.dumps(stats, indent=2), encoding="utf-8")
    print(json.dumps(stats, indent=2))


if __name__ == "__main__":
    main()
