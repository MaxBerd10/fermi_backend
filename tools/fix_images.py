#!/usr/bin/env python3
"""Analyze/fix DB media paths and download missing files from live fjsti.uz."""

from __future__ import annotations

import json
import re
import subprocess
import tempfile
import unicodedata
from pathlib import Path
from urllib.parse import unquote, urljoin
from urllib.request import Request, urlopen

ROOT = Path(r"C:\Users\User\Desktop\LastFjsti")
WEB = ROOT / "frontend" / "web"
LIVE = "https://fjsti.uz"
MYSQL = r"C:\xampp\mysql\bin\mysql.exe"
DB = "ttaff_fjsti"
MYSQL_ARGS = ["-uroot", "--max_allowed_packet=512M", DB]

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

CONTENT_TABLES = {
    "about": ["content_uz", "content_ru", "content_en"],
    "departments": ["content_uz", "content_ru", "content_en"],
    "faculty": ["content_uz", "content_ru", "content_en"],
    "img": ["content_uz", "content_ru", "content_en"],
    "page": ["content_uz", "content_ru", "content_en"],
    "post": ["content_uz", "content_ru", "content_en"],
}

IMG_SRC_RE = re.compile(
    r"""(?P<attr>src|href)=["'](?P<url>(?:/uploads/|/img/|uploads/|img/)[^"']+)["']""",
    re.I,
)


def run_mysql(sql: str) -> str:
    proc = subprocess.run(
        [MYSQL, *MYSQL_ARGS, "-N", "-B", "-e", sql],
        capture_output=True,
        text=True,
        encoding="utf-8",
        errors="replace",
    )
    if proc.returncode != 0:
        raise RuntimeError(proc.stderr.strip() or proc.stdout)
    return proc.stdout


def exec_sql_file(statements: list[str]) -> None:
    if not statements:
        return
    with tempfile.NamedTemporaryFile("w", encoding="utf-8", suffix=".sql", delete=False) as tmp:
        tmp.write("\n".join(statements))
        path = tmp.name
    proc = subprocess.run(
        [MYSQL, *MYSQL_ARGS, "-e", f"source {path.replace(chr(92), '/')}"],
        capture_output=True,
        text=True,
        encoding="utf-8",
        errors="replace",
    )
    Path(path).unlink(missing_ok=True)
    if proc.returncode != 0:
        raise RuntimeError(proc.stderr.strip() or proc.stdout)


def sql_escape(value: str) -> str:
    return value.replace("\\", "\\\\").replace("'", "''")


def normalize_key(value: str) -> str:
    value = unquote(value.strip().strip("/"))
    value = value.replace("\\", "/").lower()
    value = unicodedata.normalize("NFKC", value)
    value = re.sub(r"\s+", " ", value)
    return value.rstrip("/")


def variants(path: str) -> list[str]:
    raw = unquote(path.split("?")[0].strip()).rstrip("/")
    out = {raw, raw.lstrip("/"), "/" + raw.lstrip("/")}
    # common mojibake from SQL dumps on Windows
    reps = {
        "bo%E2%80%98": "bo'",
        "O%E2%80%98": "O'",
        "o%E2%80%98": "o'",
        "bo\u0432\u0402\u0458": "bo'",
        "O\u0432\u0402\u0458": "O'",
    }
    encoded = path
    for a, b in reps.items():
        encoded = encoded.replace(a, b)
    out.add(unquote(encoded.split("?")[0].strip()).rstrip("/"))
    return list(out)


def build_file_index() -> dict[str, Path]:
    index: dict[str, Path] = {}
    for path in WEB.rglob("*"):
        if path.is_file():
            index[normalize_key(path.relative_to(WEB).as_posix())] = path
    return index


def resolve_path(web_path: str, index: dict[str, Path]) -> tuple[str | None, str]:
    if not web_path or web_path.startswith(("http", "data:")):
        return web_path, "external"

    for candidate in variants(web_path):
        rel = candidate.lstrip("/")
        local = WEB / rel.replace("/", "\\")
        if local.is_file():
            fixed = "/" + rel.replace("\\", "/")
            return fixed, "ok" if candidate == unquote(web_path.split("?")[0].strip()) else "decoded"

        key = normalize_key(rel)
        if key in index:
            fixed = "/" + index[key].relative_to(WEB).as_posix()
            return fixed, "index"

    return None, "missing"


def download_missing(web_path: str) -> bool:
    clean = unquote(web_path.split("?")[0].strip()).rstrip("/")
    if not clean.startswith("/"):
        clean = "/" + clean
    url = urljoin(LIVE, quote_path(clean))
    local = WEB / clean.lstrip("/").replace("/", "\\")
    local.parent.mkdir(parents=True, exist_ok=True)
    try:
        req = Request(url, headers={"User-Agent": "FjstiAssetSync/1.0"})
        with urlopen(req, timeout=30) as resp:
            data = resp.read()
        if len(data) < 32:
            return False
        local.write_bytes(data)
        return True
    except Exception:
        return False


