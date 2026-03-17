<?php
/**
 * Arti100 — template-parts/hero.php
 * Section hero de la homepage
 */

$title      = get_option( 'arti100_hero_title', 'Artisan qualifié\nprès de chez vous' );
$subtitle   = get_option( 'arti100_hero_subtitle', 'Intervention rapide · Devis gratuit · Garantie RGE' );
$cta_text   = get_option( 'arti100_hero_cta', 'Demander un devis gratuit' );
$bg_url     = get_option( 'arti100_hero_bg', '' );
$phone      = arti100_get_phone();
$zone       = get_option( 'arti100_zone', '' );
$devis_url  = arti100_get_devis_url();
$calendly   = get_option( 'arti100_calendly_url', '' );
$is_cal     = ! empty( $calendly );

$inline_bg = $bg_url ? ' style="background-image:url(' . esc_url( $bg_url ) . ')"' : '';
?>

<section class="hero-section"<?php echo $inline_bg; ?>>
	<?php if ( $bg_url ) : ?>
		<div class="hero-overlay" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="container hero-inner">
		<div class="hero-content">

			<!-- Badges trust -->
			<div class="hero-badges">
				<span class="hero-badge">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9 16.17L5.53 12.7a.996.996 0 10-1.41 1.41l4.18 4.18c.39.39 1.02.39 1.41 0L20.29 7.71a.996.996 0 10-1.41-1.41L9 16.17z"/></svg>
					<?php esc_html_e( 'Certifié RGE', 'arti100' ); ?>
				</span>
				<span class="hero-badge">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
					<?php esc_html_e( 'Assuré RC Pro', 'arti100' ); ?>
				</span>
				<span class="hero-badge">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 119.5 9a2.5 2.5 0 012.5 2.5z"/></svg>
					<?php echo esc_html( $zone ?: __( 'Local', 'arti100' ) ); ?>
				</span>
			</div>

			<h1 class="hero-title"><?php echo nl2br( esc_html( $title ) ); ?></h1>

			<?php if ( $subtitle ) : ?>
				<p class="hero-subtitle"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>

			<div class="hero-actions">
				<a href="<?php echo esc_url( $devis_url ); ?>"
				   class="btn btn-accent btn-large<?php echo $is_cal ? ' js-calendly' : ''; ?>"
				   <?php echo $is_cal ? 'data-calendly="' . esc_attr( $calendly ) . '"' : ''; ?>>
					<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 3h-1V1h-2v2H8V1H6v2H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zm0 16H5V8h14v11zM9 10H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zM9 14H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2z"/></svg>
					<?php echo esc_html( $cta_text ); ?>
				</a>
				<?php if ( $phone ) : ?>
					<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="btn btn-outline-white btn-large">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79a15.1 15.1 0 006.59 6.59l2.2-2.2a1 1 0 011.02-.24A11.36 11.36 0 0020 17.57a1 1 0 011 1V20a1 1 0 01-1 1C10.56 21 3 13.44 3 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.45.57 3.57a1 1 0 01-.25 1.02l-2.2 2.2z"/></svg>
						<?php echo esc_html( $phone ); ?>
					</a>
				<?php endif; ?>
			</div>

			<!-- Stats rapides -->
			<div class="hero-stats">
				<div class="hero-stat" data-count="500" data-suffix="+">
					<span class="stat-number">500+</span>
					<span class="stat-label"><?php esc_html_e( 'Chantiers réalisés', 'arti100' ); ?></span>
				</div>
				<div class="hero-stat" data-count="12" data-suffix=" ans">
					<span class="stat-number">12 ans</span>
					<span class="stat-label"><?php esc_html_e( 'D\'expérience', 'arti100' ); ?></span>
				</div>
				<div class="hero-stat" data-count="98" data-suffix="%">
					<span class="stat-number">98%</span>
					<span class="stat-label"><?php esc_html_e( 'Clients satisfaits', 'arti100' ); ?></span>
				</div>
				<div class="hero-stat">
					<span class="stat-number">4.9</span>
					<span class="stat-label"><?php echo arti100_stars( 5 ); ?> <?php esc_html_e( 'Google', 'arti100' ); ?></span>
				</div>
			</div>

		</div><!-- .hero-content -->
	</div><!-- .hero-inner -->

	<!-- Scroll indicator -->
	<div class="hero-scroll" aria-hidden="true">
		<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
	</div>
</section>
