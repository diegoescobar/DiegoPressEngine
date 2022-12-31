<?php

require_once(  __DIR__ . '/scssphp/scss.inc.php');

include_once( __DIR__ . '/customizer-functions.php');

if (is_customize_preview()) {
	add_action('wp_head', function() {
		
        $css = compileCleoSass();

		if (!empty($css) && is_string($css)) {
			echo '<style type="text/css">' . $css . '</style>';
		}

	});
}

add_action('customize_register', function($wp_customize) {
    /*
    $primary:       #d63384 !default;
    $secondary:     #e9ecef !default;
    $success:       #198754 !default;
    $info:          #0dcaf0 !default;
    $warning:       #ffc107 !default;
    $danger:        #dc3545 !default;
    $light:         #212529 !default;
    $dark:          #f8f9fa !default;
    */

	$wp_customize->add_section('theme-variables', [
		'title' => __('Theme Colours', 'txtdomain'),
		'priority' => 25
	]);
 
	$wp_customize->add_setting('theme-primary', ['default' => '#594c74']);
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme-primary', [
		'section' => 'theme-variables',
		'label' => __('Primary theme color', 'txtdomain'),
		'priority' => 10
	]));
 
	$wp_customize->add_setting('theme-secondary', ['default' => '#e9ecef']);
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme-secondary', [
		'section' => 'theme-variables',
		'label' => __('Secondary theme color', 'txtdomain'),
		'priority' => 20
	]));

    $wp_customize->add_setting('theme-success', ['default' => '#198754']);
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme-success', [
		'section' => 'theme-variables',
		'label' => __('Success theme color', 'txtdomain'),
		'priority' => 20
	]));

    $wp_customize->add_setting('theme-info', ['default' => '#0dcaf0']);
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme-info', [
		'section' => 'theme-variables',
		'label' => __('info theme color', 'txtdomain'),
		'priority' => 20
	]));

    $wp_customize->add_setting('theme-warning', ['default' => '#ffc107']);
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme-warning', [
		'section' => 'theme-variables',
		'label' => __('warning theme color', 'txtdomain'),
		'priority' => 20
	]));

    $wp_customize->add_setting('theme-danger', ['default' => '#dc3545']);
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme-danger', [
		'section' => 'theme-variables',
		'label' => __('danger theme color', 'txtdomain'),
		'priority' => 20
	]));

    $wp_customize->add_setting('theme-light', ['default' => '#212529']);
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme-light', [
		'section' => 'theme-variables',
		'label' => __('light theme color', 'txtdomain'),
		'priority' => 20
	]));

    $wp_customize->add_setting('theme-dark', ['default' => '#f8f9fa']);
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme-dark', [
		'section' => 'theme-variables',
		'label' => __('dark theme color', 'txtdomain'),
		'priority' => 20
	]));
 
	// $wp_customize->add_setting('theme-text-size', ['default' => '12']);
	// $wp_customize->add_control('theme-text-size', [
	// 	'section' => 'theme-variables',
	// 	'label' => __('Text size', 'txtdomain'),
	// 	'type' => 'number',
	// 	'priority' => 30,
	// 	'input_attrs' => ['min' => 8, 'max' => 20, 'step' => 1]
	// ]);
});

add_action('customize_save_after', function() {

	$target_css =  __DIR__ . '/../css/resume-colour.css';

	$css = compileCleoSass();
    
    
    // if (is_array()){ $css_test = implode('; ', $variables); }

	if (!empty($css) && is_string($css)) {
		file_put_contents($target_css, $css);
	} else {
        customizer_throw_error( implode(';', $css) ); 
        // var_dump( $css );
    }

});

function customizer_throw_error( $message ){
    header('HTTP/1.1 500 Internal Server Booboo');
    header('Content-Type: application/json; charset=UTF-8');
    // if (is_array()){ $css_test = implode('; ', $variables); }
    die(json_encode(array('message' => 'ERROR: ' . $message , 'code' => 1337)));
}



function dynamic_dpe_add_footer_styles() {
    wp_enqueue_style( 'new-theme-style', get_stylesheet_directory_uri() . '/css/resume-colour.css', array('cleo-style'), _S_VERSION, true );
};

add_action( 'get_footer', 'dynamic_dpe_add_footer_styles' );