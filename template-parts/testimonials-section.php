<?php
/**
 * Arti100 — template-parts/testimonials-section.php
 * Les témoignages viennent :
 *   1. En priorité des CPT Réalisations (travaux) si renseignés.
 *   2. Sinon depuis les options admin (onglet Contenu → Témoignages).
 *   3. Sinon message d'info à l'admin si aucune source disponible.
 */
if ( ! get_option( 'arti100_show_temoignages', '1' ) ) return;

$titre = get_option( 'arti100_temos_titre', __( 'XXX - Titre avis clients', 'arti100' ) );
$note  = get_option( 'arti100_temos_note', 'XXX' );

// 1. Témoignages depuis les réalisations (CPT)
$tquery = new WP_Query( [
	'post_type'      => 'travaux',
	'post_status'    => 'publish',
	'posts_per_page' => 6,
	'meta_query'     => [[
		'key'     => '_travaux_client_temoignage',
		'value'   => '',
		'compare' => '!=',
	]],
] );

// 2. Témoignages depuis les options admin
$temos_admin = [];
for ( $i = 1; $i <= 6; $i++ ) {
	$texte = get_option( "arti100_temo_{$i}_texte", '' );
	if ( ! empty( $texte ) ) {
		$temos_admin[] = [
			'nom'      => get_option( "arti100_temo_{$i}_nom",      "XXX - Prénom N." ),
			'localite' => get_option( "arti100_temo_{$i}_localite", "XXX - Ville" ),
			'texte'    => $texte,
			'note'     => (int) get_option( "arti100_temo_{$i}_note", 5 ),
		];
	}
}

$use_cpt   = $tquery->have_posts();
$use_admin = ! $use_cpt && ! empty( $temos_admin );
$is_empty  = ! $use_cpt && ! $use_admin;

// Si vide et visiteur non admin → on n'affiche pas la section
if ( $is_empty && ! current_user_can( 'manage_options' ) ) return;
?>

<section id="temoignages" class="testimonials-section section-padded bg-light">
	<div class="container">
		<div class="section-header">
			<span class="section-eyebrow"><?php esc_html_e( 'Ils nous font confiance', 'arti100' ); ?></span>
			<h2 class="section-title"><?php echo esc_html( $titre ); ?></h2>
			<div class="testimonials-rating-global">
				<?php echo arti100_stars( 5 ); ?>
				<span class="rating-score"><?php echo esc_html( $note ); ?>/5</span>
				<span class="rating-source"><?php esc_html_e( 'sur Google', 'arti100' ); ?></span>
			</div>
		</div>

		<?php if ( $is_empty ) : ?>
			<div class="arti100-empty-notice">
				<span class="material-symbols-outlined" aria-hidden="true">info</span>
				<p>
					<?php esc_html_e( 'Aucun témoignage configuré.', 'arti100' ); ?>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=arti100-settings&tab=content' ) ); ?>">
						<?php esc_html_e( 'Ajouter des témoignages →', 'arti100' ); ?>
					</a>
					<?php esc_html_e( 'ou publier des réalisations avec un avis client.', 'arti100' ); ?>
				</p>
			</div>
		<?php else : ?>
		<div class="testimonials-grid" id="testimonials-slider">
			<?php if ( $use_cpt ) :
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
							<span class="material-symbols-outlined" style="font-size:2rem;color:var(--color-primary-light)">person</span>
						</div>
						<div class="author-info">
							<cite class="author-name"><?php the_title(); ?></cite>
							<?php if ( $localite ) : ?>
								<span class="author-location">
									<span class="material-symbols-outlined" aria-hidden="true">location_on</span>
									<?php echo esc_html( $localite ); ?>
								</span>
							<?php endif; ?>
						</div>
					</footer>
				</div>
			<?php endwhile; wp_reset_postdata();

			else :
				foreach ( $temos_admin as $t ) : ?>
				<div class="testimonial-card">
					<div class="testimonial-stars"><?php echo arti100_stars( $t['note'] ); ?></div>
					<blockquote class="testimonial-quote"><?php echo esc_html( $t['texte'] ); ?></blockquote>
					<footer class="testimonial-author">
						<div class="author-avatar" aria-hidden="true">
							<span class="material-symbols-outlined" style="font-size:2rem;color:var(--color-primary-light)">person</span>
						</div>
						<div class="author-info">
							<cite class="author-name"><?php echo esc_html( $t['nom'] ); ?></cite>
							<span class="author-location">
								<span class="material-symbols-outlined" aria-hidden="true">location_on</span>
								<?php echo esc_html( $t['localite'] ); ?>
							</span>
						</div>
					</footer>
				</div>
			<?php endforeach;
			endif; ?>
		</div>
		<?php endif; ?>
	</div>
</section>
