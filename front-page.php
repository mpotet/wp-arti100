<?php
/**
 * Arti100 — front-page.php
 * Template homepage (supporte "page statique" dans Réglages > Lecture)
 */
get_header();
?>

<?php get_template_part( 'template-parts/hero' ); ?>

<!-- Section confiance / certifications -->
<section class="trust-strip">
	<div class="container trust-strip-inner">
		<div class="trust-item">
			<svg width="32" height="32" viewBox="0 0 24 24" fill="var(--color-accent)" aria-hidden="true"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
			<div>
				<strong><?php esc_html_e( 'Assuré RC Pro', 'arti100' ); ?></strong>
				<span><?php esc_html_e( 'Garantie décennale', 'arti100' ); ?></span>
			</div>
		</div>
		<div class="trust-item">
			<svg width="32" height="32" viewBox="0 0 24 24" fill="var(--color-accent)" aria-hidden="true"><path d="M9 16.17L5.53 12.7a.996.996 0 10-1.41 1.41l4.18 4.18c.39.39 1.02.39 1.41 0L20.29 7.71a.996.996 0 10-1.41-1.41L9 16.17z"/></svg>
			<div>
				<strong><?php esc_html_e( 'Certifié RGE', 'arti100' ); ?></strong>
				<span><?php esc_html_e( 'Qualibat / Qualifelec', 'arti100' ); ?></span>
			</div>
		</div>
		<div class="trust-item">
			<svg width="32" height="32" viewBox="0 0 24 24" fill="var(--color-accent)" aria-hidden="true"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm.01 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm1-13H10v6l5 3 .75-1.23-4.5-2.67V7H13z"/></svg>
			<div>
				<strong><?php esc_html_e( 'Intervention rapide', 'arti100' ); ?></strong>
				<span><?php esc_html_e( 'Urgences 7j/7', 'arti100' ); ?></span>
			</div>
		</div>
		<div class="trust-item">
			<svg width="32" height="32" viewBox="0 0 24 24" fill="var(--color-accent)" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
			<div>
				<strong>4.9/5 ★★★★★</strong>
				<span><?php esc_html_e( '120+ avis Google', 'arti100' ); ?></span>
			</div>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/services-section' ); ?>
<?php get_template_part( 'template-parts/portfolio-section' ); ?>
<?php get_template_part( 'template-parts/team-section' ); ?>
<?php get_template_part( 'template-parts/testimonials-section' ); ?>
<?php get_template_part( 'template-parts/contact-section' ); ?>

<?php get_footer(); ?>
