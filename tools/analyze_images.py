import re
import os
from pathlib import Path
from urllib.parse import unquote

ROOT = Path(r"C:\Users\User\Desktop\LastFjsti")
WEB = ROOT / "frontend" / "web"
SQL = ROOT / "ttaff_fjsti.sql"

IMG_PATTERNS = [
    re.compile(r'["\'](/uploads/[^"\']+)["\']', re.I),
    re.compile(r'["\'](/img/[^"\']+)["\']', re.I),
    re.compile(r'["\'](uploads/[^"\']+)["\']', re.I),
    re.compile(r'["\'](img/[^"\']+)["\']', re.I),
    re.compile(r"src=['\"]([^'\"]+\.(?:jpg|jpeg|png|gif|webp|svg|pdf))['\"]", re.I),
]

# also column values like '/uploads/img/...'
COL_PATTERN = re.compile(r"'(/uploads/[^']+)'", re.I)


def normalize_path(p: str) -> str:
    p = unquote(p.strip())
    if p.startswith("http://") or p.startswith("https://"):
        return p
    if not p.startswith("/"):
        p = "/" + p
    return p.replace("\\", "/")


def exists_local(web_path: str) -> bool:
    if web_path.startswith("http"):
        return True
    rel = web_path.lstrip("/")
    return (WEB / rel).exists()


def find_case_insensitive(web_path: str):
    rel = web_path.lstrip("/")
    target = WEB / rel
    if target.exists():
        return str(target.relative_to(WEB)).replace("\\", "/")

    parts = rel.split("/")
    cur = WEB
    resolved = []
    for part in parts:
        if not cur.exists():
            return None
        matches = [c for c in cur.iterdir() if c.name.lower() == part.lower()]
        if not matches:
            return None
        cur = matches[0]
        resolved.append(cur.name)
    if cur.is_file():
        return "/".join(resolved)
    return None


def main():
    text = SQL.read_text(encoding="utf-8", errors="ignore")
    refs = set()
    for pat in IMG_PATTERNS:
        refs.update(normalize_path(m) for m in pat.findall(text))
    refs.update(normalize_path(m) for m in COL_PATTERN.findall(text))

    refs = {r for r in refs if not r.startswith("http") and "data:image" not in r}

    missing = []
    case_fix = []
    ok = 0
    for r in sorted(refs):
        if exists_local(r):
            ok += 1
            continue
        alt = find_case_insensitive(r)
        if alt:
            case_fix.append((r, "/" + alt))
        else:
            missing.append(r)

    print(f"Total unique image refs in SQL: {len(refs)}")
    print(f"OK locally: {ok}")
    print(f"Case mismatch fixable: {len(case_fix)}")
    print(f"Missing: {len(missing)}")
    print("\n--- Sample case fixes ---")
    for a, b in case_fix[:15]:
        print(f"  {a}\n    -> {b}")
    print("\n--- Sample missing ---")
    for m in missing[:25]:
        print(f"  {m}")

    out = ROOT / "tools" / "image_report.txt"
    out.write_text(
        "\n".join([
            f"OK: {ok}",
            f"CASE: {len(case_fix)}",
            f"MISSING: {len(missing)}",
            "",
            "CASE FIXES:",
            *[f"{a} -> {b}" for a, b in case_fix],
            "",
            "MISSING:",
            *missing,
        ]),
        encoding="utf-8",
    )
    print(f"\nReport: {out}")


if __name__ == "__main__":
    main()
