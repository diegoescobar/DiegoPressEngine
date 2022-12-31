<?php


// require( __DIR__ . "/../../../wp-load.php" );
require_once( __DIR__ . "/scssphp/scss.inc.php" );

use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\ValueConverter;


function compileCleoSass(){

    $compiler = new Compiler();

    $compiler->setImportPaths( __DIR__ . '/../sass/' );


    $variables = cleoStyleVariables_arr();

    $compiler->replaceVariables(	$variables	);

    try {

        // $css = $compiler->compileString('@import "style.scss";')->getCss();
        $css = $compiler->compileString('@import "layouts/bs.resume.scss";')->getCss();
        return $css;

    } catch (\Exception $e) {
        return $e;
        syslog(LOG_ERR, 'scssphp: Unable to compile content');
    }
}


function cleoStyleVariables_arr() {
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

    $variables = array( 
        '$primary'      => ValueConverter::parseValue(get_theme_mod('theme-primary', '#d63384')),
        '$secondary'    => ValueConverter::parseValue(get_theme_mod('theme-secondary', '#e9ecef')),
        // '$text-size' => ValueConverter::parseValue(get_theme_mod('theme-text-size', '12'. 'px')),
        '$success'	    =>	ValueConverter::parseValue(get_theme_mod('theme-success', '#198754')),
        '$info'	        =>	ValueConverter::parseValue(get_theme_mod('theme-info','#0dcaf0')),
        '$warning'	    =>	ValueConverter::parseValue(get_theme_mod('theme-warning','#ffc107')),
        '$danger'	    =>	ValueConverter::parseValue(get_theme_mod('theme-danger','#dc3545')),
        '$light'	    =>	ValueConverter::parseValue(get_theme_mod('theme-light','#212529')),
        '$dark'	        =>	ValueConverter::parseValue(get_theme_mod('theme-dark','#f8f9fa')),
        );

    return $variables;

}

?>