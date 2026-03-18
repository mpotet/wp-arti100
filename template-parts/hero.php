<?php
/**
 * Arti100 — template-parts/hero.php
 * Section hero de la homepage
 */

$title     = get_option( 'arti100_hero_title',    __( 'XXX - Votre titre principal', 'arti100' ) );
$subtitle  = get_option( 'arti100_hero_subtitle', __( 'XXX - Votre sous-titre descriptif · Devis gratuit', 'arti100' ) );
$cta_text  = get_option( 'arti100_hero_cta',      __( 'Demander un devis gratuit', 'arti100' ) );
$bg_url    = get_option( 'arti100_hero_bg', '' );
$phone     = arti100_get_phone();
$zone      = get_option( 'arti100_zone', '' );
$devis_url = arti100_get_devis_url();
$calendly  = get_option( 'arti100_calendly_url', '' );
$is_cal    = ! empty( $calendly );

$inline_bg = $bg_url ? ' style="background-image:url(' . esc_url( $bg_url ) . ')"' : '';

// Stats depuis les options (avec valeurs par défaut configurables)
$stats = [];
$stat_defaults = [
	1 => [ 'value' => 'XXX', 'suffix' => '',   'label' => __( 'Chantiers réalisés', 'arti100' ) ],
	2 => [ 'value' => 'XXX', 'suffix' => '',   'label' => __( "D'expérience",      'arti100' ) ],
	3 => [ 'value' => 'XXX', 'suffix' => '',   'label' => __( 'Clients satisfaits', 'arti100' ) ],
	4 => [ 'value' => 'XXX', 'suffix' => '',   'label' => __( 'Note Google',        'arti100' ) ],
];
for ( $i = 1; $i <= 4; $i++ ) {
	$stats[] = [
		'value'  => get_option( "arti100_stat_{$i}_value",  $stat_defaults[ $i ]['value'] ),
		'suffix' => get_option( "arti100_stat_{$i}_suffix", $stat_defaults[ $i ]['suffix'] ),
		'label'  => get_option( "arti100_stat_{$i}_label",  $stat_defaults[ $i ]['label'] ),
	];
}
$badge1 = get_option( 'arti100_badge_1', __( 'XXX - Badge 1', 'arti100' ) );
$badge2 = get_option( 'arti100_badge_2', __( 'XXX - Badge 2', 'arti100' ) );
$badge3 = get_option( 'arti100_badge_3', $zone ?: __( 'XXX - Badge 3', 'arti100' ) );
?>

<section class="hero-section"<?php echo $inline_bg; ?>>
	<?php if ( $bg_url ) : ?>
		<div class="hero-overlay" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="container hero-inner">
		<div class="hero-content">

			<!-- Badges trust (configurables depuis Général → Hero Section) -->
			<div class="hero-badges">
				<?php if ( $badge1 ) : ?>
				<span class="hero-badge">
					<span class="material-symbols-outlined" aria-hidden="true">check_circle</span>
					<?php echo esc_html( $badge1 ); ?>
				</span>
				<?php endif; ?>
				<?php if ( $badge2 ) : ?>
				<span class="hero-badge">
					<span class="material-symbols-outlined" aria-hidden="true">verified_user</span>
					<?php echo esc_html( $badge2 ); ?>
				</span>
				<?php endif; ?>
				<?php if ( $badge3 ) : ?>
				<span class="hero-badge">
					<span class="material-symbols-outlined" aria-hidden="true">location_on</span>
					<?php echo esc_html( $badge3 ); ?>
				</span>
				<?php endif; ?>
			</div>

			<h1 class="hero-title"><?php echo nl2br( esc_html( $title ) ); ?></h1>

			<?php if ( $subtitle ) : ?>
				<p class="hero-subtitle"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>

			<div class="hero-actions">
				<a href="<?php echo esc_url( $devis_url ); ?>"
				   class="btn btn-accent btn-large<?php echo $is_cal ? ' js-calendly' : ''; ?>"
				   <?php echo $is_cal ? 'data-calendly="' . esc_attr( $calendly ) . '"' : ''; ?>>
					<span class="material-symbols-outlined" aria-hidden="true">calendar_month</span>
					<?php echo esc_html( $cta_text ); ?>
				</a>
				<?php if ( $phone ) : ?>
					<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="btn btn-outline-white btn-large">
						<span class="material-symbols-outlined" aria-hidden="true">call</span>
						<?php echo esc_html( $phone ); ?>
					</a>
				<?php endif; ?>
			</div>

			<!-- Stats rapides (configurables depuis l'onglet Contenu) -->
			<div class="hero-stats">
				<?php foreach ( $stats as $stat ) : ?>
				<div class="hero-stat" data-count="<?php echo esc_attr( $stat['value'] ); ?>" data-suffix="<?php echo esc_attr( $stat['suffix'] ); ?>">
					<span class="stat-number"><?php echo esc_html( $stat['value'] . $stat['suffix'] ); ?></span>
					<span class="stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
				</div>
				<?php endforeach; ?>
			</div>

		</div><!-- .hero-content -->
	</div><!-- .hero-inner -->

	<!-- Scroll indicator -->
	<div class="hero-scroll" aria-hidden="true">
		<span class="material-symbols-outlined">keyboard_arrow_down</span>
	</div>
</section>
