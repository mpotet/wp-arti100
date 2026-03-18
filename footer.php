<?php
/**
 * Arti100 - footer.php
 */

$company     = arti100_get_company_name();
$company_raw = get_option( 'arti100_company_name', '' );
$company_copy = $company_raw ?: __( 'XXX - Nom entreprise', 'arti100' );
$phone       = arti100_get_phone();
$email       = esc_html( get_option( 'arti100_email', '' ) );
$address     = esc_html( get_option( 'arti100_address', '' ) );
$zone        = esc_html( get_option( 'arti100_zone', '' ) );
$facebook    = get_option( 'arti100_facebook', '' );
$instagram   = get_option( 'arti100_instagram', '' );
$linkedin    = get_option( 'arti100_linkedin_url', '' );
$siret       = esc_html( get_option( 'arti100_siret', '' ) );
$footer_text = get_option( 'arti100_footer_text', '' );
?>
</main><!-- #main-content -->

<footer id="colophon" class="site-footer" role="contentinfo">

	<!-- FOOTER CTA BAND -->
	<div class="footer-cta-band">
		<div class="container footer-cta-inner">
			<div class="footer-cta-text">
				<h2><?php esc_html_e( 'Besoin d\'un artisan rapidement ?', 'arti100' ); ?></h2>
				<p><?php echo esc_html( $zone ? sprintf( __( 'Intervention sur %s.', 'arti100' ), $zone ) : __( 'Contactez-nous dès aujourd\'hui.', 'arti100' ) ); ?></p>
			</div>
			<div class="footer-cta-actions">
				<?php if ( $phone ) : ?>
					<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="btn btn-white-outline">
						<span class="material-symbols-outlined" aria-hidden="true">call</span>
						<?php echo esc_html( $phone ); ?>
					</a>
				<?php endif; ?>
				<a href="<?php echo esc_url( arti100_get_devis_url() ); ?>" class="btn btn-accent">
					<?php esc_html_e( 'Devis gratuit', 'arti100' ); ?>
				</a>
			</div>
		</div>
	</div>

	<!-- FOOTER COLONNES -->
	<div class="footer-main">
		<div class="container footer-grid">

			<!-- Col 1 : Infos entreprise -->
			<div class="footer-col footer-col-brand">
				<?php echo arti100_logo_html(); ?>
				<p class="footer-slogan"><?php echo arti100_get_slogan(); ?></p>
				<div class="footer-contact-list">
					<?php if ( $phone ) : ?>
						<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="footer-contact-item">
							<span class="material-symbols-outlined" aria-hidden="true">call</span>
							<?php echo esc_html( $phone ); ?>
						</a>
					<?php endif; ?>
					<?php if ( $email ) : ?>
						<a href="mailto:<?php echo esc_attr( $email ); ?>" class="footer-contact-item">
							<span class="material-symbols-outlined" aria-hidden="true">mail</span>
							<?php echo esc_html( $email ); ?>
						</a>
					<?php endif; ?>
					<?php if ( $address ) : ?>
						<span class="footer-contact-item">
							<span class="material-symbols-outlined" aria-hidden="true">location_on</span>
							<?php echo esc_html( $address ); ?>
						</span>
					<?php endif; ?>
				</div>
				<!-- Réseaux sociaux via Bootstrap Icons CDN -->
				<div class="footer-socials">
					<?php if ( $facebook ) : ?>
						<a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="social-icon">
							<i class="bi bi-facebook" aria-hidden="true"></i>
						</a>
					<?php endif; ?>
					<?php if ( $instagram ) : ?>
						<a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="social-icon">
							<i class="bi bi-instagram" aria-hidden="true"></i>
						</a>
					<?php endif; ?>
					<?php if ( $linkedin ) : ?>
						<a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" class="social-icon">
							<i class="bi bi-linkedin" aria-hidden="true"></i>
						</a>
					<?php endif; ?>
				</div>
			</div>

			<!-- Col 2 : Services -->
			<div class="footer-col">
				<h4 class="footer-col-title"><?php esc_html_e( 'Nos services', 'arti100' ); ?></h4>
				<?php
				$services_query = arti100_get_services( 6 );
				if ( $services_query->have_posts() ) :
				?>
				<ul class="footer-links">
					<?php while ( $services_query->have_posts() ) : $services_query->the_post(); ?>
						<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
					<?php endwhile; wp_reset_postdata(); ?>
				</ul>
				<?php endif; ?>
			</div>

			<!-- Col 3 : Navigation (liens ancre → homepage) -->
			<div class="footer-col">
				<h4 class="footer-col-title"><?php esc_html_e( 'Navigation', 'arti100' ); ?></h4>
				<?php
				$home = home_url( '/' );
				wp_nav_menu( [
					'theme_location' => 'footer',
					'menu_class'     => 'footer-links',
					'container'      => false,
					'depth'          => 1,
					'fallback_cb'    => function() use ( $home ) {
						echo '<ul class="footer-links">';
						echo '<li><a href="' . esc_url( $home ) . '">' . esc_html__( 'Accueil', 'arti100' ) . '</a></li>';
						echo '<li><a href="' . esc_url( $home ) . '#services">'     . esc_html__( 'Services', 'arti100' )     . '</a></li>';
						echo '<li><a href="' . esc_url( $home ) . '#realisations">' . esc_html__( 'Réalisations', 'arti100' ) . '</a></li>';
						echo '<li><a href="' . esc_url( $home ) . '#contact">'      . esc_html__( 'Contact', 'arti100' )      . '</a></li>';
						$mentions = get_page_by_path( 'mentions-legales' );
						if ( $mentions ) echo '<li><a href="' . esc_url( get_permalink( $mentions ) ) . '">' . esc_html__( 'Mentions légales', 'arti100' ) . '</a></li>';
						echo '</ul>';
					},
				] );
				?>
			</div>

			<!-- Col 4 : Zone -->
			<div class="footer-col">
				<h4 class="footer-col-title"><?php esc_html_e( 'Zone d\'intervention', 'arti100' ); ?></h4>
				<?php if ( $zone ) : ?>
					<div class="footer-zone">
						<span class="material-symbols-outlined" aria-hidden="true" style="color:var(--color-accent)">location_on</span>
						<p><?php echo esc_html( $zone ); ?></p>
					</div>
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'footer-1' ) ) dynamic_sidebar( 'footer-1' ); ?>
			</div>

		</div><!-- .footer-grid -->
	</div><!-- .footer-main -->

	<!-- FOOTER BOTTOM -->
	<div class="footer-bottom">
		<div class="container footer-bottom-inner">
			<div class="footer-bottom-left">
				<?php if ( $footer_text ) : ?>
					<?php echo wp_kses_post( $footer_text ); ?>
				<?php else : ?>
					<span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> &middot; <?php echo esc_html( $company_copy ); ?> &middot; <?php esc_html_e( 'Tous droits réservés', 'arti100' ); ?></span>
				<?php endif; ?>
				<?php if ( $siret ) : ?>
					<span class="footer-siret"><?php esc_html_e( 'SIRET :', 'arti100' ); ?> <?php echo esc_html( $siret ); ?></span>
				<?php endif; ?>
			</div>
			<div class="footer-bottom-right">
				<?php
				$mentions = get_page_by_path( 'mentions-legales' );
				if ( $mentions ) : ?>
					<a href="<?php echo esc_url( get_permalink( $mentions ) ); ?>"><?php esc_html_e( 'Mentions légales', 'arti100' ); ?></a>
				<?php endif;
				$privacy = get_page_by_path( 'politique-confidentialite' );
				if ( $privacy ) : ?>
					<a href="<?php echo esc_url( get_permalink( $privacy ) ); ?>"><?php esc_html_e( 'Confidentialité', 'arti100' ); ?></a>
				<?php endif; ?>
				<a href="<?php echo esc_url( admin_url() ); ?>" class="footer-admin-link"><?php esc_html_e( 'Admin', 'arti100' ); ?></a>
			</div>
		</div>
	</div>

</footer><!-- #colophon -->

<?php if ( $phone ) : ?>
<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="fab-phone" aria-label="<?php esc_attr_e( 'Appeler', 'arti100' ); ?>">
	<span class="material-symbols-outlined" aria-hidden="true">call</span>
</a>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
