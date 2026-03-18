<?php
/**
 * Arti100 - template-parts/services-section.php
 */
if ( ! get_option( 'arti100_show_services', '1' ) ) return;

$query = arti100_get_services( 6 );
$is_empty = ! $query->have_posts();

// Si vide et visiteur non admin → on n'affiche pas la section
if ( $is_empty && ! current_user_can( 'manage_options' ) ) return;

$titre      = get_option( 'arti100_services_titre',      __( 'XXX - Titre services', 'arti100' ) );
$sous_titre = get_option( 'arti100_services_sous_titre', __( 'XXX - Sous-titre services', 'arti100' ) );
?>

<section id="services" class="services-section section-padded">
	<div class="container">
		<div class="section-header">
			<span class="section-eyebrow"><?php esc_html_e( 'Ce que nous faisons', 'arti100' ); ?></span>
			<h2 class="section-title"><?php echo esc_html( $titre ); ?></h2>
			<?php if ( $sous_titre ) : ?>
				<p class="section-subtitle"><?php echo esc_html( $sous_titre ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( $is_empty ) : ?>
			<div class="arti100-empty-notice">
				<span class="material-symbols-outlined" aria-hidden="true">info</span>
				<p>
					<?php esc_html_e( 'Aucun service publié.', 'arti100' ); ?>
					<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=service' ) ); ?>">
						<?php esc_html_e( 'Ajouter des services →', 'arti100' ); ?>
					</a>
				</p>
			</div>
		<?php else : ?>
		<div class="services-grid">
			<?php while ( $query->have_posts() ) : $query->the_post();
				$icone = get_post_meta( get_the_ID(), '_service_icone', true );
				$prix  = get_post_meta( get_the_ID(), '_service_prix', true );
				$duree = get_post_meta( get_the_ID(), '_service_duree', true );
			?>
			<div class="service-card">
				<div class="service-card-icon">
					<?php if ( $icone ) : ?>
						<?php echo wp_kses_post( $icone ); ?>
					<?php else : ?>
						<span class="material-symbols-outlined" style="font-size:2.5rem;color:var(--color-primary)" aria-hidden="true">build</span>
					<?php endif; ?>
				</div>
				<div class="service-card-body">
					<h3 class="service-card-title"><?php the_title(); ?></h3>
					<p class="service-card-desc"><?php echo esc_html( get_the_excerpt() ); ?></p>
					<?php if ( $prix || $duree ) : ?>
						<div class="service-card-meta">
							<?php if ( $prix ) : ?>
								<span class="service-price-tag"><?php echo esc_html( $prix ); ?></span>
							<?php endif; ?>
							<?php if ( $duree ) : ?>
								<span class="service-duration-tag">
									<span class="material-symbols-outlined" style="font-size:14px" aria-hidden="true">schedule</span>
									<?php echo esc_html( $duree ); ?>
								</span>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="service-card-link" aria-label="<?php echo esc_attr( sprintf( __( 'En savoir plus sur %s', 'arti100' ), get_the_title() ) ); ?>">
					<?php esc_html_e( 'En savoir plus', 'arti100' ); ?>
					<span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
				</a>
			</div>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>

		<div class="section-footer-cta">
			<a href="<?php echo esc_url( arti100_get_devis_url() ); ?>" class="btn btn-primary btn-large">
				<?php esc_html_e( 'Obtenir un devis gratuit', 'arti100' ); ?>
			</a>
		</div>
		<?php endif; ?>
	</div>
</section>
