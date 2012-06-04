<?php
//this file has some cool code for messing with page templates, might come in handy some day.  right now it just sits here and never executes.
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 

if (!is_plugin_active('bbpress/bbpress.php')) {return;}

//require_once( PARENT_DIR .'/hopper/bbpress-templates/functions.php' );

if(current_theme_supports('espresso-bbPress')){	
	class EspressoBBPress{
		function &init() {
			static $instance = false;

			if ( !$instance ) {
				$instance = new EspressoBBPress;
			}

			return $instance;
		}

		function EspressoBBPress() {

			wp_enqueue_script('espresso-bbpress-js', PARENT_URL . '/hopper/js/espresso-bbpress.js', array('jquery'), '1.0', true);
			wp_enqueue_style('espresso-bbpress-css', PARENT_URL . '/hopper/css/espresso-bbpress.css');

			$args = array();
			$args['page.php'] = 'Default Template';
			$temps = get_page_templates();
			ksort( $temps );

			foreach ($temps as $template_name => $template_filename){
			    $args[$template_filename] = $template_name;
			}

			//Add BBpress Templates to Espresso
			$bbtemps = $this->get_bbpress_templates();
			ksort( $bbtemps );

			foreach ($bbtemps as $title => $fiename) {
				$args[$fiename] = $title;
			}


			$meta_boxes[] = array(
				'id' => 'meta_custom_page_templates',
		    	'title' => 'Page Template',
		    	'pages' => array('page'),	 
		    	'context' => 'side',			  
		    	'priority' => 'low',			  
		    	'fields' => array(
		    		array(	'name' => 'Template',
		    			  	'id' => 'custom_page_template',
		    				'type' => 'select',
		    				'options' => $args
		    				)			
				)
		    );
		    
		    foreach ($meta_boxes as $meta_box) {
		    	$my_box = new EspressoMetaBox($meta_box);
		    }
		}

		function get_bbpress_templates(){
			static $bbTemplates = null;

			if ( isset( $bbTemplates ) )
				return $bbTemplates;

			$files = $this->glob_php( PARENT_DIR . '/hopper/bbpress-templates' );

			foreach ( $files as $file ) {

				if ( $headers = $this->get_bb_template( $file  , PARENT_DIR .'/hopper/bbpress-templates') ) {
					$bbTemplates[$headers['name']] = basename( $file );
				}
			}

			return $bbTemplates;
		}

		function get_bb_template( $module, $dir ) {
			$headers = array(
				'name' => 'Template Name'
			);
			$file = EspressoGrinder::get_module_path( EspressoGrinder::get_module_slug( $module  ) , $dir);
			$mod = get_file_data( $file, $headers );

			if ( !empty( $mod['name'] ) )
				return $mod;
			return false;
		}

		/**
		 * Returns an array of all PHP files in the specified absolute path.
		 * Equivalent to glob( "$absolute_path/*.php" ).
		 *
		 * @param string $absolute_path The absolute path of the directory to search.
		 * @return array Array of absolute paths to the PHP files.
		 */
		function glob_php( $absolute_path ) {
			$absolute_path = untrailingslashit( $absolute_path );
			$files = array();
			if ( !$dir = @opendir( $absolute_path ) ) {
				return $files;
			}

			while ( false !== $file = readdir( $dir ) ) {
				if ( '.' == substr( $file, 0, 1 ) || '.php' != substr( $file, -4 ) ) {
					continue;
				}

				$file = "$absolute_path/$file";

				if ( !is_file( $file ) ) {
					continue;
				}

				$files[] = $file;
			}

			closedir( $dir );

			return $files;
		}
	}
	add_action('_admin_menu',array('EspressoBBPress','init'),100);

	class EspressoBBPressLoader{
		function &init() {
			static $instance = false;

			if ( !$instance ) {
				$instance = new EspressoBBPressLoader;
			}

			return $instance;
		}

		function EspressoBBPressLoader() {
			add_filter( 'page_template', array(&$this,'get_espresso_bbpress_template') );

			// add_filter( 'taxonomy_template', array(&$this,'get_espresso_bbpress_template') );
			// add_filter( 'single_template', array(&$this,'get_espresso_bbpress_single_template') );

			// add_filter('bbp_get_theme_compat_name', array(&$this,'override_bbp_theme_name') );
			// add_filter('bbp_get_theme_compat_version', array(&$this,'override_bbp_theme_version') );
			// add_filter('bbp_get_theme_compat_dir', array(&$this,'override_bbp_theme_directory') );
			// add_filter('bbp_get_theme_compat_url', array(&$this,'override_bbp_theme_url') );
		
			//remove_filter( 'bbp_template_include', 'bbp_template_include_theme_supports', 2, 1 );
			//remove_filter( 'bbp_template_include', 'bbp_template_include_theme_compat',   4, 2 );

			// bbp_{$type}_template

			// add_filter( 'bbp_profile_template', array(&$this,'get_espresso_profile_template') );
			
			//add_filter( 'template_include' , array(&$this,'check_template_include'),11);

			

		}

		function locate_bbPress_template($template_names, $load = false, $require_once = true ){
		    if ( !is_array($template_names) )
		        return '';
		    
		    $located = '';

		    $espresso_bbPress_dir = PARENT_DIR . '/hopper/bbpress-templates/';
		    
		    foreach ( $template_names as $template_name ) {
		        if ( !$template_name )
		            continue;
		        if ( file_exists(STYLESHEETPATH . '/' . $template_name)) {
		            $located = STYLESHEETPATH . '/' . $template_name;
		            break;
		        } else if ( file_exists(TEMPLATEPATH . '/' . $template_name) ) {
		            $located = TEMPLATEPATH . '/' . $template_name;
		            break;
		        } else if ( file_exists( $espresso_bbPress_dir .  $template_name) ) {
		            $located = $espresso_bbPress_dir . $template_name;
		            break;
		        }
		    }
		    
		    //echo '<br>Located = '.$located;

		    if ( $load && '' != $located )
		        load_template( $located, $require_once );
		    
		    return $located;
		}

		function get_espresso_bbpress_template($template){

			$templates = array();

			if( is_page() ){
				global $post;
				$templates[] = get_post_meta( $post->ID, 'custom_page_template', true );
			}
			$templates[] = $template;

			$template = $this->locate_bbPress_template($templates);

			return $template;
		}

		function get_espresso_bbpress_single_template($template){    
			global $wp_query;    
			$object = $wp_query->get_queried_object(); 
			
			echo '<br>'.$template; 
			       
			//if ( 'forum' == $object->post_type ) {        
				$templates = array('single-' . $object->post_type . '.php');        
				$template = $this->locate_bbPress_template($templates); 
				echo '<br>'.$template;   
			//}    
			// return apply_filters('single_template', $template);    
			return $template;
			//return false;
		}

		function get_espresso_profile_template($templates){
			echo 'profile template : ';
			print_r($templates);
			return $templates;
		}

		function check_template_include($template){
			echo 'TEMPLATE TO INCLUDE : '.$template;
			// if( is_page() ){
			// 	echo 'its a page????';
			// }
			// if( is_single() ){
			// 	echo 'its a SINGLE WTF';
			// }
			
			

			return $template;
		}

		function override_bbp_theme_name($name){
			return "espresso";
		}

		function override_bbp_theme_version($ver){
			return "2011118";
		}

		function override_bbp_theme_directory($dir){			
			$dir = PARENT_DIR.'/hopper/bbpress-templates';
			return $dir;
		}

		function override_bbp_theme_url($url){
			$dir = PARENT_URL.'/hopper/bbpress-templates';
			return $dir;
		}
	}
	add_action('init',array('EspressoBBPressLoader','init'),100);
}























