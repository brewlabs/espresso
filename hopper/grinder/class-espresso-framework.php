<?php 
/**
 * Module Name: Espresso Framework
 * Module Description: Adds the Espresso Framework Engine
 */
/**
* 	WARNING: This file is part of the Espresso framework. DO NOT edit
* 	this file under any circumstances. Please do all modifications
* 	in the form of a child theme. 
*
*	This class it the Espresso's storage engine and manager	
*/

class EspressoFramework {
	/*
	* Their can be only one!
	*/
	private $_content_layout_classes = array();
	private $_footer_widget_classes = array();
	private $_content_layouts2 = array(
		"content-sidebar1" => "Content - Primary Sidebar",
		"sidebar1-content" => "Primary Sidebar - Content",
		"content-sidebar1-sidebar2" => "Content - Primary Sidebar - Secondary Sidebar",
		"sidebar2-content-sidebar1" => "Secondary Sidebar - Content - Primary Sidebar",
		"sidebar2-sidebar1-content" => "Secondary Sidebar - Primary Sidebar - Content",
		"content" => "Content Only"
		);
	
	private $_content_layouts = array(	);
	
	private $_header_layouts = array();
	
	
	
	private $_footer_wideget_layouts = array();
	
	private $_default_array = array(
		"content_layout"=>"content-sidebar1",
		"menu_location"=>"header-bottom",
		"footer_widgets"=>"footer1-footer2-footer3-footer4",
		"header_layout"=>"logo-branding",
		"footer"=>"footer-content");	
	private $_child_default_array = array();
	
	private $_menu_locations =  array();
	
	private $_menu_classes = array();
	
	private $_menu_mapping = array(
		"header-top" => "header_layout",
		"header-bottom" => "header_layout",
		"content-top" => "content_layout",
		"sidebar-top" => "content_layout",
	);
	
	private $_menu_default = "header-bottom";
	
	private $_option_name = 'espresso-layout';
	
	private $_image_sizes = array();
	
	function &init() {
		static $instance = false;

		if ( !$instance ) {
			$instance = new EspressoFramework;
		
		}

		return $instance;
	}
	
