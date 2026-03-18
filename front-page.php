<?php
/**
 * Arti100 — front-page.php
 * Template homepage (supporte "page statique" dans Réglages > Lecture)
 */
get_header();
?>

<?php get_template_part( 'template-parts/hero' ); ?>

<?php if ( get_option( 'arti100_show_trust', '1' ) ) : ?>
<!-- Section confiance / certifications -->
<section class="trust-strip">
	<div class="container trust-strip-inner">
		<?php
		$trust_icons = [
			1 => '<span class="material-symbols-outlined trust-icon" aria-hidden="true">verified_user</span>',
			2 => '<span class="material-symbols-outlined trust-icon" aria-hidden="true">check_circle</span>',
			3 => '<span class="material-symbols-outlined trust-icon" aria-hidden="true">bolt</span>',
			4 => '<span class="material-symbols-outlined trust-icon" aria-hidden="true">star</span>',
		];
		$trust_defaults = [
			1 => [ 'title' => __( 'XXX - Certification 1', 'arti100' ),  'desc' => __( 'XXX - Description cert. 1', 'arti100' ) ],
			2 => [ 'title' => __( 'XXX - Certification 2', 'arti100' ),  'desc' => __( 'XXX - Description cert. 2', 'arti100' ) ],
			3 => [ 'title' => __( 'XXX - Certification 3', 'arti100' ),  'desc' => __( 'XXX - Description cert. 3', 'arti100' ) ],
			4 => [ 'title' => __( 'XXX - Note / 5 ★★★★★', 'arti100' ),  'desc' => __( 'XXX - xxx avis Google', 'arti100' ) ],
		];
		for ( $i = 1; $i <= 4; $i++ ) :
			$t_title = get_option( "arti100_trust_{$i}_title", $trust_defaults[ $i ]['title'] );
			$t_desc  = get_option( "arti100_trust_{$i}_desc",  $trust_defaults[ $i ]['desc'] );
		?>
		<div class="trust-item">
			<?php echo $trust_icons[ $i ]; ?>
			<div>
				<strong><?php echo esc_html( $t_title ); ?></strong>
				<span><?php echo esc_html( $t_desc ); ?></span>
			</div>
		</div>
		<?php endfor; ?>
	</div>
</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/services-section' ); ?>
<?php get_template_part( 'template-parts/portfolio-section' ); ?>
<?php get_template_part( 'template-parts/team-section' ); ?>
<?php get_template_part( 'template-parts/testimonials-section' ); ?>
<?php get_template_part( 'template-parts/contact-section' ); ?>

<?php get_footer(); ?>
