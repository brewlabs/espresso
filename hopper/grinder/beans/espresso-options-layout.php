<?php
/**
* Bean Name: Layout Options
* Bean Description: Adds the Espresso Layout options to the menu
*
* 	@since 1.0.0
* 	@package Espresso
*/

if( ! current_theme_supports('espresso-layouts') )
	return;

global $espresso_framework;
$esk_layouts = new EspressoKit();
$esk_layouts->set_option_name($espresso_framework->get_option_basename().'-layout');
$esk_layouts->set_menu_title( apply_filters('espresso-theme-layout-menu-name', 'Theme Layout') );
$esk_array = array();
//$esk_array[] = array( "desc" =>"","type" => "title"	);

if( current_theme_supports('header-layouts') ){	
	$esk_array[] = array( 
		"name" => "Header",
		"type" => "open"
		);
	$esk_array[] = array( 
		"desc" => "L = Logo | W= Widget Area",
		"id" => "header_layout",
		"type" => "radio-image",
		"std" => $espresso_framework->get_header_layout_default(),
		"options"=> $espresso_framework->get_header_layouts()
		);
	$esk_array[] = array(
		"type" => "close"
		);		
}	
		
if( current_theme_supports('menu-locations') ){	
	$esk_array[] = array( 
		"name" => "Menu Location",
		"type" => "open"
	);
	$esk_array[] = array( 
		"desc" => "Choose where you would like the menu. Depending on Theme design some locations may look the same.",
		"id" => "menu_location",
		"type" => "radio-image",
		"std" => $espresso_framework->get_menu_location_default(),
		"options"=> $espresso_framework->get_menu_locations()
	);
	$esk_array[] = array(
		"type" => "close"
	);
}

if( current_theme_supports('content-layouts') ){	
	$esk_array[] = array( 
		"name" => "Content Area",
		"type" => "open"
	);
	$esk_array[] = array( 
		"subtext" => "",
		"desc" => "This can also be changed per page.",
		"id" => "content_layout",
		"type" => "radio-image",
		"std" => $espresso_framework->get_content_layout_default(),
		"options"=> $espresso_framework->get_content_layouts()
	);
	$esk_array[] = array(
		"type" => "close"
	);
}

if( current_theme_supports('footer-widgets') ){
	$esk_array[] = array( 
		"name" => "Footer Widgets",
		"type" => "open"
	);	
	$esk_array[] = array( 
		"subtext" => "",
		"desc" => "",
		"id" => "footer_widgets",
		"type" => "radio-image",
		"std" => $espresso_framework->get_footer_widgets_default(),
		"options"=> $espresso_framework->get_footer_widget_layouts()
	);
	$esk_array[] = array(
		"type" => "close"
	);
}

$esk_layouts->register_options($esk_array);
	
// add links/menus to the admin bar
function espresso_layout_admin_bar_render() {
	global $wp_admin_bar, $espresso_framework;
	$page = $espresso_framework->get_option_basename().'-layout';
	$wp_admin_bar->add_menu( 
		array(
			'parent' => 'appearance', // use 'false' for a root menu, or pass the ID of the parent menu
			'id' => 'theme_layout', // link ID, defaults to a sanitized title value
			'title' => __( apply_filters('espresso-theme-layout-menu-name', 'Theme Layout') ), // link title
			'href' => admin_url( 'themes.php' ).'?page='.$page, // name of file
			'meta' => false 
		)
	);
}
add_action( 'wp_before_admin_bar_render', 'espresso_layout_admin_bar_render' );




