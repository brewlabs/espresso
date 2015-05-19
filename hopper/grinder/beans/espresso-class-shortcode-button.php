<?php
/**
 * Bean Name: Espresso Shortcode Dropdown
 * Bean Description: Adds support for a child theme to display WordPress ID's in the admin area
 *
 * @since 1.0.1
 * @package Espresso
 * @author Jared Harbour
 */
class Espresso_Shortcode_Button{

	var $buttonName = 'EspressoShortcodeSelector';

	function &init() {
		static $instance = false;

		if ( !$instance ) {
			$instance = new Espresso_Shortcode_Button;
		}

		return $instance;
	}

	function Espresso_Shortcode_Button(){

		// Don't bother doing this stuff if the current user lacks permissions
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;
	 
	   // Add only in Rich Editor mode
	    if ( get_user_option('rich_editing') == 'true') {
	      add_filter('mce_external_plugins', array($this, 'registerTmcePlugin'));
	      //you can use the filters mce_buttons_2, mce_buttons_3 and mce_buttons_4 
	      //to add your button to other toolbars of your tinymce
	      add_filter('mce_buttons', array($this, 'registerButton'));
	    }

	}

	function registerButton($buttons){
		array_push($buttons, "|", $this->buttonName);
		return $buttons;
	}
	
	function registerTmcePlugin($plugin_array){
		$plugin_array[$this->buttonName] = PARENT_URL . '/hopper/js/espresso_shortcode_dropdown_plugin.js';
		if ( get_user_option('rich_editing') == 'true') 
		 	//var_dump($plugin_array);
		return $plugin_array;
	}

	function get_shortcodes_js(){
		global $shortcode_tags;

		$ordered_sct = array_keys($shortcode_tags);
		sort($ordered_sct);

		echo '<script>var wp_shortcodes = '. json_encode($ordered_sct).'</script>';

	}

}
add_action('init',array('Espresso_Shortcode_Button','init'),10);
add_action('admin_head',array('Espresso_Shortcode_Button','get_shortcodes_js'));