	function __construct() {
	
		$this->_content_layouts = array(
			'content-sidebar1' => array(
				'value' => 'content-sidebar1',
				'label' =>  'Content on left',
				'thumbnail' => PARENT_URL . '/hopper/images/content-sidebar1.png',
			),
			'sidebar1-content' => array(
				'value' => 'sidebar1-content',
				'label' => __( 'Content on right', 'twentyeleven' ),
				'thumbnail' => PARENT_URL . '/hopper/images/sidebar1-content.png',
			),
			'content' => array(
				'value' => 'content',
				'label' => __( 'One-column, no Sidebars', 'twentyeleven' ),
				'thumbnail' => PARENT_URL . '/hopper/images/content.png',
			),
			'content-sidebar1-sidebar2'=> array(
				'value' => 'content-sidebar1-sidebar2',
				'label' => __( 'Content on left with Primary and Secondary sidebars', 'twentyeleven' ),
				'thumbnail' => PARENT_URL . '/hopper/images/content-sidebar1-sidebar2.png',
			),
			'sidebar2-content-sidebar1'=> array(
				'value' => 'sidebar2-content-sidebar1',
				'label' => __( 'Content in the Middle, Primary sidebar on the right', 'twentyeleven' ),
				'thumbnail' => PARENT_URL . '/hopper/images/sidebar2-content-sidebar1.png',
			),
			'sidebar2-sidebar1-content'=> array(
				'value' => 'sidebar2-sidebar1-content',
				'label' => __( 'Content on right, Primary sidebar in the middle', 'twentyeleven' ),
				'thumbnail' => PARENT_URL . '/hopper/images/sidebar2-sidebar1-content.png',
			),
		);
		
		$this->_header_layouts = array(
		    'logo-branding' => array(
		    	'value' => 'logo-branding',
		    	'label' =>  'Logo on left<br>H1 Widget area right',
		    	'thumbnail' => PARENT_URL . '/hopper/images/logo-branding.png',
		    ),
		    'branding-logo' => array(
		    	'value' => 'branding-logo',
		    	'label' =>  'Logo on right<br>H1 Widget area left',
		    	'thumbnail' => PARENT_URL . '/hopper/images/branding-logo.png',
		    ),
		 	'logo-third-branding' => array(
		    	'value' => 'logo-third-branding',
		    	'label' =>  "Logo on left 1/3 width<br>H1 Widget area right 2/3's width",
		    	'thumbnail' => PARENT_URL . '/hopper/images/logo-1-3-branding.png',
		    ),
			'branding-logo-third' => array(
		    	'value' => 'branding-logo-third',
		    	'label' =>  'Logo on right 1/3<br>H1 Widget area left 2/3',
		    	'thumbnail' => PARENT_URL . '/hopper/images/branding-logo-1-3.png',
		    ),
		    'logo-above-branding' => array(
		    	'value' => 'logo-above-branding',
		    	'label' =>  'Logo above H1 Widget area',
		    	'thumbnail' => PARENT_URL . '/hopper/images/logo-above-branding.png',
		    ),
		    'logo-branding-branding2' => array(
		    	'value' => 'logo-branding-branding2',
		    	'label' =>  'Logo on the left<br>H1 Widget area middle<br>H2 Widget area on right',
		    	'thumbnail' => PARENT_URL . '/hopper/images/logo-branding-branding2.png',
		    ),
		    'branding-logo-branding2' => array(
		    	'value' => 'branding-logo-branding2',
		    	'label' =>  'Logo in the middle<br>H1 Widget area left<br>H2 Widget area on right',
		    	'thumbnail' => PARENT_URL . '/hopper/images/branding-logo-branding2.png',
		    ),
		    'logo-above-branding-branding2' => array(
		    	'value' => 'logo-above-branding-branding2',
		    	'label' =>  'Logo above H1 Widget area and H2 Widget area',
		    	'thumbnail' => PARENT_URL . '/hopper/images/logo-above-branding-branding2.png',
		    ),
		    'logo-branding-above-branding2' => array(
		    	'value' => 'logo-branding-above-branding2',
		    	'label' =>  'Logo and H1 Widget area above H2 Widget area',
		    	'thumbnail' => PARENT_URL . '/hopper/images/logo-branding-above-branding2.png',
		    ),
		    'branding-logo-above-branding2' => array(
		    	'value' => 'branding-logo-above-branding2',
		    	'label' =>  'Logo and H1 Widget area above H2 Widget area',
		    	'thumbnail' => PARENT_URL . '/hopper/images/branding-logo-above-branding2.png',
		    ),
		    'logo' => array(
		    	'value' => 'logo',
		    	'label' =>  'Logo only',
		    	'thumbnail' => PARENT_URL . '/hopper/images/logo.png',
		    ),
		    'none' => array(
		    	'value' => 'none',
		    	'label' =>  'No Header',
		    	'thumbnail' => PARENT_URL . '/hopper/images/no-header.png',
		    ),
		
		);
		
		$this->_footer_widget_layouts = array(
			'footer1-footer2-footer3-footer4' => array(
				'value' => 'footer1-footer2-footer3-footer4',
				'label' =>  '4 Footer Widgets',
				'thumbnail' => PARENT_URL . '/hopper/images/footer1-footer2-footer3-footer4.png',
			),
			'footer1-footer2-footer3' => array(
				'value' => 'footer1-footer2-footer3',
				'label' =>  '3 Footer Widgets',
				'thumbnail' => PARENT_URL . '/hopper/images/footer1-footer2-footer3.png',
			),
			'footer1-wide-footer2-footer3' => array(
				'value' => 'footer1-wide-footer2-footer3',
				'label' =>  '3 Footer Widgets<br>Widget 1 is Wide',
				'thumbnail' => PARENT_URL . '/hopper/images/footer1-wide-footer2-footer3.png',
			),
			'footer1-footer2-footer3-wide' => array(
				'value' => 'footer1-footer2-footer3-wide',
				'label' =>  '3 Footer Widgets<br>Widget 3 is Wide',
				'thumbnail' => PARENT_URL . '/hopper/images/footer1-footer2-footer3-wide.png',
			),
			'footer1-footer2' => array(
				'value' => 'footer1-footer2',
				'label' =>  '2 Footer Widgets',
				'thumbnail' => PARENT_URL . '/hopper/images/footer1-footer2.png',
			),
			'footer1' => array(
				'value' => 'footer1',
				'label' =>  '1 Footer Widget',
				'thumbnail' => PARENT_URL . '/hopper/images/footer1.png',
			),
			'none' => array(
				'value' => 'none',
				'label' =>  'No Footer Widgets',
				'thumbnail' => PARENT_URL . '/hopper/images/no-widgets.png',
			)
		);
		$this->_menu_locations = array(
			'header-top' => array(
				'value' => 'header-top',
				'label' =>  'Top of Header',
				'thumbnail' => PARENT_URL . '/hopper/images/header-top.png',
			),
			'header-bottom' => array(
				'value' => 'header-bottom',
				'label' =>  'Bottom of Header',
				'thumbnail' => PARENT_URL . '/hopper/images/header-bottom.png',
			),
			'above-content' => array(
				'value' => 'above-content',
				'label' =>  'Between the Header and the Content Area',
				'thumbnail' => PARENT_URL . '/hopper/images/above-content.png',
			),
			'content-top' => array(
				'value' => 'content-top',
				'label' =>  'Inside Content Area Top',
				'thumbnail' => PARENT_URL . '/hopper/images/content-top.png',
			),
			'none' => array(
				'value' => 'none',
				'label' =>  'No Menu Displayed',
				'thumbnail' => PARENT_URL . '/hopper/images/no-menu.png',
			)
		);	
				
		$content_lc = array();
		$content_lc['content-sidebar1']= array(
			"container"=> array("container_24"),
			"sidebar1" => array("grid_8","omega"),
			"content" => array("grid_15 suffix_1","alpha")
			);
		$content_lc['sidebar1-content']= array(
			"container"=> array("container_24"),
			"sidebar1" => array("grid_8 pull_15","omega"),
			"content" => array("grid_15 push_9","alpha")
		);
		$content_lc['content-sidebar1-sidebar2']= array(
			"container"=> array("container_24"),
			"sidebar1" => array("grid_7"),
			"sidebar2" => array("grid_5","omega"),
			"content" => array("grid_12","alpha")
			);
		$content_lc['sidebar2-content-sidebar1']= array(
			"container"=> array("container_24"),
			"sidebar1" => array("grid_7 push_5"),
			"sidebar2" => array("grid_5 pull_19","omega"),
			"content" => array("grid_12 push_5","alpha")
			);
		$content_lc['sidebar2-sidebar1-content']= array(
			"container"=> array("container_24"),
			"sidebar1" => array("grid_7 pull_7"),
			"sidebar2" => array("grid_5 pull_19","omega"),
			"content" => array("grid_12 push_12","alpha")
			);
		$content_lc['content']= array(
			"content" => array("grid_16","alpha","omega")
			);	
			
		$this->_content_layout_classes = apply_filters("espresso_content_layout_classes", $content_lc);
			
			
		$header_ls = array();
		$header_ls['logo-branding'] = array(
			"logo" =>array("grid_8 alpha"),
			"branding" =>array("grid_8 omega")
		);
		$header_ls['logo-third-branding'] = array(
			"container" =>array("container_12"),
			"logo" =>array("grid_4 alpha"),
			"branding" =>array("grid_8 omega")
		);
		$header_ls['branding-logo'] = array(
			"logo" =>array("grid_8 push_8 alpha"),
			"branding" =>array("grid_8 pull_8 omega")
		);
		$header_ls['branding-logo-third'] = array(
			"container" =>array("container_12"),
			"logo" =>array("grid_4 push_8 alpha"),
			"branding" =>array("grid_8 pull_4 omega")
		);
		
		$header_ls['logo-above-branding'] = array(
			"logo" =>array("grid_16 push_16 alpha omega"),
			"branding" =>array("grid_16 pull_16 alpha omega")
		);
		
		$header_ls['logo-branding-branding2'] = array(
			"container" =>array("container_12"),
			"logo" =>array("grid_4 alpha"),
			"branding" =>array("grid_4"),
			"branding2" =>array("grid_4 omega")
		);
		
		$header_ls['branding-logo-branding2'] = array(
			"container" =>array("container_12"),
			"logo" =>array("grid_4 push_4 alpha"),
			"branding" =>array("grid_4 pull_4"),
			"branding2" =>array("grid_4 omega")
		);
		$header_ls['logo-branding-above-branding2'] = array(
			"logo" =>array("grid_8 alpha"),
			"branding" =>array("grid_8 omega"),
			"branding2" =>array("grid_16 alpha omega")
		);
		$header_ls['logo-above-branding-branding2'] = array(
			"logo" =>array("grid_16 alpha omega"),
			"branding" =>array("grid_8 alpha"),
			"branding2" =>array("grid_8 omega")
		);
		
		$header_ls['branding-logo-above-branding2'] = array(
			"logo" =>array("grid_8 push_8 alpha"),
			"branding" =>array("grid_8 pull_8 "),
			"branding2" =>array("grid_16 alpha omega")
		);
		
		$header_ls['logo'] = array(
			"logo" =>array("grid_16 alpha omega"),
		);	
		
		$this->_header_layout_classes = apply_filters("espresso_header_layout_classes" , $header_ls);
		
		$menu_lc = array();
		$menu_lc['header-top'] = array(
			'logo-third-branding' => array("grid_12 alpha omega"),
			'branding-logo-third' => array("grid_12 alpha omega"),
			'logo-branding-branding2' => array("grid_12 alpha omega"),
			'branding-logo-branding2' => array("grid_12 alpha omega")
		);
		$menu_lc['header-bottom'] = array(
			'logo-third-branding' => array("grid_12 alpha omega"),
			'branding-logo-third' => array("grid_12 alpha omega"),
			'logo-branding-branding2' => array("grid_12 alpha omega"),
			'branding-logo-branding2' => array("grid_12 alpha omega")
		);

		$menu_lc['content-top'] = array(
			'default' => array('grid_24'),
			'content' => array('grid_16')
		);

		$menu_lc['above-content'] = array('default' => array('grid_16','clearfix','alpha omega'));
		
		$this->_menu_classes = apply_filters("espresso_menu_classes" , $menu_lc);
			
			
		
		$footer_wc = array();
		$footer_wc['footer1-footer2-footer3-footer4'] = array(
			"footer1" =>array("grid_4 alpha"),
			"footer2" =>array("grid_4"),
			"footer3" =>array("grid_4"),
			"footer4" =>array("grid_4 omega")
		);
		$footer_wc['footer1-footer2-footer3'] = array(
			"container" =>array("container_12"),
			"footer1" =>array("grid_4 alpha"),
			"footer2" =>array("grid_4"),
			"footer3" =>array("grid_4 omega")
		);
		$footer_wc['footer1-wide-footer2-footer3'] = array(
			"container" =>array("container_12"),
			"footer1" =>array("grid_6 alpha"),
			"footer2" =>array("grid_3"),
			"footer3" =>array("grid_3 omega")
		);
		$footer_wc['footer1-footer2-footer3-wide'] = array(
			"container" =>array("container_12"),
			"footer1" =>array("grid_3 alpha"),
			"footer2" =>array("grid_3"),
			"footer3" =>array("grid_6 omega")
		);
		$footer_wc['footer1-footer2'] = array(
			"footer1" =>array("grid_8 alpha"),
			"footer2" =>array("grid_8 omega")
		);
		$footer_wc['footer1'] = array(
			"footer1" =>array("grid_16 alpha omega"),
		);
		
		$this->_footer_widget_classes = apply_filters("espresso_footer_widget_classes" , $footer_wc);
		
		
		$footer_lc = array();
		
		$footer_lc['footer-content'] = array(
			"default"=>array("grid_16 alpha omega")
		);
				
		$this->_footer_layout_classes = apply_filters("espresso_footer_layout_classes" , $footer_lc);
	
		$this->_child_default_array = array(
			"content_layout"=>$this->get_content_layout_default(),
			"menu_location"=>$this->get_menu_location_default(),
			"header_layout"=>$this->get_header_layout_default(),
			"footer_widgets"=>$this->get_footer_widgets_default(),
			"footer_layout"=>$this->get_footer_default()
		);
		
		/*
		$temp = $this->get_option_basename(); //apply_filters('espresso_option_name','espresso-layout');
		$setup = get_option( $temp );
		if(!$setup){
			
		    update_option($temp, $this->_child_default_array);
		} 
		*/
		add_action( 'admin_init', array($this, 'add_media_settings') );		
	}
	
