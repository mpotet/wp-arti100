"""
build_translations.py — Arti100
Génère fr_FR.po, en_US.po, es_ES.po complets depuis un dictionnaire centralisé.
Lance ensuite generate_mo.py pour compiler les .mo.
"""
import os, subprocess, sys

DIR = os.path.dirname(os.path.abspath(__file__))

# ------------------------------------------------------------------ #
# Dictionnaire centralisé : msgid -> {'en': ..., 'es': ...}
# msgid = texte source en français
# fr_FR.po = msgid == msgstr (same-as-source)
# ------------------------------------------------------------------ #
STRINGS = {
    # ── Admin navigation & global ─────────────────────────────────────
    "🏠 Général":                       {"en": "🏠 General",                          "es": "🏠 General"},
    "📝 Contenu":                       {"en": "📝 Content",                           "es": "📝 Contenido"},
    "🔌 Intégrations":                  {"en": "🔌 Integrations",                      "es": "🔌 Integraciones"},
    "📈 SEO & Footer":                  {"en": "📈 SEO & Footer",                      "es": "📈 SEO y Pie de página"},
    "Arti100 Settings":                 {"en": "Arti100 Settings",                     "es": "Ajustes de Arti100"},
    "Arti100 — Paramètres du thème":    {"en": "Arti100 — Theme Settings",             "es": "Arti100 — Ajustes del tema"},
    "⚙️ Arti100":                       {"en": "⚙️ Arti100",                           "es": "⚙️ Arti100"},
    "Enregistrer les paramètres":       {"en": "Save Settings",                        "es": "Guardar ajustes"},
    "✅ Paramètres sauvegardés.":       {"en": "✅ Settings saved.",                   "es": "✅ Ajustes guardados."},
    "Choisir image":                    {"en": "Choose image",                         "es": "Elegir imagen"},
    "Afficher":                         {"en": "Show",                                 "es": "Mostrar"},

    # ── Menus & navigation ────────────────────────────────────────────
    "Menu principal":                   {"en": "Main Menu",                            "es": "Menú principal"},
    "Menu pied de page":               {"en": "Footer Menu",                          "es": "Menú de pie de página"},
    "Barre latérale":                  {"en": "Sidebar",                              "es": "Barra lateral"},
    "Footer colonne 1":                {"en": "Footer Column 1",                      "es": "Columna 1 del pie de página"},
    "Aller au contenu":                {"en": "Skip to content",                      "es": "Ir al contenido"},
    "Ouvrir le menu":                  {"en": "Open menu",                            "es": "Abrir menú"},
    "Navigation":                      {"en": "Navigation",                           "es": "Navegación"},
    "Accueil":                         {"en": "Home",                                 "es": "Inicio"},
    "Services":                        {"en": "Services",                             "es": "Servicios"},
    "Réalisations":                    {"en": "Projects",                             "es": "Proyectos"},
    "Équipe":                          {"en": "Team",                                 "es": "Equipo"},
    "Contact":                         {"en": "Contact",                              "es": "Contacto"},
    "Actualités":                      {"en": "News",                                 "es": "Noticias"},

    # ── Hero section ──────────────────────────────────────────────────
    "🦸 Hero Section":                 {"en": "🦸 Hero Section",                      "es": "🦸 Sección principal (Hero)"},
    "Titre principal":                 {"en": "Main title",                           "es": "Título principal"},
    "Sous-titre":                      {"en": "Subtitle",                             "es": "Subtítulo"},
    "Texte CTA bouton":                {"en": "CTA button text",                      "es": "Texto del botón CTA"},
    "Image fond hero (URL)":           {"en": "Hero background image (URL)",          "es": "Imagen de fondo del hero (URL)"},
    "Utilisez \\n pour couper la ligne.": {"en": "Use \\n for line breaks.",          "es": "Use \\n para cortar la línea."},
    "Certifié RGE":                    {"en": "RGE Certified",                        "es": "Certificado RGE"},
    "Assuré RC Pro":                   {"en": "Insured RC Pro",                       "es": "Asegurado RC Pro"},
    "Local":                           {"en": "Local",                                "es": "Local"},
    "Demander un devis gratuit":       {"en": "Get a free quote",                     "es": "Obtener un presupuesto gratuito"},
    "Chantiers réalisés":              {"en": "Completed projects",                   "es": "Proyectos realizados"},
    "D'expérience":                    {"en": "Experience",                           "es": "De experiencia"},
    "Clients satisfaits":              {"en": "Satisfied clients",                    "es": "Clientes satisfechos"},
    "Note Google":                     {"en": "Google rating",                        "es": "Valoración de Google"},
    "Badge 1 (icône ✅)":              {"en": "Badge 1 (icon ✅)",                    "es": "Distintivo 1 (icono ✅)"},
    "Badge 2 (icône 🛡️)":             {"en": "Badge 2 (icon 🛡️)",                   "es": "Distintivo 2 (icono 🛡️)"},
    "Badge 3 (icône 📍)":              {"en": "Badge 3 (icon 📍)",                    "es": "Distintivo 3 (icono 📍)"},
    "Laissez vide pour masquer.":      {"en": "Leave empty to hide.",                 "es": "Dejar vacío para ocultar."},
    "Vide → utilise la Zone d'intervention (Général).": {
        "en": "Empty → uses the Service zone (General tab).",
        "es": "Vacío → usa la Zona de intervención (General)."},
    "Appeler":                         {"en": "Call",                                 "es": "Llamar"},

    # ── Trust strip ───────────────────────────────────────────────────
    "🏅 Bande de confiance (4 éléments)": {"en": "🏅 Trust strip (4 items)",         "es": "🏅 Banda de confianza (4 elementos)"},
    "Bande de confiance (Trust strip)": {"en": "Trust strip",                         "es": "Banda de confianza"},
    "Élément %d":                      {"en": "Item %d",                              "es": "Elemento %d"},
    "Titre":                           {"en": "Title",                                "es": "Título"},
    "Description":                     {"en": "Description",                          "es": "Descripción"},

    # ── Stats admin ───────────────────────────────────────────────────
    "📊 Statistiques (hero)":          {"en": "📊 Statistics (hero)",                "es": "📊 Estadísticas (hero)"},
    "Stat %d":                         {"en": "Stat %d",                              "es": "Estadística %d"},
    "Valeur":                          {"en": "Value",                                "es": "Valor"},
    "Suffixe":                         {"en": "Suffix",                               "es": "Sufijo"},
    "Label":                           {"en": "Label",                                "es": "Etiqueta"},
    "Ex : +, %, \" ans\", \"/5\"":    {"en": "e.g. +, %, \" yrs\", \"/5\"",         "es": "Ej.: +, %, \" años\", \"/5\""},

    # ── Company ───────────────────────────────────────────────────────
    "🏢 Informations entreprise":      {"en": "🏢 Company information",              "es": "🏢 Información de la empresa"},
    "Nom entreprise":                  {"en": "Company name",                         "es": "Nombre de la empresa"},
    "Slogan":                          {"en": "Slogan",                               "es": "Eslogan"},
    "Artisan qualifié près de chez vous.": {"en": "Qualified craftsman near you.",   "es": "Artesano cualificado cerca de usted."},
    "Métier principal":                {"en": "Main trade",                           "es": "Oficio principal"},
    "Téléphone":                       {"en": "Phone",                                "es": "Teléfono"},
    "Email":                           {"en": "Email",                                "es": "Email"},
    "Adresse":                         {"en": "Address",                              "es": "Dirección"},
    "Zone intervention":               {"en": "Service zone",                         "es": "Zona de intervención"},
    "Zone d'intervention":             {"en": "Service area",                         "es": "Zona de intervención"},
    "SIRET":                           {"en": "SIRET",                                "es": "SIRET"},
    "SIRET :":                         {"en": "SIRET:",                               "es": "SIRET:"},
    "Tous droits réservés":            {"en": "All rights reserved",                  "es": "Todos los derechos reservados"},
    "Mentions légales":                {"en": "Legal notice",                         "es": "Aviso legal"},
    "Confidentialité":                 {"en": "Privacy",                              "es": "Privacidad"},

    # ── Logo & Colors ──────────────────────────────────────────────────
    "🖼️ Logo & Couleurs":              {"en": "🖼️ Logo & Colors",                   "es": "🖼️ Logo y colores"},
    "URL du logo":                     {"en": "Logo URL",                             "es": "URL del logo"},
    "Couleur primaire":                {"en": "Primary color",                        "es": "Color primario"},
    "Couleur accent (orange)":         {"en": "Accent color (orange)",                "es": "Color de acento (naranja)"},

    # ── Social media ──────────────────────────────────────────────────
    "📱 Réseaux sociaux":              {"en": "📱 Social media",                      "es": "📱 Redes sociales"},
    "Facebook URL":                    {"en": "Facebook URL",                         "es": "URL de Facebook"},
    "Instagram URL":                   {"en": "Instagram URL",                        "es": "URL de Instagram"},
    "LinkedIn URL":                    {"en": "LinkedIn URL",                         "es": "URL de LinkedIn"},

    # ── Section visibility ────────────────────────────────────────────
    "👁️ Affichage des sections":       {"en": "👁️ Section visibility",              "es": "👁️ Visibilidad de secciones"},
    "Cochez pour afficher une section sur la page d'accueil.": {
        "en": "Check to show a section on the homepage.",
        "es": "Marque para mostrar una sección en la página de inicio."},

    # ── Section titles ────────────────────────────────────────────────
    "✏️ Titres & sous-titres des sections": {
        "en": "✏️ Section titles & subtitles",
        "es": "✏️ Títulos y subtítulos de las secciones"},
    "🔧 Services":                     {"en": "🔧 Services",                          "es": "🔧 Servicios"},
    "🏗️ Réalisations":                 {"en": "🏗️ Projects",                         "es": "🏗️ Proyectos"},
    "👷 Équipe":                       {"en": "👷 Team",                              "es": "👷 Equipo"},
    "⭐ Témoignages":                  {"en": "⭐ Testimonials",                      "es": "⭐ Testimonios"},
    "📬 Contact":                      {"en": "📬 Contact",                           "es": "📬 Contacto"},
    "Note globale (ex: 4.9)":          {"en": "Overall rating (e.g. 4.9)",            "es": "Valoración global (ej: 4.9)"},

    # ── Opening hours ─────────────────────────────────────────────────
    "🕐 Horaires d'ouverture":         {"en": "🕐 Opening hours",                    "es": "🕐 Horario de apertura"},
    "Lundi – Vendredi":                {"en": "Monday – Friday",                     "es": "Lunes – Viernes"},
    "Lun – Ven":                       {"en": "Mon – Fri",                           "es": "Lun – Vie"},
    "Samedi":                          {"en": "Saturday",                             "es": "Sábado"},
    "Dimanche":                        {"en": "Sunday",                               "es": "Domingo"},
    "Fermé":                           {"en": "Closed",                               "es": "Cerrado"},
    "Horaires":                        {"en": "Opening hours",                        "es": "Horarios"},

    # ── Contact mode ──────────────────────────────────────────────────
    "📞 Mode de contact":              {"en": "📞 Contact mode",                     "es": "📞 Modo de contacto"},
    "Choisissez comment les visiteurs peuvent vous contacter. Dans les deux cas, le téléphone, l'email et les horaires sont affichés.": {
        "en": "Choose how visitors can contact you. In both cases, phone, email and hours are displayed.",
        "es": "Elija cómo pueden contactarle los visitantes. En ambos casos se muestran el teléfono, el email y los horarios."},
    "Mode":                            {"en": "Mode",                                 "es": "Modo"},
    "Texte uniquement — affiche téléphone, email et horaires": {
        "en": "Text only — displays phone, email and opening hours",
        "es": "Solo texto — muestra teléfono, email y horarios"},
    "Lien externe — ajoute un bouton vers un site de RDV / contact": {
        "en": "External link — adds a button to an appointment / contact site",
        "es": "Enlace externo — añade un botón a un sitio de citas / contacto"},
    "URL du lien (mode Lien)":         {"en": "Link URL (Link mode)",                 "es": "URL del enlace (modo Enlace)"},
    "Calendly, Doctolib, WhatsApp, Google Forms, etc.": {
        "en": "Calendly, Doctolib, WhatsApp, Google Forms, etc.",
        "es": "Calendly, Doctolib, WhatsApp, Google Forms, etc."},
    "Texte du bouton (mode Lien)":     {"en": "Button text (Link mode)",              "es": "Texto del botón (modo Enlace)"},

    # ── Testimonials admin ────────────────────────────────────────────
    "💬 Témoignages clients (6 max)": {
        "en": "💬 Customer testimonials (6 max)",
        "es": "💬 Testimonios de clientes (6 máx.)"},
    "Ces témoignages s'affichent si aucun avis n'est renseigné dans les Réalisations (CPT). Laissez le texte vide pour masquer un témoignage.": {
        "en": "These testimonials are shown if no review is set in Projects (CPT). Leave the text empty to hide a testimonial.",
        "es": "Estos testimonios se muestran si no hay reseñas en Proyectos (CPT). Deje el texto vacío para ocultar un testimonio."},
    "Témoignage %d":                   {"en": "Testimonial %d",                       "es": "Testimonio %d"},
    "Nom":                             {"en": "Name",                                 "es": "Nombre"},
    "Localité":                        {"en": "City / Area",                          "es": "Localidad"},
    "Texte":                           {"en": "Text",                                 "es": "Texto"},
    "Note (1-5)":                      {"en": "Rating (1-5)",                         "es": "Valoración (1-5)"},
    "Témoignages clients":             {"en": "Customer testimonials",                "es": "Testimonios de clientes"},
    "Témoin client":                   {"en": "Customer",                             "es": "Cliente"},

    # ── Integrations ──────────────────────────────────────────────────
    "📅 Prise de RDV Calendly":        {"en": "📅 Calendly Appointment Booking",     "es": "📅 Reserva de citas con Calendly"},
    "URL Calendly":                    {"en": "Calendly URL",                         "es": "URL de Calendly"},
    "Votre lien personnel Calendly. Un popup s'ouvrira au clic sur \"Prendre RDV\".": {
        "en": "Your personal Calendly link. A popup will open when clicking \"Book an appointment\".",
        "es": "Su enlace personal de Calendly. Se abrirá un popup al hacer clic en \"Reservar cita\"."},
    "📧 Contact Form 7 (ID du formulaire)": {
        "en": "📧 Contact Form 7 (form ID)",
        "es": "📧 Contact Form 7 (ID del formulario)"},
    "ID du formulaire CF7":            {"en": "CF7 form ID",                          "es": "ID del formulario CF7"},
    "Trouvez l'ID dans Contact → Formulaires de contact.": {
        "en": "Find the ID under Contact → Contact Forms.",
        "es": "Encuentre el ID en Contacto → Formularios de contacto."},
    "📊 Google Analytics":             {"en": "📊 Google Analytics",                 "es": "📊 Google Analytics"},
    "GA4 Measurement ID":              {"en": "GA4 Measurement ID",                  "es": "ID de medición GA4"},
    "🗺️ Google Maps":                  {"en": "🗺️ Google Maps",                      "es": "🗺️ Google Maps"},
    "Code embed iframe":               {"en": "Embed iframe code",                   "es": "Código iframe embebido"},
    "Collez l'iframe Google Maps ici. Utiliser aussi le shortcode [arti100_map] dans les pages.": {
        "en": "Paste the Google Maps iframe here. Also use the shortcode [arti100_map] on pages.",
        "es": "Pegue el iframe de Google Maps aquí. También puede usar el shortcode [arti100_map] en las páginas."},
    "Carte non configurée. Ajoutez l'embed dans Arti100 → Intégrations.": {
        "en": "Map not configured. Add the embed code under Arti100 → Integrations.",
        "es": "Mapa no configurado. Añada el código embed en Arti100 → Integraciones."},

    # ── SEO & Footer ──────────────────────────────────────────────────
    "🔍 Meta SEO":                     {"en": "🔍 Meta SEO",                         "es": "🔍 Meta SEO"},
    "Meta description homepage":       {"en": "Homepage meta description",            "es": "Meta descripción de la página de inicio"},
    "Image Open Graph":                {"en": "Open Graph image",                    "es": "Imagen Open Graph"},
    "📄 Pied de page légal":           {"en": "📄 Legal footer",                     "es": "📄 Pie de página legal"},
    "Texte pied de page":              {"en": "Footer text",                          "es": "Texto del pie de página"},

    # ── CPT: services ─────────────────────────────────────────────────
    "Service":                         {"en": "Service",                              "es": "Servicio"},
    "Nouveau service":                 {"en": "New service",                          "es": "Nuevo servicio"},
    "Modifier le service":             {"en": "Edit service",                         "es": "Editar servicio"},
    "Détails du service":              {"en": "Service details",                      "es": "Detalles del servicio"},
    "Ajouter un service":              {"en": "Add a service",                        "es": "Añadir un servicio"},
    "Toutes nos prestations":          {"en": "All our services",                     "es": "Todos nuestros servicios"},
    "Aucun service trouvé.":           {"en": "No service found.",                    "es": "Ningún servicio encontrado."},
    "Aucun service configuré. Allez dans Services → Ajouter un service.": {
        "en": "No service configured. Go to Services → Add a service.",
        "es": "Ningún servicio configurado. Vaya a Servicios → Añadir un servicio."},
    "Prix indicatif":                  {"en": "Estimated price",                      "es": "Precio orientativo"},
    "Durée indicative":                {"en": "Estimated duration",                   "es": "Duración aproximada"},
    "Icône (SVG inline ou emoji)":     {"en": "Icon (inline SVG or emoji)",           "es": "Ícono (SVG en línea o emoji)"},
    "Ordre d'affichage":               {"en": "Display order",                        "es": "Orden de visualización"},

    # ── CPT: travaux ──────────────────────────────────────────────────
    "Réalisations / Portfolio":        {"en": "Projects / Portfolio",                 "es": "Proyectos / Portfolio"},
    "Travaux":                         {"en": "Projects",                             "es": "Proyectos"},
    "Travail":                         {"en": "Work",                                 "es": "Trabajo"},
    "Nouveau chantier":                {"en": "New project",                          "es": "Nuevo proyecto"},
    "Modifier le chantier":            {"en": "Edit project",                         "es": "Editar proyecto"},
    "Voir le chantier":                {"en": "View project",                         "es": "Ver proyecto"},
    "Ajouter un chantier":             {"en": "Add a project",                        "es": "Añadir un proyecto"},
    "Détails du chantier":             {"en": "Project details",                      "es": "Detalles del proyecto"},
    "Aucun chantier trouvé":           {"en": "No project found",                     "es": "No se encontraron proyectos"},
    "Aucune réalisation trouvée.":     {"en": "No project found.",                    "es": "Ningún proyecto encontrado."},
    "Aucune réalisation pour le moment. Revenez bientôt !": {
        "en": "No project yet. Check back soon!",
        "es": "Ningún proyecto por el momento. ¡Vuelva pronto!"},
    "Photo AVANT (URL)":               {"en": "BEFORE photo (URL)",                   "es": "Foto ANTES (URL)"},
    "Photo APRÈS (URL)":               {"en": "AFTER photo (URL)",                    "es": "Foto DESPUÉS (URL)"},
    "Durée chantier":                  {"en": "Project duration",                     "es": "Duración del proyecto"},
    "Localité":                        {"en": "City / Area",                          "es": "Localidad"},
    "Type":                            {"en": "Type",                                 "es": "Tipo"},
    "Types de travaux":                {"en": "Types of work",                        "es": "Tipos de trabajos"},

    # ── CPT: artisan ──────────────────────────────────────────────────
    "Membre":                          {"en": "Member",                               "es": "Miembro"},
    "Nouveau\xa0membre" if False else "Ajouter un membre": {"en": "Add a member",     "es": "Añadir un miembro"},
    "Ajouter un membre":               {"en": "Add a member",                         "es": "Añadir un miembro"},
    "Profil du membre":                {"en": "Member profile",                       "es": "Perfil del miembro"},
    "Poste / Métier":                  {"en": "Position / Trade",                     "es": "Puesto / Oficio"},
    "Bio courte":                      {"en": "Short bio",                            "es": "Biografía breve"},
    "LinkedIn de %s":                  {"en": "%s's LinkedIn",                        "es": "LinkedIn de %s"},
    "Téléphone direct":                {"en": "Direct phone",                         "es": "Teléfono directo"},

    # ── Frontend: services section ────────────────────────────────────
    "Ce que nous faisons":             {"en": "What we do",                           "es": "Lo que hacemos"},
    "Nos services":                    {"en": "Our services",                         "es": "Nuestros servicios"},
    "Des prestations professionnelles pour tous vos travaux, réalisées avec soin et garanties.": {
        "en": "Professional services for all your projects, carried out with care and guaranteed.",
        "es": "Servicios profesionales para todos sus trabajos, realizados con cuidado y garantizados."},
    "En savoir plus sur %s":           {"en": "Learn more about %s",                  "es": "Más información sobre %s"},
    "En savoir plus":                  {"en": "Learn more",                           "es": "Más información"},
    "Obtenir un devis gratuit":        {"en": "Get a free quote",                     "es": "Obtener un presupuesto gratuito"},
    "Aucun service publié.":           {"en": "No service published.",                "es": "Ningún servicio publicado."},
    "Ajouter des services →":          {"en": "Add services →",                       "es": "Añadir servicios →"},

    # ── Frontend: portfolio section ───────────────────────────────────
    "Nos réalisations":                {"en": "Our projects",                         "es": "Nuestros proyectos"},
    "Nos chantiers":                   {"en": "Our work",                             "es": "Nuestros proyectos"},
    "Découvrez nos derniers travaux réalisés avec professionnalisme.": {
        "en": "Discover our latest projects, carried out with professionalism.",
        "es": "Descubra nuestros últimos proyectos, realizados con profesionalismo."},
    "Avant travaux — %s":              {"en": "Before — %s",                          "es": "Antes — %s"},
    "Après travaux — %s":              {"en": "After — %s",                           "es": "Después — %s"},
    "Avant":                           {"en": "Before",                               "es": "Antes"},
    "Après":                           {"en": "After",                                "es": "Después"},
    "Curseur avant/après":             {"en": "Before/after slider",                  "es": "Control deslizante antes/después"},
    "Voir le détail":                  {"en": "View details",                         "es": "Ver detalles"},
    "Voir toutes les réalisations":    {"en": "View all projects",                    "es": "Ver todos los proyectos"},
    "Aucune réalisation publiée.":     {"en": "No project published.",                "es": "Ningún proyecto publicado."},
    "Ajouter des réalisations →":      {"en": "Add projects →",                       "es": "Añadir proyectos →"},

    # ── Frontend: team section ────────────────────────────────────────
    "Notre équipe":                    {"en": "Our team",                             "es": "Nuestro equipo"},
    "Des pros à votre service":        {"en": "Professionals at your service",        "es": "Profesionales a su servicio"},
    "Une équipe qualifiée, passionnée et disponible pour tous vos travaux.": {
        "en": "A qualified, passionate team available for all your projects.",
        "es": "Un equipo cualificado, apasionado y disponible para todos sus proyectos."},
    "Aucun membre d'équipe publié.":   {"en": "No team member published.",            "es": "Ningún miembro del equipo publicado."},
    "Ajouter des artisans →":          {"en": "Add team members →",                   "es": "Añadir artesanos →"},

    # ── Frontend: testimonials section ───────────────────────────────
    "Ils nous font confiance":         {"en": "They trust us",                        "es": "Confían en nosotros"},
    "Avis de nos clients":             {"en": "Customer reviews",                     "es": "Opiniones de nuestros clientes"},
    "sur Google":                      {"en": "on Google",                            "es": "en Google"},
    "Aucun témoignage configuré.":     {"en": "No testimonials configured.",          "es": "Ningún testimonio configurado."},
    "Ajouter des témoignages →":       {"en": "Add testimonials →",                   "es": "Añadir testimonios →"},
    "ou publier des réalisations avec un avis client.": {
        "en": "or publish projects with a customer review.",
        "es": "o publicar proyectos con una opinión de cliente."},

    # ── Frontend: contact section ─────────────────────────────────────
    "Contactez-nous":                  {"en": "Contact us",                           "es": "Contáctenos"},
    "Nos coordonnées":                 {"en": "Our contact details",                  "es": "Nuestros datos de contacto"},
    "Texte de présentation":           {"en": "Presentation text",                    "es": "Texto de presentación"},
    "Texte libre affiché sous le titre, au-dessus des coordonnées. Laissez vide pour masquer.": {
        "en": "Free text displayed below the title, above the contact details. Leave empty to hide.",
        "es": "Texto libre mostrado bajo el título, encima de los datos de contacto. Dejar vacío para ocultar."},
    "Demandez votre devis gratuit":    {"en": "Request your free quote",              "es": "Solicite su presupuesto gratuito"},
    "Réponse sous 24h · Devis gratuit et sans engagement": {
        "en": "Response within 24h · Free and non-binding quote",
        "es": "Respuesta en 24h · Presupuesto gratuito y sin compromiso"},
    "Contactez-nous directement":      {"en": "Contact us directly",                  "es": "Contáctenos directamente"},
    "Téléphone":                       {"en": "Phone",                                "es": "Teléfono"},
    "Zone d'intervention":             {"en": "Service area",                         "es": "Zona de intervención"},
    "Prendre rendez-vous en ligne":    {"en": "Book an appointment online",           "es": "Reservar una cita en línea"},
    "Mode « Lien » activé mais aucune URL configurée.": {
        "en": '"Link" mode enabled but no URL configured.',
        "es": 'Modo «Enlace» activado pero sin URL configurada.'},
    "Configurer →":                    {"en": "Configure →",                          "es": "Configurar →"},
    "Contactez-nous gratuitement, sans engagement.": {
        "en": "Contact us for free, without commitment.",
        "es": "Contáctenos de forma gratuita, sin compromiso."},
    "Contactez-nous dès aujourd'hui.": {"en": "Contact us today.",                    "es": "Contáctenos hoy mismo."},

    # ── XXX placeholder defaults (traductibles) ───────────────────────
    "XXX - Votre titre principal":       {"en": "XXX - Your main title",                "es": "XXX - Su título principal"},
    "XXX - Votre sous-titre descriptif · Devis gratuit": {
        "en": "XXX - Your descriptive subtitle · Free quote",
        "es": "XXX - Su subtítulo descriptivo · Presupuesto gratuito"},
    "XXX - Badge 1":                     {"en": "XXX - Badge 1",                        "es": "XXX - Distintivo 1"},
    "XXX - Badge 2":                     {"en": "XXX - Badge 2",                        "es": "XXX - Distintivo 2"},
    "XXX - Badge 3":                     {"en": "XXX - Badge 3",                        "es": "XXX - Distintivo 3"},
    "XXX - Certification 1":             {"en": "XXX - Certification 1",                "es": "XXX - Certificación 1"},
    "XXX - Description cert. 1":         {"en": "XXX - Cert. description 1",            "es": "XXX - Descripción cert. 1"},
    "XXX - Certification 2":             {"en": "XXX - Certification 2",                "es": "XXX - Certificación 2"},
    "XXX - Description cert. 2":         {"en": "XXX - Cert. description 2",            "es": "XXX - Descripción cert. 2"},
    "XXX - Certification 3":             {"en": "XXX - Certification 3",                "es": "XXX - Certificación 3"},
    "XXX - Description cert. 3":         {"en": "XXX - Cert. description 3",            "es": "XXX - Descripción cert. 3"},
    "XXX - Note / 5 ★★★★★":            {"en": "XXX - Score / 5 ★★★★★",               "es": "XXX - Nota / 5 ★★★★★"},
    "XXX - xxx avis Google":             {"en": "XXX - xxx Google reviews",             "es": "XXX - xxx reseñas Google"},
    "XXX - Titre services":              {"en": "XXX - Services title",                 "es": "XXX - Título servicios"},
    "XXX - Sous-titre services":         {"en": "XXX - Services subtitle",              "es": "XXX - Subtítulo servicios"},
    "XXX - Titre réalisations":          {"en": "XXX - Projects title",                 "es": "XXX - Título proyectos"},
    "XXX - Sous-titre réalisations":     {"en": "XXX - Projects subtitle",              "es": "XXX - Subtítulo proyectos"},
    "XXX - Titre équipe":                {"en": "XXX - Team title",                     "es": "XXX - Título equipo"},
    "XXX - Sous-titre équipe":           {"en": "XXX - Team subtitle",                  "es": "XXX - Subtítulo equipo"},
    "XXX - Titre avis clients":          {"en": "XXX - Customer reviews title",         "es": "XXX - Título reseñas"},
    "XXX - Titre contact":               {"en": "XXX - Contact title",                  "es": "XXX - Título contacto"},
    "XXX - Sous-titre contact":          {"en": "XXX - Contact subtitle",               "es": "XXX - Subtítulo contacto"},
    "XXX - Horaires lundi-vendredi":     {"en": "XXX - Mon–Fri hours",                  "es": "XXX - Horario lun–vie"},
    "XXX - Horaires samedi":             {"en": "XXX - Saturday hours",                 "es": "XXX - Horario sábado"},
    "XXX - Horaires dimanche":           {"en": "XXX - Sunday hours",                   "es": "XXX - Horario domingo"},
    "XXX - Texte du bouton":             {"en": "XXX - Button text",                    "es": "XXX - Texto del botón"},
    "XXX - Votre téléphone":             {"en": "XXX - Your phone number",              "es": "XXX - Su teléfono"},
    "XXX - Votre email":                 {"en": "XXX - Your email address",             "es": "XXX - Su correo electrónico"},
    "XXX - Votre zone d'intervention":   {"en": "XXX - Your service area",              "es": "XXX - Su zona de intervención"},
    "XXX - Nom entreprise":              {"en": "XXX - Company name",                   "es": "XXX - Nombre de empresa"},

    # ── Frontend: general ─────────────────────────────────────────────
    "Devis gratuit":                   {"en": "Free Quote",                           "es": "Presupuesto gratuito"},
    "Demandez un devis gratuit":       {"en": "Request a free quote",                 "es": "Solicitar un presupuesto gratuito"},
    "Besoin d'un artisan rapidement ?": {
        "en": "Need a craftsman quickly?",
        "es": "¿Necesita un artesano rápidamente?"},
    "Besoin d'un devis ?":             {"en": "Need a quote?",                        "es": "¿Necesita un presupuesto?"},
    "Tous droits réservés":            {"en": "All rights reserved",                  "es": "Todos los derechos reservados"},
    "Admin":                           {"en": "Admin",                                "es": "Admin"},
    "Fil d'Ariane":                    {"en": "Breadcrumb",                           "es": "Ruta de navegación"},
    "%d étoiles sur 5":                {"en": "%d stars out of 5",                    "es": "%d estrellas sobre 5"},
    "Demandez un devis similaire":     {"en": "Request a similar quote",              "es": "Solicitar un presupuesto similar"},
    "Toutes les réalisations":         {"en": "All projects",                         "es": "Todos los proyectos"},
    "Intervention sur %s.":            {"en": "Serving %s.",                          "es": "Intervención en %s."},
    "[Devis] %s — %s":                 {"en": "[Quote] %s — %s",                     "es": "[Presupuesto] %s — %s"},
    "Lire la suite":                   {"en": "Read more",                            "es": "Leer más"},
    "Suivant":                         {"en": "Next",                                 "es": "Siguiente"},
    "Précédent":                       {"en": "Previous",                             "es": "Anterior"},
    "Tous":                            {"en": "All",                                  "es": "Todos"},
    "Rien à afficher":                 {"en": "Nothing to display",                   "es": "Nada que mostrar"},
    "Corbeille vide":                  {"en": "Empty trash",                          "es": "Papelera vacía"},
    "Rechercher":                      {"en": "Search",                               "es": "Buscar"},
    "Résultats pour \"%s\"":           {"en": "Results for \"%s\"",                   "es": "Resultados para \"%s\""},
    "Aucun contenu ne correspond à votre recherche.": {
        "en": "No content matches your search.",
        "es": "Ningún contenido corresponde a su búsqueda."},
    "Aucun contenu pour le moment":    {"en": "No content for now",                   "es": "Sin contenido por el momento"},
    "Page introuvable":                {"en": "Page not found",                       "es": "Página no encontrada"},
    "Retour à l'accueil":              {"en": "Back to homepage",                     "es": "Volver al inicio"},
    "La page que vous cherchez n'existe pas ou a été déplacée.": {
        "en": "The page you are looking for doesn't exist or has been moved.",
        "es": "La página que busca no existe o ha sido trasladada."},
    "Nous trouver":                    {"en": "Find us",                              "es": "Encuéntrenos"},
    "Nous vous recontacterons dans les plus brefs délais.": {
        "en": "We will get back to you as soon as possible.",
        "es": "Nos pondremos en contacto con usted lo antes posible."},
}

