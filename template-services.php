<?php
/**
 * Template Name: Page Services
 * Template Post Type: page
 *
 * Arti100 - template-services.php
 */
get_header();
?>

<div class="page-banner">
	<div class="container">
		<h1 class="page-banner-title"><?php the_title(); ?></h1>
		<?php arti100_breadcrumb(); ?>
	</div>
</div>

<div class="container section-padded">

	<?php while ( have_posts() ) : the_post(); ?>
		<?php if ( get_the_content() ) : ?>
			<div class="prose-content entry-content" style="max-width:700px; margin: 0 auto 4rem;">
				<?php the_content(); ?>
			</div>
		<?php endif; ?>
	<?php endwhile; ?>

	<div class="section-header" style="margin-bottom:3rem">
		<h2 class="section-title"><?php esc_html_e( 'Toutes nos prestations', 'arti100' ); ?></h2>
	</div>

	<?php
	$services_query = arti100_get_services();
	if ( $services_query->have_posts() ) :
	?>
		<div class="services-grid">
			<?php while ( $services_query->have_posts() ) : $services_query->the_post();
				$icone = get_post_meta( get_the_ID(), '_service_icone', true );
				$prix  = get_post_meta( get_the_ID(), '_service_prix',  true );
				$duree = get_post_meta( get_the_ID(), '_service_duree', true );
			?>
			<div class="service-card">
				<div class="service-card-icon">
					<?php if ( $icone ) : ?>
						<?php echo wp_kses_post( $icone ); ?>
					<?php else : ?>
						<svg width="36" height="36" viewBox="0 0 24 24" fill="var(--color-primary)" aria-hidden="true"><path d="M13.78 15.3L19.78 21.3L21.89 19.14L15.89 13.14L13.78 15.3M17.5 11.5C17.5 11.97 17.44 12.44 17.31 12.9L18.77 14.36C19.25 13.44 19.5 12.47 19.5 11.5C19.5 8.47 17.56 5.89 14.84 4.82L14 6.5C15.77 7.35 17 9.29 17 11.5M11.5 2C6.81 2 3 5.81 3 10.5C3 14.59 5.72 18.03 9.41 19.16L7.9 12.5H5L7.5 4H11.5V2Z"/></svg>
					<?php endif; ?>
				</div>
				<div class="service-card-body">
					<h2 class="service-card-title"><?php the_title(); ?></h2>
					<p class="service-card-desc"><?php echo esc_html( get_the_excerpt() ); ?></p>
					<?php if ( $prix || $duree ) : ?>
						<div class="service-card-meta">
							<?php if ( $prix )  echo '<span class="service-price-tag">' . esc_html( $prix ) . '</span>'; ?>
							<?php if ( $duree ) echo '<span class="service-duration-tag">⏱ ' . esc_html( $duree ) . '</span>'; ?>
						</div>
					<?php endif; ?>
				</div>
				<a href="<?php the_permalink(); ?>" class="service-card-link">
					<?php esc_html_e( 'En savoir plus', 'arti100' ); ?> →
				</a>
			</div>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	<?php else : ?>
		<div class="no-results">
			<p><?php esc_html_e( 'Aucun service configuré. Allez dans Services → Ajouter un service.', 'arti100' ); ?></p>
		</div>
	<?php endif; ?>

	<div class="section-footer-cta" style="margin-top:3rem">
		<a href="<?php echo esc_url( arti100_get_devis_url() ); ?>" class="btn btn-accent btn-large">
			<?php esc_html_e( 'Demandez un devis gratuit', 'arti100' ); ?>
		</a>
	</div>
</div>

<?php get_footer(); ?>
