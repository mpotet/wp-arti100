<?php
/**
 * Arti100 — template-parts/contact-section.php
 */
$phone     = arti100_get_phone();
$email     = esc_html( get_option( 'arti100_email', '' ) );
$zone      = esc_html( get_option( 'arti100_zone', '' ) );
$calendly  = get_option( 'arti100_calendly_url', '' );
$cf7_id    = (int) get_option( 'arti100_cf7_id', 0 );
$maps      = arti100_get_maps_embed();
?>

<section id="contact" class="contact-section section-padded">
	<div class="container">
		<div class="section-header">
			<span class="section-eyebrow"><?php esc_html_e( 'Contactez-nous', 'arti100' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Demandez votre devis gratuit', 'arti100' ); ?></h2>
			<p class="section-subtitle"><?php esc_html_e( 'Réponse sous 24h · Devis gratuit et sans engagement', 'arti100' ); ?></p>
		</div>

		<div class="contact-layout">

			<!-- Formulaire / Calendly -->
			<div class="contact-form-col">
				<?php if ( $cf7_id && function_exists( 'wpcf7_contact_form' ) ) : ?>
					<?php echo do_shortcode( '[contact-form-7 id="' . $cf7_id . '" title="Devis"]' ); ?>
				<?php elseif ( ! empty( $calendly ) ) : ?>
					<div class="calendly-inline-widget"
					     data-url="<?php echo esc_url( $calendly ); ?>"
					     style="min-width:320px;height:700px">
					</div>
					<script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
				<?php else : ?>
					<!-- Formulaire HTML natif fallback -->
					<form class="contact-form-native" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						<?php wp_nonce_field( 'arti100_contact_form', 'arti100_contact_nonce' ); ?>
						<input type="hidden" name="action" value="arti100_send_contact" />
						<div class="form-row form-row-2">
							<div class="form-group">
								<label for="contact_name"><?php esc_html_e( 'Prénom & Nom *', 'arti100' ); ?></label>
								<input type="text" id="contact_name" name="contact_name" required />
							</div>
							<div class="form-group">
								<label for="contact_phone"><?php esc_html_e( 'Téléphone *', 'arti100' ); ?></label>
								<input type="tel" id="contact_phone" name="contact_phone" required />
							</div>
						</div>
						<div class="form-group">
							<label for="contact_email"><?php esc_html_e( 'Email', 'arti100' ); ?></label>
							<input type="email" id="contact_email" name="contact_email" />
						</div>
						<div class="form-group">
							<label for="contact_service"><?php esc_html_e( 'Type de travaux', 'arti100' ); ?></label>
							<select id="contact_service" name="contact_service">
								<option value=""><?php esc_html_e( 'Choisir...', 'arti100' ); ?></option>
								<?php
								$services = arti100_get_services();
								while ( $services->have_posts() ) {
									$services->the_post();
									echo '<option value="' . esc_attr( get_the_title() ) . '">' . esc_html( get_the_title() ) . '</option>';
								}
								wp_reset_postdata();
								?>
								<option value="autre"><?php esc_html_e( 'Autre / Non listé', 'arti100' ); ?></option>
							</select>
						</div>
						<div class="form-group">
							<label for="contact_message"><?php esc_html_e( 'Décrivez votre projet *', 'arti100' ); ?></label>
							<textarea id="contact_message" name="contact_message" rows="5" required placeholder="<?php esc_attr_e( 'Décrivez vos travaux, la surface, l\'urgence…', 'arti100' ); ?>"></textarea>
						</div>
						<button type="submit" class="btn btn-accent btn-large btn-full">
							<?php esc_html_e( 'Envoyer ma demande de devis', 'arti100' ); ?>
						</button>
						<p class="form-legal"><?php esc_html_e( 'Vos données sont confidentielles et ne seront pas partagées.', 'arti100' ); ?></p>
					</form>
				<?php endif; ?>
			</div>

			<!-- Infos de contact -->
			<div class="contact-info-col">
				<div class="contact-info-card">
					<h3><?php esc_html_e( 'Contactez-nous directement', 'arti100' ); ?></h3>

					<?php if ( $phone ) : ?>
						<div class="contact-info-item">
							<div class="contact-info-icon">
								<svg width="22" height="22" viewBox="0 0 24 24" fill="var(--color-primary)" aria-hidden="true"><path d="M6.62 10.79a15.1 15.1 0 006.59 6.59l2.2-2.2a1 1 0 011.02-.24A11.36 11.36 0 0020 17.57a1 1 0 011 1V20a1 1 0 01-1 1C10.56 21 3 13.44 3 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.45.57 3.57a1 1 0 01-.25 1.02l-2.2 2.2z"/></svg>
							</div>
							<div>
								<p class="contact-info-label"><?php esc_html_e( 'Téléphone', 'arti100' ); ?></p>
								<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="contact-info-value contact-info-primary"><?php echo esc_html( $phone ); ?></a>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( $email ) : ?>
						<div class="contact-info-item">
							<div class="contact-info-icon">
								<svg width="22" height="22" viewBox="0 0 24 24" fill="var(--color-primary)" aria-hidden="true"><path d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
							</div>
							<div>
								<p class="contact-info-label"><?php esc_html_e( 'Email', 'arti100' ); ?></p>
								<a href="mailto:<?php echo esc_attr( $email ); ?>" class="contact-info-value"><?php echo esc_html( $email ); ?></a>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( $zone ) : ?>
						<div class="contact-info-item">
							<div class="contact-info-icon">
								<svg width="22" height="22" viewBox="0 0 24 24" fill="var(--color-accent)" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 119.5 9a2.5 2.5 0 012.5 2.5z"/></svg>
							</div>
							<div>
								<p class="contact-info-label"><?php esc_html_e( 'Zone d\'intervention', 'arti100' ); ?></p>
								<p class="contact-info-value"><?php echo esc_html( $zone ); ?></p>
							</div>
						</div>
					<?php endif; ?>

					<!-- Horaires (statiques par défaut) -->
					<div class="contact-hours">
						<h4><?php esc_html_e( 'Horaires', 'arti100' ); ?></h4>
						<ul class="hours-list">
							<li><span><?php esc_html_e( 'Lun – Ven', 'arti100' ); ?></span><span>8h – 18h</span></li>
							<li><span><?php esc_html_e( 'Samedi', 'arti100' ); ?></span><span>9h – 12h</span></li>
							<li><span><?php esc_html_e( 'Dimanche', 'arti100' ); ?></span><span><?php esc_html_e( 'Fermé', 'arti100' ); ?></span></li>
						</ul>
					</div>

					<?php if ( ! empty( $calendly ) ) : ?>
						<a href="<?php echo esc_url( $calendly ); ?>" class="btn btn-primary btn-full js-calendly" data-calendly="<?php echo esc_attr( $calendly ); ?>">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 3h-1V1h-2v2H8V1H6v2H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zm0 16H5V8h14v11zM9 10H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2z"/></svg>
							<?php esc_html_e( 'Prendre rendez-vous en ligne', 'arti100' ); ?>
						</a>
					<?php endif; ?>
				</div>

				<?php if ( $maps ) : ?>
					<div class="contact-map"><?php echo $maps; ?></div>
				<?php endif; ?>
			</div>

		</div><!-- .contact-layout -->
	</div><!-- .container -->
</section>

<?php
// Handler formulaire natif
function arti100_handle_contact_form() {
	if ( ! isset( $_POST['arti100_contact_nonce'] ) ) return;
	if ( ! wp_verify_nonce( $_POST['arti100_contact_nonce'], 'arti100_contact_form' ) ) wp_die( 'Nonce invalide' );

	$name    = sanitize_text_field( $_POST['contact_name']    ?? '' );
	$phone   = sanitize_text_field( $_POST['contact_phone']   ?? '' );
	$email   = sanitize_email(      $_POST['contact_email']   ?? '' );
	$service = sanitize_text_field( $_POST['contact_service'] ?? '' );
	$message = sanitize_textarea_field( $_POST['contact_message'] ?? '' );

	$to      = get_option( 'arti100_email', get_option( 'admin_email' ) );
	$subject = sprintf( __( '[Devis] %s — %s', 'arti100' ), $service, $name );
	$body    = sprintf( "Nom : %s\nTél : %s\nEmail : %s\nService : %s\n\n%s", $name, $phone, $email, $service, $message );
	$headers = [ 'Content-Type: text/plain; charset=UTF-8' ];
	if ( $email ) $headers[] = 'Reply-To: ' . $email;

	wp_mail( $to, $subject, $body, $headers );
	wp_redirect( add_query_arg( 'devis', 'envoye', wp_get_referer() ) );
	exit;
}
add_action( 'admin_post_arti100_send_contact',        'arti100_handle_contact_form' );
add_action( 'admin_post_nopriv_arti100_send_contact', 'arti100_handle_contact_form' );
