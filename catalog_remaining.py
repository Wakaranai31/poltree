import os
import re

directory = r"d:\laragon\www\poltree\resources\views"
svg_regex = re.compile(r'<svg[^>]*>(.*?)</svg>', re.DOTALL | re.IGNORECASE)

remaining = {}

for root, _, files in os.walk(directory):
    for file in files:
        if file.endswith('.blade.php'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()
                matches = svg_regex.finditer(content)
                for match in matches:
                    inner = match.group(1).strip()
                    # Skip if it's already using config or dynamic
                    if '{!!' in inner or '{{' in inner or '@if' in inner:
                        continue
                    # Check if it has actual hardcoded shapes
                    if not any(tag in inner.lower() for tag in ['<path', '<circle', '<line', '<rect', '<polyline', '<polygon']):
                        continue
                    
                    if inner not in remaining:
                        remaining[inner] = []
                    relpath = os.path.relpath(filepath, directory)
                    remaining[inner].append(relpath)

# Write to markdown
md = "# Daftar Ikon Hardcode yang Belum Di-Refactor\n\n"
md += "Berikut adalah daftar ikon statis yang masih ada di dalam file Blade Anda:\n\n"

sorted_rem = sorted(remaining.items(), key=lambda x: len(x[1]), reverse=True)

for i, (inner, paths) in enumerate(sorted_rem):
    md += f"### Ikon {i+1} (Digunakan di {len(paths)} lokasi)\n"
    md += "```html\n" + inner.strip() + "\n```\n"
    md += "**Lokasi:**\n"
    for p in set(paths):
        md += f"- `{p}`\n"
    md += "\n---\n\n"

with open(r"C:\Users\wan\.gemini\antigravity-ide\brain\b8729d13-0bf5-440c-ba5d-9f302e3c4b1c\remaining_icons.md", "w", encoding='utf-8') as f:
    f.write(md)

print(f"Found {len(sorted_rem)} remaining unique SVGs.")
