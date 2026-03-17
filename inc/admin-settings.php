<?php
/**
 * Arti100 — Admin Settings Page (onglets)
 * Sans plugin tiers — options stockées avec update_option/get_option
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* =========================================================
   MENU ADMIN
   ========================================================= */
function arti100_admin_menu() {
	add_menu_page(
		__( 'Arti100 Settings', 'arti100' ),
		__( '⚙️ Arti100', 'arti100' ),
		'manage_options',
		'arti100-settings',
		'arti100_settings_page',
		'dashicons-admin-settings',
		3
	);
}
add_action( 'admin_menu', 'arti100_admin_menu' );

/* =========================================================
   SAVE OPTIONS
   ========================================================= */
function arti100_save_options() {
	if ( ! isset( $_POST['arti100_settings_nonce'] ) ) return;
	if ( ! wp_verify_nonce( $_POST['arti100_settings_nonce'], 'arti100_save_settings' ) ) return;
	if ( ! current_user_can( 'manage_options' ) ) return;

	$tab = isset( $_POST['arti100_active_tab'] ) ? sanitize_key( $_POST['arti100_active_tab'] ) : 'general';

	if ( $tab === 'general' ) {
		$fields = [
			'arti100_company_name'  => 'sanitize_text_field',
			'arti100_slogan'        => 'sanitize_text_field',
			'arti100_phone'         => 'sanitize_text_field',
			'arti100_email'         => 'sanitize_email',
			'arti100_address'       => 'sanitize_textarea_field',
			'arti100_zone'          => 'sanitize_text_field',
			'arti100_siret'         => 'sanitize_text_field',
			'arti100_metier'        => 'sanitize_text_field',
			'arti100_hero_title'    => 'sanitize_text_field',
			'arti100_hero_subtitle' => 'sanitize_textarea_field',
			'arti100_hero_cta'      => 'sanitize_text_field',
			'arti100_hero_bg'       => 'esc_url_raw',
			'arti100_color_primary' => 'sanitize_hex_color',
			'arti100_color_accent'  => 'sanitize_hex_color',
			'arti100_logo_url'      => 'esc_url_raw',
			'arti100_facebook'      => 'esc_url_raw',
			'arti100_instagram'     => 'esc_url_raw',
			'arti100_google_maps'   => 'sanitize_text_field',
		];
		foreach ( $fields as $key => $sanitizer ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_option( $key, $sanitizer( $_POST[ $key ] ) );
			}
		}
	}

	if ( $tab === 'integrations' ) {
		$fields = [
			'arti100_calendly_url'    => 'esc_url_raw',
			'arti100_cf7_id'          => 'absint',
			'arti100_stripe_pk'       => 'sanitize_text_field',
			'arti100_ga_id'           => 'sanitize_text_field',
			'arti100_maps_embed'      => 'wp_kses_post',
			'arti100_maps_api_key'    => 'sanitize_text_field',
		];
		foreach ( $fields as $key => $sanitizer ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_option( $key, $sanitizer( $_POST[ $key ] ) );
			}
		}
	}

	if ( $tab === 'seo' ) {
		$fields = [
			'arti100_meta_desc'   => 'sanitize_textarea_field',
			'arti100_og_image'    => 'esc_url_raw',
			'arti100_footer_text' => 'wp_kses_post',
		];
		foreach ( $fields as $key => $sanitizer ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_option( $key, $sanitizer( $_POST[ $key ] ) );
			}
		}
	}

	add_settings_error( 'arti100_messages', 'arti100_saved', __( '✅ Paramètres sauvegardés.', 'arti100' ), 'updated' );
}
add_action( 'admin_init', 'arti100_save_options' );

/* =========================================================
   PAGE SETTINGS HTML
   ========================================================= */
