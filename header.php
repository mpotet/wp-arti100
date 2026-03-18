<?php
/**
 * Arti100 - header.php
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
					<span class="material-symbols-outlined" aria-hidden="true">location_on</span>
					<?php echo esc_html( $zone ); ?>
				</span>
			<?php endif; ?>
			<?php if ( $phone ) : ?>
				<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="ribbon-item">
					<span class="material-symbols-outlined" aria-hidden="true">call</span>
					<?php echo esc_html( $phone ); ?>
				</a>
			<?php endif; ?>
		</div>
		<div class="ribbon-right">
			<?php if ( $facebook ) : ?>
				<a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener noreferrer" class="ribbon-social" aria-label="Facebook">
					<i class="bi bi-facebook" aria-hidden="true"></i>
				</a>
			<?php endif; ?>
			<?php if ( $instagram ) : ?>
				<a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener noreferrer" class="ribbon-social" aria-label="Instagram">
					<i class="bi bi-instagram" aria-hidden="true"></i>
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
					<span class="material-symbols-outlined" aria-hidden="true">call</span>
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
 * Fallback menu avec liens ancres vers la homepage
 */
function arti100_fallback_menu() {
	$home = home_url( '/' );
	echo '<ul class="main-menu menu-fallback">';
	echo '<li><a href="' . esc_url( $home ) . '">' . esc_html__( 'Accueil', 'arti100' ) . '</a></li>';
	echo '<li><a href="' . esc_url( $home ) . '#services">'     . esc_html__( 'Services', 'arti100' )     . '</a></li>';
	echo '<li><a href="' . esc_url( $home ) . '#realisations">' . esc_html__( 'Réalisations', 'arti100' ) . '</a></li>';
	echo '<li><a href="' . esc_url( $home ) . '#equipe">'       . esc_html__( 'Équipe', 'arti100' )       . '</a></li>';
	echo '<li><a href="' . esc_url( $home ) . '#contact">'      . esc_html__( 'Contact', 'arti100' )      . '</a></li>';
	echo '</ul>';
}
?>

<!-- JS : correction liens ancre dans les menus enregistrés -->
<script>
(function(){
	var home = <?php echo wp_json_encode( rtrim( home_url(), '/' ) ); ?>;
	var currentBase = window.location.origin + window.location.pathname.replace(/\/$/, '');
	document.addEventListener('DOMContentLoaded', function(){
		document.querySelectorAll('#primary-menu a, .footer-links a').forEach(function(a){
			var h = a.getAttribute('href');
			if ( h && h.charAt(0) === '#' ) {
				a.setAttribute('href', home + '/' + h);
			}
		});
	});
})();
</script>

<main id="main-content" class="site-main">
