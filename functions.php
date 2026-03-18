<?php
/**
 * Arti100 - functions.php
 * Thème WordPress pour artisans locaux.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'ARTI100_VERSION', '1.0.0' );
define( 'ARTI100_DIR',     get_template_directory() );
define( 'ARTI100_URI',     get_template_directory_uri() );

/* =========================================================
   1. SETUP
   ========================================================= */
function arti100_setup() {
	load_theme_textdomain( 'arti100', ARTI100_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
	add_theme_support( 'custom-logo', [
		'height'      => 80,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
	] );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );

	set_post_thumbnail_size( 1200, 800, true );
	add_image_size( 'arti100-card',     600, 400, true );
	add_image_size( 'arti100-portrait', 400, 500, true );
	add_image_size( 'arti100-square',   400, 400, true );

	register_nav_menus( [
		'primary' => __( 'Menu principal', 'arti100' ),
		'footer'  => __( 'Menu pied de page', 'arti100' ),
	] );
}
add_action( 'after_setup_theme', 'arti100_setup' );

/* =========================================================
   2. ENQUEUE ASSETS
   ========================================================= */
function arti100_enqueue_assets() {
	// Polices Google
	wp_enqueue_style( 'arti100-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap',
		[], null );
	// Material Symbols Outlined (icônes UI)
	wp_enqueue_style( 'arti100-material-icons',
		'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200',
		[], null );
	// Bootstrap Icons (réseaux sociaux et marques)
	wp_enqueue_style( 'arti100-bootstrap-icons',
		'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
		[], '1.11.3' );
	// Styles thème
	wp_enqueue_style( 'arti100-main', ARTI100_URI . '/assets/css/main.css',
		[ 'arti100-fonts', 'arti100-material-icons', 'arti100-bootstrap-icons' ], ARTI100_VERSION );
	wp_add_inline_style( 'arti100-main',
		'.arti100-empty-notice{display:flex;align-items:flex-start;gap:10px;background:#fff3cd;border-left:4px solid #f0b429;border-radius:0 6px 6px 0;padding:16px 20px;margin:24px 0;font-size:14px;color:#7a5c00}'
		. '.arti100-empty-notice .material-symbols-outlined{font-size:20px;flex-shrink:0;margin-top:1px}'
		. '.arti100-empty-notice p{margin:0}.arti100-empty-notice a{color:#007CBA;text-decoration:underline}'
		. '@media(max-width:768px){.fab-phone{display:flex!important}}'
		. '.fab-phone{display:none;position:fixed;bottom:1.4rem;right:1.4rem;z-index:9998;width:56px;height:56px;border-radius:50%;background:var(--color-accent,#F5821F);color:#fff;align-items:center;justify-content:center;box-shadow:0 4px 16px rgba(0,0,0,.25);text-decoration:none;transition:transform .2s}'
		. '.fab-phone:hover{transform:scale(1.08)}'
		. '.fab-phone .material-symbols-outlined{font-size:28px}'
		/* Trust strip - icônes visibles + cercle accent */
		. '.trust-strip{padding:.25rem 0}'
		. '.trust-strip-inner{padding:1.75rem 1.5rem;gap:0;align-items:stretch}'
		. '.trust-item{flex:1 1 0;flex-direction:column;align-items:center;text-align:center;gap:.6rem;padding:1.25rem 1rem;border-right:1px solid var(--color-border)}'
		. '.trust-item:last-child{border-right:none}'
		. '.trust-icon{font-size:2.4rem!important;flex-shrink:0;color:var(--color-accent,#F5821F);width:3.4rem;height:3.4rem;background:rgba(245,130,31,.1);border-radius:50%;display:flex;align-items:center;justify-content:center}'
		. '.trust-item strong{font-size:.95rem;line-height:1.3}'
		. '.trust-item span{font-size:.82rem;margin-top:0}'
		. '@media(max-width:900px){.trust-item{flex:1 1 45%;border-right:none;border-bottom:1px solid var(--color-border)}}'
		. '@media(max-width:480px){.trust-item{flex:1 1 100%;flex-direction:row;align-items:center;text-align:left;gap:1rem;border-bottom:1px solid var(--color-border)}}'
		/* Contact section - redesign */
		. '.contact-intro-text{max-width:640px;margin:0 auto;text-align:center;color:var(--color-text-muted);font-size:1rem;line-height:1.7}'
		. '.contact-panels{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-top:2.5rem}'
		. '.contact-panel{border-radius:var(--radius-md);padding:2rem;display:flex;flex-direction:column;gap:1.5rem}'
		. '.contact-panel-info{background:#fff;border:1px solid var(--color-border);box-shadow:var(--shadow-md)}'
		. '.contact-panel-hours{background:var(--color-bg-dark);color:#fff}'
		. '.contact-panel-title{display:flex;align-items:center;gap:.75rem;font-family:var(--font-heading);font-size:1.1rem;font-weight:700;margin:0;padding-bottom:1.25rem;border-bottom:1px solid var(--color-border)}'
		. '.contact-panel-hours .contact-panel-title{border-bottom-color:rgba(255,255,255,.15);color:#fff}'
		. '.contact-panel-title-icon{flex-shrink:0;width:2.4rem;height:2.4rem;border-radius:50%;background:var(--color-primary-light);display:flex;align-items:center;justify-content:center;color:var(--color-primary)}'
		. '.contact-panel-title-icon .material-symbols-outlined{font-size:1.2rem}'
		. '.contact-panel-hours .contact-panel-title-icon{background:rgba(255,255,255,.12);color:#fff}'
		. '.contact-details-list{list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:1.1rem}'
		. '.contact-details-list li{display:flex;align-items:center;gap:.9rem}'
		. '.contact-detail-icon{flex-shrink:0;width:2.75rem;height:2.75rem;border-radius:50%;background:var(--color-primary-light);display:flex;align-items:center;justify-content:center;color:var(--color-primary)}'
		. '.contact-detail-icon--accent{background:rgba(245,130,31,.12);color:var(--color-accent)}'
		. '.contact-detail-icon .material-symbols-outlined{font-size:1.2rem}'
		. '.contact-detail-body{display:flex;flex-direction:column;gap:.1rem}'
		. '.contact-detail-label{font-size:.75rem;color:var(--color-text-muted);text-transform:uppercase;letter-spacing:.05em;font-weight:600}'
		. '.contact-detail-value{font-weight:600;font-size:.95rem;color:var(--color-dark);text-decoration:none}'
		. 'a.contact-detail-value:hover{color:var(--color-primary)}'
		. '.contact-detail-primary{font-size:1.2rem!important;font-weight:800!important;color:var(--color-primary)!important}'
		. 'a.contact-detail-primary:hover{color:var(--color-primary-dark)!important}'
		. '.contact-cta-btn{margin-top:auto;display:inline-flex;width:100%;justify-content:center}'
		. '.contact-panel-hours .hours-list{gap:.5rem}'
		. '.contact-panel-hours .hours-list li{border-bottom-color:rgba(255,255,255,.1);color:rgba(255,255,255,.75);font-size:.92rem}'
		. '.contact-panel-hours .hours-list li span:last-child{color:#fff;font-weight:700}'
		. '.contact-map-full{margin-top:1.5rem;border-radius:var(--radius-md);overflow:hidden;box-shadow:var(--shadow-md)}'
		. '.contact-map-full iframe{width:100%;height:320px;display:block;border:0}'
		. '@media(max-width:768px){.contact-panels{grid-template-columns:1fr}}'
		/* Footer - fond continu + centrage copyright */
		. '.site-footer{background:var(--color-bg-dark)}'
		. '.footer-bottom-inner{justify-content:center;gap:2rem}'
		/* About section */
		. '.about-section{background:var(--color-bg-light,#f8f8f6)}'
		. '.about-inner{display:grid;gap:3rem;align-items:center;margin-top:2.5rem}'
		. '.about-has-image{grid-template-columns:1fr 1fr}'
		. '.about-no-image{grid-template-columns:1fr;max-width:760px;margin-left:auto;margin-right:auto}'
		. '.about-image-wrap{border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow-lg)}'
		. '.about-image{width:100%;height:100%;object-fit:cover;display:block;max-height:480px}'
		. '.about-body{display:flex;flex-direction:column;gap:1.25rem}'
		. '.about-text{color:var(--color-text);line-height:1.8;font-size:1rem;white-space:pre-line}'
		. '@media(max-width:768px){.about-has-image{grid-template-columns:1fr}.about-image{max-height:280px}}'
	);

	// Scripts
	wp_enqueue_script( 'arti100-main', ARTI100_URI . '/assets/js/main.js', [], ARTI100_VERSION, true );

	// Localise JS
	wp_localize_script( 'arti100-main', 'arti100', [
		'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
		'nonce'         => wp_create_nonce( 'arti100_nonce' ),
		'calendlyUrl'   => esc_url( get_option( 'arti100_calendly_url', '' ) ),
		'phoneNumber'   => esc_html( get_option( 'arti100_phone', '' ) ),
		'homeUrl'       => home_url( '/' ),
	] );

	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'arti100_enqueue_assets' );

