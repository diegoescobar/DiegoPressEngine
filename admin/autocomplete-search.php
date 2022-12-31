<?php
/**
 * Enqueue scripts and styles.
 *
 * @since 1.0.0
 */
function ja_global_enqueues() {

	wp_enqueue_style(
		'jquery-auto-complete',
		'https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.css',
		array(),
		'1.0.7'
	);

	wp_enqueue_script(
		'jquery-auto-complete',
		'https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.js',
		array( 'jquery' ),
		'1.0.7',
		true
	);

	wp_enqueue_script(
		'global',
		get_template_directory_uri() . '/admin/global-search.js',
		array( 'jquery' ),
		'1.0.0',
		true
	);

	wp_localize_script(
		'global',
		'global',
		array(
			'ajax' => admin_url( 'admin-ajax.php' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'ja_global_enqueues' );
add_action( 'admin_enqueue_scripts', 'ja_global_enqueues' );

/**
 * Live autocomplete search feature.
 *
 * @since 1.0.0
 */
function ja_ajax_search() {

	$results = new WP_Query( array(
		'post_type'         => 'post',
        'post_status'       => 'publish',
        // 'nopaging'       => false,
        'orderby'           => 'ID',
        'order'             => 'DESC',
		'posts_per_page'    => 15,
		's'                 => stripslashes( $_REQUEST['search'] ),
	) );

	$items = array();

	if ( !empty( $results->posts ) ) {
		foreach ( $results->posts as $result ) {
            $items[] = array("label" => $result->post_title, "value" => $result->ID);
		}
	}

	wp_send_json_success( $items );
}
add_action( 'wp_ajax_search_site',        'ja_ajax_search' );
add_action( 'wp_ajax_nopriv_search_site', 'ja_ajax_search' );