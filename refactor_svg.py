import os
import re
import json

# Define the mapping of inner SVG to config key
icon_mapping = {
    '<line x1="18" y1="6" x2="6" y2="18"></line>\\n                        <line x1="6" y1="6" x2="18" y2="18"></line>': 'ui_tutup',
    '<line x1="18" y1="6" x2="6" y2="18"></line>\\n                    <line x1="6" y1="6" x2="18" y2="18"></line>': 'ui_tutup',
    '<line x1="18" y1="6" x2="6" y2="18"></line>\\n                            <line x1="6" y1="6" x2="18" y2="18"></line>': 'ui_tutup',
    '<line x1="18" y1="6" x2="6" y2="18"></line>\\n                                <line x1="6" y1="6" x2="18" y2="18"></line>': 'ui_tutup',
    '<line x1="18" y1="6" x2="6" y2="18"></line>\\n            <line x1="6" y1="6" x2="18" y2="18"></line>': 'ui_tutup',

    '<polyline points="6 9 12 15 18 9"></polyline>': 'ui_panah_bawah',
    '<polyline points="20 6 9 17 4 12"></polyline>': 'ui_centang',

    '<circle cx="11" cy="11" r="8"></circle>\\n                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>': 'ui_cari',
    
    '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>\\n                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>': 'ui_edit',
    '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>\\n                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>': 'ui_edit',
    '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>': 'ui_edit',
    '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>\\n                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4L18.5 2.5z"></path>': 'ui_edit',

    '<polyline points="3 6 5 6 21 6"></polyline>\\n                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>': 'ui_hapus',
    '<polyline points="3 6 5 6 21 6"></polyline>\\n                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>': 'ui_hapus',
    '<polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>': 'ui_hapus',
    '<polyline points="3 6 5 6 21 6"></polyline>\\n                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>': 'ui_hapus',
    '<polyline points="3 6 5 6 21 6"></polyline>\\n                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>': 'ui_hapus',

    '<circle cx="12" cy="12" r="10"></circle>\\n                            <line x1="12" y1="8" x2="12" y2="12"></line>\\n                            <line x1="12" y1="16" x2="12.01" y2="16"></line>': 'ui_peringatan',
    '<circle cx="12" cy="12" r="10"></circle>\\n                        <line x1="12" y1="8" x2="12" y2="12"></line>\\n                        <line x1="12" y1="16" x2="12.01" y2="16"></line>': 'ui_peringatan',
    '<circle cx="12" cy="12" r="10"></circle>\\n                        <line x1="12" y1="9" x2="12" y2="13"></line>\\n                        <line x1="12" y1="17" x2="12.01" y2="17"></line>': 'ui_peringatan_alt',

    '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4m7 14l5-5-5-5m5 5H9" />': 'ui_keluar',
    
    '<line x1="3" y1="12" x2="21" y2="12"></line>\\n                        <line x1="3" y1="6" x2="21" y2="6"></line>\\n                        <line x1="3" y1="18" x2="21" y2="18"></line>': 'ui_menu',
    '<line x1="3" y1="6" x2="21" y2="6" />\\n                <line x1="3" y1="12" x2="21" y2="12" />\\n                <line x1="3" y1="18" x2="21" y2="18" />': 'ui_menu',

    '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>\\n                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>': 'ui_tautan',

    '<path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>\\n                        <polyline points="17 21 17 13 7 13 7 21"></polyline>\\n                        <polyline points="7 3 7 8 15 8"></polyline>': 'ui_simpan',
}

# Format the mapping so newlines match what's in the files
icon_mapping = {k.replace("\\n", "\n"): v for k, v in icon_mapping.items()}

# Replace in blade files
directory = r"d:\laragon\www\poltree\resources\views"
svg_regex = re.compile(r'(<svg[^>]*>)(.*?)(</svg>)', re.DOTALL | re.IGNORECASE)

changed_files = 0

for root, _, files in os.walk(directory):
    for file in files:
        if file.endswith('.blade.php'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()
            
            new_content = content
            def replacer(match):
                prefix = match.group(1)
                inner = match.group(2)
                suffix = match.group(3)
                
                stripped = inner.strip()
                if stripped in icon_mapping:
                    name = icon_mapping[stripped]
                    return f"{prefix}\n    {{!! config('icons.{name}') !!}}\n{suffix}"
                return match.group(0)
                
            new_content = svg_regex.sub(replacer, content)
            
            if new_content != content:
                with open(filepath, 'w', encoding='utf-8') as f:
                    f.write(new_content)
                changed_files += 1

print(f"Refactored {changed_files} Blade files.")
