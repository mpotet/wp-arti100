<?php
/**
 * Arti100 — Custom Post Types & Taxonomies
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* =========================================================
   CPT : TRAVAUX
   ========================================================= */
function arti100_register_cpt_travaux() {
	$labels = [
		'name'               => __( 'Travaux', 'arti100' ),
		'singular_name'      => __( 'Travail', 'arti100' ),
		'add_new'            => __( 'Ajouter un chantier', 'arti100' ),
		'add_new_item'       => __( 'Nouveau chantier', 'arti100' ),
		'edit_item'          => __( 'Modifier le chantier', 'arti100' ),
		'new_item'           => __( 'Nouveau chantier', 'arti100' ),
		'view_item'          => __( 'Voir le chantier', 'arti100' ),
		'search_items'       => __( 'Rechercher', 'arti100' ),
		'not_found'          => __( 'Aucun chantier trouvé', 'arti100' ),
		'not_found_in_trash' => __( 'Corbeille vide', 'arti100' ),
		'menu_name'          => __( 'Réalisations', 'arti100' ),
	];
	register_post_type( 'travaux', [
		'labels'             => $labels,
		'public'             => true,
		'has_archive'        => true,
		'rewrite'            => [ 'slug' => 'realisations' ],
		'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
		'menu_icon'          => 'dashicons-hammer',
		'show_in_rest'       => true,
		'menu_position'      => 5,
	] );
}
add_action( 'init', 'arti100_register_cpt_travaux' );

/* =========================================================
   CPT : SERVICE
   ========================================================= */
function arti100_register_cpt_service() {
	$labels = [
		'name'               => __( 'Services', 'arti100' ),
		'singular_name'      => __( 'Service', 'arti100' ),
		'add_new'            => __( 'Ajouter un service', 'arti100' ),
		'add_new_item'       => __( 'Nouveau service', 'arti100' ),
		'edit_item'          => __( 'Modifier le service', 'arti100' ),
		'menu_name'          => __( 'Services', 'arti100' ),
	];
	register_post_type( 'service', [
		'labels'             => $labels,
		'public'             => true,
		'has_archive'        => false,
		'rewrite'            => [ 'slug' => 'services' ],
		'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
		'menu_icon'          => 'dashicons-screenoptions',
		'show_in_rest'       => true,
		'menu_position'      => 6,
	] );
}
add_action( 'init', 'arti100_register_cpt_service' );

/* =========================================================
   CPT : ARTISAN (équipe)
   ========================================================= */
function arti100_register_cpt_artisan() {
	$labels = [
		'name'          => __( 'Équipe', 'arti100' ),
		'singular_name' => __( 'Membre', 'arti100' ),
		'add_new'       => __( 'Ajouter un membre', 'arti100' ),
		'menu_name'     => __( 'Équipe', 'arti100' ),
	];
	register_post_type( 'artisan', [
		'labels'       => $labels,
		'public'       => false,
		'show_ui'      => true,
		'supports'     => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
		'menu_icon'    => 'dashicons-groups',
		'show_in_rest' => true,
		'menu_position'=> 7,
	] );
}
add_action( 'init', 'arti100_register_cpt_artisan' );

/* =========================================================
   TAXONOMIE : Catégorie de travaux
   ========================================================= */
function arti100_register_tax_travaux() {
	register_taxonomy( 'type_travaux', 'travaux', [
		'labels'       => [
			'name'          => __( 'Types de travaux', 'arti100' ),
			'singular_name' => __( 'Type', 'arti100' ),
		],
		'hierarchical' => true,
		'rewrite'      => [ 'slug' => 'type-travaux' ],
		'show_in_rest' => true,
	] );
}
add_action( 'init', 'arti100_register_tax_travaux' );

/* =========================================================
   METABOXES — TRAVAUX
   ========================================================= */
