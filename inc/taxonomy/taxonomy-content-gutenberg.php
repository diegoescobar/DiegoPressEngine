<?php
if ( ! function_exists('taxonomy_content_init') ) {

    // Register Custom Post Type
    function taxonomy_content_init() {
    
        $labels = array(
            'name'                  => _x( 'Taxonomy Content', 'Post Type General Name', 'dpe_' ),
            'singular_name'         => _x( 'Taxonomy Content', 'Post Type Singular Name', 'dpe_' ),
            'menu_name'             => __( 'Taxonomy Content', 'dpe_' ),
            'name_admin_bar'        => __( 'Taxonomy Content', 'dpe_' ),
            'archives'              => __( 'Taxonomy Content', 'dpe_' ),
            'attributes'            => __( 'Taxonomy Content', 'dpe_' ),
            'parent_item_colon'     => __( 'Taxonomy Content', 'dpe_' ),
            'all_items'             => __( 'Taxonomy Content', 'dpe_' ),
            'add_new_item'          => __( 'Taxonomy Content', 'dpe_' ),
            'add_new'               => __( 'Taxonomy Content', 'dpe_' ),
            'new_item'              => __( 'Taxonomy Content', 'dpe_' ),
            'edit_item'             => __( 'Taxonomy Content', 'dpe_' ),
            'update_item'           => __( 'Taxonomy Content', 'dpe_' ),
            'view_item'             => __( 'Taxonomy Content', 'dpe_' ),
            'view_items'            => __( 'Taxonomy Content', 'dpe_' ),
            'search_items'          => __( 'Taxonomy Content', 'dpe_' ),
            'not_found'             => __( 'Taxonomy Content', 'dpe_' ),
            'not_found_in_trash'    => __( 'Taxonomy Content', 'dpe_' ),
            'featured_image'        => __( 'Taxonomy Content', 'dpe_' ),
            'set_featured_image'    => __( 'Taxonomy Content', 'dpe_' ),
            'remove_featured_image' => __( 'Taxonomy Content', 'dpe_' ),
            'use_featured_image'    => __( 'Taxonomy Content', 'dpe_' ),
            'insert_into_item'      => __( 'Taxonomy Content', 'dpe_' ),
            'uploaded_to_this_item' => __( 'Taxonomy Content', 'dpe_' ),
            'items_list'            => __( 'Taxonomy Content', 'dpe_' ),
            'items_list_navigation' => __( 'Taxonomy Content', 'dpe_' ),
            'filter_items_list'     => __( 'Taxonomy Content', 'dpe_' ),
        );
        $args = array(
            'label'                 => __( 'Taxonomy Content', 'dpe_' ),
            'description'           => __( 'Taxonomy Content', 'dpe_' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor' ),
            'taxonomies'            => array( 'category', 'post_tag', 'topic' ),
            'hierarchical'          => false,
            'public'                => false,
            'show_ui'               => true,
            'show_in_menu'          => false,
            'menu_position'         => 5,
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => false,
            'capability_type'       => 'page',
            'show_in_rest'          => true
        );
        register_post_type( 'taxonomy_content', $args );
    
    }
    add_action( 'init', 'taxonomy_content_init', 0 );
    
    }

//added to support salespage creation
add_filter( 'default_content', 'taxonomy_content', 10, 2 );

function taxonomy_content( $content, $post ) {

    if ($post->post_type === "taxonomy_content"){

        $tag_id = $_GET['term_id'];
        // $content = term_description( $tag_id );
        $term_data = get_term($tag_id);

        $content = $term_data->description;

    }
    
    return $content;
}


add_filter( 'default_title', 'taxonomy_title', 10, 2);

function taxonomy_title( $content, $post ) {
    if ($post->post_type === "taxonomy_content"){

        $tag_id = $_GET['term_id'];
        return $tag_id;

    }
}


remove_filter( 'pre_term_description', 'wp_filter_kses' );
remove_filter( 'pre_link_description', 'wp_filter_kses' );
remove_filter( 'pre_link_notes', 'wp_filter_kses' );
remove_filter( 'term_description', 'wp_kses_data' );


// add_action( 'admin_enqueue_scripts', 'my_admin_enqueue_scripts' );
// function my_admin_enqueue_scripts() {
//     if ( 'taxonomy_content' == get_post_type() )
//         wp_dequeue_script( 'autosave' );
// }

add_action('save_post_taxonomy_content', 'taxonomy_content_update', 10, 2);

function taxonomy_content_update($post_id, $post){
    if ($post->post_type === "taxonomy_content"){
        
        if ($post->post_status !== "auto-draft") {
            wp_update_term($post->post_title, 'topic', array('description'=> $post->post_content));            
            wp_delete_post( $post_id, true );
        }
        
    }
}

//Pre_save post_type