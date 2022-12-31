<?php
/**
 * Class: Image_Block_Credit_Parser
 *
 * @package Image_Block_Credit_Parser
 * @subpackage Image_Block_Credit_Parser
 * @since 1.0.0
 * @source https://zao.is/blog/2019/05/30/an-introduction-to-gutenbergs-block-parser-class/
 */
add_filter(
	'block_parser_class',
	function() {
		return __NAMESPACE__ . '\\Image_Block_Credit_Parser';
	}
);
/***
 * Specialized block serialization parser
 */
class Image_Block_Credit_Parser extends \WP_Block_Parser {
	/**
	 * Blocks that could be last
	 *
	 * @var array
	 */
	public static $allowed_inner_blocks = [
		// Classic blocks have their blockName set to null.
		null,
		'core/image'
	];
	/**
	 * Parse document to get a list of block structures
	 *
	 * @param string $document  Input document being parsed.
	 */
	public function parse( $document ) {
		$this->document    = $document;
		$this->offset      = 0;
		$this->output      = array();
		$this->stack       = array();
		$this->empty_attrs = json_decode( '{}', true );
		// phpcs:disable Generic.CodeAnalysis.EmptyStatement
		do {
			// twiddle our thumbs.
		} while ( $this->proceed() );
		// phpcs:enable
		return $this->process_output();
	}
	/**
	 * Put Article tags at the end
	 */
	public function process_output() {
		if ( ! is_array( $this->output ) ) {
			return $this->output;
		}
		foreach ( $this->output as $index => $block ) {
			if ( ! isset( $block['blockName'] ) ) {
				continue;
			}
			if ( in_array( $block['blockName'], self::$allowed_inner_blocks, true ) ) {

			// pre_dump($this->output[ $index ]['attrs']);

				if (!empty($this->output[ $index ]['attrs'] && isset($this->output[ $index ]['attrs']['id']))) {

					$post_attr = get_post_meta($this->output[ $index ]['attrs']['id'] );

					if ( isset($post_attr["_mx_image_credit"]) && isset($post_attr["_mx_image_credit_url"]) ) {
						$credit_link = '<a href="'.$post_attr["_mx_image_credit_url"][0].'">'.$post_attr["_mx_image_credit"][0].'</a>';
					} else if ( isset($post_attr["_mx_image_credit"]) && !isset($post_attr["_mx_image_credit_url"])) {
						$credit_link = $post_attr["_mx_image_credit"][0];
					} elseif (!isset($post_attr["_mx_image_credit"]) && isset($post_attr["_mx_image_credit_url"])){
						$credit_link = '<a href="'.$post_attr["_mx_image_credit_url"][0].'">'.$post_attr["_mx_image_credit_url"][0].'</a>';
					}

					if (isset($credit_link)){
						$string = preg_replace('/<figcaption>(.*?)<\/figcaption>/', '<figcaption><p><span class="caption">$1</span> <span class="credit">Credit: '.$credit_link.'</span></p></figcaption>',  $this->output[ $index ]['innerHTML']);
					
						if( !preg_match('/<figcaption>(.*?)<\/figcaption>/', $this->output[ $index ]['innerHTML']) && isset($credit_link)){
							// pre_dump( $this->output[ $index ]['innerHTML'] );
							$string = preg_replace('/<figure(.*?)>(.*?)<\/figure>/', '<figure>$2 <figcaption><p><span class="credit">Credit: '.$credit_link.'</span></p></figcaption></figure>',  $this->output[ $index ]['innerHTML']);
						}

						if (!$string){
							$string = $credit_link;
						}
						
						$this->output[ $index ]['innerHTML'] = $string;
						$this->output[ $index ]['innerContent'][0] = $string;
					}
				}
            }
    

		}
		return $this->output;
	}
}