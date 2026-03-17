<?php
/**
 * Arti100 — template-parts/testimonials-section.php
 * Témoignages clients lus depuis les travaux + témoignages statiques de fallback.
 */

// Récupérer témoignages depuis les travaux
$args = [
	'post_type'      => 'travaux',
	'post_status'    => 'publish',
	'posts_per_page' => 6,
	'meta_query'     => [
		[
			'key'     => '_travaux_client_temoignage',
			'value'   => '',
			'compare' => '!=',
		],
	],
];
$tquery = new WP_Query( $args );

// Témoignages statiques de fallback si aucun chantier
$fallback = [
	[ 'name' => 'Jean-Pierre M.', 'localite' => 'Nantes', 'stars' => 5, 'text' => 'Intervention très rapide, travail soigné. Je recommande vivement cet artisan sérieux et professionnel.' ],
	[ 'name' => 'Sophie L.',      'localite' => 'Vallet',  'stars' => 5, 'text' => 'Devis clair, délais respectés, résultat impeccable. Équipe sympathique et compétente.' ],
	[ 'name' => 'Marc D.',        'localite' => 'Ancenis', 'stars' => 5, 'text' => 'Excellent rapport qualité-prix. Je ferai à nouveau appel à eux sans hésitation.' ],
];

if ( ! $tquery->have_posts() && empty( $fallback ) ) return;
?>

<section id="temoignages" class="testimonials-section section-padded bg-light">
	<div class="container">
		<div class="section-header">
			<span class="section-eyebrow"><?php esc_html_e( 'Ils nous font confiance', 'arti100' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Avis de nos clients', 'arti100' ); ?></h2>
			<div class="testimonials-rating-global">
				<?php echo arti100_stars( 5 ); ?>
				<span class="rating-score">4.9/5</span>
				<span class="rating-source"><?php esc_html_e( 'sur Google', 'arti100' ); ?></span>
			</div>
		</div>

		<div class="testimonials-grid" id="testimonials-slider">
			<?php if ( $tquery->have_posts() ) :
				while ( $tquery->have_posts() ) : $tquery->the_post();
					$temoignage = get_post_meta( get_the_ID(), '_travaux_client_temoignage', true );
					$localite   = get_post_meta( get_the_ID(), '_travaux_localite', true );
					if ( ! $temoignage ) continue;
			?>
				<div class="testimonial-card">
					<div class="testimonial-stars"><?php echo arti100_stars( 5 ); ?></div>
					<blockquote class="testimonial-quote"><?php echo esc_html( $temoignage ); ?></blockquote>
					<footer class="testimonial-author">
						<div class="author-avatar" aria-hidden="true">
							<svg width="32" height="32" viewBox="0 0 24 24" fill="var(--color-primary-light)"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
						</div>
						<div class="author-info">
							<cite class="author-name"><?php the_title(); ?></cite>
							<?php if ( $localite ) : ?>
								<span class="author-location">📍 <?php echo esc_html( $localite ); ?></span>
							<?php endif; ?>
						</div>
					</footer>
				</div>
			<?php endwhile; wp_reset_postdata();
			else :
				foreach ( $fallback as $t ) : ?>
					<div class="testimonial-card">
						<div class="testimonial-stars"><?php echo arti100_stars( $t['stars'] ); ?></div>
						<blockquote class="testimonial-quote"><?php echo esc_html( $t['text'] ); ?></blockquote>
						<footer class="testimonial-author">
							<div class="author-avatar" aria-hidden="true">
								<svg width="32" height="32" viewBox="0 0 24 24" fill="var(--color-primary-light)"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
							</div>
							<div class="author-info">
								<cite class="author-name"><?php echo esc_html( $t['name'] ); ?></cite>
								<span class="author-location">📍 <?php echo esc_html( $t['localite'] ); ?></span>
							</div>
						</footer>
					</div>
				<?php endforeach;
			endif; ?>
		</div>
	</div>
</section>
