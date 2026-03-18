<?php
/**
 * Arti100 - 404.php
 */
get_header();
?>

<div class="container section-padded text-center">
	<div class="error-404">
		<div class="error-404-icon" aria-hidden="true">🔧</div>
		<h1>404</h1>
		<h2><?php esc_html_e( 'Page introuvable', 'arti100' ); ?></h2>
		<p><?php esc_html_e( 'La page que vous cherchez n\'existe pas ou a été déplacée.', 'arti100' ); ?></p>
		<div class="error-404-actions">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary"><?php esc_html_e( 'Retour à l\'accueil', 'arti100' ); ?></a>
			<?php
			$phone = arti100_get_phone();
			if ( $phone ) : ?>
				<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="btn btn-outline-primary"><?php echo esc_html( $phone ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
