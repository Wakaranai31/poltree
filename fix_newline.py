import os

directory = r"d:\laragon\www\poltree\resources\views"

changed_files = 0

for root, _, files in os.walk(directory):
    for file in files:
        if file.endswith('.blade.php'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()
            
            if '\\n    {!! config' in content or '} !!}\\n</svg>' in content:
                new_content = content.replace("\\n    {!! config", "\n    {!! config").replace("} !!}\\n</svg>", "} !!}\n</svg>")
                with open(filepath, 'w', encoding='utf-8') as f:
                    f.write(new_content)
                changed_files += 1

print(f"Fixed {changed_files} Blade files.")
