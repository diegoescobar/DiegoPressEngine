<?php

require_once(  __DIR__ . '/scssphp/scss.inc.php');


if (is_customize_preview()) {
	add_action('wp_head', function() {
		$compiler = new ScssPhp\ScssPhp\Compiler();
 
		// $source_scss = get_stylesheet_directory() . '/sass/variables.scss';
        $source_scss = __DIR__ . '/../sass/variables.scss';

		$scssContents = file_get_contents($source_scss);
		$import_path = __DIR__ . '/../sass';
		$compiler->addImportPath($import_path);
        $compiler->setImportPaths( $import_path );
		$variables = [
			// '$primary' => get_theme_mod('theme-main', '#594c74'),
			// '$secondary' => get_theme_mod('theme-secondary', '#555'),
			'$text-size' => get_theme_mod('theme-text-size', '12') . 'px',

			'$primary' => get_theme_mod('theme-primary','#d63384'),
			'$secondary' => get_theme_mod('theme-secondary','#e9ecef'),
			'$success' => get_theme_mod('theme-success','#198754'),
			'$info' => get_theme_mod('theme-info','#0dcaf0'),
			'$warning' => get_theme_mod('theme-warning','#ffc107'),
			'$danger' => get_theme_mod('theme-danger',' #dc3545'),
			'$light' => get_theme_mod('theme-light','  #212529'),
			'$dark' => get_theme_mod('theme-dark','#f8f9fa'),

		];
		$compiler->setVariables($variables);

        $css = $compiler->compileString($scssContents, $source_scss);

        // var_dump( $compiler->getCompileOptions() );

        // echo '<hr>' . $compiler->compile($scssContents) . '<hr>';
        // var_dump( $compiler->getVariables( $scssContents ) );
		
        // var_dump( $css );

        // echo $css->getCss();
		if (!empty($css) && is_string($css)) {
			echo '<!--Generated CSS--><style type="text/css">' . $css . '</style>';
            // var_dump( $css );    
		}
        // $result->getCss();
        // var_dump( $css );

	});
}

add_action('customize_register', function($wp_customize) {
	$wp_customize->add_section('dynamic-variables', [
		'title' => __('Dynamic Variables', 'txtdomain'),
		'priority' => 25
	]);
 
	$wp_customize->add_setting('theme-main', ['default' => '#594c74']);
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme-main', [
		'section' => 'dynamic-variables',
		'label' => __('Primary color', 'txtdomain'),
		'priority' => 10
	]));
 
	$wp_customize->add_setting('theme-secondary', ['default' => '#555']);
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme-secondary', [
		'section' => 'dynamic-variables',
		'label' => __('Secondary theme color', 'txtdomain'),
		'priority' => 20
	]));
 
	$wp_customize->add_setting('theme-text-size', ['default' => '12']);
	$wp_customize->add_control('theme-text-size', [
		'section' => 'dynamic-variables',
		'label' => __('Text size', 'txtdomain'),
		'type' => 'number',
		'priority' => 30,
		'input_attrs' => ['min' => 8, 'max' => 20, 'step' => 1]
	]);
});

add_action('customize_save_after', function() {
	$compiler = new ScssPhp\ScssPhp\Compiler();
 
	$source_scss =  __DIR__ . '/../sass/variables.scss';
	$scssContents = file_get_contents($source_scss);
	$import_path =  __DIR__ . '/../sass';
	$compiler->addImportPath($import_path);
	$target_css =  __DIR__ . '/../css/variables.css';

	$variables = [
		'$primary' => get_theme_mod('theme-main', '#594c74'),
		'$secondary' => get_theme_mod('theme-secondary', '#555'),
		'$text-size' => get_theme_mod('theme-text-size', '12') . 'px',
	];		
	$compiler->setVariables($variables);
 
	$css = $compiler->compileString($scssContents, $import_path);
	if (!empty($css) && is_string($css)) {
		file_put_contents($target_css, $css);
	} else {
        dynamoc_throw_error( implode(';', $css) ); 
    }

});

function dynamoc_throw_error( $message ){
    header('HTTP/1.1 500 Internal Server Booboo');
    header('Content-Type: application/json; charset=UTF-8');
    // if (is_array()){ $css_test = implode('; ', $variables); }
    die(json_encode(array('message' => 'ERROR: ' . $message , 'code' => 1337)));
}


wp_enqueue_style( 'theme-style', get_stylesheet_directory_uri() . '/css/variables.css' );