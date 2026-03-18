<?php
/**
 * Arti100 — single-travaux.php
 * Détail d'une réalisation avec avant/après slider
 */
get_header();
?>

<style>
.travaux-detail-layout {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 3rem;
	align-items: start;
}
@media (max-width: 900px) {
	.travaux-detail-layout { grid-template-columns: 1fr; }
}
.ba-slider-large {
	position: relative;
	overflow: hidden;
	border-radius: 12px;
	aspect-ratio: 4 / 3;
	user-select: none;
}
.ba-slider-large .ba-avant,
.ba-slider-large .ba-apres {
	position: absolute;
	inset: 0;
}
.ba-slider-large img {
	width: 100%;
	height: 100%;
	object-fit: cover;
	display: block;
}
.ba-slider-large .ba-handle {
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	width: 44px;
	height: 44px;
	border-radius: 50%;
	background: white;
	box-shadow: 0 2px 12px rgba(0,0,0,.25);
	display: flex;
	align-items: center;
	justify-content: center;
	cursor: ew-resize;
	z-index: 10;
	color: var(--color-primary, #007cba);
}
.ba-thumbs {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: .75rem;
	margin-top: 1rem;
}
.ba-thumb-item {
	text-align: center;
}
.ba-thumb-item img {
	width: 100%;
	aspect-ratio: 4 / 3;
	object-fit: cover;
	border-radius: 8px;
}
.ba-thumb-item span {
	display: block;
	font-size: .8rem;
	font-weight: 600;
	margin-top: .25rem;
	color: var(--color-gray-500, #6b7280);
	text-transform: uppercase;
	letter-spacing: .05em;
}
.travaux-content { padding-top: .5rem; }
.travaux-meta-badges {
	display: flex;
	flex-wrap: wrap;
	gap: .5rem;
	margin-bottom: 1.5rem;
}
.travaux-badge {
	display: inline-flex;
	align-items: center;
	gap: .3rem;
	padding: .375rem .875rem;
	background: var(--color-gray-100, #f3f4f6);
	border-radius: 50px;
	font-size: .85rem;
	font-weight: 600;
}
.travaux-badge .material-symbols-outlined { font-size: 16px; }
.travaux-badge-category {
	background: var(--color-primary, #007cba);
	color: white;
}
.travaux-temoignage {
	border-left: 4px solid var(--color-primary, #007cba);
	padding: 1.25rem 1.5rem;
	margin: 1.75rem 0;
	background: var(--color-gray-50, #f8f9fa);
	border-radius: 0 10px 10px 0;
	font-style: italic;
}
.travaux-temoignage .material-symbols-outlined {
	display: block;
	font-size: 2rem;
	color: var(--color-primary, #007cba);
	margin-bottom: .5rem;
	opacity: .5;
}
.travaux-cta {
	display: flex;
	gap: 1rem;
	flex-wrap: wrap;
	margin-top: 2rem;
}
.travaux-single-img {
	width: 100%;
	border-radius: 12px;
	object-fit: cover;
}
</style>

<?php while ( have_posts() ) : the_post();
	$photo_avant  = get_post_meta( get_the_ID(), '_travaux_photo_avant',       true );
	$photo_apres  = get_post_meta( get_the_ID(), '_travaux_photo_apres',       true );
	$temoignage   = get_post_meta( get_the_ID(), '_travaux_client_temoignage', true );
	$duree        = get_post_meta( get_the_ID(), '_travaux_duree',             true );
	$localite     = get_post_meta( get_the_ID(), '_travaux_localite',          true );
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
						<span class="material-symbols-outlined" aria-hidden="true">swap_horiz</span>
					</div>
				</div>
				<div class="ba-thumbs">
					<div class="ba-thumb-item">
						<img src="<?php echo esc_url( $photo_avant ); ?>" alt="<?php esc_attr_e( 'Avant', 'arti100' ); ?>" loading="lazy" />
						<span><?php esc_html_e( 'Avant', 'arti100' ); ?></span>
					</div>
					<div class="ba-thumb-item">
						<img src="<?php echo esc_url( $photo_apres ); ?>" alt="<?php esc_attr_e( 'Après', 'arti100' ); ?>" loading="lazy" />
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
					<span class="travaux-badge">
						<span class="material-symbols-outlined" aria-hidden="true">location_on</span>
						<?php echo esc_html( $localite ); ?>
					</span>
				<?php endif; ?>
				<?php if ( $duree ) : ?>
					<span class="travaux-badge">
						<span class="material-symbols-outlined" aria-hidden="true">schedule</span>
						<?php echo esc_html( $duree ); ?>
					</span>
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
					<span class="material-symbols-outlined" aria-hidden="true">format_quote</span>
					<p><?php echo esc_html( $temoignage ); ?></p>
					<?php echo arti100_stars( 5 ); ?>
				</blockquote>
			<?php endif; ?>

			<div class="travaux-cta">
				<a href="<?php echo esc_url( arti100_get_devis_url() ); ?>" class="btn btn-accent btn-large">
					<?php esc_html_e( 'Demandez un devis similaire', 'arti100' ); ?>
				</a>
				<?php $archive = get_post_type_archive_link( 'travaux' ) ?: home_url( '/realisations/' ); ?>
				<a href="<?php echo esc_url( $archive ); ?>" class="btn btn-outline-primary">
					<span class="material-symbols-outlined" aria-hidden="true">arrow_back</span>
					<?php esc_html_e( 'Toutes les réalisations', 'arti100' ); ?>
				</a>
			</div>
		</div>
	</div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
