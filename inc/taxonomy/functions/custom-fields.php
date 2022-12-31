<?php


if ( ! class_exists( 'dpe_TAX_FIELDS_META' ) ) {
    class dpe_TAX_FIELDS_META {
        
        public function __construct() {
            $fields = array();

            $this->fields = $fields;
        }

        public function fields( $fields ){
            $this->fields = $fields;
            return $fields;
        }

        public function init($taxonomy){
            add_action( $taxonomy.'_add_form_fields', array( $this , 'dpe__add_new_meta_field') );
            add_action( $taxonomy.'_edit_form_fields', array( $this , 'dpe__edit_meta_field'));
            add_action( 'edited_'.$taxonomy, array( $this , 'save_contributor_custom_meta'), 10, 2 );  
            add_action( 'create_'.$taxonomy, array( $this , 'save_contributor_custom_meta'), 10, 2 );
        }

        // Add term page
        public function dpe__add_new_meta_field() {
            // this will add the custom meta field to the add new term page
            // global $field_array;

            foreach ($this->fields AS $field){
                ?>
                <div class="form-field">
                    <label for="term_meta[<?php echo $field; ?>]"><?php _e( $field, 'xtramag' ); ?></label>
                    <input type="text" name="term_meta[<?php echo $field; ?>]" id="term_meta[<?php echo $field; ?>]" value="">
                    <p class="description"><?php _e( 'Enter a value for this field','xtramag' ); ?></p>
                </div>
            <?php
            }
        }

        public function dpe__edit_meta_field($term) {
                // retrieve the existing value(s) for this meta field. This returns an array
                $term_meta = get_term_meta( $term->term_id ); 
                if (isset( $term_meta["term_meta"] )){
                    $values = unserialize( $term_meta["term_meta"][0] );
                } else {
                    foreach ($this->fields AS $key => $field){
                        $values[$field] = "";
                    }
                }

                foreach ($this->fields AS $key => $field){

                    $value="";
                    if (isset($values[$field])){
                        $value = esc_attr( $values[$field]); 
                    }
                    

                ?>
                <tr class="form-field">
                <th scope="row" valign="top"><label for="term_meta[<?php echo $field; ?>]"><?php _e( $field, 'xtramag' ); ?></label></th>
                    <td>
                        <input type="text" name="term_meta[<?php echo $field; ?>]" id="term_meta[<?php echo $field; ?>]" value="<?php echo $value; ?>">
                        <p class="description"><?php _e( 'Enter a value for this field','xtramag' ); ?></p>
                    </td>
                </tr>
            <?php

            }
        }



        // Save extra taxonomy fields callback function.
        public function save_contributor_custom_meta( $term_id, $taxonomy ) {
            if ( isset( $_POST['term_meta'] ) ) {

                $data = $_POST['term_meta'];

                if(!add_term_meta( $term_id, "term_meta", $data , true)){
                    update_term_meta($term_id, "term_meta", $data);
                };
            }

            $term_data = get_term_by( 'ID',  $term_id);

            if ( isset( $_REQUEST['biography'] ) ) {
                $data = $_REQUEST['biography'];

                if(!add_term_meta( $term_id, "biography", $data , true)){
                    update_term_meta($term_id, "biography", $data);
                };

                wp_update_term( $term_id, $term_data->taxonomy, array("description" => $data) );

            }

        }  
    }
}

