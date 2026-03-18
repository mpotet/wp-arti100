"""Extract all translatable strings from PHP files and compare with .po files."""
import re, os, glob, sys

sys.stdout.reconfigure(encoding='utf-8')

theme_dir = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

# Extract strings from PHP files
php_strings = set()
pattern = re.compile(r"""(?:__|_e|esc_html_e|esc_attr_e|esc_html__|esc_attr__|esc_html_x)\s*\(\s*'((?:[^'\\]|\\.)*)'\s*,\s*'arti100'""")
for f in glob.glob(os.path.join(theme_dir, '**', '*.php'), recursive=True):
    try:
        content = open(f, encoding='utf-8').read()
        for m in pattern.finditer(content):
            php_strings.add(m.group(1))
    except Exception as e:
        print(f'ERROR reading {f}: {e}')

# Parse .po file
def parse_po(path):
    ids = set()
    try:
        content = open(path, encoding='utf-8').read()
        for m in re.finditer(r'msgid\s+"((?:[^"\\]|\\.)*)"', content):
            s = m.group(1)
            if s:
                ids.add(s)
        for m in re.finditer(r"msgid\s+'((?:[^'\\]|\\.)*)'", content):
            s = m.group(1)
            if s:
                ids.add(s)
    except Exception as e:
        print(f'ERROR reading {path}: {e}')
    return ids

en_ids = parse_po(os.path.join(theme_dir, 'languages', 'en_US.po'))
es_ids = parse_po(os.path.join(theme_dir, 'languages', 'es_ES.po'))

print(f'PHP strings found: {len(php_strings)}')
print(f'en_US.po msgids:   {len(en_ids)}')
print(f'es_ES.po msgids:   {len(es_ids)}')

missing_en = sorted(php_strings - en_ids)
missing_es = sorted(php_strings - es_ids)

print(f'\n=== Missing from en_US.po ({len(missing_en)}) ===')
for s in missing_en:
    print(f'  {s}')

print(f'\n=== Missing from es_ES.po ({len(missing_es)}) ===')
for s in missing_es:
    print(f'  {s}')

print(f'\n=== All PHP strings ({len(php_strings)}) ===')
for s in sorted(php_strings):
    print(f'  {s}')


theme_dir = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

# Extract strings from PHP files
php_strings = set()
pattern = re.compile(r"""(?:__|_e|esc_html_e|esc_attr_e|esc_html__|esc_attr__|esc_html_x)\s*\(\s*'((?:[^'\\]|\\.)*)'\s*,\s*'arti100'""")
for f in glob.glob(os.path.join(theme_dir, '**', '*.php'), recursive=True):
    try:
        content = open(f, encoding='utf-8').read()
        for m in pattern.finditer(content):
            php_strings.add(m.group(1))
    except Exception as e:
        print(f'ERROR reading {f}: {e}')

# Parse .po file
def parse_po(path):
    ids = set()
    try:
        content = open(path, encoding='utf-8').read()
        for m in re.finditer(r'msgid\s+"((?:[^"\\]|\\.)*)"', content):
            s = m.group(1)
            if s:
                ids.add(s)
        # Also single-quoted style
        for m in re.finditer(r"msgid\s+'((?:[^'\\]|\\.)*)'", content):
            s = m.group(1)
            if s:
                ids.add(s)
    except Exception as e:
        print(f'ERROR reading {path}: {e}')
    return ids

en_ids = parse_po(os.path.join(theme_dir, 'languages', 'en_US.po'))
es_ids = parse_po(os.path.join(theme_dir, 'languages', 'es_ES.po'))

print(f'PHP strings found: {len(php_strings)}')
print(f'en_US.po msgids: {len(en_ids)}')
print(f'es_ES.po msgids: {len(es_ids)}')

missing_en = php_strings - en_ids
missing_es = php_strings - es_ids

print(f'\n=== Missing from en_US.po ({len(missing_en)}) ===')
for s in sorted(missing_en):
    print(f'  {repr(s)}')

print(f'\n=== Missing from es_ES.po ({len(missing_es)}) ===')
for s in sorted(missing_es):
    print(f'  {repr(s)}')

print(f'\n=== All PHP strings ({len(php_strings)}) ===')
for s in sorted(php_strings):
    print(f'  {repr(s)}')
