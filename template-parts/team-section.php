<?php
/**
 * Arti100 - template-parts/team-section.php
 */
if ( ! get_option( 'arti100_show_equipe', '1' ) ) return;

$query = arti100_get_equipe();
$is_empty = ! $query->have_posts();

// Si vide et visiteur non admin → on n'affiche pas la section
if ( $is_empty && ! current_user_can( 'manage_options' ) ) return;

$titre      = get_option( 'arti100_equipe_titre',      __( 'XXX - Titre équipe', 'arti100' ) );
$sous_titre = get_option( 'arti100_equipe_sous_titre', __( 'XXX - Sous-titre équipe', 'arti100' ) );
?>

<section id="equipe" class="team-section section-padded">
	<div class="container">
		<div class="section-header">
			<span class="section-eyebrow"><?php esc_html_e( 'Notre équipe', 'arti100' ); ?></span>
			<h2 class="section-title"><?php echo esc_html( $titre ); ?></h2>
			<?php if ( $sous_titre ) : ?>
				<p class="section-subtitle"><?php echo esc_html( $sous_titre ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( $is_empty ) : ?>
			<div class="arti100-empty-notice">
				<span class="material-symbols-outlined" aria-hidden="true">info</span>
				<p>
					<?php esc_html_e( 'Aucun membre d\'équipe publié.', 'arti100' ); ?>
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=artisan' ) ); ?>">
						<?php esc_html_e( 'Ajouter des artisans →', 'arti100' ); ?>
					</a>
				</p>
			</div>
		<?php else : ?>
		<div class="team-grid">
			<?php while ( $query->have_posts() ) : $query->the_post();
				$poste    = get_post_meta( get_the_ID(), '_artisan_poste',    true );
				$bio      = get_post_meta( get_the_ID(), '_artisan_bio',     true );
				$linkedin = get_post_meta( get_the_ID(), '_artisan_linkedin', true );
				$photo    = get_the_post_thumbnail_url( null, 'arti100-portrait' );
			?>
			<div class="team-card">
				<div class="team-card-photo">
					<?php if ( $photo ) : ?>
						<img src="<?php echo esc_url( $photo ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" />
					<?php else : ?>
						<div class="team-photo-placeholder">
							<span class="material-symbols-outlined" style="font-size:4rem;color:var(--color-gray-300)" aria-hidden="true">person</span>
						</div>
					<?php endif; ?>
				</div>
				<div class="team-card-body">
					<h3 class="team-name"><?php the_title(); ?></h3>
					<?php if ( $poste ) : ?>
						<p class="team-poste"><?php echo esc_html( $poste ); ?></p>
					<?php endif; ?>
					<?php if ( $bio ) : ?>
						<p class="team-bio"><?php echo esc_html( $bio ); ?></p>
					<?php endif; ?>
					<?php if ( $linkedin ) : ?>
						<a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" class="team-linkedin" aria-label="<?php echo esc_attr( sprintf( __( 'LinkedIn de %s', 'arti100' ), get_the_title() ) ); ?>">
							<i class="bi bi-linkedin" aria-hidden="true"></i>
						</a>
					<?php endif; ?>
				</div>
			</div>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
		<?php endif; ?>
	</div>
</section>
