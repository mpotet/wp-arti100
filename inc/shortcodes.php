<?php
/**
 * Arti100 - Shortcodes
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* =========================================================
   [arti100_map] - Google Maps embed
   ========================================================= */
function arti100_shortcode_map( $atts ) {
	$atts = shortcode_atts( [ 'height' => '400' ], $atts, 'arti100_map' );
	$embed = arti100_get_maps_embed();
	if ( empty( $embed ) ) {
		return '<p class="notice">' . esc_html__( 'Carte non configurée. Ajoutez l\'embed dans Arti100 → Intégrations.', 'arti100' ) . '</p>';
	}
	return '<div class="arti100-map-wrap" style="height:' . absint( $atts['height'] ) . 'px">' . $embed . '</div>';
}
add_shortcode( 'arti100_map', 'arti100_shortcode_map' );

/* =========================================================
   [arti100_devis_btn] - Bouton devis / Calendly
   ========================================================= */
function arti100_shortcode_devis_btn( $atts ) {
	$atts = shortcode_atts( [
		'text'  => __( 'Demander un devis gratuit', 'arti100' ),
		'class' => 'btn btn-primary',
	], $atts, 'arti100_devis_btn' );

	$url = arti100_get_devis_url();
	$calendly = get_option( 'arti100_calendly_url', '' );
	$is_calendly = ! empty( $calendly );

	return sprintf(
		'<a href="%s" class="%s"%s>%s</a>',
		esc_url( $url ),
		esc_attr( $atts['class'] ),
		$is_calendly ? ' data-calendly="1"' : '',
		esc_html( $atts['text'] )
	);
}
add_shortcode( 'arti100_devis_btn', 'arti100_shortcode_devis_btn' );

/* =========================================================
   [arti100_phone] - Numéro de téléphone cliquable
   ========================================================= */
function arti100_shortcode_phone( $atts ) {
	$atts = shortcode_atts( [ 'class' => 'phone-link' ], $atts, 'arti100_phone' );
	$phone = get_option( 'arti100_phone', '' );
	if ( empty( $phone ) ) return '';
	$href = 'tel:' . preg_replace( '/\s+/', '', $phone );
	return '<a href="' . esc_url( $href ) . '" class="' . esc_attr( $atts['class'] ) . '">' . esc_html( $phone ) . '</a>';
}
add_shortcode( 'arti100_phone', 'arti100_shortcode_phone' );

/* =========================================================
   [arti100_services] - Liste des services
   ========================================================= */
function arti100_shortcode_services( $atts ) {
	$atts = shortcode_atts( [ 'limit' => 6, 'columns' => 3 ], $atts, 'arti100_services' );

	$query = arti100_get_services( (int) $atts['limit'] );
	if ( ! $query->have_posts() ) {
		return '<p>' . esc_html__( 'Aucun service trouvé.', 'arti100' ) . '</p>';
	}

	$out  = '<div class="services-grid columns-' . absint( $atts['columns'] ) . '">';
	while ( $query->have_posts() ) {
		$query->the_post();
		$icone = get_post_meta( get_the_ID(), '_service_icone', true );
		$prix  = get_post_meta( get_the_ID(), '_service_prix',  true );
		$out  .= '<div class="service-card">';
		if ( $icone ) $out .= '<div class="service-icon">' . wp_kses_post( $icone ) . '</div>';
		$out  .= '<h3 class="service-title">' . esc_html( get_the_title() ) . '</h3>';
		$out  .= '<p class="service-excerpt">' . esc_html( get_the_excerpt() ) . '</p>';
		if ( $prix ) $out .= '<p class="service-price">' . esc_html( $prix ) . '</p>';
		$out  .= '</div>';
	}
	wp_reset_postdata();
	$out .= '</div>';

	return $out;
}
add_shortcode( 'arti100_services', 'arti100_shortcode_services' );

/* =========================================================
   [arti100_realisations] - Portfolio travaux
   ========================================================= */
function arti100_shortcode_realisations( $atts ) {
	$atts = shortcode_atts( [ 'limit' => 6 ], $atts, 'arti100_realisations' );

	$query = arti100_get_travaux( (int) $atts['limit'] );
	if ( ! $query->have_posts() ) {
		return '<p>' . esc_html__( 'Aucune réalisation trouvée.', 'arti100' ) . '</p>';
	}

	$out = '<div class="portfolio-grid">';
	while ( $query->have_posts() ) {
		$query->the_post();
		$avant = get_post_meta( get_the_ID(), '_travaux_photo_avant', true );
		$apres = get_post_meta( get_the_ID(), '_travaux_photo_apres', true );
		$thumb = get_the_post_thumbnail_url( null, 'arti100-card' );
		$img   = $apres ?: $thumb;

		$out .= '<div class="portfolio-item">';
		if ( $img ) $out .= '<img src="' . esc_url( $img ) . '" alt="' . esc_attr( get_the_title() ) . '" loading="lazy" />';
		$out .= '<div class="portfolio-overlay">';
		$out .= '<h3>' . esc_html( get_the_title() ) . '</h3>';
		$out .= '<a href="' . esc_url( get_permalink() ) . '" class="btn btn-sm btn-white">' . esc_html__( 'Voir le détail', 'arti100' ) . '</a>';
		$out .= '</div></div>';
	}
	wp_reset_postdata();
	$out .= '</div>';

	return $out;
}
add_shortcode( 'arti100_realisations', 'arti100_shortcode_realisations' );

/* =========================================================
   [arti100_zone] - Zone d'intervention
   ========================================================= */
function arti100_shortcode_zone() {
	$zone = get_option( 'arti100_zone', '' );
	if ( empty( $zone ) ) return '';
	return '<span class="zone-badge">📍 ' . esc_html( $zone ) . '</span>';
}
add_shortcode( 'arti100_zone', 'arti100_shortcode_zone' );