	function create_content_sidebar( $post_id ) {
		
		$sidebars = get_option( 'espresso_content_sidebar', array(  ) );
		 
		if ( ! in_array( $post_id, $sidebars ) ) {
			$sidebars[] = $post_id;
			update_option( 'espresso_content_sidebar' , $sidebars );
			return true;
		}
		return false;
	}

	function remove_content_sidebar( $post_id ) {

		$sidebars = get_option( 'espresso_content_sidebar', array(  ) );

			if ( false !== ( $key = array_search( $post_id, $sidebars ) ) ) {
				unset( $sidebars[$key] );
				update_option( 'espresso_content_sidebar', $sidebars );
				return true;
			}
	
		return false;
	}

	//primary custom sidebar
	function create_primary_sidebar( $post_id ) {
		
		$sidebars = get_option( 'espresso_primary_sidebar', array(  ) );
		 
		if ( ! in_array( $post_id, $sidebars ) ) {
			$sidebars[] = $post_id;
			update_option( 'espresso_primary_sidebar' , $sidebars );
			return true;
		}
		return false;
	}

	function remove_primary_sidebar( $post_id ) {

		$sidebars = get_option( 'espresso_primary_sidebar', array(  ) );

			if ( false !== ( $key = array_search( $post_id, $sidebars ) ) ) {
				unset( $sidebars[$key] );
				update_option( 'espresso_primary_sidebar', $sidebars );
				return true;
			}
	
		return false;
	}

