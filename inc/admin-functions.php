<?php 

if ( ! function_exists( 'disable_post_status' ) ) :
    function disable_post_status( $postid ){

        if (!$postid || is_null($postid) || $postid == 0 ) {
            return false;
        }

        if ( ctype_alpha( $postid ) ){
            return false;
        }
        
        if(!current_user_can('administrator')) {
            return false;    
        }

        // echo "<h2>WHHHOOOOOP ". $postid ."</h2>";

        wp_update_post(array(
            'ID'    =>  $postid,
            'post_status'   =>  'private'
        ));
    }
endif;

if ( ! function_exists( 'disable_post_link' ) ) :
    function disable_post_link( $postid ){
        if ( $postid){
            return "?disable=".$postid;
        }
    }
endif;

if ( ! function_exists( 'admin_function_options' ) ) :
    function admin_function_options(){
        global $post;
        if(current_user_can('administrator')) {
            echo '<span class="adminOptions"><a href="' . disable_post_link ($post->ID) . '">Disable Post</a> </span>';
        }
    }
endif;


if (isset($_REQUEST) && isset($_GET['disable'])){
    if(current_user_can('administrator')) {
        disable_post_status( $_GET['disable'] );
    }
}


if ( ! function_exists( 'dpe_dev_toolbar' ) ) :
    // Add Toolbar Menus
    function dpe_dev_toolbar() {
        global $wp_admin_bar;
        global $wpdb;

        $args = array(
            'id'     => 'dev-nav-menu',
            'title'  => __( 'Navigation', 'text_domain' ),
        );

        $wp_admin_bar->add_menu( $args );

        $row = $wpdb->get_results("SELECT ID, post_title FROM " . $wpdb->prefix . "posts WHERE post_type = 'post' ORDER BY RAND() LIMIT 1");

        // if ( $rand_query->have_posts() ) {
        if (!empty($row[0])){
            $args = array(
                'id'     => 'random-post',
                'parent' => 'dev-nav-menu',
                'title'  => __( 'Random Post', 'text_domain' ),
                'href'	 => get_site_url() . '?p='.$row[0]->ID
            );
            $wp_admin_bar->add_menu( $args );
        }
        if (!is_admin()){
            $prev_post = get_previous_post();
            if ($prev_post){
                $args = array(
                    'id'     => 'prev-post',
                    'parent' => 'dev-nav-menu',
                    'title'  => __( 'Previous Post', 'text_domain' ),
                    'href'	 => get_site_url() . '?p='.$prev_post->ID
                );
                $wp_admin_bar->add_menu( $args );
            }

            $next_post = get_next_post();
            if ($next_post){
                $args = array(
                    'id'     => 'next-post',
                    'parent' => 'dev-nav-menu',
                    'title'  => __( 'Next Post', 'text_domain' ),
                    'href'	 => get_site_url() . '?p='.$next_post->ID
                );
                $wp_admin_bar->add_menu( $args );
            }

            $args = array(
                'id'     => 'dev-post',
                'parent' => 'dev-nav-menu',
                'title'  => __( 'View on Dev', 'text_domain' ),
                'href'	 => 'https://dev1.domain.com?p=' . get_the_ID(),
                "meta"	 => array(
                                'target'	=> "_prod"
                            )
            );
            // $wp_admin_bar->add_menu( $args );

            $args = array(
                'id'     => 'stage-post',
                'parent' => 'dev-nav-menu',
                'title'  => __( 'View on Staging', 'text_domain' ),
                'href'	 => 'https://staging1.domain.com?p=' . get_the_ID(),
                "meta"	 => array(
                                'target'	=> "_prod"
                            )
            );
            // $wp_admin_bar->add_menu( $args );

            $args = array(
                'id'     => 'prod-post',
                'parent' => 'dev-nav-menu',
                'title'  => __( 'View on Production', 'text_domain' ),
                'href'	 => 'http://domain.com?p=' . get_the_ID(),
                "meta"	 => array(
                                'target'	=> "_prod"
                            )
            );
            // $wp_admin_bar->add_menu( $args );
        }
    }
    add_action( 'wp_before_admin_bar_render', 'dpe_dev_toolbar', 999 );
endif; 



if ( ! function_exists( 'dpe_admin_toolbar' ) ) :
    // Add Toolbar Menus
    function dpe_admin_toolbar() {
        global $wp_admin_bar;
        global $wpdb;

        $args = array(
            'id'     => 'admin-nav-menu',
            'title'  => __( 'Post Admin', 'text_domain' ),
        );
        $wp_admin_bar->add_menu( $args );

        if (!is_admin()){
            $args = array(
                'id'     => 'admin-post',
                'parent' => 'admin-nav-menu',
                'title'  => __( 'Set Private', 'text_domain' ),
                'href'	 => '?disable=' . get_the_ID()
            );

            $wp_admin_bar->add_menu( $args );
        }
    }
    add_action( 'wp_before_admin_bar_render', 'dpe_admin_toolbar', 999 );
endif; 

if ( ! function_exists( 'dpe_disable_srcset' ) ) :
    function dpe_disable_srcset( $sources ) {
        return false;
    }
    // if ( isLocalhost() ){
    // 	add_filter( 'wp_calculate_image_srcset', 'dpe_disable_srcset' );
    // }
endif;

if ( ! function_exists( 'dpe_disable_srcset' ) ) :
    function dpe_disable_srcset( $sources ) {
        return false;
    }
    // if ( isLocalhost() ){
    // 	add_filter( 'wp_calculate_image_srcset', 'dpe_disable_srcset' );
    // }
endif;
?>