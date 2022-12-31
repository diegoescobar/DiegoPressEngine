<?php

class XMMagazineDescriptions {

	private $_dpe_description;


	public function __construct() {
		add_action( 'admin_menu', array( $this, 'dpe_description_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'dpe_description_settings_page_init' ) );
	}

	public function dpe_description_settings_add_plugin_page() {
		add_options_page(
			'Magazine Settings', // page_title
			'Magazine Settings', // menu_title
			'manage_options', // capability
			'xm-magazine-settings', // menu_slug
			array( $this, 'dpe_description_settings_create_admin_page' ) // function
		);
	}

	public function dpe_description_settings_create_admin_page() {
		$this->_dpe_description = get_option( 'dpe_description' ); 
		$this->dpe_newsletter_description = get_option( 'dpe_newsletter_description' ); 
		?>

		<div class="wrap">
			<h2>Magazine Settings</h2>

			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'dpe_description_group' );
					do_settings_sections( 'xm-magazine-settings-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function dpe_description_settings_page_init() {


		register_setting(
			'dpe_description_group', // option_group
			'dpe_description', // option_name
			array( $this, 'dpe_description_settings_sanitize' ) // sanitize_callback
		);

		register_setting(
			'dpe_description_group', // option_group
			'dpe_newsletter_description', // option_name
			array( $this, 'dpe_description_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'dpe_description_settings_section', // id
			'Site Description', // title
			array( $this, 'dpe_description_settings_section_info' ), // callback
			'xm-magazine-settings-admin' // page
		);

		add_settings_field(
			'dpe_description', // id
			'Site Description', // title
			array( $this, 'site_description_callback' ), // callback
			'xm-magazine-settings-admin', // page
			'dpe_description_settings_section' // section
		);

		add_settings_field(
			'dpe_newsletter_description', // id
			'Newsletter Description', // title
			array( $this, 'newsletter_description_callback' ), // callback
			'xm-magazine-settings-admin', // page
			'dpe_description_settings_section' // section
		);

		
	}


	public function dpe_description_settings_section_info() {
		print 'Enter your settings below:';
	}

	public function site_description_callback(){
		printf(
			'<textarea class="regular-text" name="dpe_description" id="xm-description">%s</textarea>',
			isset( $this->_dpe_description ) ? esc_attr( $this->_dpe_description ) : ''
		);
	}

	public function newsletter_description_callback(){
		printf(
			'<textarea class="regular-text" name="dpe_newsletter_description" id="dpe_newsletter_description">%s</textarea>',
			isset( $this->dpe_newsletter_description ) ? esc_attr( $this->dpe_newsletter_description ) : ''
		);
	}

}
if ( is_admin() )
	$dpe_description_settings = new XMMagazineDescriptions();