<?php

add_action( 'admin_init', '_dpe_settings_page_init' );


function _dpe_settings_add_plugin_page() {
    add_options_page(
        'Social Settings', // page_title
        'Social Settings', // menu_title
        'manage_options', // capability
        'xm-social-settings', // menu_slug
        'dpe_social_settings_create_admin_page' // function
    );
}

function dpe_social_settings_create_admin_page() {
    $dpe_settings_options = get_option( '_dpe_social_links' ); 

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

function _dpe_settings_page_init() {
    register_setting(
        'dpe_social_settings_group', // option_group
        '_dpe_social_links', // option_name
        'dpe_social_settings_sanitize'  // sanitize_callback
    );

    add_settings_section(
        '_dpe_settings_section', // id
        'Settings', // title
        '_dpe_settings_section_info' , // callback
        'xm-social-settings-admin' // page
    );

    add_settings_field(
        'facebook', // id
        'Facebook', // title
        'facebook_callback' , // callback
        'xm-social-settings-admin', // page
        '_dpe_settings_section' // section
    );

    add_settings_field(
        'twitter', // id
        'Twitter', // title
        'twitter_callback' , // callback
        'xm-social-settings-admin', // page
        '_dpe_settings_section' // section
    );

    add_settings_field(
        'youtube', // id
        'Youtube', // title
        'youtube_callback' , // callback
        'xm-social-settings-admin', // page
        '_dpe_settings_section' // section
    );

    add_settings_field(
        'instagram', // id
        'Instagram', // title
        'instagram_callback' , // callback
        'xm-social-settings-admin', // page
        '_dpe_settings_section' // section
    );

    add_settings_field(
        'reddit', // id
        'Reddit', // title
        'reddit_callback' , // callback
        'xm-social-settings-admin', // page
        '_dpe_settings_section' // section
    );

    add_settings_field(
        'flipboard', // id
        'Flipboard', // title
        'flipboard_callback' , // callback
        'xm-social-settings-admin', // page
        '_dpe_settings_section' // section
    );
}

function dpe_social_settings_sanitize($input) {

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


function _dpe_settings_section_info() {
    print 'Enter your settings below:';
}

function facebook_callback() {
    $dpe_settings_options = get_option( '_dpe_social_links' ); 
    printf(
        '<input class="regular-text" type="text" name="_dpe_social_links[facebook]" id="facebook" value="%s">',
        isset( $dpe_settings_options['facebook'] ) ? esc_attr( $dpe_settings_options['facebook']) : ''
    );
}

function twitter_callback() {
    $dpe_settings_options = get_option( '_dpe_social_links' ); 
    printf(
        '<input class="regular-text" type="text" name="_dpe_social_links[twitter]" id="twitter" value="%s">',
        isset( $dpe_settings_options['twitter'] ) ? esc_attr( $dpe_settings_options['twitter']) : ''
    );
}

function youtube_callback() {
    $dpe_settings_options = get_option( '_dpe_social_links' ); 
    printf(
        '<input class="regular-text" type="text" name="_dpe_social_links[youtube]" id="youtube" value="%s">',
        isset( $dpe_settings_options['youtube'] ) ? esc_attr( $dpe_settings_options['youtube']) : ''
    );
}

function instagram_callback() {
    $dpe_settings_options = get_option( '_dpe_social_links' ); 
    printf(
        '<input class="regular-text" type="text" name="_dpe_social_links[instagram]" id="instagram" value="%s">',
        isset( $dpe_settings_options['instagram'] ) ? esc_attr( $dpe_settings_options['instagram']) : ''
    );
}

function reddit_callback() {
    $dpe_settings_options = get_option( '_dpe_social_links' ); 
    printf(
        '<input class="regular-text" type="text" name="_dpe_social_links[reddit]" id="reddit" value="%s">',
        isset( $dpe_settings_options['reddit'] ) ? esc_attr( $dpe_settings_options['reddit']) : ''
    );
}

function flipboard_callback() {
    $dpe_settings_options = get_option( '_dpe_social_links' ); 
    printf(
        '<input class="regular-text" type="text" name="_dpe_social_links[flipboard]" id="flipboard" value="%s">',
        isset( $dpe_settings_options['flipboard'] ) ? esc_attr( $dpe_settings_options['flipboard']) : ''
    );
}
