<?php
/**
 * Template Name: Portfolio - Réalisations
 * Template Post Type: page
 *
 * Arti100 - template-portfolio.php
 */
get_header();
?>

<div class="page-banner">
	<div class="container">
		<h1 class="page-banner-title"><?php the_title(); ?></h1>
		<?php arti100_breadcrumb(); ?>
	</div>
</div>

<?php
// Filtres par type de travaux
$terms = get_terms( [ 'taxonomy' => 'type_travaux', 'hide_empty' => true ] );
?>

<?php if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) : ?>
<div class="portfolio-filters-bar">
	<div class="container">
		<div class="portfolio-filters">
			<button class="filter-btn active" data-filter="*"><?php esc_html_e( 'Tous', 'arti100' ); ?></button>
			<?php foreach ( $terms as $term ) : ?>
				<button class="filter-btn" data-filter="<?php echo esc_attr( $term->slug ); ?>">
					<?php echo esc_html( $term->name ); ?>
				</button>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<?php endif; ?>

<div class="container section-padded">
	<?php
	$paged = max( 1, get_query_var( 'paged' ) );
	$args  = [
		'post_type'      => 'travaux',
		'post_status'    => 'publish',
		'posts_per_page' => 12,
		'paged'          => $paged,
		'orderby'        => 'date',
		'order'          => 'DESC',
	];

	// Filtre terme si URL contient ?filtre=
	if ( isset( $_GET['filtre'] ) && ! empty( $_GET['filtre'] ) ) {
		$term_slug = sanitize_key( $_GET['filtre'] );
		$args['tax_query'] = [ [
			'taxonomy' => 'type_travaux',
			'field'    => 'slug',
			'terms'    => $term_slug,
		] ];
	}

	$query = new WP_Query( $args );
	?>

	<?php if ( $query->have_posts() ) : ?>
		<div class="portfolio-grid portfolio-filterable">
			<?php while ( $query->have_posts() ) : $query->the_post();
				$photo_apres = get_post_meta( get_the_ID(), '_travaux_photo_apres', true );
				$photo_avant = get_post_meta( get_the_ID(), '_travaux_photo_avant', true );
				$localite    = get_post_meta( get_the_ID(), '_travaux_localite', true );
				$duree       = get_post_meta( get_the_ID(), '_travaux_duree', true );
				$thumb       = get_the_post_thumbnail_url( null, 'arti100-card' );
				$img         = $photo_apres ?: $thumb;

				// Terms pour filtre
				$post_terms = get_the_terms( get_the_ID(), 'type_travaux' );
				$term_slugs = '';
				if ( $post_terms && ! is_wp_error( $post_terms ) ) {
					$term_slugs = implode( ' ', wp_list_pluck( $post_terms, 'slug' ) );
				}
			?>
			<article class="portfolio-item filterable-item <?php echo esc_attr( $term_slugs ); ?>"
			         data-terms="<?php echo esc_attr( $term_slugs ); ?>">
				<div class="portfolio-media">
					<?php if ( $photo_avant && $photo_apres ) : ?>
						<div class="ba-slider"
						     data-avant="<?php echo esc_url( $photo_avant ); ?>"
						     data-apres="<?php echo esc_url( $photo_apres ); ?>">
							<div class="ba-avant">
								<img src="<?php echo esc_url( $photo_avant ); ?>" alt="Avant" loading="lazy" />
								<span class="ba-label ba-label-avant"><?php esc_html_e( 'Avant', 'arti100' ); ?></span>
							</div>
							<div class="ba-apres" style="clip-path:inset(0 0 0 50%)">
								<img src="<?php echo esc_url( $photo_apres ); ?>" alt="Après" loading="lazy" />
								<span class="ba-label ba-label-apres"><?php esc_html_e( 'Après', 'arti100' ); ?></span>
							</div>
							<div class="ba-handle">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="white"><path d="M9.4 18L8 16.6 12.6 12 8 7.4 9.4 6l6 6z"/><path d="M14.6 18l1.4-1.4L11.4 12l4.6-4.6L14.6 6l-6 6z"/></svg>
							</div>
						</div>
					<?php elseif ( $img ) : ?>
						<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" />
					<?php endif; ?>

					<?php if ( $post_terms && ! is_wp_error( $post_terms ) ) : ?>
						<span class="portfolio-category"><?php echo esc_html( $post_terms[0]->name ); ?></span>
					<?php endif; ?>
				</div>
				<div class="portfolio-body">
					<h2><?php the_title(); ?></h2>
					<?php if ( $localite ) echo '<p class="portfolio-location">📍 ' . esc_html( $localite ) . '</p>'; ?>
					<?php if ( $duree )    echo '<p class="portfolio-duration">⏱ ' . esc_html( $duree ) . '</p>'; ?>
					<a href="<?php the_permalink(); ?>" class="portfolio-link"><?php esc_html_e( 'Voir le détail', 'arti100' ); ?> →</a>
				</div>
			</article>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>

		<?php
		echo paginate_links( [
			'base'    => get_pagenum_link( 1 ) . '%_%',
			'format'  => 'page/%#%/',
			'current' => $paged,
			'total'   => $query->max_num_pages,
		] );
		?>

	<?php else : ?>
		<div class="no-results">
			<p><?php esc_html_e( 'Aucune réalisation pour le moment. Revenez bientôt !', 'arti100' ); ?></p>
		</div>
	<?php endif; ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
	var btns  = document.querySelectorAll('.filter-btn');
	var items = document.querySelectorAll('.filterable-item');
	btns.forEach(function(btn){
		btn.addEventListener('click', function(){
			btns.forEach(function(b){ b.classList.remove('active'); });
			btn.classList.add('active');
			var filter = btn.dataset.filter;
			items.forEach(function(item){
				if(filter === '*' || item.dataset.terms.split(' ').includes(filter)){
					item.style.display = '';
				} else {
					item.style.display = 'none';
				}
			});
		});
	});
});
</script>

<style>
.portfolio-filters-bar { border-bottom: 1px solid var(--color-border); padding: 1rem 0; background: #fff; position: sticky; top: 72px; z-index: 100; }
.portfolio-filters      { display: flex; gap: .5rem; flex-wrap: wrap; }
.filter-btn {
	padding: .45rem 1.1rem;
	border: 1.5px solid var(--color-border);
	border-radius: 999px;
	font-size: .85rem;
	font-weight: 600;
	cursor: pointer;
	background: #fff;
	color: var(--color-text);
	transition: all .2s;
}
.filter-btn.active,
.filter-btn:hover { background: var(--color-primary); color: #fff; border-color: var(--color-primary); }
</style>

<?php get_footer(); ?>