	//secondary custom sidebar
	function create_secondary_sidebar( $post_id ) {
		
		$sidebars = get_option( 'espresso_secondary_sidebar', array(  ) );
		 
		if ( ! in_array( $post_id, $sidebars ) ) {
			$sidebars[] = $post_id;
			update_option( 'espresso_secondary_sidebar' , $sidebars );
			return true;
		}
		return false;
	}

	function remove_secondary_sidebar( $post_id ) {

		$sidebars = get_option( 'espresso_secondary_sidebar', array(  ) );

		if ( false !== ( $key = array_search( $post_id, $sidebars ) ) ) {
			unset( $sidebars[$key] );
			update_option( 'espresso_secondary_sidebar', $sidebars );
			return true;
		}
		return false;
	}
	
	
	
	
	
	function add_media_settings(){
		foreach( $this->_image_sizes as $s ){
			register_setting( 'media', "{$s['name']}_size_w","intval" );
			register_setting( 'media', "{$s['name']}_size_h","intval" );
			add_settings_field( $s['name'], $s['display_name'], array($this,'espresso_media'), 'media', 'default',$s);
		}
	}
	function espresso_media($s){ 
		extract($s);
		$w= get_option("{$name}_size_w");
		$h= get_option("{$name}_size_h");
		?>
		<fieldset><legend class="screen-reader-text"><span><?php echo $display_name; ?></span></legend>
		<label for="<?php echo $name; ?>_size_w"><?php _e('Max Width'); ?></label>
		<input name="<?php echo $name; ?>_size_w" type="text" id="<?php echo $name; ?>_size_w" value="<?php echo $w; ?>" class="small-text" />
		<label for="<?php echo $name; ?>_size_h"><?php _e('Max Height'); ?></label>
		<input name="<?php echo $name; ?>_size_h" type="text" id="<?php echo $name; ?>_size_h" value="<?php echo $h; ?>" class="small-text" />
		<div>Original Size: <?php echo  $s['width'] . ' x '. $s['height']; ?>
		</fieldset>
	<?php
	}
	
	
	function get_content_classes( $layout ){
		return $this->get_classes('content_layout', $layout );
	}
	
