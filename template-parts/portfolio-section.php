<?php
/**
 * Arti100 — template-parts/portfolio-section.php
 */
if ( ! get_option( 'arti100_show_portfolio', '1' ) ) return;

$query = arti100_get_travaux( 6 );
$is_empty = ! $query->have_posts();

// Si vide et visiteur non admin → on n'affiche pas la section
if ( $is_empty && ! current_user_can( 'manage_options' ) ) return;

$titre      = get_option( 'arti100_portfolio_titre',      __( 'XXX - Titre réalisations', 'arti100' ) );
$sous_titre = get_option( 'arti100_portfolio_sous_titre', __( 'XXX - Sous-titre réalisations', 'arti100' ) );
?>

<section id="realisations" class="portfolio-section section-padded bg-light">
	<div class="container">
		<div class="section-header">
			<span class="section-eyebrow"><?php esc_html_e( 'Nos réalisations', 'arti100' ); ?></span>
			<h2 class="section-title"><?php echo esc_html( $titre ); ?></h2>
			<?php if ( $sous_titre ) : ?>
				<p class="section-subtitle"><?php echo esc_html( $sous_titre ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( $is_empty ) : ?>
			<div class="arti100-empty-notice">
				<span class="material-symbols-outlined" aria-hidden="true">info</span>
				<p>
					<?php esc_html_e( 'Aucune réalisation publiée.', 'arti100' ); ?>
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=travaux' ) ); ?>">
						<?php esc_html_e( 'Ajouter des réalisations →', 'arti100' ); ?>
					</a>
				</p>
			</div>
		<?php else : ?>
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
						<div class="ba-slider" data-avant="<?php echo esc_url( $photo_avant ); ?>" data-apres="<?php echo esc_url( $photo_apres ); ?>">
							<div class="ba-avant">
								<img src="<?php echo esc_url( $photo_avant ); ?>" alt="<?php echo esc_attr( sprintf( __( 'Avant travaux — %s', 'arti100' ), get_the_title() ) ); ?>" loading="lazy" />
								<span class="ba-label ba-label-avant"><?php esc_html_e( 'Avant', 'arti100' ); ?></span>
							</div>
							<div class="ba-apres" style="clip-path:inset(0 0 0 50%)">
								<img src="<?php echo esc_url( $photo_apres ); ?>" alt="<?php echo esc_attr( sprintf( __( 'Après travaux — %s', 'arti100' ), get_the_title() ) ); ?>" loading="lazy" />
								<span class="ba-label ba-label-apres"><?php esc_html_e( 'Après', 'arti100' ); ?></span>
							</div>
							<div class="ba-handle" role="slider" aria-valuemin="0" aria-valuemax="100" aria-valuenow="50" aria-label="<?php esc_attr_e( 'Curseur avant/après', 'arti100' ); ?>">
								<span class="material-symbols-outlined" aria-hidden="true">swap_horiz</span>
							</div>
						</div>
					<?php elseif ( $display_img ) : ?>
						<img src="<?php echo esc_url( $display_img ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="portfolio-img" loading="lazy" />
					<?php else : ?>
						<div class="portfolio-placeholder">
							<span class="material-symbols-outlined" aria-hidden="true" style="font-size:3rem;color:var(--color-gray-300)">hide_image</span>
						</div>
					<?php endif; ?>

					<?php if ( $term_name ) : ?>
						<span class="portfolio-category"><?php echo esc_html( $term_name ); ?></span>
					<?php endif; ?>
				</div>
				<div class="portfolio-body">
					<h3><?php the_title(); ?></h3>
					<?php if ( $localite ) : ?>
						<p class="portfolio-location">
							<span class="material-symbols-outlined" aria-hidden="true">location_on</span>
							<?php echo esc_html( $localite ); ?>
						</p>
					<?php endif; ?>
					<?php if ( $temoignage ) : ?>
						<blockquote class="portfolio-quote"><?php echo esc_html( $temoignage ); ?></blockquote>
					<?php endif; ?>
					<a href="<?php the_permalink(); ?>" class="portfolio-link">
						<?php esc_html_e( 'Voir le détail', 'arti100' ); ?>
						<span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
					</a>
				</div>
			</article>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>

		<?php
		// Fallback sur home_url si les rewrite rules ne sont pas encore flushées
		$archive = get_post_type_archive_link( 'travaux' ) ?: home_url( '/realisations/' );
		?>
		<div class="section-footer-cta">
			<a href="<?php echo esc_url( $archive ); ?>" class="btn btn-outline-primary">
				<?php esc_html_e( 'Voir toutes les réalisations', 'arti100' ); ?>
			</a>
		</div>
		<?php endif; ?>
	</div>
</section>
