<?php
/**
 * Arti100 — functions.php
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
	// Styles
	wp_enqueue_style( 'arti100-main', ARTI100_URI . '/assets/css/main.css', [], ARTI100_VERSION );
	wp_enqueue_style( 'arti100-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap',
		[], null );

	// Scripts
	wp_enqueue_script( 'arti100-main', ARTI100_URI . '/assets/js/main.js', [], ARTI100_VERSION, true );

	// Localise JS
	wp_localize_script( 'arti100-main', 'arti100', [
		'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
		'nonce'         => wp_create_nonce( 'arti100_nonce' ),
		'calendlyUrl'   => esc_url( get_option( 'arti100_calendly_url', '' ) ),
		'phoneNumber'   => esc_html( get_option( 'arti100_phone', '' ) ),
	] );

	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'arti100_enqueue_assets' );

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

	$name    = esc_js( get_option( 'arti100_company_name', get_bloginfo( 'name' ) ) );
	$phone   = esc_js( get_option( 'arti100_phone', '' ) );
	$email   = esc_js( get_option( 'arti100_email', '' ) );
	$zone    = esc_js( get_option( 'arti100_zone', '' ) );
	$url     = esc_url( home_url( '/' ) );
	$logo    = esc_url( get_option( 'arti100_logo_url', '' ) );

	echo '<script type="application/ld+json">' . "\n";
	echo '{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "' . $name . '",
  "url": "' . $url . '",
  "telephone": "' . $phone . '",
  "email": "' . $email . '",
  "logo": "' . $logo . '",
  "areaServed": "' . $zone . '",
  "priceRange": "€€"
}' . "\n";
	echo '</script>' . "\n";
}
add_action( 'wp_head', 'arti100_schema_local_business' );

/* =========================================================
   7. EXCERPT
   ========================================================= */
function arti100_excerpt_length( $length ) { return 25; }
add_filter( 'excerpt_length', 'arti100_excerpt_length' );

function arti100_excerpt_more( $more ) { return '…'; }
add_filter( 'excerpt_more', 'arti100_excerpt_more' );

/* =========================================================
   8. CLEANUP
   ========================================================= */
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
