<?php

//Article UTM Link
add_action( 'load-post.php', 'editors_pick_meta_boxes_setup' );
add_action( 'load-post-new.php', 'editors_pick_meta_boxes_setup' );

function editors_pick_meta_boxes_setup() {
    add_action( 'add_meta_boxes', 'editors_pick_add_post_meta_boxes' );
    add_action( 'save_post', 'editors_pick_save_post_class_meta', 10, 2 );
}

function editors_pick_add_post_meta_boxes() {
    add_meta_box(
        'editors_pick_class',
        'Editor\'s Pick',
        'editors_pick_class_meta_box',
        'post',
        'side',
        'default'
    );
}

function editors_pick_class_meta_box( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'editors_pick_class_nonce' );
    $editor_pick = get_post_meta( $post->ID, "editors_pick", true);
    ?>
    <div class="components-base-control">
        <div class="components-base-control__field">
            <div>
                <label>
                <input type="checkbox" name="editors_pick_class" value="true" data-field="checkbox" id="editors_pick" <?php echo (!empty($editor_pick)) ? "checked " : ""; ?>class="field-editors_pick">This is an Editor’s Pick:</label><br/>
            </div>
        </div>
    </div>
<?php }

function editors_pick_save_post_class_meta( $post_id, $post ) {
    if ( !isset( $_POST['editors_pick_class_nonce'] ) || !wp_verify_nonce( $_POST['editors_pick_class_nonce'], basename( __FILE__ ) ) )
        return $post_id;

    $post_type = get_post_type_object( $post->post_type );
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

    $new_meta_value = ( isset( $_POST['editors_pick_class'] ) ? $_POST['editors_pick_class'] : '' );
    $meta_key = 'editors_pick';
    $meta_value = get_post_meta( $post_id, $meta_key, true );

    if ( $new_meta_value && '' == $meta_value )
        add_post_meta( $post_id, $meta_key, $new_meta_value, true );
    elseif ( $new_meta_value && $new_meta_value != $meta_value )
        update_post_meta( $post_id, $meta_key, $new_meta_value );
    elseif ( '' == $new_meta_value && $meta_value )
        delete_post_meta( $post_id, $meta_key, $meta_value );
}