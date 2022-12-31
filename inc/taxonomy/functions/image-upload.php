<?php 

if ( ! class_exists( 'dpe_TAX_META_UPLOAD' ) ) {

class dpe_TAX_META_UPLOAD {

  public function __construct() {
    //
  }

  /*
    * Initialize the class and start calling our hooks and filters
    * @since 1.0.0
  */
  public function init( $taxonomy ){
      add_action( $taxonomy.'_add_form_fields', array ( $this, 'add_category_image' ), 10, 2 );
      add_action( 'created_'.$taxonomy, array ( $this, 'save_category_image' ), 10, 2 );
      add_action( $taxonomy.'_edit_form_fields', array ( $this, 'update_category_image' ), 10, 2 );
      add_action( 'edited_'.$taxonomy, array ( $this, 'updated_category_image' ), 10, 2 );
      add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
      add_action( 'admin_footer', array ( $this, 'add_script' ) );
  }

  public function load_media() {
      wp_enqueue_media(); 
  }

  /*
    * Add a form field in the new category page
    * @since 1.0.0
  */
  public function add_category_image ( $taxonomy ) { ?>
    <div class="form-field term-group">
      <label for="_term-image-id"><?php _e('Image', 'hero-theme'); ?></label>
      <input type="hidden" id="_term-image-id" name="_term-image-id" class="custom_media_url" value="">
      <div id="category-image-wrapper"></div>
      <p>
        <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'hero-theme' ); ?>" />
        <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'hero-theme' ); ?>" />
      </p>
    </div>
  <?php
  }

  /*
    * Save the form field
    * @since 1.0.0
  */
  public function save_category_image ( $term_id, $tt_id ) {
    if( isset( $_POST['_term-image-id'] ) && '' !== $_POST['_term-image-id'] ){
      $image = $_POST['_term-image-id'];
      add_term_meta( $term_id, '_term-image-id', $image, true );
    }
  }

  /*
  * Edit the form field
  * @since 1.0.0
  */
  public function update_category_image ( $term, $taxonomy ) { ?>
    <tr class="form-field term-group-wrap">
      <th scope="row">
        <label for="_term-image-id"><?php _e( 'Image', 'hero-theme' ); ?></label>
      </th>
      <td>
        <?php $image_id = get_term_meta ( $term->term_id, '_term-image-id' ); ?>

        <?php if ( $image_id ) { ?>
          <input type="hidden" id="_term-image-id" name="_term-image-id" value="<?php 
          if (isset($image_id[0])){ echo $image_id[0];  } ?>">
          <div id="category-image-wrapper">
            <?php if ( $image_id ) { ?>
              <?php echo wp_get_attachment_image ( $image_id[0], 'thumbnail' ); ?>
            <?php } ?>
          </div>
        <?php } ?>
        <p>
          <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'hero-theme' ); ?>" />
          <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'hero-theme' ); ?>" />
        </p>
      </td>
    </tr>
  <?php
  }

  /*
  * Update the form field value
  * @since 1.0.0
  */
  public function updated_category_image ( $term_id, $tt_id ) {
    if( isset( $_POST['_term-image-id'] ) && '' !== $_POST['_term-image-id'] ){
      $image = $_POST['_term-image-id'];
      
      if (is_array($image)){
          update_term_meta ( $term_id, '_term-image-id', $image[0] );
      } else {
          update_term_meta ( $term_id, '_term-image-id', $image );
      }
    } else {
      update_term_meta ( $term_id, '_term-image-id', '' );
    }
  }

  /*
  * Add script
  * @since 1.0.0
  */
  public function add_script() { ?>
    <script>
      jQuery(document).ready( function($) {
        function ct_media_upload(button_class) {
          var _custom_media = true,
          _orig_send_attachment = wp.media.editor.send.attachment;
          $('body').on('click', button_class, function(e) {
            var button_id = '#'+$(this).attr('id');
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(button_id);
            _custom_media = true;
            wp.media.editor.send.attachment = function(props, attachment){
              if ( _custom_media ) {
                $('#_term-image-id').val(attachment.id);
                $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                $('#category-image-wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
              } else {
                return _orig_send_attachment.apply( button_id, [props, attachment] );
              }
              }
          wp.media.editor.open(button);
          return false;
        });
      }
      ct_media_upload('.ct_tax_media_button.button'); 
      $('body').on('click','.ct_tax_media_remove',function(){
        $('#_term-image-id').val('');
        $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
      });
      // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-category-ajax-response
      $(document).ajaxComplete(function(event, xhr, settings) {
        var queryStringArr = settings.data.split('&');
        if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
          var xml = xhr.responseXML;
          $response = $(xml).find('term_id').text();
          if($response!=""){
            // Clear the thumb image
            $('#category-image-wrapper').html('');
          }
        }
      });
    });
  </script>
  <?php }

  }
}