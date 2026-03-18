=== Arti100 ===
Theme URI:    https://arti100.fr
Author:       Arti100
Version:      1.0.0
Requires WP:  6.0
Tested up to: 6.7
Requires PHP: 8.0
License:      GPLv2 or later

Thème WordPress one-page pour artisans, professionnels de santé et PME locales.
100 % configurable depuis l'administration - aucune retouche de code requise.

== Description ==

Arti100 est un thème vitrine clé en main conçu pour les indépendants et petites
entreprises souhaitant une présence web professionnelle rapidement opérationnelle.

Fonctionnalités clés :
- Page d'accueil one-page configurable (hero, services, réalisations, équipe,
  témoignages, contact)
- Section Avant / Après interactive (slider JS) pour les réalisations
- Compteurs animés (statistiques hero)
- 2 modes contact : texte seul ou lien externe (Calendly, Doctolib, WhatsApp…)
- Google Analytics GA4 intégré (ID configurable)
- Schema.org LocalBusiness automatique (SEO local)
- Bouton flottant d'appel (mobile)
- 3 langues incluses : Français, English, Español

== Installation ==

1. Téléchargez et déposez le dossier `arti100` dans `wp-content/themes/`
2. Dans WordPress : Apparence → Thèmes → Activer "Arti100"
3. Allez dans ⚙️ Arti100 (menu gauche) et complétez chaque onglet

== Configuration rapide ==

Après activation, tous les champs affichent « XXX - ... » pour signaler ce qui
doit être personnalisé. Parcourez les 4 onglets dans l'ordre :

=== Onglet Général ===
- Nom & coordonnées de l'entreprise
- Couleurs principale et accent
- Logo (téléversement via médiathèque)
- Section Hero : titre, sous-titre, bouton CTA, image de fond, 3 badges
- Réseaux sociaux : Facebook, Instagram, LinkedIn

=== Onglet Contenu ===
- Activer / désactiver chaque section de la page d'accueil
- Bande de confiance (4 items configurables)
- Statistiques hero (4 chiffres animés)
- Titres et sous-titres de chaque section
- Horaires d'ouverture
- Mode de contact (texte ou lien externe)
- Témoignages clients (6 max)

=== Onglet Intégrations ===
- Calendly : URL pour popup de prise de rendez-vous
- Contact Form 7 : ID du formulaire
- Google Maps : code iframe à coller
- Google Analytics 4 : Measurement ID (G-XXXXXXXXXX)

=== Onglet SEO & Footer ===
- Meta description et image Open Graph
- Texte légal du pied de page (éditeur riche)

== Types de contenu personnalisés (CPT) ==

Arti100 enregistre 3 CPT accessibles dans le menu d'administration :

--- Services ---
Ajoutez vos prestations : titre, description, icône (SVG ou emoji), prix
indicatif, durée, ordre d'affichage.
Menu : Services → Ajouter un service

--- Réalisations (Travaux) ---
Présentez vos chantiers avec photos Avant / Après, témoignage client, durée,
localité. Archive publique accessible sur /realisations/.
Menu : Réalisations → Ajouter un chantier

--- Équipe (Artisans) ---
Présentez votre équipe : photo, poste, courte bio, téléphone direct, LinkedIn.
Menu : Équipe → Ajouter un membre

== Shortcodes ==

[arti100_map]          Affiche la carte Google Maps configurée
[arti100_devis_btn]    Bouton « Devis gratuit » (lien Calendly ou contact)
[arti100_phone]        Affiche le numéro de téléphone en lien tel:
[arti100_services]     Grille des services (utilisable dans une page WP)
[arti100_realisations] Grille des réalisations (utilisable dans une page WP)
[arti100_zone]         Affiche la zone d'intervention

== Langues ==

Dossier languages/ - três fichiers compilés (.mo) :
- fr_FR - Français (langue par défaut)
- en_US - English
- es_ES - Español

Pour ajouter une langue : copiez fr_FR.po, traduisez les msgstr, compilez avec
`python languages/generate_mo.py` ou utilisez Poedit.

== Personnalisation avancée ==

Couleurs      → Onglet Général → Logo & Couleurs (primary, accent)
CSS custom    → Apparence → CSS additionnel (ne pas modifier assets/css/main.css)
Templates     → template-parts/*.php (un fichier par section)
Helpers PHP   → inc/template-functions.php (fonctions utilitaires)
Shortcodes    → inc/shortcodes.php

== Changelog ==

= 1.0.0 =
* Version initiale