	function get_header_classes( $layout ){
		return $this->get_classes('header_layout', $layout );
	}
	
	function get_footer_widget_classes( $layout ){
		return $this->get_classes('footer_widgets', $layout );
	}
	
	function get_footer_classes( $layout ){
		return $this->get_classes('footer_layout', $layout );
	}
	
	function get_menu_classes( $menu_location ){
		return $this->get_classes('menu_location', $menu_location );	
	}
	
	function add_image_size($display_name, $name, $width, $height, $crop){
		$this->_image_sizes[] = array(
			"display_name"=>$display_name,
			"name"=> $name,
			"width"=> $width,
			"height"=> $height,
			"crop"=> $crop
		);
	}
	
	function get_classes( $type, $layout){
		switch( $type ){
			case 'header_layout':
				$default = isset($this->_header_layout_classes[$layout]) ? $this->_header_layout_classes[$layout] : array(ESPRESSO_NO_CLASS) ;
				return $default;
			break;
			case 'footer_widgets':
				$default = isset($this->_footer_widget_classes[$layout]) ? $this->_footer_widget_classes[$layout] : array(ESPRESSO_NO_CLASS) ;
				return $default;
			break;
			case 'content_layout':
				$default = isset($this->_content_layout_classes[$layout]) ? $this->_content_layout_classes[$layout] : array(ESPRESSO_NO_CLASS) ;
				return $default;
			break;
			case 'menu_location':
				if( isset($this->_menu_mapping[$layout]) ){
					$check_layout= $this->get_layout_option();	
					$check_layout = isset($check_layout[$this->_menu_mapping[$layout]])?$check_layout[$this->_menu_mapping[$layout]]:false;
					if(isset( $this->_menu_classes[$layout][$check_layout] ) ){
						return $this->_menu_classes[$layout][$check_layout];
					}
				} 
				if(isset($this->_menu_classes[$layout]['default'])){
					return $this->_menu_classes[$layout]['default'];
				}
				return array("grid_16","alpha","omega");
			
			break;
			case 'footer_layout':
				$default = isset($this->_footer_layout_classes[$layout]) ? $this->_footer_layout_classes[$layout] : array(ESPRESSO_NO_CLASS) ;
				return $default;
			break;
			
		}
		
	}
	
