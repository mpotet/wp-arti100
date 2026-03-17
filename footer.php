<?php
/**
 * Arti100 — footer.php
 */

$company   = arti100_get_company_name();
$phone     = arti100_get_phone();
$email     = esc_html( get_option( 'arti100_email', '' ) );
$address   = esc_html( get_option( 'arti100_address', '' ) );
$zone      = esc_html( get_option( 'arti100_zone', '' ) );
$facebook  = get_option( 'arti100_facebook', '' );
$instagram = get_option( 'arti100_instagram', '' );
$siret     = esc_html( get_option( 'arti100_siret', '' ) );
$footer_text = get_option( 'arti100_footer_text', '' );
?>
</main><!-- #main-content -->

<footer id="colophon" class="site-footer" role="contentinfo">

	<!-- FOOTER CTA BAND -->
	<div class="footer-cta-band">
		<div class="container footer-cta-inner">
			<div class="footer-cta-text">
				<h2><?php esc_html_e( 'Besoin d\'un artisan rapidement ?', 'arti100' ); ?></h2>
				<p><?php echo esc_html( $zone ? 'Intervention sur ' . $zone . '.' : 'Contactez-nous dès aujourd\'hui.' ); ?></p>
			</div>
			<div class="footer-cta-actions">
				<?php if ( $phone ) : ?>
					<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="btn btn-white-outline">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79a15.1 15.1 0 006.59 6.59l2.2-2.2a1 1 0 011.02-.24A11.36 11.36 0 0020 17.57a1 1 0 011 1V20a1 1 0 01-1 1C10.56 21 3 13.44 3 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.45.57 3.57a1 1 0 01-.25 1.02l-2.2 2.2z"/></svg>
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
							<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79a15.1 15.1 0 006.59 6.59l2.2-2.2a1 1 0 011.02-.24A11.36 11.36 0 0020 17.57a1 1 0 011 1V20a1 1 0 01-1 1C10.56 21 3 13.44 3 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.45.57 3.57a1 1 0 01-.25 1.02l-2.2 2.2z"/></svg>
							<?php echo esc_html( $phone ); ?>
						</a>
					<?php endif; ?>
					<?php if ( $email ) : ?>
						<a href="mailto:<?php echo esc_attr( $email ); ?>" class="footer-contact-item">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
							<?php echo esc_html( $email ); ?>
						</a>
					<?php endif; ?>
					<?php if ( $address ) : ?>
						<span class="footer-contact-item">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 119.5 9a2.5 2.5 0 012.5 2.5z"/></svg>
							<?php echo esc_html( $address ); ?>
						</span>
					<?php endif; ?>
				</div>
				<div class="footer-socials">
					<?php if ( $facebook ) : ?>
						<a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="social-icon">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3l-.5 3H13v6.95c4.56-.93 8-4.96 8-9.95z"/></svg>
						</a>
					<?php endif; ?>
					<?php if ( $instagram ) : ?>
						<a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="social-icon">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 01-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 017.8 2zm-.2 2A3.6 3.6 0 004 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 003.6-3.6V7.6C20 5.61 18.39 4 16.4 4H7.6zm9.65 1.5a1.25 1.25 0 110 2.5 1.25 1.25 0 010-2.5zM12 7a5 5 0 110 10A5 5 0 0112 7zm0 2a3 3 0 100 6 3 3 0 000-6z"/></svg>
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

			<!-- Col 3 : Navigation -->
			<div class="footer-col">
				<h4 class="footer-col-title"><?php esc_html_e( 'Navigation', 'arti100' ); ?></h4>
				<?php
				wp_nav_menu( [
					'theme_location' => 'footer',
					'menu_class'     => 'footer-links',
					'container'      => false,
					'depth'          => 1,
					'fallback_cb'    => function() {
						echo '<ul class="footer-links">';
						echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Accueil', 'arti100' ) . '</a></li>';
						echo '<li><a href="#services">'    . esc_html__( 'Services', 'arti100' )     . '</a></li>';
						echo '<li><a href="#realisations">' . esc_html__( 'Réalisations', 'arti100' ) . '</a></li>';
						echo '<li><a href="#contact">'     . esc_html__( 'Contact', 'arti100' )      . '</a></li>';
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
						<svg width="20" height="20" viewBox="0 0 24 24" fill="var(--color-accent)" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 119.5 9a2.5 2.5 0 012.5 2.5z"/></svg>
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
					<span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php echo esc_html( $company ); ?> — <?php esc_html_e( 'Tous droits réservés', 'arti100' ); ?></span>
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

<?php wp_footer(); ?>
</body>
</html>
