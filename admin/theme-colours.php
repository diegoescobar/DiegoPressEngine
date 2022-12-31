<?php

function dpe__theme_colors() {
    add_theme_support( 'editor-color-palette', array(

        array(
            'name' => __( 'Magenta', 'dpe_' ),
            'slug' => 'magenta',
            'color' => '#FA2891',
        ),
        array(
            'name' => __( 'Cyan', 'dpe_' ),
            'slug' => 'cyan',
            'color' => '#1DBEC8',
        ),
        array(
            'name' => __( 'Blue', 'dpe_' ),
            'slug' => 'blue',
            'color' => '#1446AA',
        ),
        array(
            'name' => __( 'Purple', 'dpe_' ),
            'slug' => 'purple',
            'color' => '#4B144B',
        ),
        array(
            'name' => __( 'Yellow', 'dpe_' ),
            'slug' => 'yellow',
            'color' => '#FFCD00',
        ),
        array(
            'name' => __( 'Pink', 'dpe_' ),
            'slug' => 'pink',
            'color' => '#FFD2D1',
        ),
        array(
            'name' => __( 'Black', 'dpe_' ),
            'slug' => 'black',
            'color' => '#000000',
        ),
        array(
            'name' => __( 'Grey Darkest', 'dpe_' ),
            'slug' => 'grey_darkest',
            'color' => '#333333',
        ),
        array(
            'name' => __( 'Grey Darker', 'dpe_' ),
            'slug' => 'grey_darker',
            'color' => '#4F4F4F',
        ),
        array(
            'name' => __( 'Grey Dark', 'dpe_' ),
            'slug' => 'grey_dark',
            'color' => '#828282',
        ),
        array(
            'name' => __( 'White', 'dpe_' ),
            'slug' => 'white',
            'color' => '#ffffff',
        ),
        array(
            'name' => __( 'Grey Lightest', 'dpe_' ),
            'slug' => 'grey_lightest',
            'color' => '#F2F2F2',
        ),
        array(
            'name' => __( 'Grey Lighter', 'dpe_' ),
            'slug' => 'grey_lighter',
            'color' => '#E0E0E0',
        ),
        array(
            'name' => __( 'Grey Light', 'dpe_' ),
            'slug' => 'grey_light',
            'color' => '#BDBDBD',
        ),
    ) );
}
 
add_action( 'after_setup_theme', 'dpe__theme_colors' );

?>
