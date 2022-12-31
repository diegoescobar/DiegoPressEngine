<?php
/** TODO Extend functionality of Privacy Policy page to add Terms and Conditions page
 * 
 * Possibly generate a new settings page & add similar functionality to that page instead of including within the WP Privacy Page
 * 
 */

add_action('admin_init', 'dpe_about_select_section');  
function dpe_about_select_section() {  
    add_settings_section(  
        'dpe_about_section', // Section ID 
        'About Us Select', // Section Title
        'about_select_section_callback', // Callback
        'reading' // What Page?  This makes the section show up on the General Settings Page
    );

    add_settings_field( // Option 1
        'about-page', // Option ID
        'Select About Us Page', // Label
        'about_select_callback', // !important - This is where the args go!
        'reading', // Page it will be displayed (General Settings)
        'dpe_about_section', // Name of our section
        array( // The $args
            'about-page' // Should match Option ID
        )  
    ); 

    register_setting('reading','about-page', 'esc_attr');
}

function about_select_section_callback() { // Section Callback
    echo '<p>Select the default About Us page</p>';  
}

function about_select_callback($args) {  // Textbox Callback
	// $option = get_option($args[0]);
	$option = get_option('about-page');
	
	// Custom query.
	$query = new WP_Query( array(
							'post_type'			=> 'page',
							'posts_per_page'	=> -1
						) );
	
	// Check that we have query results.
	if ( $query->have_posts() ) {
	
		// Start looping over the query results.

		echo '<select id="about-select" id="about-select" name="about-page">';
		while ( $query->have_posts() ) {
	
			$query->the_post();

			if ($option == get_the_ID()) {
				$selected = " selected";
			} else {
				$selected = "";
			}

			echo '<option value="' . get_the_ID() . '" ' . $selected .'>' . get_the_title() . '</option>';
		}
		echo '</select>';
	}
}

?>