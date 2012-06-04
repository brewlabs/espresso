<?php
/**
 * This file loads all the files used by the framework within espresso
 *
 * @since 1.0.0
 * @package Espresso
 * @author Josh Lyford
 */
require_once(dirname(__FILE__) . '/grinder/class-espresso-framework.php');
require_once(dirname(__FILE__) . '/grinder/class-espresso-meta-box.php');
require_once(dirname(__FILE__) . '/grinder/class-espresso-images.php');
require_once(dirname(__FILE__) . '/grinder/espresso-functions.php');

//CHECK FOR THEMEKIT - http://themekit.me
if( !class_exists('ThemeKitForWP') ){
	//Provided the ThemeKit Plugin was not foudn load the Espresso Version
	require_once(dirname(__FILE__) . '/themekit/class-themekitforwp.php');
	//Extend ThemeKit for easy reference to EspressoKit
	class EspressoKit extends ThemeKitForWP {
		public function __construct() { 
	        parent::__construct(); 
		} 
	}
	//Finally Spin up the grinder and get things going
	require_once(dirname(__FILE__) . '/grinder/class-espresso-grinder.php');
} else{
	//Cool you have the pluign version of ThemeKit. You don't need it anymore.
	add_action('admin_notices','espresso_remove_themekit');
}

/**
 * Alert user to the fact that they have the ThemeKit.me Plugin running
 *
 * @since 1.0.0
 * @return void
 * @author Josh Lyford
 */
function espresso_remove_themekit(){
	echo "<div id='message' class='error'><p>Please deactivate the <a href=".admin_url('plugins.php').">ThemeKit For WordPress</a> plugin. Espresso contains the latest version.</p></div>";
}
