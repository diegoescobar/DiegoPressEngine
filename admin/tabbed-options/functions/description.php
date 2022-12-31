<?php

add_action( 'admin_init', 'dpe_description_settings_page_init' );


function dpe_description_settings_create_admin_page() {
    $dpe_description = get_option( 'dpe_description' ); 
    $dpe_newsletter_description = get_option( 'dpe_newsletter_description' ); 
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

function dpe_description_settings_page_init() {
    register_setting(
        'dpe_description_group', // option_group
        'dpe_description', // option_name
        'dpe_description_settings_sanitize'  // sanitize_callback
    );

    register_setting(
        'dpe_description_group', // option_group
        'dpe_newsletter_description', // option_name
        'dpe_description_settings_sanitize'  // sanitize_callback
    );

    add_settings_section(
        'dpe_description_settings_section', // id
        'Site Description', // title
        'dpe_description_settings_section_info' , // callback
        'xm-magazine-settings-admin' // page
    );

    add_settings_field(
        'dpe_description', // id
        'Site Description', // title
        'site_description_callback' , // callback
        'xm-magazine-settings-admin', // page
        'dpe_description_settings_section' // section
    );

    add_settings_field(
        'dpe_newsletter_description', // id
        'Newsletter Description', // title
        'newsletter_description_callback' , // callback
        'xm-magazine-settings-admin', // page
        'dpe_description_settings_section' // section
    );
    
}


function dpe_description_settings_section_info() {
    print 'Enter your settings below:';
}

function site_description_callback(){
    $dpe_description = get_option( 'dpe_description' ); 

    printf(
        '<textarea class="regular-text" name="dpe_description" id="xm-description">%s</textarea>',
        isset( $dpe_description ) ? esc_attr( $dpe_description ) : ''
    );
}

function newsletter_description_callback(){
    $dpe_newsletter_description = get_option( 'dpe_newsletter_description' ); 
    
    printf(
        '<textarea class="regular-text" name="dpe_newsletter_description" id="dpe_newsletter_description">%s</textarea>',
        isset( $dpe_newsletter_description ) ? esc_attr( $dpe_newsletter_description ) : ''
    );
}