# ------------------------------------------------------------------ #
PO_HEADER_FR = """# French (France) translations for Arti100
# Copyright (C) 2025 Maxim Potet
#
msgid ""
msgstr ""
"Project-Id-Version: Arti100 1.0.0\\n"
"Language: fr_FR\\n"
"MIME-Version: 1.0\\n"
"Content-Type: text/plain; charset=UTF-8\\n"
"Content-Transfer-Encoding: 8bit\\n"
"Plural-Forms: nplurals=2; plural=(n > 1);\\n"

"""

PO_HEADER_EN = """# English (US) translations for Arti100
# Copyright (C) 2025 Maxim Potet
#
msgid ""
msgstr ""
"Project-Id-Version: Arti100 1.0.0\\n"
"Language: en_US\\n"
"MIME-Version: 1.0\\n"
"Content-Type: text/plain; charset=UTF-8\\n"
"Content-Transfer-Encoding: 8bit\\n"
"Plural-Forms: nplurals=2; plural=(n != 1);\\n"

"""

PO_HEADER_ES = """# Spanish (Spain) translations for Arti100
# Copyright (C) 2025 Maxim Potet
#
msgid ""
msgstr ""
"Project-Id-Version: Arti100 1.0.0\\n"
"Language: es_ES\\n"
"MIME-Version: 1.0\\n"
"Content-Type: text/plain; charset=UTF-8\\n"
"Content-Transfer-Encoding: 8bit\\n"
"Plural-Forms: nplurals=2; plural=(n != 1);\\n"

"""