function arti100_add_travaux_metaboxes() {
	add_meta_box( 'arti100_travaux_meta', __( 'Détails du chantier', 'arti100' ), 'arti100_travaux_meta_callback', 'travaux', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'arti100_add_travaux_metaboxes' );

function arti100_travaux_meta_callback( $post ) {
	wp_nonce_field( 'arti100_travaux_meta', 'arti100_travaux_nonce' );
	$avant     = get_post_meta( $post->ID, '_travaux_photo_avant', true );
	$apres     = get_post_meta( $post->ID, '_travaux_photo_apres', true );
	$client    = get_post_meta( $post->ID, '_travaux_client_temoignage', true );
	$duree     = get_post_meta( $post->ID, '_travaux_duree', true );
	$localite  = get_post_meta( $post->ID, '_travaux_localite', true );
	?>
	<table class="form-table">
		<tr>
			<th><?php esc_html_e( 'Photo AVANT (URL)', 'arti100' ); ?></th>
			<td>
				<input type="url" name="travaux_photo_avant" value="<?php echo esc_attr( $avant ); ?>" class="large-text" />
				<button type="button" class="button arti100-media-btn" data-target="travaux_photo_avant"><?php esc_html_e( 'Choisir image', 'arti100' ); ?></button>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Photo APRÈS (URL)', 'arti100' ); ?></th>
			<td>
				<input type="url" name="travaux_photo_apres" value="<?php echo esc_attr( $apres ); ?>" class="large-text" />
				<button type="button" class="button arti100-media-btn" data-target="travaux_photo_apres"><?php esc_html_e( 'Choisir image', 'arti100' ); ?></button>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Témoin client', 'arti100' ); ?></th>
			<td><textarea name="travaux_client_temoignage" rows="3" class="large-text"><?php echo esc_textarea( $client ); ?></textarea></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Durée chantier', 'arti100' ); ?></th>
			<td><input type="text" name="travaux_duree" value="<?php echo esc_attr( $duree ); ?>" placeholder="ex: 2 jours" /></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Localité', 'arti100' ); ?></th>
			<td><input type="text" name="travaux_localite" value="<?php echo esc_attr( $localite ); ?>" placeholder="ex: Nantes" /></td>
		</tr>
	</table>
	<script>
	jQuery(function($){
		$('.arti100-media-btn').on('click',function(){
			var target=$(this).data('target');
			var frame=wp.media({title:'Choisir une image',button:{text:'Utiliser cette image'},multiple:false});
			frame.on('select',function(){
				var a=frame.state().get('selection').first().toJSON();
				$('input[name="'+target+'"]').val(a.url);
			});
			frame.open();
		});
	});
	</script>
	<?php
}

function arti100_save_travaux_meta( $post_id ) {
	if ( ! isset( $_POST['arti100_travaux_nonce'] ) ) return;
	if ( ! wp_verify_nonce( $_POST['arti100_travaux_nonce'], 'arti100_travaux_meta' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	$fields = [ 'travaux_photo_avant', 'travaux_photo_apres', 'travaux_duree', 'travaux_localite' ];
	foreach ( $fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, '_' . $field, sanitize_text_field( $_POST[ $field ] ) );
		}
	}
	if ( isset( $_POST['travaux_client_temoignage'] ) ) {
		update_post_meta( $post_id, '_travaux_client_temoignage', sanitize_textarea_field( $_POST['travaux_client_temoignage'] ) );
	}
}
add_action( 'save_post_travaux', 'arti100_save_travaux_meta' );

/* =========================================================
   METABOXES — SERVICE
   ========================================================= */
function arti100_add_service_metaboxes() {
	add_meta_box( 'arti100_service_meta', __( 'Détails du service', 'arti100' ), 'arti100_service_meta_callback', 'service', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'arti100_add_service_metaboxes' );

function arti100_service_meta_callback( $post ) {
	wp_nonce_field( 'arti100_service_meta', 'arti100_service_nonce' );
	$icone  = get_post_meta( $post->ID, '_service_icone', true );
	$prix   = get_post_meta( $post->ID, '_service_prix', true );
	$duree  = get_post_meta( $post->ID, '_service_duree', true );
	$ordre  = get_post_meta( $post->ID, '_service_ordre', true );
	?>
	<table class="form-table">
		<tr>
			<th><?php esc_html_e( 'Icône (SVG inline ou emoji)', 'arti100' ); ?></th>
			<td><input type="text" name="service_icone" value="<?php echo esc_attr( $icone ); ?>" class="large-text" placeholder="🔧 ou <svg>…</svg>" /></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Prix indicatif', 'arti100' ); ?></th>
			<td><input type="text" name="service_prix" value="<?php echo esc_attr( $prix ); ?>" placeholder="À partir de 80 €/h" /></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Durée indicative', 'arti100' ); ?></th>
			<td><input type="text" name="service_duree" value="<?php echo esc_attr( $duree ); ?>" placeholder="1 à 3 jours" /></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Ordre d\'affichage', 'arti100' ); ?></th>
			<td><input type="number" name="service_ordre" value="<?php echo esc_attr( $ordre ); ?>" min="0" max="99" /></td>
		</tr>
	</table>
	<?php
}

function arti100_save_service_meta( $post_id ) {
	if ( ! isset( $_POST['arti100_service_nonce'] ) ) return;
	if ( ! wp_verify_nonce( $_POST['arti100_service_nonce'], 'arti100_service_meta' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	foreach ( [ 'service_icone', 'service_prix', 'service_duree', 'service_ordre' ] as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, '_' . $field, sanitize_text_field( $_POST[ $field ] ) );
		}
	}
}
add_action( 'save_post_service', 'arti100_save_service_meta' );

/* =========================================================
   METABOXES — ARTISAN (équipe)
   ========================================================= */
function arti100_add_artisan_metaboxes() {
	add_meta_box( 'arti100_artisan_meta', __( 'Profil du membre', 'arti100' ), 'arti100_artisan_meta_callback', 'artisan', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'arti100_add_artisan_metaboxes' );

function arti100_artisan_meta_callback( $post ) {
	wp_nonce_field( 'arti100_artisan_meta', 'arti100_artisan_nonce' );
	$poste  = get_post_meta( $post->ID, '_artisan_poste', true );
	$bio    = get_post_meta( $post->ID, '_artisan_bio', true );
	$tel    = get_post_meta( $post->ID, '_artisan_tel', true );
	$linkedin = get_post_meta( $post->ID, '_artisan_linkedin', true );
	?>
	<table class="form-table">
		<tr>
			<th><?php esc_html_e( 'Poste / Métier', 'arti100' ); ?></th>
			<td><input type="text" name="artisan_poste" value="<?php echo esc_attr( $poste ); ?>" class="regular-text" placeholder="Chef plombier" /></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Bio courte', 'arti100' ); ?></th>
			<td><textarea name="artisan_bio" rows="3" class="large-text"><?php echo esc_textarea( $bio ); ?></textarea></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Téléphone direct', 'arti100' ); ?></th>
			<td><input type="tel" name="artisan_tel" value="<?php echo esc_attr( $tel ); ?>" /></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'LinkedIn URL', 'arti100' ); ?></th>
			<td><input type="url" name="artisan_linkedin" value="<?php echo esc_attr( $linkedin ); ?>" class="large-text" /></td>
		</tr>
	</table>
	<?php
}

function arti100_save_artisan_meta( $post_id ) {
	if ( ! isset( $_POST['arti100_artisan_nonce'] ) ) return;
	if ( ! wp_verify_nonce( $_POST['arti100_artisan_nonce'], 'arti100_artisan_meta' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	foreach ( [ 'artisan_poste', 'artisan_tel' ] as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, '_' . $field, sanitize_text_field( $_POST[ $field ] ) );
		}
	}
	if ( isset( $_POST['artisan_bio'] ) ) {
		update_post_meta( $post_id, '_artisan_bio', sanitize_textarea_field( $_POST['artisan_bio'] ) );
	}
	if ( isset( $_POST['artisan_linkedin'] ) ) {
		update_post_meta( $post_id, '_artisan_linkedin', esc_url_raw( $_POST['artisan_linkedin'] ) );
	}
}
add_action( 'save_post_artisan', 'arti100_save_artisan_meta' );
