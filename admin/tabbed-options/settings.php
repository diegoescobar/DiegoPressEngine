<?php

include 'functions/homepage.php';
include 'functions/social.php';
include 'functions/description.php';
include 'functions/policy-options-page.php';

add_action( 'admin_menu', 'dpe_theme__add_admin_menu' );
add_action( 'admin_init', 'dpe__theme_init' );

function dpe_theme__add_admin_menu(  ) { 

	add_options_page( 'Theme Settings', 'Theme Settings', 'manage_options', 'dpe_theme_settings', 'dpe_theme_options_page' );

}

function dpe__theme_init(  ) { 

	register_setting( 'dpe_theme_settings', 'dpe__theme' );

}

function dpe_admin_tabs( $current = 'homepage' ) { 
    $tabs = array( 
		'homepage' => 'Home', 
		'general' => 'General', 
		'social' => 'Social',
		'menu'	=>	'Menu',
		'policy'	=>	'Policy',
		'footer' => 'Footer' );


    $links = array();
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=dpe_theme_settings&tab=$tab'>$name</a>";
        
    }
    echo '</h2>';
}

function dpe_theme_options_page(  ) {  ?>
    <style>
        .autocomplete-suggestions { width: 625px !important; }
        .autocomplete-suggestion { max-width: 625px !important;}
    </style>

	<h2>Theme Settings</h2>
	<hr/>
	<?php

	if ( 'true' == esc_attr( $_GET['updated'] ) ) echo '<div class="updated" ><p>Theme Settings updated.</p></div>';
	
	if ( isset ( $_GET['tab'] ) ) { 
		dpe_admin_tabs($_GET['tab']); 

		if ($_GET['tab'] === "homepage"){
			dpe_homepage_options_page();	
		}
		if ($_GET['tab'] === "general"){
			dpe_description_settings_create_admin_page();
		}
		
		if ($_GET['tab'] === "social"){
			dpe_social_settings_create_admin_page();
		}

		if ($_GET['tab'] === "menu"){
			// dpe_social_settings_create_admin_page();
			echo "Menu options";
		}

		if ($_GET['tab'] === "policy"){
			policies_pages_create_admin_page();
		}

	} else { 
		dpe_admin_tabs('homepage');

		dpe_homepage_options_page();
	}

}