function arti100_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) return;

	$active_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'general';
	settings_errors( 'arti100_messages' );
	?>
	<div class="wrap arti100-admin-wrap">
		<h1 style="display:flex;align-items:center;gap:10px">
			<span style="font-size:2rem">🔧</span>
			<?php esc_html_e( 'Arti100 — Paramètres du thème', 'arti100' ); ?>
		</h1>

		<nav class="nav-tab-wrapper wp-clearfix" style="margin-bottom:20px">
			<?php
			$tabs = [
				'general'      => __( '🏠 Général', 'arti100' ),
				'integrations' => __( '🔌 Intégrations', 'arti100' ),
				'seo'          => __( '📈 SEO & Footer', 'arti100' ),
			];
			foreach ( $tabs as $slug => $label ) {
				$class = ( $active_tab === $slug ) ? 'nav-tab nav-tab-active' : 'nav-tab';
				$url   = admin_url( 'admin.php?page=arti100-settings&tab=' . $slug );
				echo '<a href="' . esc_url( $url ) . '" class="' . esc_attr( $class ) . '">' . esc_html( $label ) . '</a>';
			}
			?>
		</nav>

		<form method="post" action="">
			<?php wp_nonce_field( 'arti100_save_settings', 'arti100_settings_nonce' ); ?>
			<input type="hidden" name="arti100_active_tab" value="<?php echo esc_attr( $active_tab ); ?>" />

			<?php if ( $active_tab === 'general' ) : ?>
				<?php arti100_tab_general(); ?>
			<?php elseif ( $active_tab === 'integrations' ) : ?>
				<?php arti100_tab_integrations(); ?>
			<?php elseif ( $active_tab === 'seo' ) : ?>
				<?php arti100_tab_seo(); ?>
			<?php endif; ?>

			<?php submit_button( __( 'Enregistrer les paramètres', 'arti100' ), 'primary large', 'submit', true, [ 'style' => 'margin-top:20px' ] ); ?>
		</form>
	</div>
	<?php
}

/* =========================================================
   ONGLET GÉNÉRAL
   ========================================================= */
