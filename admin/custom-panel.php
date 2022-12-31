<?php

//Article UTM Link
add_action( 'load-post.php', 'utm_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'utm_post_meta_boxes_setup' );

function utm_post_meta_boxes_setup() {
    add_action( 'add_meta_boxes', 'utm_add_post_meta_boxes' );
    add_action( 'save_post', 'utm_save_post_class_meta', 10, 2 );
}

function utm_add_post_meta_boxes() {
    add_meta_box(
        'utm-post-class',
        'Ad Exclusion',
        'utm_post_class_meta_box',
        'post',
        'side',
        'default'
    );
}

function utm_post_class_meta_box( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'utm_post_class_nonce' );?>

    <div class="components-base-control editor-post-excerpt__textarea">
        <div class="components-base-control__field">
        
            <div scope="row">
                <label for="cpt_article_ads_exclusion-id">Exclude from this page ad campaigns that are only targeted to:</label>
            </div>
            <div>
                <label>
                <input type="radio" name="cpt_article_ads_exclusion" value="Men" data-field="radio" id="cpt_article_ads_exclusion-id" class="field-cpt_article_ads_exclusion">Men</label><br/>
                <label><input type="radio" name="cpt_article_ads_exclusion" value="Women" data-field="radio" id="cpt_article_ads_exclusion-id" class="field-cpt_article_ads_exclusion">Women</label><br/>
                <label><input type="radio" name="cpt_article_ads_exclusion" value="not-show" data-field="radio" id="cpt_article_ads_exclusion-id" class="field-cpt_article_ads_exclusion" checked="">Do not exclude any ads from this page</label><br/>
            </div>
        </div>
    </div>
<?php }

function utm_save_post_class_meta( $post_id, $post ) {
    if ( !isset( $_POST['utm_post_class_nonce'] ) || !wp_verify_nonce( $_POST['utm_post_class_nonce'], basename( __FILE__ ) ) )
        return $post_id;

    $post_type = get_post_type_object( $post->post_type );
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

    $new_meta_value = ( isset( $_POST['utm-post-class'] ) ? $_POST['utm-post-class'] : '' );
    $meta_key = 'utm_post_class';
    $meta_value = get_post_meta( $post_id, $meta_key, true );

    if ( $new_meta_value && '' == $meta_value )
        add_post_meta( $post_id, $meta_key, $new_meta_value, true );
    elseif ( $new_meta_value && $new_meta_value != $meta_value )
        update_post_meta( $post_id, $meta_key, $new_meta_value );
    elseif ( '' == $new_meta_value && $meta_value )
        delete_post_meta( $post_id, $meta_key, $meta_value );
}