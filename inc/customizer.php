<?php
/**
 * Arti100 — Customizer (couleurs dynamiques CSS)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Inject couleurs dynamiques via l'admin settings.
 */
function arti100_inject_dynamic_colors() {
	$primary = get_option( 'arti100_color_primary', '#007CBA' );
	$accent  = get_option( 'arti100_color_accent',  '#F5821F' );

	// Générer variantes
	$primary_dark  = arti100_adjust_color( $primary, -20 );
	$primary_light = arti100_adjust_color( $primary, 60 );
	$accent_dark   = arti100_adjust_color( $accent, -20 );

	echo '<style id="arti100-dynamic-colors">:root{';
	echo '--color-primary:'        . esc_attr( $primary ) . ';';
	echo '--color-primary-dark:'   . esc_attr( $primary_dark ) . ';';
	echo '--color-primary-light:'  . esc_attr( $primary_light ) . ';';
	echo '--color-accent:'         . esc_attr( $accent ) . ';';
	echo '--color-accent-dark:'    . esc_attr( $accent_dark ) . ';';
	echo '}</style>' . "\n";
}
add_action( 'wp_head', 'arti100_inject_dynamic_colors', 5 );

/**
 * Adjust brightness of a hex color.
 * @param string $hex   Couleur hexadecimale (#RRGGBB)
 * @param int    $steps Valeur entre -255 et 255
 * @return string
 */
function arti100_adjust_color( $hex, $steps ) {
	$hex = ltrim( $hex, '#' );
	if ( strlen( $hex ) === 3 ) {
		$hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
	}
	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );

	$r = max( 0, min( 255, $r + $steps ) );
	$g = max( 0, min( 255, $g + $steps ) );
	$b = max( 0, min( 255, $b + $steps ) );

	return sprintf( '#%02x%02x%02x', $r, $g, $b );
}
