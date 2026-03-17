<?php
/**
 * Arti100 — sidebar.php
 */
if ( ! is_active_sidebar( 'sidebar-1' ) ) return;
?>
<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>

	<!-- Widget sticky CTA devis -->
	<div class="sidebar-cta-widget">
		<h3><?php esc_html_e( 'Besoin d\'un devis ?', 'arti100' ); ?></h3>
		<p><?php esc_html_e( 'Contactez-nous gratuitement, sans engagement.', 'arti100' ); ?></p>
		<a href="<?php echo esc_url( arti100_get_devis_url() ); ?>" class="btn btn-accent btn-full">
			<?php esc_html_e( 'Devis gratuit', 'arti100' ); ?>
		</a>
		<?php
		$phone = arti100_get_phone();
		if ( $phone ) : ?>
			<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="btn btn-outline-primary btn-full">
				<?php echo esc_html( $phone ); ?>
			</a>
		<?php endif; ?>
	</div>
</aside>
