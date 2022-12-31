<?php
// Register Custom Taxonomy
function dpe_topic_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Topics', 'Taxonomy General Name', 'dpe_' ),
		'singular_name'              => _x( 'Topic', 'Taxonomy Singular Name', 'dpe_' ),
		'menu_name'                  => __( 'Topics', 'dpe_' ),
		'all_items'                  => __( 'All Topics', 'dpe_' ),
		'parent_item'                => __( 'Parent Topic', 'dpe_' ),
		'parent_item_colon'          => __( 'Parent Topic:', 'dpe_' ),
		'new_item_name'              => __( 'New Topic Name', 'dpe_' ),
		'add_new_item'               => __( 'Add New Topic', 'dpe_' ),
		'edit_item'                  => __( 'Edit Topic', 'dpe_' ),
		'update_item'                => __( 'Update Topic', 'dpe_' ),
		'view_item'                  => __( 'View Topic', 'dpe_' ),
		'separate_items_with_commas' => __( 'Separate topics with commas', 'dpe_' ),
		'add_or_remove_items'        => __( 'Add or remove topics', 'dpe_' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'dpe_' ),
		'popular_items'              => __( 'Popular Topics', 'dpe_' ),
		'search_items'               => __( 'Search Topics', 'dpe_' ),
		'not_found'                  => __( 'Not Found', 'dpe_' ),
		'no_terms'                   => __( 'No topics', 'dpe_' ),
		'items_list'                 => __( 'Topics list', 'dpe_' ),
		'items_list_navigation'      => __( 'Topics list navigation', 'dpe_' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
	);
	register_taxonomy( 'topic', array( 'post' ), $args );

}
add_action( 'init', 'dpe_topic_taxonomy', 0 );

//http://localhost/wp_xtramagazine/wp-admin/post-new.php?post_type=taxonomy_content&taxonomy=topic&tag_ID=12517


if ( class_exists( 'dpe_TAX_META_UPLOAD' ) ) {        
	$dpe_TAX_META_UPLOAD = new dpe_TAX_META_UPLOAD();
	$dpe_TAX_META_UPLOAD -> init( "topic" );
}

add_action( "topic_edit_form_fields", 'topic_gutten_link', 10, 2);

function topic_gutten_link( $topic, $tt ){

	echo '<a href="http://localhost/wp_xtramagazine/wp-admin/post-new.php?post_type=taxonomy_content&term_id='.$topic->term_id.'">Guten Link</a>';

}

