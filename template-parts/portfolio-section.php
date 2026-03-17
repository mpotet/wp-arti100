<?php
/**
 * Arti100 — template-parts/portfolio-section.php
 */
$query = arti100_get_travaux( 6 );
if ( ! $query->have_posts() ) return;
?>

<section id="realisations" class="portfolio-section section-padded bg-light">
	<div class="container">
		<div class="section-header">
			<span class="section-eyebrow"><?php esc_html_e( 'Nos réalisations', 'arti100' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Nos chantiers', 'arti100' ); ?></h2>
			<p class="section-subtitle"><?php esc_html_e( 'Découvrez nos derniers travaux réalisés avec professionnalisme.', 'arti100' ); ?></p>
		</div>

		<div class="portfolio-grid">
			<?php while ( $query->have_posts() ) : $query->the_post();
				$photo_avant  = get_post_meta( get_the_ID(), '_travaux_photo_avant',        true );
				$photo_apres  = get_post_meta( get_the_ID(), '_travaux_photo_apres',        true );
				$localite     = get_post_meta( get_the_ID(), '_travaux_localite',           true );
				$temoignage   = get_post_meta( get_the_ID(), '_travaux_client_temoignage',  true );
				$has_ba       = $photo_avant && $photo_apres;
				$thumb_url    = get_the_post_thumbnail_url( null, 'arti100-card' );
				$display_img  = $photo_apres ?: $thumb_url;
				$terms        = get_the_terms( get_the_ID(), 'type_travaux' );
				$term_name    = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
			?>
			<article class="portfolio-item">
				<div class="portfolio-media">
					<?php if ( $has_ba ) : ?>
						<!-- Slider avant/après -->
						<div class="ba-slider" data-avant="<?php echo esc_url( $photo_avant ); ?>" data-apres="<?php echo esc_url( $photo_apres ); ?>">
							<div class="ba-avant">
								<img src="<?php echo esc_url( $photo_avant ); ?>" alt="<?php esc_attr_e( 'Avant travaux', 'arti100' ); ?> — <?php echo esc_attr( get_the_title() ); ?>" loading="lazy" />
								<span class="ba-label ba-label-avant"><?php esc_html_e( 'Avant', 'arti100' ); ?></span>
							</div>
							<div class="ba-apres" style="clip-path:inset(0 0 0 50%)">
								<img src="<?php echo esc_url( $photo_apres ); ?>" alt="<?php esc_attr_e( 'Après travaux', 'arti100' ); ?> — <?php echo esc_attr( get_the_title() ); ?>" loading="lazy" />
								<span class="ba-label ba-label-apres"><?php esc_html_e( 'Après', 'arti100' ); ?></span>
							</div>
							<div class="ba-handle" role="slider" aria-valuemin="0" aria-valuemax="100" aria-valuenow="50" aria-label="<?php esc_attr_e( 'Curseur avant/après', 'arti100' ); ?>">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="white" aria-hidden="true"><path d="M9.4 18L8 16.6 12.6 12 8 7.4 9.4 6l6 6z"/><path d="M14.6 18l1.4-1.4L11.4 12l4.6-4.6L14.6 6l-6 6z"/></svg>
							</div>
						</div>
					<?php elseif ( $display_img ) : ?>
						<img src="<?php echo esc_url( $display_img ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="portfolio-img" loading="lazy" />
					<?php else : ?>
						<div class="portfolio-placeholder">
							<svg width="48" height="48" viewBox="0 0 24 24" fill="var(--color-gray-300)" aria-hidden="true"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
						</div>
					<?php endif; ?>

					<?php if ( $term_name ) : ?>
						<span class="portfolio-category"><?php echo esc_html( $term_name ); ?></span>
					<?php endif; ?>
				</div>
				<div class="portfolio-body">
					<h3><?php the_title(); ?></h3>
					<?php if ( $localite ) : ?>
						<p class="portfolio-location">📍 <?php echo esc_html( $localite ); ?></p>
					<?php endif; ?>
					<?php if ( $temoignage ) : ?>
						<blockquote class="portfolio-quote"><?php echo esc_html( $temoignage ); ?></blockquote>
					<?php endif; ?>
					<a href="<?php the_permalink(); ?>" class="portfolio-link">
						<?php esc_html_e( 'Voir le détail', 'arti100' ); ?>
						<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
					</a>
				</div>
			</article>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>

		<?php
		$archive = get_post_type_archive_link( 'travaux' );
		if ( $archive ) : ?>
			<div class="section-footer-cta">
				<a href="<?php echo esc_url( $archive ); ?>" class="btn btn-outline-primary">
					<?php esc_html_e( 'Voir toutes les réalisations', 'arti100' ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</section>
