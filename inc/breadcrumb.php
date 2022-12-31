<?php
/**
* BREADCRUMBS
*/

//  to include in functions.php
function the_breadcrumb() {
    global $post;
    // var_dump ( $post );
    if (!is_front_page()) {
        ?>
        <nav class="breadcrumb" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="<?php echo get_option('home');?>">Home</a></li>
    <?php
	
    // Check if the current page is a category, an archive or a single page. If so show the category or archive name.
    if (is_category() || is_single() ){

        ?><li class="breadcrumb-item"><?php the_category(' |  '); ?></li><?php
    } elseif (is_archive() || is_single()){
        if ( is_day() ) {
            printf( __( '%s', 'text_domain' ), get_the_date() );
        } elseif ( is_month() ) {
            printf( __( '%s', 'text_domain' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'text_domain' ) ) );
        } elseif ( is_year() ) {
            printf( __( '%s', 'text_domain' ), get_the_date( _x( 'Y', 'yearly archives date format', 'text_domain' ) ) );
        } else {
            _e( 'Blog Archives', 'text_domain' );
        }
    }

    //Get Post Parent Link
    if ( $post->post_parent ) {
        ?><li class="breadcrumb-item"><a href="<?php the_permalink( $post->post_parent ); ?>"><?php echo get_the_title( $post->post_parent ); ?></a></li><?php 
    } 

    // If the current page is a single post, show its title with the separator
    if (is_single() || is_page()) {
        ?><li class="breadcrumb-item"><?php the_title(); ?></li><?php
    }

    // if you have a static page assigned to be you posts list page. It will find the title of the static page and display it. i.e Home >> Blog
    if (is_home()){
        $page_for_posts_id = get_option('page_for_posts');
        if ( $page_for_posts_id ) { 
            $post = get_post($page_for_posts_id);
            setup_postdata($post);
            ?><li class="breadcrumb-item"><?php the_title();?></li><?php
            rewind_posts();
        }
    }

    // ?><li class="breadcrumb-item"><?php  
    // ?></li><?php
}

?>
    </ol>
</nav>
<?php
}
/*
* Credit: http://www.thatweblook.co.uk/blog/tutorials/tutorial-wordpress-breadcrumb-function/
*/
?>