<?php
    
    
    // add_image_size( string $name, int $width, int $height, bool|array $crop = false );

    
    // add_filter( 'intermediate_image_sizes_advanced', 'prefix_remove_default_images' );
    // Remove default image sizes here. 
    
    function prefix_remove_default_images( $sizes ) {
        unset( $sizes['small']); // 150px
        unset( $sizes['medium']); // 300px
        unset( $sizes['large']); // 1024px
        unset( $sizes['medium_large']); // 768px
        return $sizes;
    }
/*
    // 1:1 Ratio
    // add_image_size ('banner_menu', 65, 65, TRUE);
    add_image_size ('banner_menu', 130, 130, TRUE); //Retina

    //16:9 Ration
    // add_image_size ('thumb-large', 720, 405, TRUE);
    add_image_size ('thumb-large', 1440, 810, TRUE); //Retina

    // add_image_size ('thumb-big', 610, 343, TRUE);
    add_image_size ('thumb-big', 1220, 686, TRUE); //Retina

    // add_image_size ('thumb-med', 390, 219, TRUE);
    add_image_size ('thumb-med', 780, 438, TRUE); //Retina

    // add_image_size ('thumb-small', 345, 194, TRUE);
    add_image_size ('thumb-small', 690, 388, TRUE); //Retina

    // add_image_size ('thumb-mobile', 280, 158, TRUE);
    add_image_size ('thumb-mobile', 560, 316, TRUE); //Retina
    
    
    //3:4 Ratio
    // add_image_size ('video_thumb_m', 285, 380, TRUE);
    add_image_size ('video_thumb_m', 570, 760,  TRUE); //Retina
   
    // add_image_size ('video_thumb', 164, 219, TRUE);
    add_image_size ('video_thumb', 328, 438, TRUE); //Retina
        

    // Banners & Featured
    // add_image_size ('banner', 1440, 400, TRUE);
    add_image_size ('banner', 2880, 800, TRUE); //Retina

    // add_image_size ('featured', 1270, '', FALSE);
    add_image_size ('featured', 2540, '', FALSE); //Retina

*/
    ?>