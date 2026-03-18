<?php
/**
 * Arti100 — template-parts/contact-section.php
 *
 * Mode "texte" (défaut) : affiche les coordonnées + horaires.
 * Mode "lien"           : idem + un bouton vers une URL externe (RDV, devis…).
 */

$phone   = arti100_get_phone();
$email   = esc_html( get_option( 'arti100_email', '' ) );
$zone    = esc_html( get_option( 'arti100_zone',  '' ) );
$maps    = arti100_get_maps_embed();

$titre      = get_option( 'arti100_contact_titre',      __( 'XXX - Titre contact', 'arti100' ) );
$sous_titre = get_option( 'arti100_contact_sous_titre', __( 'XXX - Sous-titre contact', 'arti100' ) );
$texte      = get_option( 'arti100_contact_texte', '' );

$hours_lv  = get_option( 'arti100_hours_lv',  __( 'XXX - Horaires lundi-vendredi', 'arti100' ) );
$hours_sam = get_option( 'arti100_hours_sam', __( 'XXX - Horaires samedi', 'arti100' ) );
$hours_dim = get_option( 'arti100_hours_dim', __( 'XXX - Horaires dimanche', 'arti100' ) );

$mode       = get_option( 'arti100_contact_mode',       'texte' );
$link_url   = get_option( 'arti100_contact_link_url',   '' );
$link_label = get_option( 'arti100_contact_link_label', __( 'XXX - Texte du bouton', 'arti100' ) );
?>

<section id="contact" class="contact-section section-padded">
	<div class="container">

		<div class="section-header">
			<span class="section-eyebrow"><?php esc_html_e( 'Contactez-nous', 'arti100' ); ?></span>
			<h2 class="section-title"><?php echo esc_html( $titre ); ?></h2>
			<?php if ( $sous_titre ) : ?>
				<p class="section-subtitle"><?php echo esc_html( $sous_titre ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( $texte ) : ?>
		<p class="contact-intro-text"><?php echo nl2br( esc_html( $texte ) ); ?></p>
		<?php endif; ?>

		<div class="contact-panels">

			<!-- Panel coordonnées -->
			<div class="contact-panel contact-panel-info">
				<h3 class="contact-panel-title">
					<span class="contact-panel-title-icon">
						<span class="material-symbols-outlined" aria-hidden="true">contact_phone</span>
					</span>
					<?php esc_html_e( 'Nos coordonnées', 'arti100' ); ?>
				</h3>

				<ul class="contact-details-list">
					<?php $phone_disp = $phone ?: __( 'XXX - Votre téléphone', 'arti100' ); ?>
					<li>
						<span class="contact-detail-icon">
							<span class="material-symbols-outlined" aria-hidden="true">call</span>
						</span>
						<span class="contact-detail-body">
							<span class="contact-detail-label"><?php esc_html_e( 'Téléphone', 'arti100' ); ?></span>
							<?php if ( $phone ) : ?>
								<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="contact-detail-value contact-detail-primary">
									<?php echo esc_html( $phone ); ?>
								</a>
							<?php else : ?>
								<span class="contact-detail-value contact-detail-primary"><?php echo esc_html( $phone_disp ); ?></span>
							<?php endif; ?>
						</span>
					</li>

					<?php $email_disp = $email ?: __( 'XXX - Votre email', 'arti100' ); ?>
					<li>
						<span class="contact-detail-icon">
							<span class="material-symbols-outlined" aria-hidden="true">mail</span>
						</span>
						<span class="contact-detail-body">
							<span class="contact-detail-label"><?php esc_html_e( 'Email', 'arti100' ); ?></span>
							<?php if ( $email ) : ?>
								<a href="mailto:<?php echo esc_attr( $email ); ?>" class="contact-detail-value">
									<?php echo esc_html( $email ); ?>
								</a>
							<?php else : ?>
								<span class="contact-detail-value"><?php echo esc_html( $email_disp ); ?></span>
							<?php endif; ?>
						</span>
					</li>

					<?php $zone_disp = $zone ?: __( 'XXX - Votre zone d\'intervention', 'arti100' ); ?>
					<li>
						<span class="contact-detail-icon contact-detail-icon--accent">
							<span class="material-symbols-outlined" aria-hidden="true">location_on</span>
						</span>
						<span class="contact-detail-body">
							<span class="contact-detail-label"><?php esc_html_e( 'Zone d\'intervention', 'arti100' ); ?></span>
							<span class="contact-detail-value"><?php echo esc_html( $zone_disp ); ?></span>
						</span>
					</li>
				</ul>

				<?php if ( $mode === 'lien' && $link_url ) : ?>
					<a href="<?php echo esc_url( $link_url ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary contact-cta-btn">
						<span class="material-symbols-outlined" aria-hidden="true">calendar_month</span>
						<?php echo esc_html( $link_label ); ?>
					</a>
				<?php elseif ( $mode === 'lien' && ! $link_url && current_user_can( 'manage_options' ) ) : ?>
					<div class="arti100-empty-notice" style="margin-top:1rem">
						<span class="material-symbols-outlined" aria-hidden="true">info</span>
						<p>
							<?php esc_html_e( 'Mode « Lien » activé mais aucune URL configurée.', 'arti100' ); ?>
							<a href="<?php echo esc_url( admin_url( 'admin.php?page=arti100-settings&tab=content' ) ); ?>">
								<?php esc_html_e( 'Configurer →', 'arti100' ); ?>
							</a>
						</p>
					</div>
				<?php endif; ?>
			</div>

			<!-- Panel horaires -->
			<div class="contact-panel contact-panel-hours">
				<h3 class="contact-panel-title">
					<span class="contact-panel-title-icon">
						<span class="material-symbols-outlined" aria-hidden="true">schedule</span>
					</span>
					<?php esc_html_e( 'Horaires', 'arti100' ); ?>
				</h3>

				<ul class="hours-list">
					<li>
						<span><?php esc_html_e( 'Lun – Ven', 'arti100' ); ?></span>
						<span><?php echo esc_html( $hours_lv ); ?></span>
					</li>
					<li>
						<span><?php esc_html_e( 'Samedi', 'arti100' ); ?></span>
						<span><?php echo esc_html( $hours_sam ); ?></span>
					</li>
					<li>
						<span><?php esc_html_e( 'Dimanche', 'arti100' ); ?></span>
						<span><?php echo esc_html( $hours_dim ); ?></span>
					</li>
				</ul>
			</div>

		</div><!-- .contact-panels -->

		<?php if ( $maps ) : ?>
		<div class="contact-map-full">
			<?php echo $maps; ?>
		</div>
		<?php endif; ?>

	</div><!-- .container -->
</section>
