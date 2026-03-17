<?php
/**
 * Arti100 — single-travaux.php
 * Détail d'une réalisation avec avant/après slider
 */
get_header();
?>

<?php while ( have_posts() ) : the_post();
	$photo_avant  = get_post_meta( get_the_ID(), '_travaux_photo_avant',       true );
	$photo_apres  = get_post_meta( get_the_ID(), '_travaux_photo_apres',       true );
	$temoignage   = get_post_meta( get_the_ID(), '_travaux_client_temoignage', true );
	$duree        = get_post_meta( get_the_ID(), '_travaux_duree',             true );
	$localite     = get_post_meta( get_the_ID(), '_travaux_localite',           true );
	$has_ba       = $photo_avant && $photo_apres;
?>

<div class="page-banner">
	<div class="container">
		<h1 class="page-banner-title"><?php the_title(); ?></h1>
		<?php arti100_breadcrumb(); ?>
	</div>
</div>

<div class="container section-padded">
	<div class="travaux-detail-layout">

		<!-- Media avant/après -->
		<div class="travaux-media">
			<?php if ( $has_ba ) : ?>
				<div class="ba-slider ba-slider-large" data-avant="<?php echo esc_url( $photo_avant ); ?>" data-apres="<?php echo esc_url( $photo_apres ); ?>">
					<div class="ba-avant">
						<img src="<?php echo esc_url( $photo_avant ); ?>" alt="<?php esc_attr_e( 'Avant', 'arti100' ); ?>" />
						<span class="ba-label ba-label-avant"><?php esc_html_e( 'Avant', 'arti100' ); ?></span>
					</div>
					<div class="ba-apres" style="clip-path:inset(0 0 0 50%)">
						<img src="<?php echo esc_url( $photo_apres ); ?>" alt="<?php esc_attr_e( 'Après', 'arti100' ); ?>" />
						<span class="ba-label ba-label-apres"><?php esc_html_e( 'Après', 'arti100' ); ?></span>
					</div>
					<div class="ba-handle" role="slider" aria-valuemin="0" aria-valuemax="100" aria-valuenow="50">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="white"><path d="M9.4 18L8 16.6 12.6 12 8 7.4 9.4 6l6 6z"/><path d="M14.6 18l1.4-1.4L11.4 12l4.6-4.6L14.6 6l-6 6z"/></svg>
					</div>
				</div>
				<div class="ba-thumbs">
					<div class="ba-thumb-item">
						<img src="<?php echo esc_url( $photo_avant ); ?>" alt="Avant" loading="lazy" />
						<span><?php esc_html_e( 'Avant', 'arti100' ); ?></span>
					</div>
					<div class="ba-thumb-item">
						<img src="<?php echo esc_url( $photo_apres ); ?>" alt="Après" loading="lazy" />
						<span><?php esc_html_e( 'Après', 'arti100' ); ?></span>
					</div>
				</div>
			<?php elseif ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'large', [ 'class' => 'travaux-single-img' ] ); ?>
			<?php endif; ?>
		</div>

		<!-- Contenu & détails -->
		<div class="travaux-content">
			<div class="travaux-meta-badges">
				<?php if ( $localite ) : ?>
					<span class="travaux-badge">📍 <?php echo esc_html( $localite ); ?></span>
				<?php endif; ?>
				<?php if ( $duree ) : ?>
					<span class="travaux-badge">⏱ <?php echo esc_html( $duree ); ?></span>
				<?php endif; ?>
				<?php
				$terms = get_the_terms( get_the_ID(), 'type_travaux' );
				if ( $terms && ! is_wp_error( $terms ) ) :
					foreach ( $terms as $term ) : ?>
						<span class="travaux-badge travaux-badge-category"><?php echo esc_html( $term->name ); ?></span>
					<?php endforeach;
				endif; ?>
			</div>

			<div class="entry-content prose-content">
				<?php the_content(); ?>
			</div>

			<?php if ( $temoignage ) : ?>
				<blockquote class="travaux-temoignage">
					<svg width="28" height="28" viewBox="0 0 24 24" fill="var(--color-primary-light)" aria-hidden="true"><path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/></svg>
					<p><?php echo esc_html( $temoignage ); ?></p>
					<?php echo arti100_stars( 5 ); ?>
				</blockquote>
			<?php endif; ?>

			<div class="travaux-cta">
				<a href="<?php echo esc_url( arti100_get_devis_url() ); ?>" class="btn btn-accent btn-large">
					<?php esc_html_e( 'Demandez un devis similaire', 'arti100' ); ?>
				</a>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'travaux' ) ); ?>" class="btn btn-outline-primary">
					<?php esc_html_e( '← Toutes les réalisations', 'arti100' ); ?>
				</a>
			</div>
		</div>
	</div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
