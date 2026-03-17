<?php
/**
 * Arti100 — template-parts/team-section.php
 */
$query = arti100_get_equipe();
if ( ! $query->have_posts() ) return;
?>

<section id="equipe" class="team-section section-padded">
	<div class="container">
		<div class="section-header">
			<span class="section-eyebrow"><?php esc_html_e( 'Notre équipe', 'arti100' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Des pros à votre service', 'arti100' ); ?></h2>
			<p class="section-subtitle"><?php esc_html_e( 'Une équipe qualifiée, passionnée et disponible pour tous vos travaux.', 'arti100' ); ?></p>
		</div>

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
							<svg width="64" height="64" viewBox="0 0 24 24" fill="var(--color-gray-300)" aria-hidden="true"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
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
							<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 3a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14m-.5 15.5v-5.3a3.26 3.26 0 00-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 011.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 001.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 00-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>
						</a>
					<?php endif; ?>
				</div>
			</div>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
</section>
