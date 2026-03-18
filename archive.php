<?php
/**
 * Arti100 - archive.php
 * Archive pour les CPT travaux et service
 */
get_header();
$post_type = get_query_var( 'post_type' );
?>

<div class="page-banner">
	<div class="container">
		<h1 class="page-banner-title"><?php the_archive_title(); ?></h1>
		<?php arti100_breadcrumb(); ?>
	</div>
</div>

<div class="container section-padded">
	<?php if ( have_posts() ) : ?>
		<?php if ( $post_type === 'travaux' || is_post_type_archive( 'travaux' ) ) : ?>
			<!-- Grid portfolio pour les travaux -->
			<div class="portfolio-grid">
				<?php while ( have_posts() ) : the_post();
					$photo_apres = get_post_meta( get_the_ID(), '_travaux_photo_apres', true );
					$localite    = get_post_meta( get_the_ID(), '_travaux_localite', true );
					$thumb       = get_the_post_thumbnail_url( null, 'arti100-card' );
					$img         = $photo_apres ?: $thumb;
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'portfolio-item' ); ?>>
					<div class="portfolio-media">
						<?php if ( $img ) : ?>
							<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" />
						<?php endif; ?>
						<div class="portfolio-overlay">
							<h2><?php the_title(); ?></h2>
							<?php if ( $localite ) : ?>
								<p>📍 <?php echo esc_html( $localite ); ?></p>
							<?php endif; ?>
							<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-white"><?php esc_html_e( 'Voir le détail', 'arti100' ); ?></a>
						</div>
					</div>
				</article>
				<?php endwhile; ?>
			</div>
		<?php else : ?>
			<!-- Grid générique pour les services -->
			<div class="services-grid">
				<?php while ( have_posts() ) : the_post();
					$icone = get_post_meta( get_the_ID(), '_service_icone', true );
					$prix  = get_post_meta( get_the_ID(), '_service_prix', true );
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'service-card' ); ?>>
					<?php if ( $icone ) : ?>
						<div class="service-card-icon"><?php echo wp_kses_post( $icone ); ?></div>
					<?php endif; ?>
					<div class="service-card-body">
						<h2 class="service-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php the_excerpt(); ?></p>
						<?php if ( $prix ) : ?><p class="service-price-tag"><?php echo esc_html( $prix ); ?></p><?php endif; ?>
					</div>
					<a href="<?php the_permalink(); ?>" class="service-card-link"><?php esc_html_e( 'En savoir plus', 'arti100' ); ?> →</a>
				</article>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>

		<?php the_posts_pagination( [
			'prev_text' => '&laquo; ' . __( 'Précédent', 'arti100' ),
			'next_text' => __( 'Suivant', 'arti100' ) . ' &raquo;',
		] ); ?>

	<?php else : ?>
		<div class="no-results">
			<h2><?php esc_html_e( 'Aucun contenu pour le moment', 'arti100' ); ?></h2>
		</div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
