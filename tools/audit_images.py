#!/usr/bin/env python3
from pathlib import Path
from urllib.parse import unquote
import subprocess

WEB = Path(r"C:\Users\User\Desktop\LastFjsti\frontend\web")
MYSQL = [r"C:\xampp\mysql\bin\mysql.exe", "-uroot", "-N", "-B", "ttaff_fjsti", "-e"]

checks = [
    ("corusel", "SELECT img FROM corusel WHERE status=1"),
    ("faculty", "SELECT img FROM faculty WHERE status=1"),
    ("departments", "SELECT img FROM departments WHERE status=1"),
    ("post", "SELECT img FROM post WHERE status=1 AND img != '' LIMIT 300"),
    ("leader", "SELECT rasm FROM leader WHERE status=1"),
    ("logo", "SELECT img FROM logo WHERE status=1"),
]

print("=== IMAGE AUDIT ===")
for name, sql in checks:
    proc = subprocess.run(MYSQL + [sql], capture_output=True, text=True, encoding="utf-8", errors="replace")
    lines = [l.strip() for l in proc.stdout.splitlines() if l.strip()]
    ok = miss = 0
    samples = []
    for line in lines:
        p = unquote(line)
        fp = WEB / p.lstrip("/").replace("/", "\\")
        if fp.is_file():
            ok += 1
        else:
            miss += 1
            if len(samples) < 3:
                samples.append(p)
    print(f"{name}: {ok} OK, {miss} missing")
    for s in samples:
        print(f"  - {s}")

print(f"\nLocal upload files: {sum(1 for _ in WEB.rglob('*') if _.is_file() and 'uploads' in _.as_posix())}")
