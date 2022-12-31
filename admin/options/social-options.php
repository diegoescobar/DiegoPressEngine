<?php

class XMSocialSettings {
	private $_dpe_settings_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, '_dpe_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, '_dpe_settings_page_init' ) );
	}

	public function _dpe_settings_add_plugin_page() {
		add_options_page(
			'Social Settings', // page_title
			'Social Settings', // menu_title
			'manage_options', // capability
			'xm-social-settings', // menu_slug
			array( $this, 'dpe_social_settings_create_admin_page' ) // function
		);
	}

	public function dpe_social_settings_create_admin_page() {
		$this->_dpe_settings_options = get_option( '_dpe_social_links' ); 

		?>

		<div class="wrap">
			<h2>Magazine Settings</h2>

			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'dpe_social_settings_group' );
					// settings_fields( 'dpe_description_group' );
					do_settings_sections( 'xm-social-settings-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function _dpe_settings_page_init() {
		register_setting(
			'dpe_social_settings_group', // option_group
			'_dpe_social_links', // option_name
			array( $this, 'dpe_social_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'_dpe_settings_section', // id
			'Settings', // title
			array( $this, '_dpe_settings_section_info' ), // callback
			'xm-social-settings-admin' // page
		);

		add_settings_field(
			'facebook', // id
			'Facebook', // title
			array( $this, 'facebook_callback' ), // callback
			'xm-social-settings-admin', // page
			'_dpe_settings_section' // section
		);

		add_settings_field(
			'twitter', // id
			'Twitter', // title
			array( $this, 'twitter_callback' ), // callback
			'xm-social-settings-admin', // page
			'_dpe_settings_section' // section
		);

		add_settings_field(
			'youtube', // id
			'Youtube', // title
			array( $this, 'youtube_callback' ), // callback
			'xm-social-settings-admin', // page
			'_dpe_settings_section' // section
		);

		add_settings_field(
			'instagram', // id
			'Instagram', // title
			array( $this, 'instagram_callback' ), // callback
			'xm-social-settings-admin', // page
			'_dpe_settings_section' // section
		);

		add_settings_field(
			'reddit', // id
			'Reddit', // title
			array( $this, 'reddit_callback' ), // callback
			'xm-social-settings-admin', // page
			'_dpe_settings_section' // section
		);

		add_settings_field(
			'flipboard', // id
			'Flipboard', // title
			array( $this, 'flipboard_callback' ), // callback
			'xm-social-settings-admin', // page
			'_dpe_settings_section' // section
		);
	}

	public function dpe_social_settings_sanitize($input) {

		if ( $input['_dpe_social_links']){
			$input['_dpe_social_links'] = $input['_dpe_social_links'];
		}

		if ( isset( $input['facebook'] ) ) {
			$input['facebook'] = sanitize_text_field( $input['facebook'] );
		}

		if ( isset( $input['twitter'] ) ) {
			$input['twitter'] = sanitize_text_field( $input['twitter'] );
		}

		if ( isset( $input['youtube'] ) ) {
			$input['youtube'] = sanitize_text_field( $input['youtube'] );
		}

		if ( isset( $input['instagram'] ) ) {
			$input['instagram'] = sanitize_text_field( $input['instagram'] );
		}

		if ( isset( $input['reddit'] ) ) {
			$input['reddit'] = sanitize_text_field( $input['reddit'] );
		}

		if ( isset( $input['flipboard'] ) ) {
			$input['flipboard'] = sanitize_text_field( $input['flipboard'] );
		}

		return $input;
	}


	public function _dpe_settings_section_info() {
		print 'Enter your settings below:';
	}

	public function facebook_callback() {
		printf(
			'<input class="regular-text" type="text" name="_dpe_social_links[facebook]" id="facebook" value="%s">',
			isset( $this->_dpe_settings_options['facebook'] ) ? esc_attr( $this->_dpe_settings_options['facebook']) : ''
		);
	}

	public function twitter_callback() {
		printf(
			'<input class="regular-text" type="text" name="_dpe_social_links[twitter]" id="twitter" value="%s">',
			isset( $this->_dpe_settings_options['twitter'] ) ? esc_attr( $this->_dpe_settings_options['twitter']) : ''
		);
	}

	public function youtube_callback() {
		printf(
			'<input class="regular-text" type="text" name="_dpe_social_links[youtube]" id="youtube" value="%s">',
			isset( $this->_dpe_settings_options['youtube'] ) ? esc_attr( $this->_dpe_settings_options['youtube']) : ''
		);
	}

	public function instagram_callback() {
		printf(
			'<input class="regular-text" type="text" name="_dpe_social_links[instagram]" id="instagram" value="%s">',
			isset( $this->_dpe_settings_options['instagram'] ) ? esc_attr( $this->_dpe_settings_options['instagram']) : ''
		);
	}

	public function reddit_callback() {
		printf(
			'<input class="regular-text" type="text" name="_dpe_social_links[reddit]" id="reddit" value="%s">',
			isset( $this->_dpe_settings_options['reddit'] ) ? esc_attr( $this->_dpe_settings_options['reddit']) : ''
		);
	}

	public function flipboard_callback() {
		printf(
			'<input class="regular-text" type="text" name="_dpe_social_links[flipboard]" id="flipboard" value="%s">',
			isset( $this->_dpe_settings_options['flipboard'] ) ? esc_attr( $this->_dpe_settings_options['flipboard']) : ''
		);
	}
}

if ( is_admin() )
	$_dpe_settings = new XMSocialSettings();