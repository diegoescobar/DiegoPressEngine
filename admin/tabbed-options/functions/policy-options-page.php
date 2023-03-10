<?php
/**
 * Generated by the WordPress Option Page generator
 * at http://jeremyhixon.com/wp-tools/option-page/
 */


add_action( 'admin_init', 'policies_pages_page_init' );

function policies_pages_create_admin_page() {
	$policies_pages_options = get_option( 'policies_options' ); ?>

	<div class="wrap">
		<h2>Policies Pages</h2>
		<p>Settings for various policy and legal boilerplate pages across the site</p>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'policies_pages_option_group' );
				do_settings_sections( 'policies-pages-admin' );
				submit_button();
			?>
		</form>
	</div>
<?php }

function policies_pages_page_init() {
	register_setting(
		'policies_pages_option_group', // option_group
		'policies_options', // option_name
		'policies_pages_sanitize' // sanitize_callback
	);

	// register_setting('reading','gnews-page', 'esc_attr');

	add_settings_section(
		'policies_pages_setting_section', // id
		'Settings', // title
		'policies_pages_section_info', // callback
		'policies-pages-admin' // page
	);

	add_settings_field(
		'terms_of_service', // id
		'Terms of Service', // title
		'terms_of_service_callback', // callback
		'policies-pages-admin', // page
		'policies_pages_setting_section' // section
	);

	add_settings_field(
		'promotional_policies', // id
		'Promotional Policies', // title
		'promotional_policies_callback', // callback
		'policies-pages-admin', // page
		'policies_pages_setting_section' // section
	);

	add_settings_field(
		'privacy_policy', // id
		'Privacy Policy ', // title
		'privacy_policy_callback', // callback
		'policies-pages-admin', // page
		'policies_pages_setting_section' // section
	);

	add_settings_field(
		'editorial_standards', // id
		__('Editorial Standards', 'xtra'), // title
		'editorial_standards_callback', // callback
		'policies-pages-admin', // page
		'policies_pages_setting_section' // section
	);

	add_settings_section(  
		'dpe_gnews_section', // Section ID 
		'Google News Select', // Section Title
		'gnews_exclude_section_callback', // Callback
		'policies-pages-admin' // What Page?  This makes the section show up on the General Settings Page
	);

	// add_settings_field( // Option 1
	// 	'gnews-page', // Option ID
	// 	'Select Google News Page', // Label
	// 	'gnews_exclude_callback', // !important - This is where the args go!
	// 	'policies-pages-admin', // Page it will be displayed (General Settings)
	// 	'dpe_gnews_section', // Name of our section
	// 	array( // The $args
	// 		'gnews-page' // Should match Option ID
	// 	)  
	// ); 


    add_settings_section(  
        'dpe_about_section', // Section ID 
        'About Us Select', // Section Title
        'about_select_section_callback', // Callback
        'policies-pages-admin' // What Page?  This makes the section show up on the General Settings Page
    );

    add_settings_field( // Option 1
        'about-page', // Option ID
        'Select About Us Page', // Label
        'about_select_callback', // !important - This is where the args go!
        'policies-pages-admin', // Page it will be displayed (General Settings)
        'dpe_about_section', // Name of our section
        array( // The $args
            'about-page' // Should match Option ID
        )  
    );
}


function policies_pages_sanitize($input) {
	$sanitary_values = array();
	
	if ( isset( $input['terms_of_service'] ) ) {
		$sanitary_values['terms_of_service'] = $input['terms_of_service'];
	}

	if ( isset( $input['promotional_policies'] ) ) {
		$sanitary_values['promotional_policies'] = $input['promotional_policies'];
	}

	if ( isset( $input['privacy_policy'] ) ) {
		$sanitary_values['privacy_policy'] = $input['privacy_policy'];
	}

	if ( isset( $input['editorial_standards'] ) ) {
		$sanitary_values['editorial_standards'] = $input['editorial_standards'];
	}

	return $sanitary_values;
}

function policies_pages_section_info() {
	
}

function terms_of_service_callback() {
	$policies_pages_options = get_option( 'policies_options' );
	$pages = get_pages_info();
	?> <select name="policies_options[terms_of_service]" id="terms_of_service">
		<option value=""><?= __('Select a page', 'xtra') ?></option>
		<?php foreach ($pages AS $page) {?>
		<?php $selected = (isset( $policies_pages_options['terms_of_service'] ) && $policies_pages_options['terms_of_service'] === $page["ID"]) ? 'selected' : '' ; ?>
		<option value="<?php echo $page["ID"]; ?>" <?php echo $selected; ?>><?php echo $page["post_title"]; ?></option>
		<?php } ?>
	</select> <?php
}

function promotional_policies_callback() {
	$policies_pages_options = get_option( 'policies_options' );
	$pages = get_pages_info();
	?> <select name="policies_options[promotional_policies]" id="promotional_policies">
		<?php foreach ($pages AS $page) {?>
		<?php $selected = (isset( $policies_pages_options['promotional_policies'] ) && $policies_pages_options['promotional_policies'] === $page["ID"]) ? 'selected' : '' ; ?>
		<option value="<?php echo $page["ID"]; ?>" <?php echo $selected; ?>><?php echo $page["post_title"]; ?></option>
		<?php } ?>
	</select> <?php
}

function privacy_policy_callback() {
	$policies_pages_options = get_option( 'policies_options' );
	$pages = get_pages_info();
	?> <select name="policies_options[privacy_policy]" id="privacy_policy">
		<?php foreach ($pages AS $page) {?>
		<?php $selected = (isset( $policies_pages_options['privacy_policy'] ) && $policies_pages_options['privacy_policy'] === $page["ID"]) ? 'selected' : '' ; ?>
		<option value="<?php echo $page["ID"]; ?>" <?php echo $selected; ?>><?php echo $page["post_title"]; ?></option>
		<?php } ?>
	</select> <?php
}

function editorial_standards_callback() {
	$policies_pages_options = get_option( 'policies_options' );
	$pages = get_pages_info();
	?> <select name="policies_options[editorial_standards]" id="editorial_standards">
		<?php foreach ($pages AS $page) {?>
		<?php $selected = (isset( $policies_pages_options['editorial_standards'] ) && $policies_pages_options['editorial_standards'] === $page["ID"]) ? 'selected' : '' ; ?>
		<option value="<?php echo $page["ID"]; ?>" <?php echo $selected; ?>><?php echo $page["post_title"]; ?></option>
		<?php } ?>
	</select> <?php
}

function get_pages_info(){
	global $wpdb;
	$result = $wpdb->get_results( "SELECT * FROM  $wpdb->posts WHERE post_type = 'page'",  ARRAY_A );

	return $result;
}



/*
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
*/



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
