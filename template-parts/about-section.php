<?php
/**
 * Arti100 — template-parts/about-section.php
 *
 * Section "À propos" : image + texte de présentation côte à côte.
 * Activée/désactivée via l'option arti100_show_about.
 */

if ( ! get_option( 'arti100_show_about', '1' ) ) return;

$titre     = get_option( 'arti100_about_titre',     __( 'XXX - Titre À propos', 'arti100' ) );
$sous_titre = get_option( 'arti100_about_sous_titre', '' );
$texte     = get_option( 'arti100_about_texte',     __( 'XXX - Décrivez ici votre entreprise, votre histoire, vos valeurs et ce qui vous différencie de la concurrence.', 'arti100' ) );
$image_url  = get_option( 'arti100_about_image', '' );

// Si aucun contenu configuré et visiteur non admin → ne pas afficher
if (
	str_starts_with( $titre, 'XXX' ) &&
	str_starts_with( $texte, 'XXX' ) &&
	! $image_url
	&& ! current_user_can( 'manage_options' )
) return;
?>

<section id="about" class="about-section section-padded">
	<div class="container">

		<div class="section-header">
			<span class="section-eyebrow"><?php esc_html_e( 'À propos', 'arti100' ); ?></span>
			<h2 class="section-title"><?php echo esc_html( $titre ); ?></h2>
			<?php if ( $sous_titre ) : ?>
				<p class="section-subtitle"><?php echo esc_html( $sous_titre ); ?></p>
			<?php endif; ?>
		</div>

		<div class="about-inner <?php echo $image_url ? 'about-has-image' : 'about-no-image'; ?>">

			<?php if ( $image_url ) : ?>
			<div class="about-image-wrap">
				<img
					src="<?php echo esc_url( $image_url ); ?>"
					alt="<?php echo esc_attr( get_option( 'arti100_company_name', '' ) ); ?>"
					class="about-image"
					loading="lazy"
				/>
			</div>
			<?php endif; ?>

			<div class="about-body">
				<?php if ( $texte ) : ?>
				<div class="about-text">
					<?php echo nl2br( esc_html( $texte ) ); ?>
				</div>
				<?php endif; ?>

				<?php if ( current_user_can( 'manage_options' ) && str_starts_with( $titre, 'XXX' ) ) : ?>
				<div class="arti100-empty-notice">
					<span class="material-symbols-outlined" aria-hidden="true">info</span>
					<p>
						<?php esc_html_e( 'Section À propos non configurée.', 'arti100' ); ?>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=arti100-settings&tab=content' ) ); ?>">
							<?php esc_html_e( 'Configurer →', 'arti100' ); ?>
						</a>
					</p>
				</div>
				<?php endif; ?>
			</div>

		</div>

	</div><!-- .container -->
</section>