/* =========================================================
   ADMIN - Enqueue media library on settings page
   ========================================================= */
add_action( 'admin_enqueue_scripts', function() {
	if ( isset( $_GET['page'] ) && $_GET['page'] === 'arti100-settings' ) {
		wp_enqueue_media();
	}
} );

/* =========================================================
   FLUSH REWRITE RULES (activation thème)
   ========================================================= */
function arti100_flush_rewrite_rules() {
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'arti100_flush_rewrite_rules' );

/* =========================================================
   3. CUSTOM POST TYPES
   ========================================================= */
require_once ARTI100_DIR . '/inc/cpt.php';

/* =========================================================
   4. INC FILES
   ========================================================= */
require_once ARTI100_DIR . '/inc/customizer.php';
require_once ARTI100_DIR . '/inc/template-functions.php';
require_once ARTI100_DIR . '/inc/shortcodes.php';

if ( is_admin() ) {
	require_once ARTI100_DIR . '/inc/admin-settings.php';
}

/* =========================================================
   5. WIDGETS
   ========================================================= */
function arti100_widgets_init() {
	register_sidebar( [
		'name'          => __( 'Barre latérale', 'arti100' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	] );
	register_sidebar( [
		'name'          => __( 'Footer colonne 1', 'arti100' ),
		'id'            => 'footer-1',
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="footer-widget-title">',
		'after_title'   => '</h4>',
	] );
}
add_action( 'widgets_init', 'arti100_widgets_init' );

/* =========================================================
   6. SCHEMA.ORG LOCAL BUSINESS
   ========================================================= */
function arti100_schema_local_business() {
	if ( ! is_front_page() ) return;

	$name    = get_option( 'arti100_company_name', get_bloginfo( 'name' ) );
	$phone   = get_option( 'arti100_phone', '' );
	$email   = get_option( 'arti100_email', '' );
	$address = get_option( 'arti100_address', '' );
	$zone    = get_option( 'arti100_zone', '' );
	$logo    = get_option( 'arti100_logo_url', '' ) ?: get_option( 'arti100_og_image', '' );

	$schema = [
		'@context'    => 'https://schema.org',
		'@type'       => 'LocalBusiness',
		'name'        => $name,
		'url'         => home_url( '/' ),
		'priceRange'  => '€€',
	];

	if ( $phone )  $schema['telephone']  = $phone;
	if ( $email )  $schema['email']      = $email;
	if ( $logo )   $schema['image']      = $logo;
	if ( $zone )   $schema['areaServed'] = $zone;

	if ( $address ) {
		$schema['address'] = [
			'@type'         => 'PostalAddress',
			'streetAddress' => $address,
		];
	}

	// Horaires d'ouverture
	$hours_lv  = get_option( 'arti100_hours_lv',  '' );
	$hours_sam = get_option( 'arti100_hours_sam', '' );
	$hours_dim = get_option( 'arti100_hours_dim', '' );
	$opening   = [];

	if ( $hours_lv && ! str_starts_with( $hours_lv, 'XXX' ) ) {
		$opening[] = [
			'@type'       => 'OpeningHoursSpecification',
			'dayOfWeek'   => [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ],
			'description' => $hours_lv,
		];
	}
	if ( $hours_sam && ! str_starts_with( $hours_sam, 'XXX' ) ) {
		$opening[] = [
			'@type'       => 'OpeningHoursSpecification',
			'dayOfWeek'   => [ 'Saturday' ],
			'description' => $hours_sam,
		];
	}
	if ( $hours_dim && ! str_starts_with( $hours_dim, 'XXX' ) ) {
		$opening[] = [
			'@type'       => 'OpeningHoursSpecification',
			'dayOfWeek'   => [ 'Sunday' ],
			'description' => $hours_dim,
		];
	}
	if ( $opening ) {
		$schema['openingHoursSpecification'] = $opening;
	}

	// Note globale (aggregateRating)
	$note = get_option( 'arti100_temos_note', '' );
	if ( $note && ! str_starts_with( $note, 'XXX' ) && is_numeric( $note ) ) {
		$schema['aggregateRating'] = [
			'@type'       => 'AggregateRating',
			'ratingValue' => (float) $note,
			'bestRating'  => 5,
			'worstRating' => 1,
		];
	}

	echo '<script type="application/ld+json">' . "\n";
	echo wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . "\n";
	echo '</script>' . "\n";
}
add_action( 'wp_head', 'arti100_schema_local_business' );

/* =========================================================
   7. GA4 & META TAGS (front-end seulement)
   ========================================================= */
function arti100_inject_ga4() {
	$ga_id = get_option( 'arti100_ga_id', '' );
	if ( empty( $ga_id ) ) return;
	?>
	<!-- Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $ga_id ); ?>"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', '<?php echo esc_js( $ga_id ); ?>');
	</script>
	<?php
}
add_action( 'wp_head', 'arti100_inject_ga4' );

