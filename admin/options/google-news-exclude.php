<?php
/** TODO Extend functionality of Privacy Policy page to add Terms and Conditions page
 * 
 * Possibly generate a new settings page & add similar functionality to that page instead of including within the WP Privacy Page
 * 
 */

add_action('admin_init', 'dpe_gnews_exclude_section');  
function dpe_gnews_exclude_section() {  
    add_settings_section(  
        'dpe_gnews_section', // Section ID 
        'Google News Select', // Section Title
        'gnews_exclude_section_callback', // Callback
        'reading' // What Page?  This makes the section show up on the General Settings Page
    );

    add_settings_field( // Option 1
        'gnews-page', // Option ID
        'Select Google News Page', // Label
        'gnews_exclude_callback', // !important - This is where the args go!
        'reading', // Page it will be displayed (General Settings)
        'dpe_gnews_section', // Name of our section
        array( // The $args
            'gnews-page' // Should match Option ID
        )  
    ); 

    register_setting('reading','gnews-page', 'esc_attr');
}

function gnews_exclude_section_callback() { // Section Callback
    echo '<p>Select which category to exclude from Google News Feed</p>';  
}

function gnews_exclude_callback($args) {  // Textbox Callback
	// $option = get_option($args[0]);
	$option = get_option('gnews-page');

	$categories = get_categories();

	if(count($categories) > 0){
		echo '<select id="gnews-select" id="gnews-select" name="gnews-page">';
		
		foreach ($categories as $category){

			if ($option == $category->cat_ID){
				$selected = " selected";
			} else {
				$selected = "";
			}	
			echo '<option value="' . $category->cat_ID . '" ' . $selected .'>' . $category->name . '</option>';

		}
		echo '</select>';
	}
}

?>