	function get_header_layouts(){
		$hlayouts =  apply_filters('espresso_header_layout_options', $this->_header_layouts );
		$supported_layout = get_theme_support('header-layouts');
		$options = array();
		$supported_layout = $supported_layout[0];
		foreach ( $supported_layout as $value) {
			$options[$value] = $hlayouts[$value];
		}
		return $options;
		
	}
	
	function get_header_layout_default(){
		return apply_filters('espresso_header_layout_default', $this->_default_array['header_layout']);
	}
	
	function get_footer_widget_layouts( ){
		$footer_widgets = apply_filters('espresso_footer_widget_options', $this->_footer_widget_layouts );
		$supported_layout = get_theme_support('footer-widgets');
		$options = array();
		$supported_layout = $supported_layout[0];
		foreach ( $supported_layout as $value) {
			$options[$value] = $footer_widgets[$value];
		}
		return $options;
	}
	
	function get_footer_widgets_default(){
		return apply_filters('espresso_footer_widgets_default', $this->_default_array['footer_widgets']);
	}
	
	function get_footer_default(){
		return apply_filters('espresso_footer_default', $this->_default_array['footer']);
	}
	
	
	function get_content_layouts( ){
		$content = apply_filters('espresso_content_layout_options', $this->_content_layouts );
		$supported_layout = get_theme_support('content-layouts');
		$options = array();
		if( current_theme_supports('content-layouts') ){
			$supported_layout = $supported_layout[0];
			foreach ( $supported_layout as $value) {
				$options[$value] = $content[$value];
			}
		}
		
		return $options;
	}
	
	function get_content_layout_default(){
		return apply_filters('espresso_content_layout_default', $this->_default_array['content_layout']);
	}
	
	function get_menu_locations(){
		$menulocations =  apply_filters('espresso_menu_locations', $this->_menu_locations );
		$supported_layout = get_theme_support('menu-locations');
		$options = array();
		$supported_layout = $supported_layout[0];
		foreach ( $supported_layout as $value) {
			$options[$value] = $menulocations[$value];
		}
		return $options;
	}
	
	function get_menu_location_default(){
		$supported_layout = get_theme_support('menu-locations');
		if(	$supported_layout ){
			return apply_filters('espresso_menu_location_default', $this->_default_array['menu_location'] );
		} 
	}
	
	function get_layout_option(){
		$setup = get_option( $this->get_option_basename() .'-layout' );
		
		foreach( $this->_child_default_array as $key => $value ){
			if(! isset($setup[ $key ])){
				$setup[$key] = $value;
			}
		}
		
		return $setup;
	}
	function get_option_basename(){
		if (function_exists('wp_get_theme')){
			$theme = wp_get_theme();
			$theme_name = $theme->name;
		}else{
			$theme_name = get_current_theme();
		}

		return apply_filters('espresso_option_basename',sanitize_title_with_dashes( $theme_name ) );
	}
	
	function get_current_header_layout(){
		$h_layout = $this->get_option();
		return $h_layout['header_layout'];
	}
}

global $espresso_framework;
$espresso_framework = new EspressoFramework;



/*
*
*	Make Espresso Work with wordpress 3.0+
*
*/

if( ! function_exists('get_theme_support')){
	function get_theme_support( $feature ) {
		global $_wp_theme_features;
		if ( !isset( $_wp_theme_features[$feature] ) )
			return false;
		else
			return $_wp_theme_features[$feature];
	}
}
if( ! function_exists('get_post_format')){
	function get_post_format( $post = null ) {
		$post = get_post($post);
	
		if ( ! post_type_supports( $post->post_type, 'post-formats' ) )
			return false;
	
		$_format = get_the_terms( $post->ID, 'post_format' );
	
		if ( empty( $_format ) )
			return false;
	
		$format = array_shift( $_format );
	
		return ( str_replace('post-format-', '', $format->slug ) );
	}
}


