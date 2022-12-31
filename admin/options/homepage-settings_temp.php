<?php
add_action( 'admin_menu', 'dpe_homepage__add_admin_menu' );
add_action( 'admin_init', 'dpe__homepage_init' );



function dpe_homepage__add_admin_menu(  ) { 

	add_options_page( 'Homepage Settings', 'Homepage Settings', 'manage_options', 'dpe_homepage_settings', 'dpe_homepage_options_page' );

}


function dpe__homepage_init(  ) { 

	register_setting( 'dpe_homepage_settings', 'dpe__homepage' );

    add_settings_section(
		'dpe__hero_section', 
		__( 'Homepage Hero Settings', 'dpe_' ), 
		'dpe_hero_settings_section_callback', 
		'dpe_homepage_settings'
	);

	add_settings_section(
		'dpe__video_section', 
		__( 'Featured Video Settings', 'dpe_' ), 
		'dpe_video_settings_section_callback', 
		'dpe_homepage_settings'
	);



	add_settings_field( 
		'hero_field_1', 
		__( 'Hero Post 1', 'dpe_' ), 
		'hero_field_1_render', 
		'dpe_homepage_settings', 
		'dpe__hero_section' 
	);


	add_settings_field( 
		'hero_field_2', 
		__( 'Hero Post 2', 'dpe_' ), 
		'hero_field_2_render', 
		'dpe_homepage_settings', 
		'dpe__hero_section' 
	);

	add_settings_field( 
		'hero_field_3', 
		__( 'Hero Post 3', 'dpe_' ), 
		'hero_field_3_render', 
		'dpe_homepage_settings', 
		'dpe__hero_section' 
	);

	add_settings_field( 
		'video_field', 
		__( 'Video Block', 'dpe_' ), 
		'video_field_render', 
		'dpe_homepage_settings', 
		'dpe__video_section' 
	);

}


function hero_field_1_render(  ) { 
	$value = "";
	$options = get_option( 'dpe__homepage' );
	if (isset($options ) && !empty($options )){
		echo "<strong>".get_the_title(  $options['hero_field_1']  ) . "</strong>".'<br/>';  	
		$value = $options['hero_field_1'];
	} else {
		$value = "";
	} 
	
	?>
	
    <input type="text" id="field_1" class="form-control search-autocomplete" data-link="field_1_hidden" placeholder="Search Posts...">
    <input type="text" value="<?php echo $value; ?>" data-link="field_1_hidden" class="hidden" name="dpe__homepage[hero_field_1]" id="field_1_hidden">
	<?php

}


function hero_field_2_render(  ) { 
	$value = "";
	$options = get_option( 'dpe__homepage' );
	if (isset($options ) && !empty($options )){
		echo "<strong>".get_the_title(  $options['hero_field_2']  ) . "</strong>".'<br/>';  	
		$value = $options['hero_field_2'];
	} else {
		$value = "";
	} 
	
	?>
	
    <input type="text" id="field_2" class="form-control search-autocomplete" data-link="field_2_hidden" placeholder="Search Posts...">
    <input type="text" value="<?php echo $value; ?>" data-link="field_2_hidden" class="hidden" name="dpe__homepage[hero_field_2]" id="field_2_hidden">
	<?php

}


function hero_field_3_render(  ) { 
	$value = "";
	$options = get_option( 'dpe__homepage' );
	if (isset($options ) && !empty($options )){
		echo "<strong>".get_the_title(  $options['hero_field_3']  ) . "</strong>".'<br/>';  	
		$value = $options['hero_field_3'];
	} else {
		$value = "";
	} 
	
	?>
	
    <input type="text" id="field_3" class="form-control search-autocomplete" data-link="field_3_hidden" placeholder="Search Posts...">
    <input type="text" value="<?php echo $value; ?>" data-link="field_3_hidden" class="hidden" name="dpe__homepage[hero_field_3]" id="field_3_hidden">
	<?php

}



function video_field_render(  ) { 
	$value = "";

	$options = get_option( 'dpe__homepage' );
	if (isset($options ) && !empty($options )){
		echo "<strong>".get_the_title(  $options['video_field']  ) . "</strong>".'<br/>'; 
		$value = $options['video_field'];
	} else {
		$value = "";
	}  ?>

    <input type="text" id="video_field" class="form-control search-autocomplete" data-link="video_field_hidden" placeholder="Search Posts...">
    <input type="text" value="<?php echo $value; ?>" data-link="video_field_hidden" class="hidden" name="dpe__homepage[video_field]" id="video_field_hidden">
	<?php
}


/*
function dpe__select_field_7_render(  ) { 

    $options = get_option( 'dpe__homepage' );
    $select_options = "";

    $the_query = new WP_Query( 'posts_per_page=30&ignore_sticky_posts=1&editorial_format=video' );
    if ( $the_query->have_posts() ) {
  
        while ( $the_query->have_posts() ) {
            $the_query->the_post();

            $select_options .=  "<option value='" . get_the_ID() . "'". selected( $options['dpe__select_field_7'], 1 ) .">" . get_the_title() . "</option>";
        }
    }
    echo get_the_title(  $options['dpe__select_field_7'] ) . '<br/>';
	?>
	<select name='dpe__homepage[dpe__select_field_7]'>
        <?php echo $select_options; ?>
	</select>

<?php

}
*/


function dpe_hero_settings_section_callback(  ) { 

	echo __( 'This section description', 'dpe_' );

}



function dpe_video_settings_section_callback(  ) { 

	echo __( 'This section description', 'dpe_' );

}



function dpe_homepage_options_page(  ) { 

    ?>
    <style>
        .autocomplete-suggestions { width: 625px !important; }
        .autocomplete-suggestion { max-width: 625px !important;}
    </style>

    <form action='options.php' method='post'>

        <h2>Homepage Settings</h2>

        <hr/>

        <?php

        settings_fields( 'dpe_homepage_settings' );

        do_settings_sections( 'dpe_homepage_settings' );

        submit_button();

        ?>

    </form>
    <?php

}
