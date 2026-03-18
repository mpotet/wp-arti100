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
			'arti100_badge_1'       => 'sanitize_text_field',
			'arti100_badge_2'       => 'sanitize_text_field',
			'arti100_badge_3'       => 'sanitize_text_field',
			'arti100_color_primary' => 'sanitize_hex_color',
			'arti100_color_accent'  => 'sanitize_hex_color',
			'arti100_logo_url'      => 'esc_url_raw',
			'arti100_facebook'      => 'esc_url_raw',
			'arti100_instagram'     => 'esc_url_raw',
			'arti100_linkedin_url'  => 'esc_url_raw',
			'arti100_google_maps'   => 'sanitize_text_field',
		];
		foreach ( $fields as $key => $sanitizer ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_option( $key, $sanitizer( $_POST[ $key ] ) );
			}
		}
	}

	if ( $tab === 'content' ) {
		// Show/hide sections
		$toggles = [ 'arti100_show_trust', 'arti100_show_services', 'arti100_show_portfolio', 'arti100_show_equipe', 'arti100_show_temoignages' ];
		foreach ( $toggles as $toggle ) {
			update_option( $toggle, isset( $_POST[ $toggle ] ) ? '1' : '0' );
		}

		// Trust strip (4 items)
		for ( $i = 1; $i <= 4; $i++ ) {
			$k = "arti100_trust_{$i}";
			if ( isset( $_POST["{$k}_title"] ) ) update_option( "{$k}_title", sanitize_text_field( $_POST["{$k}_title"] ) );
			if ( isset( $_POST["{$k}_desc"] ) )  update_option( "{$k}_desc",  sanitize_text_field( $_POST["{$k}_desc"] ) );
		}

		// Hero stats (4 items)
		for ( $i = 1; $i <= 4; $i++ ) {
			$k = "arti100_stat_{$i}";
			if ( isset( $_POST["{$k}_value"] ) )  update_option( "{$k}_value",  sanitize_text_field( $_POST["{$k}_value"] ) );
			if ( isset( $_POST["{$k}_suffix"] ) ) update_option( "{$k}_suffix", sanitize_text_field( $_POST["{$k}_suffix"] ) );
			if ( isset( $_POST["{$k}_label"] ) )  update_option( "{$k}_label",  sanitize_text_field( $_POST["{$k}_label"] ) );
		}

		// Section titles & sous-titres
		$section_fields = [
			'arti100_services_titre'       => 'sanitize_text_field',
			'arti100_services_sous_titre'  => 'sanitize_text_field',
			'arti100_portfolio_titre'      => 'sanitize_text_field',
			'arti100_portfolio_sous_titre' => 'sanitize_text_field',
			'arti100_equipe_titre'         => 'sanitize_text_field',
			'arti100_equipe_sous_titre'    => 'sanitize_text_field',
			'arti100_temos_titre'          => 'sanitize_text_field',
			'arti100_temos_note'           => 'sanitize_text_field',
			'arti100_contact_titre'        => 'sanitize_text_field',
			'arti100_contact_sous_titre'   => 'sanitize_text_field',
			'arti100_contact_texte'        => 'sanitize_textarea_field',
		];
		foreach ( $section_fields as $key => $sanitizer ) {
			if ( isset( $_POST[ $key ] ) ) update_option( $key, $sanitizer( $_POST[ $key ] ) );
		}

		// Témoignages (6 items)
		for ( $i = 1; $i <= 6; $i++ ) {
			$k = "arti100_temo_{$i}";
			if ( isset( $_POST["{$k}_nom"] ) )     update_option( "{$k}_nom",     sanitize_text_field( $_POST["{$k}_nom"] ) );
			if ( isset( $_POST["{$k}_localite"] ) ) update_option( "{$k}_localite", sanitize_text_field( $_POST["{$k}_localite"] ) );
			if ( isset( $_POST["{$k}_texte"] ) )   update_option( "{$k}_texte",   sanitize_textarea_field( $_POST["{$k}_texte"] ) );
			if ( isset( $_POST["{$k}_note"] ) )    update_option( "{$k}_note",    absint( $_POST["{$k}_note"] ) );
		}

		// Horaires
		$hours_fields = [
			'arti100_hours_lv'  => 'sanitize_text_field',
			'arti100_hours_sam' => 'sanitize_text_field',
			'arti100_hours_dim' => 'sanitize_text_field',
		];
		foreach ( $hours_fields as $key => $sanitizer ) {
			if ( isset( $_POST[ $key ] ) ) update_option( $key, $sanitizer( $_POST[ $key ] ) );
		}

		// Mode contact
		$contact_mode = isset( $_POST['arti100_contact_mode'] ) ? sanitize_key( $_POST['arti100_contact_mode'] ) : 'texte';
		update_option( 'arti100_contact_mode', in_array( $contact_mode, [ 'texte', 'lien' ], true ) ? $contact_mode : 'texte' );
		if ( isset( $_POST['arti100_contact_link_url'] ) )   update_option( 'arti100_contact_link_url',   esc_url_raw( $_POST['arti100_contact_link_url'] ) );
		if ( isset( $_POST['arti100_contact_link_label'] ) ) update_option( 'arti100_contact_link_label', sanitize_text_field( $_POST['arti100_contact_link_label'] ) );
	}

	if ( $tab === 'integrations' ) {
		$fields = [
			'arti100_calendly_url'  => 'esc_url_raw',
			'arti100_cf7_id'        => 'absint',
			'arti100_stripe_pk'     => 'sanitize_text_field',
			'arti100_ga_id'         => 'sanitize_text_field',
			'arti100_maps_embed'    => 'wp_kses_post',
			'arti100_maps_api_key'  => 'sanitize_text_field',
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
				'content'      => __( '📝 Contenu', 'arti100' ),
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
			<?php elseif ( $active_tab === 'content' ) : ?>
				<?php arti100_tab_content(); ?>
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
   STYLES ADMIN PARTAGÉS
   ========================================================= */
function arti100_admin_card_styles() {
	?>
	<style>
	.arti100-card{background:#fff;border:1px solid #ddd;border-radius:8px;padding:24px;margin-bottom:20px}
	.arti100-card h2{margin-top:0;padding-bottom:10px;border-bottom:2px solid #007CBA;color:#1d2327}
	.arti100-card table{width:100%}
	.arti100-card th{width:200px;font-weight:600;color:#444}
	.arti100-notice-xxx{background:#fff8e1;border-left:4px solid #f0b429;padding:8px 12px;margin:0 0 16px;font-size:12px;color:#7a5c00;border-radius:0 4px 4px 0}
	.arti100-group{background:#f8f9fa;border:1px solid #e0e0e0;border-radius:6px;padding:14px;margin-bottom:10px}
	.arti100-group h4{margin:0 0 10px;color:#1d2327;font-size:13px;text-transform:uppercase;letter-spacing:.5px}
	</style>
	<?php
}

/* =========================================================
   ONGLET GÉNÉRAL
   ========================================================= */
function arti100_tab_general() {
	arti100_admin_card_styles();
	?>
	<div class="arti100-card">
		<div class="arti100-notice-xxx">💡 Les champs marqués <strong>XXX</strong> sont des exemples à remplacer par vos vraies informations.</div>
		<h2><?php esc_html_e( '🏢 Informations entreprise', 'arti100' ); ?></h2>
		<table class="form-table">
			<tr>
				<th><?php esc_html_e( 'Nom entreprise', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_company_name" value="<?php echo esc_attr( get_option( 'arti100_company_name', 'XXX - Nom de votre entreprise' ) ); ?>" class="large-text" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Slogan', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_slogan" value="<?php echo esc_attr( get_option( 'arti100_slogan', 'XXX - Votre slogan accrocheur' ) ); ?>" class="large-text" /></td>
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
				<td><input type="tel" name="arti100_phone" value="<?php echo esc_attr( get_option( 'arti100_phone', 'XXX - 06 00 00 00 00' ) ); ?>" class="regular-text" placeholder="06 12 34 56 78" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Email', 'arti100' ); ?></th>
				<td><input type="email" name="arti100_email" value="<?php echo esc_attr( get_option( 'arti100_email', 'XXX - contact@votreentreprise.fr' ) ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Adresse', 'arti100' ); ?></th>
				<td><textarea name="arti100_address" rows="2" class="large-text"><?php echo esc_textarea( get_option( 'arti100_address', 'XXX - Votre adresse complète' ) ); ?></textarea></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Zone intervention', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_zone" value="<?php echo esc_attr( get_option( 'arti100_zone', 'XXX - Ville & rayon km' ) ); ?>" class="large-text" placeholder="Nantes & 50 km" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'SIRET', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_siret" value="<?php echo esc_attr( get_option( 'arti100_siret', 'XXX - 000 000 000 00000' ) ); ?>" class="regular-text" /></td>
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
				<td>
					<input type="text" name="arti100_hero_title" value="<?php echo esc_attr( get_option( 'arti100_hero_title', 'XXX - Votre titre principal' ) ); ?>" class="large-text" />
					<p class="description"><?php esc_html_e( 'Utilisez \\n pour couper la ligne.', 'arti100' ); ?></p>
				</td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Sous-titre', 'arti100' ); ?></th>
				<td><textarea name="arti100_hero_subtitle" rows="2" class="large-text"><?php echo esc_textarea( get_option( 'arti100_hero_subtitle', 'XXX - Votre sous-titre descriptif · Devis gratuit' ) ); ?></textarea></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Texte CTA bouton', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_hero_cta" value="<?php echo esc_attr( get_option( 'arti100_hero_cta', 'XXX - Texte du bouton principal' ) ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Image fond hero (URL)', 'arti100' ); ?></th>
				<td>
					<input type="url" id="arti100_hero_bg" name="arti100_hero_bg" value="<?php echo esc_attr( get_option( 'arti100_hero_bg' ) ); ?>" class="large-text" />
					<button type="button" class="button" id="arti100-hero-media"><?php esc_html_e( 'Choisir image', 'arti100' ); ?></button>
				</td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Badge 1 (icône ✅)', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_badge_1" value="<?php echo esc_attr( get_option( 'arti100_badge_1', 'XXX - Badge 1' ) ); ?>" class="regular-text" placeholder="Ex : Certifié RGE, Médecin agréé…" />
				<p class="description"><?php esc_html_e( 'Laissez vide pour masquer.', 'arti100' ); ?></p></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Badge 2 (icône 🛡️)', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_badge_2" value="<?php echo esc_attr( get_option( 'arti100_badge_2', 'XXX - Badge 2' ) ); ?>" class="regular-text" placeholder="Ex : Assuré RC Pro, Cabinet reconnu…" />
				<p class="description"><?php esc_html_e( 'Laissez vide pour masquer.', 'arti100' ); ?></p></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Badge 3 (icône 📍)', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_badge_3" value="<?php echo esc_attr( get_option( 'arti100_badge_3', '' ) ); ?>" class="regular-text" placeholder="Ex : Nantes &amp; 50 km (vide = Zone intervention)" />
				<p class="description"><?php esc_html_e( 'Vide → utilise la Zone d\'intervention (Général).', 'arti100' ); ?></p></td>
			</tr>
		</table>
	</div>

	<div class="arti100-card">
		<h2><?php esc_html_e( '📱 Réseaux sociaux', 'arti100' ); ?></h2>
		<table class="form-table">
			<tr>
				<th><?php esc_html_e( 'Facebook URL', 'arti100' ); ?></th>
				<td><input type="url" name="arti100_facebook" value="<?php echo esc_attr( get_option( 'arti100_facebook' ) ); ?>" class="large-text" placeholder="https://facebook.com/votreentreprise" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Instagram URL', 'arti100' ); ?></th>
				<td><input type="url" name="arti100_instagram" value="<?php echo esc_attr( get_option( 'arti100_instagram' ) ); ?>" class="large-text" placeholder="https://instagram.com/votreentreprise" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'LinkedIn URL', 'arti100' ); ?></th>
				<td><input type="url" name="arti100_linkedin_url" value="<?php echo esc_attr( get_option( 'arti100_linkedin_url' ) ); ?>" class="large-text" placeholder="https://linkedin.com/company/votreentreprise" /></td>
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
   ONGLET CONTENU
   ========================================================= */
function arti100_tab_content() {
	arti100_admin_card_styles();
	?>

	<!-- ▸ Affichage des sections -->
	<div class="arti100-card">
		<h2><?php esc_html_e( '👁️ Affichage des sections', 'arti100' ); ?></h2>
		<p><?php esc_html_e( 'Cochez pour afficher une section sur la page d\'accueil.', 'arti100' ); ?></p>
		<table class="form-table">
			<?php
			$sections = [
				'arti100_show_trust'       => __( 'Bande de confiance (Trust strip)', 'arti100' ),
				'arti100_show_services'    => __( 'Services', 'arti100' ),
				'arti100_show_portfolio'   => __( 'Réalisations / Portfolio', 'arti100' ),
				'arti100_show_equipe'      => __( 'Équipe', 'arti100' ),
				'arti100_show_temoignages' => __( 'Témoignages clients', 'arti100' ),
			];
			foreach ( $sections as $key => $label ) : ?>
				<tr>
					<th><?php echo esc_html( $label ); ?></th>
					<td>
						<label>
							<input type="checkbox" name="<?php echo esc_attr( $key ); ?>" value="1" <?php checked( get_option( $key, '1' ) ); ?> />
							<?php esc_html_e( 'Afficher', 'arti100' ); ?>
						</label>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>

	<!-- ▸ Trust strip -->
	<div class="arti100-card">
		<h2><?php esc_html_e( '🏅 Bande de confiance (4 éléments)', 'arti100' ); ?></h2>
		<?php
		$trust_defaults = [
			1 => [ 'title' => 'Assuré RC Pro',       'desc' => 'Garantie décennale' ],
			2 => [ 'title' => 'Certifié RGE',         'desc' => 'Qualibat / Qualifelec' ],
			3 => [ 'title' => 'Intervention rapide',  'desc' => 'XXX - Urgences 7j/7' ],
			4 => [ 'title' => 'XXX - Note / 5 ★★★★★', 'desc' => 'XXX - xxx avis Google' ],
		];
		for ( $i = 1; $i <= 4; $i++ ) : ?>
			<div class="arti100-group">
				<h4><?php printf( esc_html__( 'Élément %d', 'arti100' ), $i ); ?></h4>
				<table class="form-table">
					<tr>
						<th style="width:140px"><?php esc_html_e( 'Titre', 'arti100' ); ?></th>
						<td><input type="text" name="arti100_trust_<?php echo $i; ?>_title" value="<?php echo esc_attr( get_option( "arti100_trust_{$i}_title", $trust_defaults[ $i ]['title'] ) ); ?>" class="large-text" /></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Description', 'arti100' ); ?></th>
						<td><input type="text" name="arti100_trust_<?php echo $i; ?>_desc" value="<?php echo esc_attr( get_option( "arti100_trust_{$i}_desc", $trust_defaults[ $i ]['desc'] ) ); ?>" class="large-text" /></td>
					</tr>
				</table>
			</div>
		<?php endfor; ?>
	</div>

	<!-- ▸ Stats du hero -->
	<div class="arti100-card">
		<h2><?php esc_html_e( '📊 Statistiques (hero)', 'arti100' ); ?></h2>
		<?php
		$stat_defaults = [
			1 => [ 'value' => '500', 'suffix' => '+',    'label' => 'Chantiers réalisés' ],
			2 => [ 'value' => '12',  'suffix' => ' ans',  'label' => "D'expérience" ],
			3 => [ 'value' => '98',  'suffix' => '%',    'label' => 'Clients satisfaits' ],
			4 => [ 'value' => '4.9', 'suffix' => '/5',   'label' => 'XXX - Note Google' ],
		];
		for ( $i = 1; $i <= 4; $i++ ) : ?>
			<div class="arti100-group">
				<h4><?php printf( esc_html__( 'Stat %d', 'arti100' ), $i ); ?></h4>
				<table class="form-table">
					<tr>
						<th style="width:140px"><?php esc_html_e( 'Valeur', 'arti100' ); ?></th>
						<td><input type="text" name="arti100_stat_<?php echo $i; ?>_value" value="<?php echo esc_attr( get_option( "arti100_stat_{$i}_value", $stat_defaults[ $i ]['value'] ) ); ?>" class="small-text" placeholder="500" /></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Suffixe', 'arti100' ); ?></th>
						<td><input type="text" name="arti100_stat_<?php echo $i; ?>_suffix" value="<?php echo esc_attr( get_option( "arti100_stat_{$i}_suffix", $stat_defaults[ $i ]['suffix'] ) ); ?>" class="small-text" placeholder="+" />
						<p class="description"><?php esc_html_e( 'Ex : +, %, " ans", "/5"', 'arti100' ); ?></p></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Label', 'arti100' ); ?></th>
						<td><input type="text" name="arti100_stat_<?php echo $i; ?>_label" value="<?php echo esc_attr( get_option( "arti100_stat_{$i}_label", $stat_defaults[ $i ]['label'] ) ); ?>" class="regular-text" /></td>
					</tr>
				</table>
			</div>
		<?php endfor; ?>
	</div>

	<!-- ▸ Titres des sections -->
	<div class="arti100-card">
		<h2><?php esc_html_e( '✏️ Titres & sous-titres des sections', 'arti100' ); ?></h2>
		<table class="form-table">
			<tr><td colspan="2"><strong><?php esc_html_e( '🔧 Services', 'arti100' ); ?></strong></td></tr>
			<tr>
				<th><?php esc_html_e( 'Titre', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_services_titre" value="<?php echo esc_attr( get_option( 'arti100_services_titre', 'XXX - Titre services' ) ); ?>" class="large-text" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Sous-titre', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_services_sous_titre" value="<?php echo esc_attr( get_option( 'arti100_services_sous_titre', 'XXX - Des prestations professionnelles pour tous vos travaux, réalisées avec soin et garanties.' ) ); ?>" class="large-text" /></td>
			</tr>

			<tr><td colspan="2"><strong><?php esc_html_e( '🏗️ Réalisations', 'arti100' ); ?></strong></td></tr>
			<tr>
				<th><?php esc_html_e( 'Titre', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_portfolio_titre" value="<?php echo esc_attr( get_option( 'arti100_portfolio_titre', 'XXX - Titre réalisations' ) ); ?>" class="large-text" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Sous-titre', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_portfolio_sous_titre" value="<?php echo esc_attr( get_option( 'arti100_portfolio_sous_titre', 'XXX - Découvrez nos dernières réalisations avec professionnalisme.' ) ); ?>" class="large-text" /></td>
			</tr>

			<tr><td colspan="2"><strong><?php esc_html_e( '👷 Équipe', 'arti100' ); ?></strong></td></tr>
			<tr>
				<th><?php esc_html_e( 'Titre', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_equipe_titre" value="<?php echo esc_attr( get_option( 'arti100_equipe_titre', 'XXX - Titre équipe' ) ); ?>" class="large-text" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Sous-titre', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_equipe_sous_titre" value="<?php echo esc_attr( get_option( 'arti100_equipe_sous_titre', 'XXX - Une équipe qualifiée, passionnée et disponible pour tous vos travaux.' ) ); ?>" class="large-text" /></td>
			</tr>

			<tr><td colspan="2"><strong><?php esc_html_e( '⭐ Témoignages', 'arti100' ); ?></strong></td></tr>
			<tr>
				<th><?php esc_html_e( 'Titre', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_temos_titre" value="<?php echo esc_attr( get_option( 'arti100_temos_titre', 'XXX - Titre avis clients' ) ); ?>" class="large-text" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Note globale (ex: 4.9)', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_temos_note" value="<?php echo esc_attr( get_option( 'arti100_temos_note', 'XXX' ) ); ?>" class="small-text" placeholder="4.9" /></td>
			</tr>

			<tr><td colspan="2"><strong><?php esc_html_e( '📬 Contact', 'arti100' ); ?></strong></td></tr>
			<tr>
				<th><?php esc_html_e( 'Titre', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_contact_titre" value="<?php echo esc_attr( get_option( 'arti100_contact_titre', 'XXX - Titre contact' ) ); ?>" class="large-text" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Sous-titre', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_contact_sous_titre" value="<?php echo esc_attr( get_option( 'arti100_contact_sous_titre', 'XXX - Réponse sous 24h · Devis gratuit et sans engagement' ) ); ?>" class="large-text" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Texte de présentation', 'arti100' ); ?></th>
				<td>
					<textarea name="arti100_contact_texte" class="large-text" rows="3"><?php echo esc_textarea( get_option( 'arti100_contact_texte', '' ) ); ?></textarea>
					<p class="description"><?php esc_html_e( 'Texte libre affiché sous le titre, au-dessus des coordonnées. Laissez vide pour masquer.', 'arti100' ); ?></p>
				</td>
			</tr>
		</table>
	</div>

	<!-- ▸ Horaires -->
	<div class="arti100-card">
		<h2><?php esc_html_e( '🕐 Horaires d\'ouverture', 'arti100' ); ?></h2>
		<table class="form-table">
			<tr>
				<th><?php esc_html_e( 'Lundi – Vendredi', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_hours_lv" value="<?php echo esc_attr( get_option( 'arti100_hours_lv', 'XXX - Horaires lundi-vendredi' ) ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Samedi', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_hours_sam" value="<?php echo esc_attr( get_option( 'arti100_hours_sam', 'XXX - Horaires samedi' ) ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Dimanche', 'arti100' ); ?></th>
				<td><input type="text" name="arti100_hours_dim" value="<?php echo esc_attr( get_option( 'arti100_hours_dim', 'XXX - Horaires dimanche' ) ); ?>" class="regular-text" /></td>
			</tr>
		</table>
	</div>

	<!-- ▸ Mode de contact -->
	<div class="arti100-card">
		<h2><?php esc_html_e( '📞 Mode de contact', 'arti100' ); ?></h2>
		<p><?php esc_html_e( 'Choisissez comment les visiteurs peuvent vous contacter. Dans les deux cas, le téléphone, l\'email et les horaires sont affichés.', 'arti100' ); ?></p>
		<?php $contact_mode = get_option( 'arti100_contact_mode', 'texte' ); ?>
		<table class="form-table">
			<tr>
				<th><?php esc_html_e( 'Mode', 'arti100' ); ?></th>
				<td>
					<label style="display:block;margin-bottom:6px">
						<input type="radio" name="arti100_contact_mode" value="texte" <?php checked( $contact_mode, 'texte' ); ?> />
						<?php esc_html_e( 'Texte uniquement — affiche téléphone, email et horaires', 'arti100' ); ?>
					</label>
					<label style="display:block">
						<input type="radio" name="arti100_contact_mode" value="lien" <?php checked( $contact_mode, 'lien' ); ?> />
						<?php esc_html_e( 'Lien externe — ajoute un bouton vers un site de RDV / contact', 'arti100' ); ?>
					</label>
				</td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'URL du lien (mode Lien)', 'arti100' ); ?></th>
				<td>
					<input type="url" name="arti100_contact_link_url"
					       value="<?php echo esc_attr( get_option( 'arti100_contact_link_url', '' ) ); ?>"
					       class="large-text"
					       placeholder="https://calendly.com/votre-lien" />
					<p class="description"><?php esc_html_e( 'Calendly, Doctolib, WhatsApp, Google Forms, etc.', 'arti100' ); ?></p>
				</td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Texte du bouton (mode Lien)', 'arti100' ); ?></th>
				<td>
					<input type="text" name="arti100_contact_link_label"
					       value="<?php echo esc_attr( get_option( 'arti100_contact_link_label', 'XXX - Texte du bouton' ) ); ?>"
					       class="regular-text" />
				</td>
			</tr>
		</table>
	</div>

	<!-- ▸ Témoignages clients (6) -->
	<div class="arti100-card">
		<h2><?php esc_html_e( '💬 Témoignages clients (6 max)', 'arti100' ); ?></h2>
		<p><?php esc_html_e( 'Ces témoignages s\'affichent si aucun avis n\'est renseigné dans les Réalisations (CPT). Laissez le texte vide pour masquer un témoignage.', 'arti100' ); ?></p>
		<?php
		$temo_defaults = [
			1 => [ 'nom' => 'XXX - Prénom N.', 'localite' => 'XXX - Ville', 'texte' => '', 'note' => 5 ],
			2 => [ 'nom' => 'XXX - Prénom N.', 'localite' => 'XXX - Ville', 'texte' => '', 'note' => 5 ],
			3 => [ 'nom' => 'XXX - Prénom N.', 'localite' => 'XXX - Ville', 'texte' => '', 'note' => 5 ],
			4 => [ 'nom' => 'XXX - Prénom N.', 'localite' => 'XXX - Ville', 'texte' => '', 'note' => 5 ],
			5 => [ 'nom' => 'XXX - Prénom N.', 'localite' => 'XXX - Ville', 'texte' => '', 'note' => 5 ],
			6 => [ 'nom' => 'XXX - Prénom N.', 'localite' => 'XXX - Ville', 'texte' => '', 'note' => 5 ],
		];
		for ( $i = 1; $i <= 6; $i++ ) : ?>
			<div class="arti100-group">
				<h4><?php printf( esc_html__( 'Témoignage %d', 'arti100' ), $i ); ?></h4>
				<table class="form-table">
					<tr>
						<th style="width:140px"><?php esc_html_e( 'Nom', 'arti100' ); ?></th>
						<td><input type="text" name="arti100_temo_<?php echo $i; ?>_nom" value="<?php echo esc_attr( get_option( "arti100_temo_{$i}_nom", $temo_defaults[ $i ]['nom'] ) ); ?>" class="regular-text" /></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Localité', 'arti100' ); ?></th>
						<td><input type="text" name="arti100_temo_<?php echo $i; ?>_localite" value="<?php echo esc_attr( get_option( "arti100_temo_{$i}_localite", $temo_defaults[ $i ]['localite'] ) ); ?>" class="regular-text" /></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Texte', 'arti100' ); ?></th>
						<td><textarea name="arti100_temo_<?php echo $i; ?>_texte" rows="3" class="large-text"><?php echo esc_textarea( get_option( "arti100_temo_{$i}_texte", '' ) ); ?></textarea></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Note (1-5)', 'arti100' ); ?></th>
						<td>
							<select name="arti100_temo_<?php echo $i; ?>_note">
								<?php for ( $n = 5; $n >= 1; $n-- ) : ?>
									<option value="<?php echo $n; ?>" <?php selected( get_option( "arti100_temo_{$i}_note", 5 ), $n ); ?>><?php echo $n; ?> ★</option>
								<?php endfor; ?>
							</select>
						</td>
					</tr>
				</table>
			</div>
		<?php endfor; ?>
	</div>
	<?php
}

/* =========================================================
   ONGLET INTÉGRATIONS
   ========================================================= */
function arti100_tab_integrations() {
	arti100_admin_card_styles();
	?>
	<div class="arti100-card">
		<h2><?php esc_html_e( '📅 Prise de RDV Calendly', 'arti100' ); ?></h2>
		<table class="form-table">
			<tr>
				<th><?php esc_html_e( 'URL Calendly', 'arti100' ); ?></th>
				<td>
					<input type="url" name="arti100_calendly_url" value="<?php echo esc_attr( get_option( 'arti100_calendly_url' ) ); ?>" class="large-text" placeholder="https://calendly.com/votre-entreprise" />
					<p class="description"><?php esc_html_e( 'Votre lien personnel Calendly. Un popup s\'ouvrira au clic sur "Prendre RDV".', 'arti100' ); ?></p>
				</td>
			</tr>
		</table>

		<h2><?php esc_html_e( '📧 Contact Form 7 (ID du formulaire)', 'arti100' ); ?></h2>
		<table class="form-table">
			<tr>
				<th><?php esc_html_e( 'ID du formulaire CF7', 'arti100' ); ?></th>
				<td>
					<input type="number" name="arti100_cf7_id" value="<?php echo esc_attr( get_option( 'arti100_cf7_id' ) ); ?>" />
					<p class="description"><?php esc_html_e( 'Trouvez l\'ID dans Contact → Formulaires de contact.', 'arti100' ); ?></p>
				</td>
			</tr>
		</table>

		<h2><?php esc_html_e( '🗺️ Google Maps', 'arti100' ); ?></h2>
		<table class="form-table">
			<tr>
				<th><?php esc_html_e( 'Code embed iframe', 'arti100' ); ?></th>
				<td>
					<textarea name="arti100_maps_embed" rows="4" class="large-text"><?php echo esc_textarea( get_option( 'arti100_maps_embed' ) ); ?></textarea>
					<p class="description"><?php esc_html_e( 'Collez l\'iframe Google Maps ici. Utiliser aussi le shortcode [arti100_map] dans les pages.', 'arti100' ); ?></p>
				</td>
			</tr>
		</table>

		<h2><?php esc_html_e( '📊 Google Analytics', 'arti100' ); ?></h2>
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
	arti100_admin_card_styles();
	?>
	<div class="arti100-card">
		<h2><?php esc_html_e( '🔍 Meta SEO', 'arti100' ); ?></h2>
		<table class="form-table">
			<tr>
				<th><?php esc_html_e( 'Meta description homepage', 'arti100' ); ?></th>
				<td><textarea name="arti100_meta_desc" rows="3" class="large-text"><?php echo esc_textarea( get_option( 'arti100_meta_desc', 'XXX - Décrivez votre activité en 160 caractères pour le SEO.' ) ); ?></textarea></td>
			</tr>
			<tr>
				<th><?php esc_html_e( 'Image Open Graph', 'arti100' ); ?></th>
				<td><input type="url" name="arti100_og_image" value="<?php echo esc_attr( get_option( 'arti100_og_image' ) ); ?>" class="large-text" /></td>
			</tr>
		</table>

		<h2><?php esc_html_e( '📄 Pied de page légal', 'arti100' ); ?></h2>
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
