#!/usr/bin/env python3
"""
generate_mo.py - Génère les fichiers .mo depuis les .po sans msgfmt externe.
Usage : python generate_mo.py
"""
import os, struct, array

def parse_po(filepath):
    """Parse un .po et retourne dict {msgid: msgstr}"""
    translations = {}
    msgid = msgstr = None
    in_msgid = in_msgstr = False
    with open(filepath, encoding='utf-8') as f:
        for line in f:
            line = line.rstrip('\n')
            if line.startswith('#') or line == '':
                if msgid is not None and msgstr is not None:
                    translations[msgid] = msgstr
                msgid = msgstr = None
                in_msgid = in_msgstr = False
                continue
            if line.startswith('msgid "'):
                if msgid is not None and msgstr is not None:
                    translations[msgid] = msgstr
                raw = line[7:]
                if raw.endswith('"'): raw = raw[:-1]
                msgid = raw.replace('\\"', '"').replace('\\n', '\n').replace('\\t', '\t')
                msgstr = None
                in_msgid = True; in_msgstr = False
            elif line.startswith('msgstr "'):
                raw = line[8:]
                if raw.endswith('"'): raw = raw[:-1]
                msgstr = raw.replace('\\"', '"').replace('\\n', '\n').replace('\\t', '\t')
                in_msgid = False; in_msgstr = True
            elif line.startswith('"') and line.endswith('"'):
                raw = line[1:-1].replace('\\"', '"').replace('\\n', '\n').replace('\\t', '\t')
                if in_msgid and msgid is not None:
                    msgid += raw
                elif in_msgstr and msgstr is not None:
                    msgstr += raw
    if msgid is not None and msgstr is not None:
        translations[msgid] = msgstr
    # Remove empty msgstr
    return {k: v for k, v in translations.items() if v}

def write_mo(translations, filepath):
    """Génère un fichier .mo binaire (little-endian)."""
    keys = sorted(translations.keys())
    offsets = []
    ids = b''
    strs = b''
    for key in keys:
        offsets.append((len(ids), len(key.encode('utf-8'))))
        ids += key.encode('utf-8') + b'\x00'
    t_offsets = []
    for key in keys:
        val = translations[key].encode('utf-8')
        t_offsets.append((len(strs), len(val)))
        strs += val + b'\x00'
    n = len(keys)
    # Header: 28 bytes
    # Original strings table starts at 28, 8 bytes per entry = 28 + 8n
    # Translated strings table starts at 28 + 8n, 8 bytes per entry = 28 + 16n
    # Strings data starts at 28 + 16n
    keystart = 28 + 16 * n
    valuestart = keystart + len(ids)
    with open(filepath, 'wb') as f:
        f.write(struct.pack('<II', 0x950412de, 0))  # magic + revision
        f.write(struct.pack('<I', n))                # number of strings
        f.write(struct.pack('<I', 28))               # offset of orig table
        f.write(struct.pack('<I', 28 + 8 * n))       # offset of trans table
        f.write(struct.pack('<II', 0, 0))             # hash table (unused)
        for i, (off, length) in enumerate(offsets):
            f.write(struct.pack('<II', length, keystart + off))
        for i, (off, length) in enumerate(t_offsets):
            f.write(struct.pack('<II', length, valuestart + off))
        f.write(ids)
        f.write(strs)

SCRIPT_DIR = os.path.dirname(os.path.abspath(__file__))
LANGS = ['fr_FR', 'en_US', 'es_ES']

for lang in LANGS:
    po_file = os.path.join(SCRIPT_DIR, f'{lang}.po')
    mo_file = os.path.join(SCRIPT_DIR, f'{lang}.mo')
    if not os.path.exists(po_file):
        print(f'[SKIP] {lang}.po introuvable')
        continue
    try:
        translations = parse_po(po_file)
        write_mo(translations, mo_file)
        print(f'[OK]  {lang}.mo généré ({len(translations)} chaînes)')
    except Exception as e:
        print(f'[ERR] {lang} : {e}')

print('\nTerminé.')
