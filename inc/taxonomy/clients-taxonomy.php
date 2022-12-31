<?php
if ( ! function_exists( 'client_taxonomy' ) ) {

    // Register Custom Taxonomy
    function client_taxonomy() {
    
        $labels = array(
            'name'                       => _x( 'Clients', 'Taxonomy General Name', 'dpe_' ),
            'singular_name'              => _x( 'Client', 'Taxonomy Singular Name', 'dpe_' ),
            'menu_name'                  => __( 'Clients', 'dpe_' ),
            'all_items'                  => __( 'All Clients', 'dpe_' ),
            'parent_item'                => __( 'Parent Client', 'dpe_' ),
            'parent_item_colon'          => __( 'Parent Client:', 'dpe_' ),
            'new_item_name'              => __( 'New Client Name', 'dpe_' ),
            'add_new_item'               => __( 'Add New Client', 'dpe_' ),
            'edit_item'                  => __( 'Edit Client', 'dpe_' ),
            'update_item'                => __( 'Update Client', 'dpe_' ),
            'view_item'                  => __( 'View Client', 'dpe_' ),
            'separate_items_with_commas' => __( 'Separate clients with commas', 'dpe_' ),
            'add_or_remove_items'        => __( 'Add or remove clients', 'dpe_' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'dpe_' ),
            'popular_items'              => __( 'Popular Clients', 'dpe_' ),
            'search_items'               => __( 'Search Clients', 'dpe_' ),
            'not_found'                  => __( 'Not Found', 'dpe_' ),
            'no_terms'                   => __( 'No clients', 'dpe_' ),
            'items_list'                 => __( 'Clients list', 'dpe_' ),
            'items_list_navigation'      => __( 'Clients list navigation', 'dpe_' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => false,
            'public'                     => false,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => false,
            'show_tagcloud'              => false,
            'show_in_quick_edit'         => false,
            'show_admin_column'          => false,
            'show_in_rest'				 => true,
        );
        register_taxonomy( 'clients', array( 'post' ), $args );
    
    }
    add_action( 'init', 'client_taxonomy', 0 );
    
    }

if ( class_exists( 'dpe_RICHTEXT_DESCRIPTION' ) ) {        
	// $dpe_RICHTEXT_DESCRIPTION = new dpe_RICHTEXT_DESCRIPTION();
	// $dpe_RICHTEXT_DESCRIPTION -> init( "clients" );
}


if ( class_exists( 'dpe_TAX_META_UPLOAD' ) ) {        
	$dpe_TAX_META_UPLOAD = new dpe_TAX_META_UPLOAD();
	$dpe_TAX_META_UPLOAD -> init( "clients" );
}

// add_action('create_clients', 'dpe_add_new_client', 10, 2);

// function dpe_add_new_client( $term, $tt ){
//     pre_dump( $term );
//     pre_dump( $tt );
//     exit;
// }