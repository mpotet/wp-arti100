<?php
/**
 * Arti100 — page.php
 * Template page WP standard
 */
get_header();
?>

<div class="page-banner">
	<div class="container">
		<h1 class="page-banner-title"><?php the_title(); ?></h1>
		<?php arti100_breadcrumb(); ?>
	</div>
</div>

<div class="container content-area section-padded">
	<div class="content-layout <?php echo is_active_sidebar( 'sidebar-1' ) ? 'has-sidebar' : 'full-width'; ?>">
		<main class="site-content prose-content">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<figure class="page-featured-image"><?php the_post_thumbnail( 'large' ); ?></figure>
					<?php endif; ?>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</article>
			<?php endwhile; ?>
		</main>
		<?php if ( is_active_sidebar( 'sidebar-1' ) ) get_sidebar(); ?>
	</div>
</div>

<?php get_footer(); ?>
