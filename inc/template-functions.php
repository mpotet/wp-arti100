<?php
/**
 * Arti100 — Template Functions
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* =========================================================
   HELPERS
   ========================================================= */

/**
 * URL "Devis" : Calendly si configuré, sinon ancre #contact
 */
function arti100_get_devis_url() {
	$calendly = get_option( 'arti100_calendly_url', '' );
	return ! empty( $calendly ) ? esc_url( $calendly ) : '#contact';
}

/**
 * Numéro de téléphone formaté
 */
function arti100_get_phone() {
	return esc_html( get_option( 'arti100_phone', '' ) );
}

/**
 * Nom de l'entreprise
 */
function arti100_get_company_name() {
	return esc_html( get_option( 'arti100_company_name', get_bloginfo( 'name' ) ) );
}

/**
 * Slogan
 */
function arti100_get_slogan() {
	return esc_html( get_option( 'arti100_slogan', 'Artisan qualifié près de chez vous.' ) );
}

/**
 * Récupérer les services (CPT) triés
 * @param int $limit
 * @return WP_Query
 */
function arti100_get_services( $limit = -1 ) {
	return new WP_Query( [
		'post_type'      => 'service',
		'post_status'    => 'publish',
		'posts_per_page' => $limit,
		'meta_key'       => '_service_ordre',
		'orderby'        => 'meta_value_num',
		'order'          => 'ASC',
	] );
}

/**
 * Récupérer les réalisations (travaux)
 * @param int $limit
 * @return WP_Query
 */
function arti100_get_travaux( $limit = 6 ) {
	return new WP_Query( [
		'post_type'      => 'travaux',
		'post_status'    => 'publish',
		'posts_per_page' => $limit,
		'orderby'        => 'date',
		'order'          => 'DESC',
	] );
}

/**
 * Récupérer les membres de l'équipe
 * @return WP_Query
 */
function arti100_get_equipe() {
	return new WP_Query( [
		'post_type'      => 'artisan',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	] );
}

/**
 * Breadcrumb simple
 */
function arti100_breadcrumb() {
	echo '<nav class="breadcrumb" aria-label="' . esc_attr__( 'Fil d\'Ariane', 'arti100' ) . '">';
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Accueil', 'arti100' ) . '</a>';
	echo '<span class="breadcrumb-sep" aria-hidden="true">›</span>';

	if ( is_single() ) {
		$type = get_post_type_object( get_post_type() );
		if ( $type && $type->has_archive ) {
			echo '<a href="' . esc_url( get_post_type_archive_link( get_post_type() ) ) . '">' . esc_html( $type->labels->name ) . '</a>';
			echo '<span class="breadcrumb-sep" aria-hidden="true">›</span>';
		}
		echo '<span>' . esc_html( get_the_title() ) . '</span>';

	} elseif ( is_page() ) {
		$ancestors = get_post_ancestors( get_the_ID() );
		foreach ( array_reverse( $ancestors ) as $ancestor ) {
			echo '<a href="' . esc_url( get_permalink( $ancestor ) ) . '">' . esc_html( get_the_title( $ancestor ) ) . '</a>';
			echo '<span class="breadcrumb-sep" aria-hidden="true">›</span>';
		}
		echo '<span>' . esc_html( get_the_title() ) . '</span>';

	} elseif ( is_archive() ) {
		echo '<span>' . esc_html( get_the_archive_title() ) . '</span>';
	}

	echo '</nav>';
}

/**
 * Renvoie le logo ou le nom de l'entreprise
 */
function arti100_logo_html() {
	$logo_url = get_option( 'arti100_logo_url', '' );
	$name     = arti100_get_company_name();

	if ( has_custom_logo() ) {
		return get_custom_logo();
	}

	if ( ! empty( $logo_url ) ) {
		return '<a href="' . esc_url( home_url( '/' ) ) . '" class="site-logo-link"><img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $name ) . '" class="site-logo" /></a>';
	}

	return '<a href="' . esc_url( home_url( '/' ) ) . '" class="site-logo-text">' . esc_html( $name ) . '</a>';
}

/**
 * Icône selon le métier configuré
 */
function arti100_get_metier_icon( $metier = '' ) {
	if ( empty( $metier ) ) {
		$metier = get_option( 'arti100_metier', 'plombier' );
	}
	$icons = [
		'plombier'     => ARTI100_URI . '/assets/images/icon-plombier.svg',
		'electricien'  => ARTI100_URI . '/assets/images/icon-electricien.svg',
		'plaquiste'    => ARTI100_URI . '/assets/images/icon-plaquiste.svg',
		'maçon'        => ARTI100_URI . '/assets/images/icon-maçon.svg',
		'peintre'      => ARTI100_URI . '/assets/images/icon-peintre.svg',
		'menuisier'    => ARTI100_URI . '/assets/images/icon-menuisier.svg',
		'chauffagiste' => ARTI100_URI . '/assets/images/icon-chauffagiste.svg',
		'charpentier'  => ARTI100_URI . '/assets/images/icon-charpentier.svg',
	];
	return isset( $icons[ $metier ] ) ? $icons[ $metier ] : $icons['plombier'];
}

/**
 * Google Maps embed HTML
 */
function arti100_get_maps_embed() {
	$embed = get_option( 'arti100_maps_embed', '' );
	if ( ! empty( $embed ) ) {
		return wp_kses( $embed, [
			'iframe' => [
				'src'             => true,
				'width'           => true,
				'height'          => true,
				'style'           => true,
				'allowfullscreen' => true,
				'loading'         => true,
				'referrerpolicy'  => true,
				'frameborder'     => true,
			],
		] );
	}
	return '';
}

/**
 * Étoiles (rating)
 */
function arti100_stars( $count = 5 ) {
	$out = '<span class="stars" aria-label="' . esc_attr( sprintf( __( '%d étoiles sur 5', 'arti100' ), $count ) ) . '">';
	for ( $i = 0; $i < 5; $i++ ) {
		$out .= $i < $count ? '★' : '☆';
	}
	$out .= '</span>';
	return $out;
}
