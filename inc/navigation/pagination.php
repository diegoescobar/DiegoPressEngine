<?php

function posts_pagination_nav() {

    if( is_singular() )
        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<div class="pagination"><ul>' . "\n";

    /** Previous Post Link */
    if ( get_previous_posts_link() ){
        printf( '<li>%s</li>' . "\n", get_previous_posts_link( '<svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4983 0.217273L11.9331 1.6521L3.58507 10.0001L11.9331 18.3481L10.4983 19.783L0.716796 10.0015L10.4983 0.217273Z" fill="#000000"/>
        </svg>') );
    } else {
        printf( '<li class="disabled">%s</li>' . "\n", '<svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4983 0.217273L11.9331 1.6521L3.58507 10.0001L11.9331 18.3481L10.4983 19.783L0.716796 10.0015L10.4983 0.217273Z" fill="#BDBDBD"/>
        </svg>');
    }
    /** Link to first page, plus ellipses if necessary */
    

    if (count($links) > 3) {
        if ( ! in_array( 3, $links ) ) {
            $class = 1 == $paged ? ' class="active"' : ' class="first"';

            printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

            if ( ! in_array(4 , $links ) )
                echo '<li class="spacer">...</li>';
        }
}
    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li class="spacer">...</li>' . "\n";


            if (count($links) > 3) {
                $class = $paged == $max ? ' class="active"' : ' class="last"';
            }

        
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /** Next Post Link */
    if ( get_next_posts_link() ){
        printf( '<li>%s</li>' . "\n", get_next_posts_link('<svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.50175 19.7827L0.0669185 18.3479L8.41493 9.99988L0.0669193 1.65187L1.50175 0.217041L11.2832 9.9985L1.50175 19.7827Z" fill="black"/>
        </svg>') );
    } else {
        printf( '<li>%s</li>' . "\n", '<svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.50175 19.7827L0.0669185 18.3479L8.41493 9.99988L0.0669193 1.65187L1.50175 0.217041L11.2832 9.9985L1.50175 19.7827Z" fill="#BDBDBD"/>
        </svg>') ;
    }

    echo '</ul></div>' . "\n";

}


function get_posts_pagination_nav() {

    if( is_singular() )
        return;

    global $wp_query;

    $pagination = "";

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    $pagination .= '<div class="pagination"><ul>' . "\n";

    /** Previous Post Link */
    if ( get_previous_posts_link() )
         $pagination .= sprintf( '<li>%s</li>' . "\n", get_previous_posts_link() );

    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';

        $pagination .= sprintf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )
            $pagination .= '<li>…</li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        $pagination .= sprintf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            $pagination .= '<li>…</li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        $pagination .= sprintf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /** Next Post Link */
    if ( get_next_posts_link() )
        $pagination .= sprintf( '<li>%s</li>' . "\n", get_next_posts_link() );

        $pagination .= '</ul></div>' . "\n";


    return $pagination;
}