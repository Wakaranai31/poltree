import os
import re
import json

directory = r"d:\laragon\www\poltree\resources\views"
svg_regex = re.compile(r'<svg[^>]*>(.*?)</svg>', re.DOTALL | re.IGNORECASE)

unique_svgs = {}

for root, _, files in os.walk(directory):
    for file in files:
        if file.endswith('.blade.php'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()
                matches = svg_regex.findall(content)
                for match in matches:
                    inner = match.strip()
                    if not inner or '{!!' in inner or '{{' in inner or '@if' in inner:
                        continue
                    
                    if inner not in unique_svgs:
                        unique_svgs[inner] = []
                    unique_svgs[inner].append(filepath)

res = []
for inner, paths in unique_svgs.items():
    if len(paths) >= 1:
        res.append({
            'count': len(paths),
            'inner': inner,
            'paths': list(set([os.path.relpath(p, directory) for p in paths]))
        })

res.sort(key=lambda x: x['count'], reverse=True)

with open(r"d:\laragon\www\poltree\svg_report.json", "w") as f:
    json.dump(res, f, indent=2)

print("Saved report to svg_report.json")
