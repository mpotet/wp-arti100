<?php
/**
 * Arti100 — index.php
 * Template blog / liste articles (fallback général)
 */
get_header();
?>

<div class="page-banner">
	<div class="container">
		<h1 class="page-banner-title">
			<?php
			if ( is_home() ) {
				esc_html_e( 'Actualités', 'arti100' );
			} elseif ( is_search() ) {
				printf( esc_html__( 'Résultats pour "%s"', 'arti100' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
			} else {
				the_archive_title();
			}
			?>
		</h1>
		<?php arti100_breadcrumb(); ?>
	</div>
</div>

<div class="container content-area section-padded">
	<div class="content-layout <?php echo is_active_sidebar( 'sidebar-1' ) ? 'has-sidebar' : 'full-width'; ?>">

		<main class="site-content">
			<?php if ( have_posts() ) : ?>
				<div class="posts-grid">
					<?php while ( have_posts() ) : the_post(); ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>" class="post-card-thumb">
									<?php the_post_thumbnail( 'arti100-card' ); ?>
								</a>
							<?php endif; ?>
							<div class="post-card-body">
								<div class="post-card-meta">
									<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php the_date(); ?></time>
									<?php the_category( ', ' ); ?>
								</div>
								<h2 class="post-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<p class="post-card-excerpt"><?php the_excerpt(); ?></p>
								<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-primary">
									<?php esc_html_e( 'Lire la suite', 'arti100' ); ?>
								</a>
							</div>
						</article>
					<?php endwhile; ?>
				</div>

				<?php the_posts_pagination( [
					'prev_text' => '&laquo; ' . __( 'Précédent', 'arti100' ),
					'next_text' => __( 'Suivant', 'arti100' ) . ' &raquo;',
				] ); ?>

			<?php else : ?>
				<div class="no-results">
					<h2><?php esc_html_e( 'Rien à afficher', 'arti100' ); ?></h2>
					<p><?php esc_html_e( 'Aucun contenu ne correspond à votre recherche.', 'arti100' ); ?></p>
					<?php get_search_form(); ?>
				</div>
			<?php endif; ?>
		</main>

		<?php if ( is_active_sidebar( 'sidebar-1' ) ) get_sidebar(); ?>

	</div>
</div>

<?php get_footer(); ?>
