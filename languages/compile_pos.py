#!/usr/bin/env python3
"""
compile_pos.py - Compile les fichiers .po en .mo pour Arti100
Usage : python compile_pos.py
Prérequis : gettext installé (msgfmt disponible dans PATH)
  - Windows : https://mlocati.github.io/articles/gettext-iconv-windows.html
  - Mac/Linux : sudo apt install gettext / brew install gettext
"""
import os, subprocess, sys

SCRIPT_DIR = os.path.dirname(os.path.abspath(__file__))
LANGS = ['fr_FR', 'en_US', 'es_ES']

for lang in LANGS:
    po_file = os.path.join(SCRIPT_DIR, f'{lang}.po')
    mo_file = os.path.join(SCRIPT_DIR, f'{lang}.mo')
    if not os.path.exists(po_file):
        print(f'[SKIP] {lang}.po introuvable')
        continue
    result = subprocess.run(['msgfmt', po_file, '-o', mo_file], capture_output=True, text=True)
    if result.returncode == 0:
        print(f'[OK]  {lang}.mo compilé')
    else:
        print(f'[ERR] {lang} : {result.stderr.strip()}')
        sys.exit(1)

print('\nTous les fichiers .mo ont été générés avec succès.')
