<?php
/**
 * Arti100 — template-parts/services-section.php
 */
$query = arti100_get_services( 6 );
if ( ! $query->have_posts() ) return;
?>

<section id="services" class="services-section section-padded">
	<div class="container">
		<div class="section-header">
			<span class="section-eyebrow"><?php esc_html_e( 'Ce que nous faisons', 'arti100' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Nos services', 'arti100' ); ?></h2>
			<p class="section-subtitle"><?php esc_html_e( 'Des prestations professionnelles pour tous vos travaux, réalisées avec soin et garanties.', 'arti100' ); ?></p>
		</div>

		<div class="services-grid">
			<?php while ( $query->have_posts() ) : $query->the_post();
				$icone = get_post_meta( get_the_ID(), '_service_icone', true );
				$prix  = get_post_meta( get_the_ID(), '_service_prix', true );
				$duree = get_post_meta( get_the_ID(), '_service_duree', true );
				$link  = get_post_type_archive_link( 'service' ) ?: get_permalink();
			?>
			<div class="service-card">
				<div class="service-card-icon">
					<?php if ( $icone ) : ?>
						<?php echo wp_kses_post( $icone ); ?>
					<?php else : ?>
						<svg width="40" height="40" viewBox="0 0 24 24" fill="var(--color-primary)" aria-hidden="true"><path d="M13.78 15.3L19.78 21.3L21.89 19.14L15.89 13.14L13.78 15.3M17.5 11.5C17.5 11.97 17.44 12.44 17.31 12.9L18.77 14.36C19.25 13.44 19.5 12.47 19.5 11.5C19.5 8.47 17.56 5.89 14.84 4.82L14 6.5C15.77 7.35 17 9.29 17 11.5M11.5 2C6.81 2 3 5.81 3 10.5C3 14.59 5.72 18.03 9.41 19.16L7.9 12.5H5L7.5 4H11.5V2M11.5 4V7H9.6L8.53 11.5H11.5V19.93C11.16 19.97 10.83 20 10.5 20C6.91 20 4 17.09 4 13.5C4 12.13 4.43 10.82 5.18 9.75L8.27 15.04L9.96 13.35L7.5 8.5H10.23L11.5 4Z"/></svg>
					<?php endif; ?>
				</div>
				<div class="service-card-body">
					<h3 class="service-card-title"><?php the_title(); ?></h3>
					<p class="service-card-desc"><?php echo esc_html( get_the_excerpt() ); ?></p>
					<?php if ( $prix || $duree ) : ?>
						<div class="service-card-meta">
							<?php if ( $prix ) : ?>
								<span class="service-price-tag"><?php echo esc_html( $prix ); ?></span>
							<?php endif; ?>
							<?php if ( $duree ) : ?>
								<span class="service-duration-tag">
									<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm.01 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/></svg>
									<?php echo esc_html( $duree ); ?>
								</span>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="service-card-link" aria-label="<?php echo esc_attr( sprintf( __( 'En savoir plus sur %s', 'arti100' ), get_the_title() ) ); ?>">
					<?php esc_html_e( 'En savoir plus', 'arti100' ); ?>
					<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
				</a>
			</div>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>

		<div class="section-footer-cta">
			<a href="<?php echo esc_url( arti100_get_devis_url() ); ?>" class="btn btn-primary btn-large">
				<?php esc_html_e( 'Obtenir un devis gratuit', 'arti100' ); ?>
			</a>
		</div>
	</div>
</section>