def quote_path(path: str) -> str:
    from urllib.parse import quote

    parts = path.split("/")
    return "/".join(quote(p, safe="") if p else "" for p in parts)


def collect_paths() -> set[str]:
    paths: set[str] = set()

    for table, columns in TABLES.items():
        cols = ", ".join(["id"] + columns)
        for row in run_mysql(f"SELECT {cols} FROM `{table}`").splitlines():
            if not row.strip():
                continue
            parts = row.split("\t")
            for i, _col in enumerate(columns, start=1):
                val = parts[i] if i < len(parts) else ""
                if val and not val.startswith(("http", "data:")):
                    paths.add(val)

    for table, columns in CONTENT_TABLES.items():
        for row_id in run_mysql(f"SELECT id FROM `{table}`").splitlines():
            if not row_id.strip():
                continue
            cols = ", ".join(["id"] + columns)
            row = run_mysql(f"SELECT {cols} FROM `{table}` WHERE id={row_id}").strip()
            if not row:
                continue
            content = "\t".join(row.split("\t")[1:])
            for m in IMG_SRC_RE.finditer(content):
                paths.add(m.group("url"))

    return paths


def apply_fixes(dry_run: bool) -> dict:
    index = build_file_index()
    stats = {"ok": 0, "fixed": 0, "missing": 0, "downloaded": 0, "column_updates": [], "html_updates": 0}
    col_sql: list[str] = []

    for table, columns in TABLES.items():
        cols = ", ".join(["id"] + columns)
        for row in run_mysql(f"SELECT {cols} FROM `{table}`").splitlines():
            if not row.strip():
                continue
            parts = row.split("\t")
            row_id = parts[0]
            for i, col in enumerate(columns, start=1):
                val = parts[i] if i < len(parts) else ""
                if not val:
                    continue
                fixed, status = resolve_path(val, index)
                if status in ("ok", "external", "decoded", "index"):
                    if fixed == val or status == "ok":
                        stats["ok"] += 1
                    else:
                        stats["fixed"] += 1
                        stats["column_updates"].append({"table": table, "id": row_id, "column": col, "from": val, "to": fixed})
                        col_sql.append(f"UPDATE `{table}` SET `{col}`='{sql_escape(fixed)}' WHERE id={row_id};")
                else:
                    stats["missing"] += 1
                    if not dry_run and download_missing(val):
                        stats["downloaded"] += 1
                        index = build_file_index()

    html_sql: list[str] = []
    for table, columns in CONTENT_TABLES.items():
        for row_id in run_mysql(f"SELECT id FROM `{table}`").splitlines():
            if not row_id.strip():
                continue
            cols = ", ".join(["id"] + columns)
            row = run_mysql(f"SELECT {cols} FROM `{table}` WHERE id={row_id}").strip()
            if not row:
                continue
            parts = row.split("\t")
            changed = False
            new_values: dict[str, str] = {}
            for i, col in enumerate(columns, start=1):
                content = parts[i] if i < len(parts) else ""
                if not content:
                    continue

                def repl(match: re.Match, _index=index) -> str:
                    nonlocal changed
                    url = match.group("url")
                    fixed, status = resolve_path(url, _index)
                    if fixed and fixed != url and status != "missing":
                        changed = True
                        return f'{match.group("attr")}="{fixed}"'
                    if status == "missing" and not dry_run and download_missing(url):
                        stats["downloaded"] += 1
                        _index.update(build_file_index())
                        fixed2, status2 = resolve_path(url, _index)
                        if fixed2 and status2 != "missing":
                            changed = True
                            return f'{match.group("attr")}="{fixed2}"'
                    return match.group(0)

                new_values[col] = IMG_SRC_RE.sub(repl, content)

            if changed:
                stats["html_updates"] += 1
                for col in columns:
                    idx = columns.index(col) + 1
                    old = parts[idx] if idx < len(parts) else ""
                    new = new_values.get(col, old)
                    if new != old:
                        html_sql.append(
                            f"UPDATE `{table}` SET `{col}`='{sql_escape(new)}' WHERE id={row_id};"
                        )

    if not dry_run:
        for chunk_start in range(0, len(col_sql), 100):
            exec_sql_file(col_sql[chunk_start : chunk_start + 100])
        for chunk_start in range(0, len(html_sql), 20):
            exec_sql_file(html_sql[chunk_start : chunk_start + 20])

    return stats


def main():
    import argparse

    parser = argparse.ArgumentParser()
    parser.add_argument("--apply", action="store_true")
    args = parser.parse_args()

    print("Scanning paths...")
    paths = collect_paths()
    print(f"Unique media paths referenced: {len(paths)}")

    stats = apply_fixes(dry_run=not args.apply)
    print(json.dumps(stats, ensure_ascii=False, indent=2))

    report = ROOT / "tools" / "image_fix_report.json"
    report.write_text(json.dumps(stats, ensure_ascii=False, indent=2), encoding="utf-8")
    print(f"Report: {report}")
    if not args.apply:
        print("Dry run. Use --apply to fix DB and download missing files from fjsti.uz")


if __name__ == "__main__":
    main()
