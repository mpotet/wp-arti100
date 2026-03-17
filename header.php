<?php
/**
 * Arti100 — header.php
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content"><?php esc_html_e( 'Aller au contenu', 'arti100' ); ?></a>

<?php
$phone       = arti100_get_phone();
$zone        = get_option( 'arti100_zone', '' );
$facebook    = get_option( 'arti100_facebook', '' );
$instagram   = get_option( 'arti100_instagram', '' );
$devis_url   = arti100_get_devis_url();
$calendly    = get_option( 'arti100_calendly_url', '' );
$is_calendly = ! empty( $calendly );
?>

<!-- RIBBON TOP -->
<div class="header-ribbon">
	<div class="container ribbon-inner">
		<div class="ribbon-left">
			<?php if ( $zone ) : ?>
				<span class="ribbon-item">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
					<?php echo esc_html( $zone ); ?>
				</span>
			<?php endif; ?>
			<?php if ( $phone ) : ?>
				<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="ribbon-item">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79a15.1 15.1 0 006.59 6.59l2.2-2.2a1 1 0 011.02-.24c1.12.37 2.33.57 3.57.57a1 1 0 011 1V20a1 1 0 01-1 1C10.56 21 3 13.44 3 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.45.57 3.57a1 1 0 01-.25 1.02l-2.2 2.2z"/></svg>
					<?php echo esc_html( $phone ); ?>
				</a>
			<?php endif; ?>
		</div>
		<div class="ribbon-right">
			<?php if ( $facebook ) : ?>
				<a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener noreferrer" class="ribbon-social" aria-label="Facebook">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3l-.5 3H13v6.95c4.56-.93 8-4.96 8-9.95z"/></svg>
				</a>
			<?php endif; ?>
			<?php if ( $instagram ) : ?>
				<a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener noreferrer" class="ribbon-social" aria-label="Instagram">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 01-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 017.8 2zm-.2 2A3.6 3.6 0 004 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 003.6-3.6V7.6C20 5.61 18.39 4 16.4 4H7.6zm9.65 1.5a1.25 1.25 0 110 2.5 1.25 1.25 0 010-2.5zM12 7a5 5 0 110 10A5 5 0 0112 7zm0 2a3 3 0 100 6 3 3 0 000-6z"/></svg>
				</a>
			<?php endif; ?>
		</div>
	</div>
</div>

<!-- HEADER PRINCIPAL -->
<header id="masthead" class="site-header" role="banner">
	<div class="container header-inner">

		<!-- LOGO -->
		<div class="site-branding">
			<?php echo arti100_logo_html(); ?>
		</div>

		<!-- NAVIGATION -->
		<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Menu principal', 'arti100' ); ?>">
			<?php
			wp_nav_menu( [
				'theme_location' => 'primary',
				'menu_id'        => 'primary-menu',
				'menu_class'     => 'main-menu',
				'container'      => false,
				'fallback_cb'    => 'arti100_fallback_menu',
			] );
			?>
		</nav>

		<!-- HEADER CTA -->
		<div class="header-actions">
			<?php if ( $phone ) : ?>
				<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="header-phone">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79a15.1 15.1 0 006.59 6.59l2.2-2.2a1 1 0 011.02-.24A11.36 11.36 0 0020 17.57a1 1 0 011 1V20a1 1 0 01-1 1C10.56 21 3 13.44 3 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.45.57 3.57a1 1 0 01-.25 1.02l-2.2 2.2z"/></svg>
					<?php echo esc_html( $phone ); ?>
				</a>
			<?php endif; ?>

			<a href="<?php echo esc_url( $devis_url ); ?>"
			   class="btn btn-accent header-cta<?php echo $is_calendly ? ' js-calendly' : ''; ?>"
			   <?php echo $is_calendly ? 'data-calendly="' . esc_attr( $calendly ) . '"' : ''; ?>>
				<?php esc_html_e( 'Devis gratuit', 'arti100' ); ?>
			</a>
		</div>

		<!-- HAMBURGER -->
		<button class="menu-toggle" id="menu-toggle" aria-controls="site-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Ouvrir le menu', 'arti100' ); ?>">
			<span class="hamburger-bar"></span>
			<span class="hamburger-bar"></span>
			<span class="hamburger-bar"></span>
		</button>

	</div><!-- .header-inner -->
</header><!-- #masthead -->

<?php
/**
 * Fallback menu si aucun menu affecté au thème
 */
function arti100_fallback_menu() {
	echo '<ul class="main-menu menu-fallback">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Accueil', 'arti100' ) . '</a></li>';
	echo '<li><a href="#services">'    . esc_html__( 'Services', 'arti100' )     . '</a></li>';
	echo '<li><a href="#realisations">' . esc_html__( 'Réalisations', 'arti100' ) . '</a></li>';
	echo '<li><a href="#equipe">'      . esc_html__( 'Équipe', 'arti100' )       . '</a></li>';
	echo '<li><a href="#contact">'     . esc_html__( 'Contact', 'arti100' )      . '</a></li>';
	echo '</ul>';
}
?>

<main id="main-content" class="site-main">
