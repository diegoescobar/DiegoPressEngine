<?php
/**
 * cleo Theme Customizer
 *
 * @package cleo
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function dpe_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'dpe_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'dpe_customize_partial_blogdescription',
			)
		);
	}
}
// add_action( 'customize_register', 'dpe_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function dpe_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function dpe_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function dpe_customize_preview_js() {
	wp_enqueue_script( 'cleo-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'dpe_customize_preview_js' );





add_action( "customize_register", "theme_customize_register" );
function theme_customize_register( $wp_customize ) {

 // Remove header image and widgets option from theme customizer
 $wp_customize->remove_control("header_image");
 $wp_customize->remove_control("blogdescription");
 $wp_customize->remove_panel("widgets");

 //  $wp_customize->remove_section("nav");
//  $wp_customize->remove_section("site_identity");

 // Remove Colors, Background image, and Static front page 
 // option from theme customizer     
 $wp_customize->remove_section("colors");
 $wp_customize->remove_section("background_image");
 $wp_customize->remove_section("static_front_page");


}