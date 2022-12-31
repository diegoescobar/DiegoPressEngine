<?php

if ( ! class_exists( 'dpe_RICHTEXT_DESCRIPTION' ) ) {
    class dpe_RICHTEXT_DESCRIPTION {

        public function __construct() {
            $fields = 'Description';
            $this->fields = $fields;

            $this->hide_description = true;
            // $this->taxonomy = $taxonomy;
        }

        public function init( $taxonomy ){

            $this->taxonomy = $taxonomy;

            add_action( $taxonomy."_edit_form_fields", array($this, 'edit_richtext_description'), 10, 2);
            add_action( $taxonomy."_add_form_fields", array($this,'add_richtext_description'), 10, 1);
            add_action( 'edited_'.$taxonomy, array( $this , 'save_description_custom'), 10, 2 );  
            // add_action( 'create_'.$taxonomy, array( $this , 'save_description_custom'), 10, 2 );  
            add_action( 'create_'.$taxonomy, array( $this , 'save_add_description'), 10, 2 );
        }

        public function field_names( $fields ){
            $this->fields = $fields;
            return $fields;
        }

        public function taxonomy( $taxonomy ){
            $this->taxonomy = $taxonomy;
            return $taxonomy;
        }

        public function hide_description( $hide = true ){
            if ($hide){
                $this->hide_description = true;
            }

            return $hide;
        }

        public function edit_richtext_description($term, $taxonomy){
            ?>
            <tr valign="top">
                <th scope="row"><?php echo ucfirst($this->fields); ?></th>
                <td>
                    <?php wp_editor(html_entity_decode($term->description), $this->fields, array('media_buttons' => false)); ?>
                    <?php if ($this->hide_description ){?>
                    <script>
                        jQuery(window).ready(function(){
                            jQuery('label[for=description]').parent().parent().remove();
                        });
                    </script>
                    <?php } ?>
                </td>
            </tr>
            <?php
        }

        public function add_richtext_description( $taxonomy ){ ?>
            <div class="form-field term-description-wrap">
                <label for="<?php echo $this->fields;?>"><?php echo ucfirst($this->fields);?></label>
                <?php wp_editor("", 'tag-'.$this->fields, array('media_buttons' => false, 'tinymce' => false)); ?>
            </div>

            <?php if ($this->hide_description ){?>
            <script>
                jQuery(window).ready(function(){
                    jQuery('label[for=tag-description]').parent().hide();
                });
            </script>
            <?php } ?>
            </td>
            <?php
        }

        // Save extra taxonomy fields callback function.
        public function save_description_custom( $term_id, $taxonomy ) {
            // remove_action('edited_'. $this->taxonomy, 'save_description_custom', 10 );
            // $term_data = get_term_by( 'id',  $term_id,);

            // pre_dump( $this->taxonomy );
            // echo $this->taxonomy;
            // pre_dump($term_id );
            // pre_dump( $term_data );

            // $tax_data = get_term_by( 'term_taxonomy_id', $taxonomy);
            if ( isset( $_REQUEST[ $this->fields ] ) ) {
                $data = htmlentities($_REQUEST[ $this->fields ], ENT_QUOTES, 'UTF-8');
                $term_return =  wp_update_term( $term_id, $this->taxonomy, array("description" => $data) );

                // pre_dump ( $term_return );

                // pre_dump( $data );

                die();
            }

            exit;
            // }else{
            //     echo "errors";
            //     exit;
            // }
            
            // // add_action( 'edited_'.$this->taxonomy, array( $this , 'save_description_custom'), 10, 2 );  
        
        } 


        // Save extra taxonomy fields callback function.
        public function save_add_description( $term_id, $taxonomy ) {

            if ( isset( $_REQUEST[ "tag-".$this->fields ] ) ) {
                $data = htmlentities($_REQUEST[ "tag-".$this->fields ], ENT_QUOTES, 'UTF-8');

                // if(!add_term_meta( $term_id, "biography", $data , true)){
                    // update_term_meta($term_id, "biography2", $data);
                // };

                $term_return =   wp_update_term( $term_id, $this->taxonomy, array( 'description' =>  $data) );
                return true;

            }else {
                return false;
            }
        }
    }
}
