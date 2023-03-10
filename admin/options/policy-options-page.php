<?php
/**
 * Generated by the WordPress Option Page generator
 * at http://jeremyhixon.com/wp-tools/option-page/
 */

class PoliciesPages {
	private $policies_pages_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'policies_pages_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'policies_pages_page_init' ) );
	}

	public function policies_pages_add_plugin_page() {
		add_submenu_page(
			'options-general.php',
			'Policies Pages', // page_title
			'Policies Pages', // menu_title
			'manage_options', // capability
			'policies-pages', // menu_slug
			array( $this, 'policies_pages_create_admin_page' ) // function
		);
	}

	public function policies_pages_create_admin_page() {
		$this->policies_pages_options = get_option( 'policies_options' ); ?>

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

	public function policies_pages_page_init() {
		register_setting(
			'policies_pages_option_group', // option_group
			'policies_options', // option_name
			array( $this, 'policies_pages_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'policies_pages_setting_section', // id
			'Settings', // title
			array( $this, 'policies_pages_section_info' ), // callback
			'policies-pages-admin' // page
		);

		add_settings_field(
			'terms_of_service', // id
			'Terms of Service', // title
			array( $this, 'terms_of_service_callback' ), // callback
			'policies-pages-admin', // page
			'policies_pages_setting_section' // section
		);

		add_settings_field(
			'promotional_policies', // id
			'Promotional Content Policies', // title
			array( $this, 'promotional_policies_callback' ), // callback
			'policies-pages-admin', // page
			'policies_pages_setting_section' // section
		);

		add_settings_field(
			'privacy_policy', // id
			'Privacy Policy ', // title
			array( $this, 'privacy_policy_callback' ), // callback
			'policies-pages-admin', // page
			'policies_pages_setting_section' // section
		);

		add_settings_field(
			'editorial_standards', // id
			__('Editorial Standards', 'xtra'), // title
			array( $this, 'editorial_standards_callback' ), // callback
			'policies-pages-admin', // page
			'policies_pages_setting_section' // section
		);
	}

	public function policies_pages_sanitize($input) {
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

	public function policies_pages_section_info() {
		
	}
    
	public function terms_of_service_callback() {
        $pages = $this->get_pages_info();
		?> <select name="policies_options[terms_of_service]" id="terms_of_service">
			<option value=""><?= __('Select a page', 'xtra') ?></option>
            <?php foreach ($pages AS $page) {?>
            <?php $selected = (isset( $this->policies_pages_options['terms_of_service'] ) && $this->policies_pages_options['terms_of_service'] === $page["ID"]) ? 'selected' : '' ; ?>
            <option value="<?php echo $page["ID"]; ?>" <?php echo $selected; ?>><?php echo $page["post_title"]; ?></option>
            <?php } ?>
		</select> <?php
	}

	public function promotional_policies_callback() {
        $pages = $this->get_pages_info();
		?> <select name="policies_options[promotional_policies]" id="promotional_policies">
			<?php foreach ($pages AS $page) {?>
            <?php $selected = (isset( $this->policies_pages_options['promotional_policies'] ) && $this->policies_pages_options['promotional_policies'] === $page["ID"]) ? 'selected' : '' ; ?>
            <option value="<?php echo $page["ID"]; ?>" <?php echo $selected; ?>><?php echo $page["post_title"]; ?></option>
            <?php } ?>
		</select> <?php
	}

	public function privacy_policy_callback() {
        $pages = $this->get_pages_info();
		?> <select name="policies_options[privacy_policy]" id="privacy_policy">
			<?php foreach ($pages AS $page) {?>
            <?php $selected = (isset( $this->policies_pages_options['privacy_policy'] ) && $this->policies_pages_options['privacy_policy'] === $page["ID"]) ? 'selected' : '' ; ?>
            <option value="<?php echo $page["ID"]; ?>" <?php echo $selected; ?>><?php echo $page["post_title"]; ?></option>
            <?php } ?>
		</select> <?php
	}

	public function editorial_standards_callback() {
				$pages = $this->get_pages_info();
		?> <select name="policies_options[editorial_standards]" id="editorial_standards">
			<?php foreach ($pages AS $page) {?>
            <?php $selected = (isset( $this->policies_pages_options['editorial_standards'] ) && $this->policies_pages_options['editorial_standards'] === $page["ID"]) ? 'selected' : '' ; ?>
            <option value="<?php echo $page["ID"]; ?>" <?php echo $selected; ?>><?php echo $page["post_title"]; ?></option>
            <?php } ?>
		</select> <?php
	}
	
    function get_pages_info(){
        global $wpdb;
        $result = $wpdb->get_results( "SELECT * FROM  $wpdb->posts WHERE post_type = 'page'",  ARRAY_A );
    
        return $result;
    }

}
if ( is_admin() ) {
	$policies_pages = new PoliciesPages();
}




/* 
 * Retrieve this value with:
 * $policies_pages_options = get_option( 'policies_options' ); // Array of All Options
 * $terms_of_service = $policies_pages_options['terms_of_service']; // Terms of Service
 * $promotional_policies = $policies_pages_options['promotional_policies']; // Promotional Content Policies
 * $privacy_policy = $policies_pages_options['privacy_policy']; // Privacy Policy 
 */
