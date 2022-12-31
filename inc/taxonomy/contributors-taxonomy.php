<?php
// Register Custom Taxonomy
function dpe_contributors_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Contributors', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Contributor', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Contributors', 'text_domain' ),
		'all_items'                  => __( 'All Contributors', 'text_domain' ),
		'parent_item'                => __( 'Parent Contributor', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Contributor:', 'text_domain' ),
		'new_item_name'              => __( 'New Contributor Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Contributor', 'text_domain' ),
		'edit_item'                  => __( 'Edit Contributor', 'text_domain' ),
		'update_item'                => __( 'Update Contributor', 'text_domain' ),
		'view_item'                  => __( 'View Contributor', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Contributors', 'text_domain' ),
		'search_items'               => __( 'Search Contributors', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
		'no_terms'                   => __( 'No items', 'text_domain' ),
		'items_list'                 => __( 'Contributors list', 'text_domain' ),
		'items_list_navigation'      => __( 'Contributors list navigation', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                       => 'contributor',
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_quick_edit'         => true,
		'show_admin_column'          => true,
		'show_in_rest'				 => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'contributors', array( 'post' ), $args );

}
add_action( 'init', 'dpe_contributors_taxonomy', 0 );

$userRoles = array(
	"administrator",
	"editor",
	"copy editor",
	"contributor",
	//"member",
	"event editor");


	
function add_new_user_as_contributor_tag( $user_id ){
	global $userRoles;
	/**
	* TODO 
	* add term to contributors
	* Name: Display Name
	* Slug: serialized Display Name 
	* User_id: Add User ID to term metadata
	*/	

	$user_info = get_userdata( $user_id );

	if ( in_array( $role, $userRoles) ) {
		$user_displayname = $user_info->display_name;

		$term_id = wp_insert_term( $user_displayname, "contributors");	
		add_term_meta ($term_id, "contributor_id", $user_info, false);
	}

}

add_filter( 'manage_edit-post_columns', 'rename_contributor_column' );
function rename_contributor_column( $columns ) {
    $columns['author'] = 'Posted by';
    return $columns;
}

add_action('add_meta_boxes', 'change_contributor_metabox');
function change_contributor_metabox() {
    global $wp_meta_boxes;
    $wp_meta_boxes['post']['normal']['core']['authordiv']['label']= 'Posted by';
}

add_action( 'user_register','add_new_user_as_contributor_tag', 10, 1);
add_action ('set_user_role', 'add_contributor_tag_on_role_update', 10, 2 );

function add_contributor_tag_on_role_update($user_id, $role){
	global $userRoles;
	$user_info = get_userdata( $user_id );
   
	if (in_array($user_info->roles[0], $userRoles)){
		$user_displayname = $user_info->display_name;
		$term_id = wp_insert_term( $user_displayname, "contributors");	
		add_term_meta ($term_id, "contributor_id", $user_info, false);
	}

}



/** */
add_action('menu_contributor_edit_form_fields','menu_contributor_edit_form_fields');
add_action('menu_category_add_form_fields','menu_contributor_edit_form_fields');
add_action('edited_menu_category', 'menu_contributor_save_form_fields', 10, 2);
add_action('created_menu_category', 'menu_contributor_save_form_fields', 10, 2);

function menu_contributor_save_form_fields($term_id) {
    $meta_name = 'order';
    if ( isset( $_POST[$meta_name] ) ) {
        $meta_value = $_POST[$meta_name];
        // This is an associative array with keys and values:
        // $term_metas = Array($meta_name => $meta_value, ...)
        $term_metas = get_option("taxonomy_{$term_id}_metas");
        if (!is_array($term_metas)) {
            $term_metas = Array();
        }
        // Save the meta value
        $term_metas[$meta_name] = $meta_value;
        update_option( "taxonomy_{$term_id}_metas", $term_metas );
    }
}

function menu_contributor_edit_form_fields ($term_obj) {
    // Read in the order from the options db
    $term_id = $term_obj->term_id;
    $term_metas = get_option("taxonomy_{$term_id}_metas");
    if ( isset($term_metas['order']) ) {
        $order = $term_metas['order'];
    } else {
        $order = '0';
    }
?>
    <tr class="form-field">
            <th valign="top" scope="row">
                <label for="order"><?php _e('Category Order', ''); ?></label>
            </th>
            <td>
                <input type="text" id="order" name="order" value="<?php echo $order; ?>"/>
            </td>
        </tr>
<?php 

}

/**
 * TODO
 * Fix Richtext Editor in taxonomy.
 * Issues when used with image upload 
 * could be reason to continue development on the gutenberg editor for taxonamy shortcut/hack/workaround
 */
// if ( class_exists( 'dpe_RICHTEXT_DESCRIPTION' ) ) {        
// 	$dpe_RICHTEXT_DESCRIPTION = new dpe_RICHTEXT_DESCRIPTION();
// 	$dpe_RICHTEXT_DESCRIPTION -> init( "contributors" );
// 	$dpe_RICHTEXT_DESCRIPTION -> field_names( "biography");
// 	$dpe_RICHTEXT_DESCRIPTION -> hide_description(true);
// }

if ( class_exists( 'dpe_TAX_FIELDS_META' ) ) {        
	$dpe_TAX_FIELDS_META = new dpe_TAX_FIELDS_META();
	$dpe_TAX_FIELDS_META -> init( "contributors" );
	$dpe_TAX_FIELDS_META -> fields( array("First name", "Last name", "Email", "Website", "Twitter","Facebook","YouTube","Instagram","LinkedIn") );
}

if ( class_exists( 'dpe_TAX_META_UPLOAD' ) ) {        
	$dpe_TAX_META_UPLOAD = new dpe_TAX_META_UPLOAD();
	$dpe_TAX_META_UPLOAD -> init( "contributors" );	
}