function arti100_meta_tags() {
	if ( ! is_front_page() ) return;
	$desc  = get_option( 'arti100_meta_desc', '' );
	$image = get_option( 'arti100_og_image', '' );
	$title = get_option( 'arti100_company_name', get_bloginfo( 'name' ) );
	if ( $desc ) {
		echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( home_url( '/' ) ) . '">' . "\n";
	if ( $image ) {
		echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
	}
	echo '<meta property="og:type" content="website">' . "\n";
}
add_action( 'wp_head', 'arti100_meta_tags' );

/* =========================================================
   8. EXCERPT
   ========================================================= */
function arti100_excerpt_length( $length ) { return 25; }
add_filter( 'excerpt_length', 'arti100_excerpt_length' );

function arti100_excerpt_more( $more ) { return '…'; }
add_filter( 'excerpt_more', 'arti100_excerpt_more' );

/* =========================================================
   9. CLEANUP
   ========================================================= */
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_generator' );

/* =========================================================
   10. LANGUAGE SWITCHER - Admin Frontend Preview
   ========================================================= */

/**
 * Save locale choice in cookie and redirect to clean URL.
 * Triggered by ?arti100_lang=XX (admin only).
 */
add_action( 'init', 'arti100_handle_lang_switch', 1 );
function arti100_handle_lang_switch() {
	if ( is_admin() || ! is_user_logged_in() || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( ! isset( $_GET['arti100_lang'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		return;
	}
	$lang    = sanitize_text_field( wp_unslash( $_GET['arti100_lang'] ) ); // phpcs:ignore WordPress.Security.NonceVerification
	$allowed = [ 'fr_FR', 'en_US', 'es_ES' ];
	$ssl     = is_ssl();
	if ( 'reset' === $lang ) {
		setcookie( 'arti100_preview_lang', '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN, $ssl, true );
	} elseif ( in_array( $lang, $allowed, true ) ) {
		setcookie( 'arti100_preview_lang', $lang, 0, COOKIEPATH, COOKIE_DOMAIN, $ssl, true );
	}
	wp_safe_redirect( remove_query_arg( 'arti100_lang' ) );
	exit;
}

/**
 * Override locale from cookie (frontend only).
 * Fires during load_theme_textdomain() so translations are correct.
 */
add_filter( 'locale', 'arti100_preview_locale_filter' );
function arti100_preview_locale_filter( $locale ) {
	if ( defined( 'WP_ADMIN' ) && WP_ADMIN ) {
		return $locale;
	}
	if ( empty( $_COOKIE['arti100_preview_lang'] ) ) {
		return $locale;
	}
	$allowed = [ 'fr_FR', 'en_US', 'es_ES' ];
	$lang    = sanitize_text_field( $_COOKIE['arti100_preview_lang'] );
	return in_array( $lang, $allowed, true ) ? $lang : $locale;
}

/**
 * Add language switcher to WP Admin Bar on frontend.
 */
add_action( 'admin_bar_menu', 'arti100_admin_bar_lang_switcher', 999 );
function arti100_admin_bar_lang_switcher( $wp_admin_bar ) {
	if ( is_admin() || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$current = get_locale();
	$langs   = [
		'fr_FR' => '🇫🇷 FR',
		'en_US' => '🇺🇸 EN',
		'es_ES' => '🇪🇸 ES',
	];
	$wp_admin_bar->add_node( [
		'id'    => 'arti100-lang',
		'title' => '🌐 ' . ( $langs[ $current ] ?? $current ),
		'href'  => '#',
	] );
	foreach ( $langs as $code => $label ) {
		$wp_admin_bar->add_node( [
			'parent' => 'arti100-lang',
			'id'     => 'arti100-lang-' . strtolower( str_replace( '_', '-', $code ) ),
			'title'  => ( $code === $current ? '✓ ' : '' ) . $label,
			'href'   => add_query_arg( 'arti100_lang', $code ),
		] );
	}
	if ( ! empty( $_COOKIE['arti100_preview_lang'] ) ) {
		$wp_admin_bar->add_node( [
			'parent' => 'arti100-lang',
			'id'     => 'arti100-lang-reset',
			'title'  => '↺ Langue du site',
			'href'   => add_query_arg( 'arti100_lang', 'reset' ),
		] );
	}
}
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