function arti100_tab_general() {
	?>
	<style>
	.arti100-card{background:#fff;border:1px solid #ddd;border-radius:8px;padding:24px;margin-bottom:20px}
	.arti100-card h2{margin-top:0;padding-bottom:10px;border-bottom:2px solid #007CBA;color:#1d2327}
	.arti100-card table{width:100%}
	.arti100-card th{width:200px;font-weight:600;color:#444}
	.arti100-color-preview{display:inline-block;width:24px;height:24px;border-radius:50%;vertical-align:middle;margin-left:8px;border:2px solid #ccc}
	</style>

	<div class="arti100-card">
		<h2><?php esc_html_e( '🏢 Informations entreprise', 'arti100' ); ?></h2>
		<table class="form-table">
			<tr>
				<th><?php esc_html_e( 'Nom entreprise', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_company_name" value="<?php echo esc_attr( get_option( 'arti100_company_name', get_bloginfo( 'name' ) ) ); ?>" class="large-text" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Slogan', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_slogan" value="<?php echo esc_attr( get_option( 'arti100_slogan', 'Artisan qualifié près de chez vous.' ) ); ?>" class="large-text" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Métier principal', 'arti100' ); ?></th>
				<td>
					<select name="arti100_metier">
						<?php
						$metiers = [ 'plombier' => 'Plombier', 'electricien' => 'Électricien', 'plaquiste' => 'Plaquiste / Plâtrier', 'maçon' => 'Maçon', 'peintre' => 'Peintre', 'menuisier' => 'Menuisier', 'chauffagiste' => 'Chauffagiste', 'charpentier' => 'Charpentier', 'autre' => 'Autre' ];
						$current = get_option( 'arti100_metier', 'plombier' );
						foreach ( $metiers as $val => $label ) {
							printf( '<option value="%s"%s>%s</option>', esc_attr( $val ), selected( $current, $val, false ), esc_html( $label ) );
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Téléphone', 'arti100' ); ?></th>
				<td><input type="tel" name="arti100_phone" value="<?php echo esc_attr( get_option( 'arti100_phone' ) ); ?>" class="regular-text" placeholder="06 12 34 56 78" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Email', 'arti100' ); ?></th>
				<td><input type="email" name="arti100_email" value="<?php echo esc_attr( get_option( 'arti100_email' ) ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Adresse', 'arti100' ); ?></th>
				<td><textarea name="arti100_address" rows="2" class="large-text"><?php echo esc_textarea( get_option( 'arti100_address' ) ); ?></textarea></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Zone intervention', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_zone" value="<?php echo esc_attr( get_option( 'arti100_zone', 'Vallet & 50 km autour' ) ); ?>" class="large-text" placeholder="Nantes & 50 km" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'SIRET', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_siret" value="<?php echo esc_attr( get_option( 'arti100_siret' ) ); ?>" class="regular-text" /></td>
			</tr>
		</table>
	</div>

	<div class="arti100-card">
		<h2><?php esc_html_e( '🖼️ Logo & Couleurs', 'arti100' ); ?></h2>
		<table class="form-table">
			<tr>
				<th><?php esc_html_e( 'URL du logo', 'arti100' ); ?></th>
				<td>
					<input type="url" id="arti100_logo_url" name="arti100_logo_url" value="<?php echo esc_attr( get_option( 'arti100_logo_url' ) ); ?>" class="large-text" />
					<button type="button" class="button" id="arti100-logo-media"><?php esc_html_e( 'Choisir image', 'arti100' ); ?></button>
					<?php if ( get_option( 'arti100_logo_url' ) ) : ?>
						<br><img src="<?php echo esc_url( get_option( 'arti100_logo_url' ) ); ?>" style="max-height:60px;margin-top:8px" />
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Couleur primaire', 'arti100' ); ?></th>
				<td>
					<input type="color" name="arti100_color_primary" value="<?php echo esc_attr( get_option( 'arti100_color_primary', '#007CBA' ) ); ?>" />
					<code><?php echo esc_html( get_option( 'arti100_color_primary', '#007CBA' ) ); ?></code>
				</td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Couleur accent (orange)', 'arti100' ); ?></th>
				<td>
					<input type="color" name="arti100_color_accent" value="<?php echo esc_attr( get_option( 'arti100_color_accent', '#F5821F' ) ); ?>" />
					<code><?php echo esc_html( get_option( 'arti100_color_accent', '#F5821F' ) ); ?></code>
				</td>
			</tr>
		</table>
	</div>

	<div class="arti100-card">
		<h2><?php esc_html_e( '🦸 Hero Section', 'arti100' ); ?></h2>
		<table class="form-table">
			<tr>
				<th><?php esc_html_e( 'Titre principal', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_hero_title" value="<?php echo esc_attr( get_option( 'arti100_hero_title', 'Artisan qualifié\nnear de chez vous' ) ); ?>" class="large-text" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Sous-titre', 'arti100' ); ?></th>
				<td><textarea name="arti100_hero_subtitle" rows="2" class="large-text"><?php echo esc_textarea( get_option( 'arti100_hero_subtitle', 'Intervention rapide · Devis gratuit · Garantie RGE' ) ); ?></textarea></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Texte CTA bouton', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_hero_cta" value="<?php echo esc_attr( get_option( 'arti100_hero_cta', 'Demander un devis gratuit' ) ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Image fond hero (URL)', 'arti100' ); ?></th>
				<td>
					<input type="url" id="arti100_hero_bg" name="arti100_hero_bg" value="<?php echo esc_attr( get_option( 'arti100_hero_bg' ) ); ?>" class="large-text" />
					<button type="button" class="button" id="arti100-hero-media"><?php esc_html_e( 'Choisir image', 'arti100' ); ?></button>
				</td>
			</tr>
		</table>
	</div>

	<div class="arti100-card">
		<h2><?php esc_html_e( '📱 Réseaux sociaux', 'arti100' ); ?></h2>
		<table class="form-table">
			<tr>
				<th><?php esc_html_e( 'Facebook URL', 'arti100' ); ?></th>
				<td><input type="url" name="arti100_facebook" value="<?php echo esc_attr( get_option( 'arti100_facebook' ) ); ?>" class="large-text" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Instagram URL', 'arti100' ); ?></th>
				<td><input type="url" name="arti100_instagram" value="<?php echo esc_attr( get_option( 'arti100_instagram' ) ); ?>" class="large-text" /></td>
			</tr>
		</table>
	</div>

	<script>
	jQuery(function($){
		function mediaUpload(btnId, inputId){
			$('#'+btnId).on('click',function(){
				var frame=wp.media({title:'Sélectionner une image',button:{text:'Utiliser cette image'},multiple:false});
				frame.on('select',function(){
					var a=frame.state().get('selection').first().toJSON();
					$('#'+inputId).val(a.url);
				});
				frame.open();
			});
		}
		mediaUpload('arti100-logo-media','arti100_logo_url');
		mediaUpload('arti100-hero-media','arti100_hero_bg');
	});
	</script>
	<?php
}

/* =========================================================
   ONGLET INTÉGRATIONS
   ========================================================= */
function arti100_tab_integrations() {
	?>
	<div class="arti100-card" style="background:#fff;border:1px solid #ddd;border-radius:8px;padding:24px">
		<h2 style="margin-top:0;border-bottom:2px solid #007CBA;padding-bottom:10px"><?php esc_html_e( '📅 Prise de RDV Calendly', 'arti100' ); ?></h2>
		<table class="form-table">
			<tr>
				<th><?php esc_html_e( 'URL Calendly', 'arti100' ); ?></th>
				<td>
					<input type="url" name="arti100_calendly_url" value="<?php echo esc_attr( get_option( 'arti100_calendly_url' ) ); ?>" class="large-text" placeholder="https://calendly.com/votre-entreprise" />
					<p class="description"><?php esc_html_e( 'Votre lien personnel Calendly. Un popup s\'ouvrira au clic sur "Prendre RDV".', 'arti100' ); ?></p>
				</td>
			</tr>
		</table>

		<h2 style="border-bottom:2px solid #007CBA;padding-bottom:10px"><?php esc_html_e( '📧 Contact Form 7 (ID du formulaire)', 'arti100' ); ?></h2>
		<table class="form-table">
			<tr>
				<th><?php esc_html_e( 'ID du formulaire CF7', 'arti100' ); ?></th>
				<td>
					<input type="number" name="arti100_cf7_id" value="<?php echo esc_attr( get_option( 'arti100_cf7_id' ) ); ?>" />
					<p class="description"><?php esc_html_e( 'Trouvez l\'ID dans Contact → Formulaires de contact.', 'arti100' ); ?></p>
				</td>
			</tr>
		</table>

		<h2 style="border-bottom:2px solid #007CBA;padding-bottom:10px"><?php esc_html_e( '🗺️ Google Maps', 'arti100' ); ?></h2>
		<table class="form-table">
			<tr>
				<th><?php esc_html_e( 'Code embed iframe', 'arti100' ); ?></th>
				<td>
					<textarea name="arti100_maps_embed" rows="4" class="large-text"><?php echo esc_textarea( get_option( 'arti100_maps_embed' ) ); ?></textarea>
					<p class="description"><?php esc_html_e( 'Collez l\'iframe Google Maps ici. Utiliser aussi le shortcode [arti100_map] dans les pages.', 'arti100' ); ?></p>
				</td>
			</tr>
		</table>

		<h2 style="border-bottom:2px solid #007CBA;padding-bottom:10px"><?php esc_html_e( '📊 Google Analytics', 'arti100' ); ?></h2>
		<table class="form-table">
			<tr>
				<th><?php esc_html_e( 'GA4 Measurement ID', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_ga_id" value="<?php echo esc_attr( get_option( 'arti100_ga_id' ) ); ?>" placeholder="G-XXXXXXXXXX" /></td>
			</tr>
		</table>
	</div>
	<?php
}

/* =========================================================
   ONGLET SEO
   ========================================================= */
function arti100_tab_seo() {
	?>
	<div class="arti100-card" style="background:#fff;border:1px solid #ddd;border-radius:8px;padding:24px">
		<h2 style="margin-top:0;border-bottom:2px solid #007CBA;padding-bottom:10px"><?php esc_html_e( '🔍 Meta SEO', 'arti100' ); ?></h2>
		<table class="form-table">
			<tr>
				<th><?php esc_html_e( 'Meta description homepage', 'arti100' ); ?></th>
				<td><textarea name="arti100_meta_desc" rows="3" class="large-text"><?php echo esc_textarea( get_option( 'arti100_meta_desc' ) ); ?></textarea></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Image Open Graph', 'arti100' ); ?></th>
				<td><input type="url" name="arti100_og_image" value="<?php echo esc_attr( get_option( 'arti100_og_image' ) ); ?>" class="large-text" /></td>
			</tr>
		</table>

		<h2 style="border-bottom:2px solid #007CBA;padding-bottom:10px"><?php esc_html_e( '📄 Pied de page légal', 'arti100' ); ?></h2>
		<table class="form-table">
			<tr>
				<th><?php esc_html_e( 'Texte pied de page', 'arti100' ); ?></th>
				<td>
					<?php
					wp_editor( get_option( 'arti100_footer_text', '© ' . date( 'Y' ) . ' — Tous droits réservés.' ), 'arti100_footer_text', [
						'textarea_rows' => 5,
						'media_buttons' => false,
					] );
					?>
				</td>
			</tr>
		</table>
	</div>
	<?php
}

/* =========================================================
   GA4 INJECT
   ========================================================= */
function arti100_inject_ga4() {
	$ga_id = get_option( 'arti100_ga_id', '' );
	if ( empty( $ga_id ) ) return;
	?>
	<!-- Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $ga_id ); ?>"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', '<?php echo esc_js( $ga_id ); ?>');
	</script>
	<?php
}
add_action( 'wp_head', 'arti100_inject_ga4' );

/* =========================================================
   META DESCRIPTION & OG TAGS
   ========================================================= */
function arti100_meta_tags() {
	if ( ! is_front_page() ) return;
	$desc  = get_option( 'arti100_meta_desc', '' );
	$image = get_option( 'arti100_og_image', '' );
	$title = get_option( 'arti100_company_name', get_bloginfo( 'name' ) );
	if ( $desc ) {
		echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( home_url( '/' ) ) . '">' . "\n";
	if ( $image ) {
		echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
	}
	echo '<meta property="og:type" content="website">' . "\n";
}
add_action( 'wp_head', 'arti100_meta_tags' );
