<?php
/**
 * Arti100 — single.php
 * Template article blog
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
	<div class="content-layout has-sidebar">
		<main class="site-content prose-content">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="single-meta">
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php the_date(); ?></time>
						<?php the_category( ', ' ); ?>
					</div>
					<?php if ( has_post_thumbnail() ) : ?>
						<figure class="single-featured"><?php the_post_thumbnail( 'large' ); ?></figure>
					<?php endif; ?>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
					<?php
					the_post_navigation( [
						'prev_text' => '&laquo; %title',
						'next_text' => '%title &raquo;',
					] );
					?>
				</article>

				<?php if ( comments_open() || get_comments_number() ) : ?>
					<div class="comments-area"><?php comments_template(); ?></div>
				<?php endif; ?>
			<?php endwhile; ?>
		</main>
		<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer(); ?>