def write_po(path, header, entries):
    """Write a .po file with given entries as list of (msgid, msgstr)."""
    lines = [header]
    for msgid, msgstr in entries:
        # Escape double-quotes inside strings
        mid = msgid.replace('"', '\\"')
        mst = msgstr.replace('"', '\\"')
        lines.append(f'msgid "{mid}"\nmsgstr "{mst}"\n')
    with open(path, 'w', encoding='utf-8') as f:
        f.write('\n'.join(lines))
    print(f'[OK] {os.path.basename(path)} — {len(entries)} chaînes')


# Build entry lists
fr_entries = [(k, k) for k in STRINGS]
en_entries = [(k, v['en']) for k, v in STRINGS.items()]
es_entries = [(k, v['es']) for k, v in STRINGS.items()]

write_po(os.path.join(DIR, 'fr_FR.po'), PO_HEADER_FR, fr_entries)
write_po(os.path.join(DIR, 'en_US.po'), PO_HEADER_EN, en_entries)
write_po(os.path.join(DIR, 'es_ES.po'), PO_HEADER_ES, es_entries)

# Recompile .mo
print('\nCompilation .mo…')
result = subprocess.run([sys.executable, os.path.join(DIR, 'generate_mo.py')],
                        capture_output=True, text=True, cwd=DIR)
print(result.stdout or result.stderr)
