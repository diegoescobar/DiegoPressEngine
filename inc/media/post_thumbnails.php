<?php 

if ( ! function_exists( 'dpe__post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function dpe__post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			?> <a class="post-no-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1"><?php echo the_title_attribute( array('echo' => false )); ?> </a>
			<?php
			return;
		}

		$thumbURL = get_the_post_thumbnail_url( get_the_id(), 'thumb-large' );
		$is_image = false;
		$file = "";

		if ($thumbURL){
			$path = parse_url( $thumbURL, PHP_URL_PATH);
			$file_path = $_SERVER['DOCUMENT_ROOT'] . $path;
			$file = file_exists ( $file_path );
			$image_heads = @get_headers( $thumbURL ); 
			$is_image = ($image_heads[0] !== "HTTP/1.0 404 Not Found" ) ? true : false;	
		
			if ( $file && $is_image) :
				if ( is_singular() ) :
					?>

					<div class="post-thumbnail">
						<?php  the_post_thumbnail(  get_the_id(), 'thumb-large' ); ?>
					</div>

				<?php else : ?>

				<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php
					the_post_thumbnail( 'thumb-large', array(
						'alt' => the_title_attribute( array(
							'echo' => false,
						) ),
					) );
					?>
				</a>

				<?php
				endif; // End is_singular().
			
			else :
				?>
				<?php //pre_dump($is_image); ?>
				<a class="post-no-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1"><?php echo the_title_attribute( array('echo' => false )); ?> </a>
				<?php

			endif; // End is_singular().
		}
	}

	function dpe__get_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {

			return '<a class="post-no-thumbnail" href="' . get_the_permalink() . '" aria-hidden="true" tabindex="-1">' . the_title_attribute( array('echo' => false )) . '</a>';
			
		}

		$thumbURL = get_the_post_thumbnail_url( get_the_id(), 'thumb-large' );
		$is_image = false;
		$file = "";

		if ($thumbURL){
			$path = parse_url( $thumbURL, PHP_URL_PATH);
			$file_path = $_SERVER['DOCUMENT_ROOT'] . $path;
			$file = file_exists ( $file_path );
			$image_heads = @get_headers( $thumbURL ); 
			$is_image = ($image_heads[0] !== "HTTP/1.0 404 Not Found" ) ? true : false;	
		
			if ( $file && $is_image) :
				if ( is_singular() ) :

					return '<div class="post-thumbnail">'.
						get_the_post_thumbnail(  get_the_id(), 'thumb-large' ) .
					'</div>';

				else : 

				return '<a class="post-thumbnail" href="'. get_the_permalink().'" aria-hidden="true" tabindex="-1">
					' . get_the_post_thumbnail( 'thumb-large', array(
						'alt' => the_title_attribute( array(
							'echo' => false,
						) ),
					) ) . '</a>';

				endif; // End is_singular().
			
			else :
				
				//pre_dump($is_image);
				
				return '<a class="post-no-thumbnail" href="'.  get_the_permalink() . '" aria-hidden="true" tabindex="-1">'.the_title_attribute( array('echo' => false )) . '</a>';
				

			endif; // End is_singular().
		}
	}
endif;



function the_post_thumbnail_credit() {
    global $post;
   
    $thumbnail_id    = get_post_thumbnail_id($post->ID);
    $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));
   
    if ($thumbnail_image && isset($thumbnail_image[0])) {

        $thumbnail_credit = get_post_meta( $thumbnail_id, "_mx_image_credit" );

        echo '<span class="credit>'.  $thumbnail_credit[0] .'</span>';
    }
}

/**
 * Register support for Gutenberg wide images in your theme
 * https://www.billerickson.net/full-and-wide-alignment-in-gutenberg/
 */


function post_attachment_credit( $attachment_id ){
  global $post;

  $attachment_meta = get_metadata('post', $attachment_id );
  $attachment_credit = "";

	if ( isset($attachment_meta['_mx_image_credit_url']) || (isset($attachment_meta['_mx_image_credit']) && !empty($attachment_meta['_mx_image_credit'][0])) ) {
    $attachment_credit .= __("Credit: ");
  }

  if (isset($attachment_meta['_mx_image_credit_url']) && isset($attachment_meta['_mx_image_credit'])){
    $attachment_credit .= '<a href="'.$attachment_meta['_mx_image_credit_url'][0] .'">' .
            $attachment_meta['_mx_image_credit'][0] .
          '</a>';
  }elseif (isset($attachment_meta['_mx_image_credit_url']) && !isset($attachment_meta['_mx_image_credit'])){
    $attachment_credit .= '<a href="'.$attachment_meta['_mx_image_credit_url'][0] .'">' .
            $attachment_meta['_mx_image_credit_url'][0] .
          '</a>';
  }elseif(!isset($attachment_meta['_mx_image_credit_url']) && isset($attachment_meta['_mx_image_credit'])){
    $attachment_credit .= $attachment_meta['_mx_image_credit'][0];
  }

  return $attachment_credit;
  
}