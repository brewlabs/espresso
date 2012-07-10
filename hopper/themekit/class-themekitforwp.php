<?php
/*
 * Plugin Name: ThemeKit For WordPress
 * Plugin URI: http://wordpress.org/extend/plugins/themekit/
 * Description: Build kick-ass options in WordPress
 * Author: ThemekitWP
 * Version: 0.5.3
 * Author URI: http://themekitwp.com
 * License: GPL2+
 * Text Domain: themekit
 * Domain Path: /languages/
 */
if( ! class_exists( 'ThemeKitForWP' ) ){
	
	class ThemeKitForWP {
	
		/**
		*
		*	This file is the Controller for all of ThemeKitForWP
		*	This class interacts with WordPress Directly
		*
		*/
	
		//ThemeKit Variables
		private $_options_array = array();
	  	private $_categories = array();
		private $_option_name = 'themekitforwp';
		private $_theme_url;
		private $_theme_name;
		private $_menu_title = 'Settings';
		private $_options_page = '';
		private $_context_help = '';
		private $_this_options_page = false;
		private $_menu_type = 'theme';
		private $_version = "0.6";
		private $_default = false;
		private $_reset_text = "Reset All Options";
		
		//Class Holders
		private $_c_optionspage;
		private $_c_optionssave;
		private $_c_cssengine;
		private $_c_engine;
		private $_c_fonts;
	
		//Public vars
		public $options_updated;
	
		public function __construct() { 
			
			include_once('class-themekitforwp-optionspage.php');
			include_once('class-themekitforwp-optionssave.php');
			include_once('class-themekitforwp-cssengine.php');
			include_once('class-themekitforwp-engine.php');
			include_once('class-themekitforwp-fonts.php');

			register_post_type( 'themekitforwp', array(
						'labels' => array(
							'name' => __( 'ThemeKit For WP' ),
						),
						'public' => true,
						'show_ui' => false,
						'capability_type' => 'post',
						'hierarchical' => false,
						'rewrite' => false,
						'supports' => array( 'title', 'editor' ), 
						'query_var' => false,
						'can_export' => true,
						'show_in_nav_menus' => false
					) );
		
		
			$this->set_categories();
			$this->set_theme_name();
			$this->_theme_url = get_template_directory_uri();
			$this->_c_optionspage = new ThemeKitForWP_OptionsPage($this);
			$this->_c_optionssave = new ThemeKitForWP_OptionsSave($this);
			$this->_c_cssengine = new ThemeKitForWP_CSSEngine($this);
			$this->_c_engine = new ThemeKitForWP_Engine($this);
			$this->_c_fonts = new ThemeKitForWP_Fonts($this);
			add_action( 'admin_menu' , array( &$this , 'admin_menu' ) );
			add_action( 'wp_head' , array( &$this , 'css_engine' ) , 49 );
			add_action('wp_ajax_tk_handle_ajax_archive', array(&$this, 'handle_ajax_archive'));
			add_action('wp_ajax_tk_get_upload_image_html', array(&$this, 'get_upload_image_html'));
			add_filter('media_send_to_editor', array( &$this , 'media_filter' ), 49, 3 );
			//, $html, $send_id, $attachment);
	
			if ( function_exists( 'add_image_size' ) ) { 
				add_image_size( 'mini', 100, 100, false);
			}
		
			$this->set_context_help( '<p>'. __( 'You can customize the look of your site without touching any of your theme&#8217;s code by using custom options. You can change any of the option below.' ) . '</p>' .
							'<p>' . __( 'Color Picker: If you know the hexadecimal code for the color you want, enter it in the Color field. If not, click on the Select a Color link, and a color picker will allow you to choose the exact shade you want.' ) . '</p>' .			'<p>' . __( 'Don&#8217;t forget to click on the Save Changes button when you are finished.' ) . '</p>');
		} 
	
		public function media_filter($html, $send_id, $attachment){
			$post_info = get_post($send_id);
			if(isset($post_info->post_parent)){
				$parent_info =  get_post($post_info->post_parent);
				if($parent_info->post_type=='themekitforwp'){
					return $post_info->ID;
				}
			}
		
			return  $html;
		}
	
		public function loaded_in_child_theme(){
			$this->_theme_url = get_stylesheet_directory_uri();
		}
	
		//Build the Menu and Page Load Actions
		public function admin_menu(){
			$menu_title = $this->get_menu_title();
			$menu_type = $this->get_menu_type();
			$option_name = $this->get_option_name();
			
				
			
			
			//TODO: Remove need for switch
			switch ($menu_type) {
			    case 'dashboard':
			        $this->_options_page = add_dashboard_page($menu_title, $menu_title, 'administrator', $option_name, array(&$this, 'load_options_page'));
			    break;
				case 'posts':
			        $this->_options_page = add_posts_page($menu_title, $menu_title, 'administrator', $option_name, array(&$this, 'load_options_page'));
			    break;
				case 'media':
			        $this->_options_page = add_media_page($menu_title, $menu_title, 'administrator', $option_name, array(&$this, 'load_options_page'));
			    break;
				case 'links':
			        $this->_options_page = add_links_page($menu_title, $menu_title, 'administrator', $option_name, array(&$this, 'load_options_page'));
			    break;
				case 'pages':
			        $this->_options_page = add_pages_page($menu_title, $menu_title, 'administrator', $option_name, array(&$this, 'load_options_page'));
			    break;
				case 'comments':
			        $this->_options_page = add_comments_page($menu_title, $menu_title, 'administrator', $option_name, array(&$this, 'load_options_page'));
			    break;
				case 'users':
			        $this->_options_page = add_users_page($menu_title, $menu_title, 'administrator', $option_name, array(&$this, 'load_options_page'));
			    break;
				case 'tools':
			        $this->_options_page = add_management_page($menu_title, $menu_title, 'administrator', $option_name, array(&$this, 'load_options_page'));
			    break;
			    case 'plugins':
			        $this->_options_page = add_plugins_page($menu_title, $menu_title, 'administrator', $option_name, array(&$this, 'load_options_page'));
			    break;
			    case 'settings':
			        $this->_options_page = add_options_page($menu_title, $menu_title, 'administrator', $option_name, array(&$this, 'load_options_page'));
			    break;
				default:
					$this->_options_page = add_theme_page($menu_title, $menu_title, 'administrator', $option_name, array(&$this, 'load_options_page'));
				
			}
		
				
			
			add_action("load-$this->_options_page", array(&$this, 'admin_load'));
			//add_action("admin_enqueue_scripts", array(&$this, 'admin_load'));
			add_action("load-$this->_options_page", array(&$this, 'handle_post_data'), 49);
			add_action('admin_print_scripts-media-upload-popup', array(&$this, 'media_upload_change_script') );

		}
		
		/**
		* Add custom ThemeKit Media script to page
		*
		*
		*/
		public function media_upload_change_script(){

		
			if(PARENT_THEME_NAME == 'Espresso' && PARENT_URL){
					wp_enqueue_script( "themekit_media_override" ,PARENT_URL.'/hopper/themekit/media.js', false , "1.0" );
			} else {
					wp_enqueue_script( "themekit_media_override" , plugins_url('media.js', __FILE__), false , "1.0" );
			}

		}
		
		
		public function get_reset_text(){
			return $this->_reset_text;
		}
		public function set_reset_text($text){
			$this->_reset_text = $text;
		}
				
		//Saves-Resets the Options Data in the Database.
		public function handle_post_data(){
			$this->_c_optionssave->save();
		}
		public function get_default_settings_init(){
			return	$this->_c_optionssave->save(true);
		}
		public function get_default_settings(){
			return 	$this->_default;
		}
	
		public function handle_ajax_archive(){
			$this->_c_optionssave->ajax_archive();
		}
	
		public function get_upload_image_html(){
			return $this->_c_engine->get_upload_image_html();
		}
	
		//CSS magic man creates styles for needed elements. 
		public function css_engine(){
			$this->_c_cssengine->add_google_font_api();
			echo $this->_c_cssengine->start();
	
		}
		
		public function get_css(){
			return $this->_c_cssengine->start(true);
			
		}
	
		//Get Class if we haven't already loaded it.
		function get_instance($class)
		{
			static $instances = array();
	        if (!array_key_exists($class, $instances))
	        {
	            $instances[$class] = new $class;
	        }

	        $instance = $instances[$class];
	        return $instance;
		}
	
		/**
		* Register a single Option on the settings page 
		*
		* @Param array $option
		*/
		public function register_option($option)
		{
			array_push( $this->_options_array, $option );
			
			
		}
	
	
		//register all options for the settings page.
		public function register_options($options)
		{
			$this->_options_array = $options;
			$this->_default = $this->get_default_settings_init();
			$saved = get_option($this->get_option_name());
			if(is_array($saved)){
				$merged = array_merge($this->_default, $saved);
			} else { $merged = $this->_default; }
			update_option($this->get_option_name(), $merged);
		}
	
	
		public function update_option( $name, $value = null){
			return $this->_c_optionssave->update_option( $name, $value);
		}
	
		//Returns the array of current options
		public function get_registered_options(){
			return $this->_options_array;
		}
	
		//Utility function to print current settings Array
		public function print_options()
		{
			print_r( $this->_options_array );
		}
	
		//Gets the Name of the theme from WordPress as set in style.css
		private function set_theme_name(){
			if (function_exists('wp_get_theme')){
				$theme = wp_get_theme();
				$this->_theme_name = $theme->name;
			}else{
				$this->_theme_name = get_current_theme();
			}
		}
		
		/*
		*
		*
		*
		*/
		
		
		public function set_menu_type($menu_type){
			$this->_menu_type = $menu_type;
		}
		
		public function get_menu_type(){
			return $this->_menu_type;
		}
		
		
		
		
		//Returns the Themekit version
		public function get_version(){
			return $this->_version;
		}
	
		//Returns the Theme name that ThemeKitForWP is using
		//Mainly for use by classes loaded into this one.
		public function get_theme_name(){
			return $this->_theme_name;
		}
	
		//set categories for current site
		private function set_categories()
		{
			if(empty($this->_categories)){
				$tkcategories = get_categories('hide_empty=0&orderby=name');
				array_push($this->_categories, array('name'=> 'Choose a category', 'id' => 0 ));
				foreach ($tkcategories as $category_list ) {
					array_push($this->_categories, array('name'=>$category_list->cat_name,'id'=>$category_list->cat_ID));
				}
			}
		}
	
		//get current categories
		public function get_categories()
		{
			return $this->_categories;
		}
	
		/*
		* Set the name of sthe option to save data in. Also used for the option page url
		*
		* @param string $option_name 
		*/
		public function set_option_name($option_name)
		{
			$this->_option_name = $option_name;
		}
	
		/*
		* Returns the current option name
		*
		* @return string _option_name 
		*/
		public function get_option_name()
		{
			return $this->_option_name;
		}
	
		public function get_options_page(){
			return $this->_options_page;
		}
		
		/*
		* Sets the Title of the menu item and the options page
		*
		* @param string $menu_title
		*/
		public function set_menu_title($menu_title){
			$this->_menu_title = $menu_title;
		}
	
		public function get_menu_title(){
			return $this->_menu_title;
		}
	
		//returns URL of the current theme ThemeKitForWP is running in
		public function get_theme_url(){
			return $this->_theme_url;
		}
	
		//Load Needed JS & CSS Files
		public function admin_load (){
			$this->_c_optionspage->support_files();
		}
	
		//Creates Options Page from the ThemeKitForWP-OptionsPage class
		public function load_options_page(){
			$this->_c_optionspage->create();		
		}
	
		public function start_engine(){
			$this->_c_engine->start();
		}
	
		public function get_context_help(){
			return $this->_context_help;
		}
		public function set_context_help( $value ){
			$this->_context_help = $value;		
		}
	
		public function get_fonts( $inherit = false ){
			return $this->_c_fonts->get_fonts( $inherit );
		}
	
	
		//Register a new font to the font list
		public function add_font( $font ){
			$this->_c_fonts->add_font( $font );
		}
	
		public function get_group_types(){
			return $this->_c_fonts->get_group_types();
		}
	
		public function load_child_theme_settings(){
			do_action($this->get_option_name() , $this);
		}
		
		//Creates a new Instance of ThemeKitForWP and adds a Demo menu item.
		public function create_demo_form_page(){
			$tkdemo = new ThemeKitForWP();
			$tkdemo->set_option_name('ThemeKitForWPDemo');
			$tkdemo->set_menu_title("ThemeKitForWP Demo");
			$demo = array();
			/*
			$demo[] = array(
				"desc" =>"Demo Form Options",
				"type" => "title"
			);
			*/
			$demo[] = array("desc" =>"Demo 1.0","type" => "title");
			$demo[] = array("name"=> "Section","type" => "section" );
			$demo[] = array( 
				"name" => "Text box",
				"desc" => "Text box description.",
				"id" => "tbox",
				"type" => "text",
				"std" => ""
			);
		
			$demo[] = array( 
				"name" => "Text Area",
				"desc" => "Text Area description",
				"id" => "tarea",
				"type" => "textarea",
				"std" => "",
				"subtext"=>"quick note here about something cool."
			);
		
			$demo[] = array( 
				"name" => "Select",
				"desc" => "Select description.",
				"id" => "feat_cat",
				"type" => "select",
				"options" => $tkdemo->get_categories(),
				"std" => 1);
			$demo[] = array( 
				"name" => "Checkbox",
				"desc" => "Some informational test about the checkbox.",
				"id" => "ga_code",
				"type" => "checkbox",
				"std" => "",
				"cbtext"=> "checkbox option."
				);
			$demo[] = array( 
				"name" => "Radio",
				"desc" => "Some informational test about the radio.",
				"id" => "radio_t",
				"type" => "radio",
				"std" => "one",
				"cbtext"=> "turn off the background.",
				"options"=> array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five")
				);
		
			$demo[] =	array(	
				"name" => "Image",		
	           	"id" => "bg_image_2",
				"std" => "",
				"desc" => "Images are uploaded to the Media library.",
				"type" => "upload");
		//	$demo[] = array( "type" => "close");
			$demo[] = array( 
				"name" => "Color Picker",
				"desc" => "Some information about the colorpicker.",
				"id" => "cptest",
				"type" => "colorpicker",
				"std" => "#000");
			$demo[] = array( 
				"name" => "Border",
				"desc" => "Some information about the border.",
				"id" => "bordertest",
				"type" => "border",
				"std" => array( "width" => "1" , "style" => "solid" , "color" => "#000" ));
			$demo[] = array( 
				"name" => "Font",
				"desc" => "Some information about the Font.",
				"id" => "textdemo",
				"type" => "typography",
				"selector" => "",
				"style" => "font",
				"std" => array('face'=>'Droid Sans','size'=>'24','style'=>'normal','color'=>'#000','underline'=>'none'));
		/*		$demo[] = array( 
					"name" => "Font",
					"desc" => "Some information about the Font. Some information about the Font. Some information about the Font. Some information about the Font.",
					"id" => "textdemo3",
					"type" => "typography",
					"selector" => "#site-title a",
					"style" => "font",
					"std" => array('face'=>'Droid Sans','size'=>'24','style'=>'normal','color'=>'#000'));
			*/	
				$demo[] = array( "type" => "close" );
			$tkdemo->register_options($demo);
		}
	
	}
}