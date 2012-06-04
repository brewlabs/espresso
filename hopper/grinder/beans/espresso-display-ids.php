<?php
/**
 * Bean Name: Display ID's
 * Bean Description: Adds support for a child theme to display WordPress ID's in the admin area
 *
 * @since 1.0.1
 * @package Espresso
 * @author Jared Harbour
 */
class EspressoDisplayIDs{

	function &init() {
		static $instance = false;

		if ( !$instance ) {
			$instance = new EspressoDisplayIDs;
		}

		return $instance;
	}

	function EspressoDisplayIDs(){

		wp_enqueue_style('espresso-displayid-css', PARENT_URL . '/hopper/css/espresso-displayid.css');

		add_action('manage_category_custom_column', array( &$this, 'espresso_custom_column_category_id'), 5, 3);
		add_filter('manage_edit-category_columns', array( &$this,'espresso_column_category_id'), 5, 1);

	}

	/**
	 * Add a new 'ID' column to the category management page
	 *
	 * @since 1.1.4
	 * @author scripts@schloebe.de
	 *
	 * @param array
	 * @return array
	 */
	function espresso_column_category_id( $defaults ) {
		if( current_user_can('manage_options') ){
			$defaults = $this->array_insert_string_keys( $defaults, array('espresso_category_id'=> '<abbr title="' . __('Unique Identifier', 'espresso') . '">' . __('ID') . '</abbr>'),'cb' );
		}
		return $defaults;
	}

	/**
	 * Adds content to the new 'ID' column in the category management view
	 *
	 * @since 1.1.4
	 * @author scripts@schloebe.de
	 *
	 * @param string
	 * @param int
	 */
	function espresso_custom_column_category_id($value, $column_name, $id) {
		if( $column_name == 'espresso_category_id' ){
			return (int) $id;
		}
		return $value;
	}

	function array_insert_string_keys($src,$ins,$pos) {

	    $counter=1;
	    foreach($src as $key=>$s){
	        if($key==$pos){
	            break;
	        }
	        $counter++;
	    } 

	    $array_head = array_slice($src,0,$counter);
	    $array_tail = array_slice($src,$counter);

	    $src = array_merge($array_head, $ins);
	    $src = array_merge($src, $array_tail);

	    return($src); 
	} 

}

if(current_theme_supports('espresso-display-ids')){
	add_action('init',array('EspressoDisplayIDs','init'),10);
}