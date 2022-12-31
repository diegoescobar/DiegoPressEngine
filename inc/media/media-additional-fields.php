<?php 
/**
 * https://www.kevinleary.net/add-custom-meta-fields-media-attachments-wordpress/
 */
/**
 * Add custom media metadata fields
 *
 * Be sure to sanitize your data before saving it
 * http://codex.wordpress.org/Data_Validation
 *
 * @param $form_fields An array of fields included in the attachment form
 * @param $post The attachment record in the database
 * @return $form_fields The final array of form fields to use
 */
function add_image_attachment_fields_to_edit( $form_fields, $post ) {
	
	// Remove the "Description" field, we're not using it
	//unset( $form_fields['post_content'] ); 
	
	// Add description text (helps) to the "Title" field
	$form_fields['post_title']['helps'] = 'Use a descriptive title for the image. This will make it easy to find the image in the future and will improve SEO.';
		
	// Re-order the "Caption" field by removing it and re-adding it later
	$form_fields['post_excerpt']['helps'] = 'Describe the significants of the image pertaining to the site.';
	$caption_field = $form_fields['post_excerpt'];
	unset($form_fields['post_excerpt']);
	
	// Re-order the "File URL" field
	//$image_url_field = $form_fields['image_url'];
	//unset($form_fields['image_url']);
	
	// Add Caption before Credit field 
	$form_fields['post_excerpt'] = $caption_field;
	
	// Add a Credit field
	$form_fields["credit_text"] = array(
		"label" => __("Credit"),
		"input" => "text", // this is default if "input" is omitted
		"value" => esc_attr( get_post_meta($post->ID, "_mx_image_credit", true) ),
		"helps" => __("The owner of the image."),
	);
	
	// Add a Credit field
	$form_fields["credit_link"] = array(
		"label" => __("Credit URL"),
		"input" => "text", // this is default if "input" is omitted
		"value" => esc_url( get_post_meta($post->ID, "_mx_image_credit_url", true) ),
		"helps" => __("Attribution link to the image source or owners website."),
	);
	
	// Add Caption before Credit field 
	//$form_fields['image_url'] = $image_url_field;
	
	return $form_fields;
}

add_filter("attachment_fields_to_edit", "add_image_attachment_fields_to_edit", null, 2);


/**
 * Save custom media metadata fields
 *
 * Be sure to validate your data before saving it
 * http://codex.wordpress.org/Data_Validation
 *
 * @param $post The $post data for the attachment
 * @param $attachment The $attachment part of the form $_POST ($_POST[attachments][postID])
 * @return $post
 */
function add_image_attachment_fields_to_save( $post, $attachment ) {
	if ( isset( $attachment['credit_text'] ) && $attachment['credit_text'] != "" ){
		update_post_meta( $post['ID'], '_mx_image_credit', esc_attr($attachment['credit_text']) );
	}

	if ( isset( $attachment['credit_link'] ) && $attachment['credit_link'] != ""){
		update_post_meta( $post['ID'], '_mx_image_credit_url', esc_url($attachment['credit_link']) );
	}

	return $post;
}
add_filter("attachment_fields_to_save", "add_image_attachment_fields_to_save", null , 2);

/**
 * Display image credit
 *
 * Display the "Credit" custom fields added to media attachments 
 *
 * Uses get_children() http://codex.wordpress.org/Function_Reference/get_children
 * Uses get_post_custom() http://codex.wordpress.org/Function_Reference/get_post_custom
 * @global $post The current post data
 * @return Prints the caption HTML
 */
function base_image_credit( $post_ID = null ) {
	// Get the post ID of the current post if not set
	if ( !$post_ID ) {
		global $post;
		$post_ID = $post->ID;
	}
	
	// Get all the attachments for the current post (object stdClass)
	$attachments = get_children('post_type=attachment&post_parent=' . $post->ID);
	
	// If attachments are found
	if ( isset($attachments) && !empty($attachments) ) {
		// Get the first attachment
		$first_attachment = current($attachments);
		$attachment_fields = get_post_custom( $first_attachment->ID );
		
		// Get custom attachment fields
		$credit_text = ( isset($attachment_fields['_mx_image_credit'][0]) && !empty($attachment_fields['_mx_image_credit'][0]) ) ? esc_attr($attachment_fields['_mx_image_credit'][0]) : '';
		$credit_link = ( isset($attachment_fields['_mx_image_credit_url'][0]) && !empty($attachment_fields['_mx_image_credit_url'][0]) ) ? esc_url($attachment_fields['_mx_image_credit_url'][0]) : '';
		
		// Output HTML if you want
		$credit = ( $credit_text && $credit_link ) ? "Image provided by $credit_text" : false;
	}
	
	return $credit;
}

/**
 * Add image credits to captions
 *
 * Add the "Credit" custom fields to media attachments with captions
 *
 * Uses get_post_custom() http://codex.wordpress.org/Function_Reference/get_post_custom
 */
function base_image_credit_to_captions($attr, $content = null) {
	// Allow plugins/themes to override the default caption template.
	$output = apply_filters('img_caption_shortcode', '', $attr, $content);
	
	if ( $output != '' )
		return $output;
		
	extract( shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr) );
	
	if ( 1 > (int) $width || empty($caption) )
		return $content;
	
	if ( $id ) {
		$attachment_id = intval( str_replace( 'attachment_', '', $id ) );
		$id = 'id="' . $id . '" ';
	}
		
	$caption_content = '';
	$caption_content .= do_shortcode( $content );
	$caption_content .= '' . $caption . '';
	
	// Get image credit custom attachment fields
	$attachment_fields = get_post_custom( $attachment_id );
	$credit_text = ( isset($attachment_fields['_mx_image_credit'][0]) && !empty($attachment_fields['_mx_image_credit'][0]) ) ? esc_attr($attachment_fields['_mx_image_credit'][0]) : '';
	$credit_link = ( isset($attachment_fields['_mx_image_credit_url'][0]) && !empty($attachment_fields['_mx_image_credit_url'][0]) ) ? esc_url($attachment_fields['_mx_image_credit_url'][0]) : '';
	
	// If image credit fields have data then attach the image credit
	if ( $credit_text && $credit_link )
		$caption_content .= 'Image provided by ' . $credit_text . '';
	
	$caption_content .= '';
	
	return $caption_content;
}
add_shortcode('wp_caption', 'base_image_credit_to_captions');
add_shortcode('caption', 'base_image_credit_to_captions');