<?php
/**
 * Template Name: Page Contact & Devis
 * Template Post Type: page
 *
 * Arti100 - template-contact.php
 */
get_header();
?>

<div class="page-banner">
	<div class="container">
		<h1 class="page-banner-title"><?php the_title(); ?></h1>
		<?php arti100_breadcrumb(); ?>
	</div>
</div>

<div class="container section-padded">
	<?php get_template_part( 'template-parts/contact-section' ); ?>
</div>

<?php
$maps = arti100_get_maps_embed();
if ( $maps ) : ?>
<div class="page-map-section">
	<div class="container">
		<h2 class="section-title" style="margin-bottom:1.5rem"><?php esc_html_e( 'Nous trouver', 'arti100' ); ?></h2>
		<div class="page-map-embed"><?php echo $maps; ?></div>
	</div>
</div>
<style>
.page-map-section { padding: 3rem 0; background: var(--color-bg-light); border-top: 1px solid var(--color-border); }
.page-map-embed   { border-radius: var(--radius-md); overflow: hidden; height: 450px; }
.page-map-embed iframe { width: 100%; height: 100%; border: 0; display: block; }
</style>
<?php endif; ?>

<?php get_footer(); ?>
