<?php
/**
 * Bean Name: MetaBox Layout Options
 * Bean Description: Adds the Espresso Layout options to the menu
 */
/********************* BEGIN DEFINITION OF META BOXES ***********************/

// prefix of meta keys, optional
// use underscore (_) at the beginning to make keys hidden, for example $prefix = '_rw_';
// you also can make prefix empty to disable it
$prefix = 'espresso_';

$meta_boxes = array();
global $espresso_framework;
// first meta box
$layouts = $espresso_framework->get_content_layouts();

$fields = array();

$meta_boxes = apply_filters('espresso_meta_boxes_before', $meta_boxes);

$meta_boxes[] = array(
	'id' => 'page_settings',							// meta box id, unique per meta box
	'title' => 'Page Settings',			// meta box title
	'pages' => array('page'),	// post types, accept custom post types as well, default is array('post'); optional
	'context' => 'normal',						// where the meta box appear: normal (default), advanced, side; optional
	'priority' => 'high',						// order of meta box: high (default), low; optional

	'fields' => array(
		array(
		'name' => 'Page Title',
		'id' => $prefix . 'page_title',
		'type' => 'radio',						// radio box
		'options' => array(						// array of key => value pairs for radio options
			'show' => 'Show',
			'hide' => 'Hide'
		),
		'std' => 'show',
		'desc' => 'This will remove the page title from being display on the site.'
		),
		array(
		'name' => 'Widget Area Only',
		'id' => $prefix . 'page_widgets_only',
		'type' => 'checkbox',
		'std' => '',
		'label' => 'This Hides the Page Title and Content. Only the Widgets will show.'
		),
		array(
		'name' => 'Content Widget Area',
		'id' => $prefix . 'content_widget',
		'type' => 'checkbox',
		'validate_func'=>'content_widget_area',					// radio box
		'std' => '',
		'label' => 'This will create a Widget area to use below the content of this page.'
		)
	)
);

$es_primary_sidebar_fields = false;
$es_secondary_sidebar_fields = false;

foreach($layouts as $layout){
	$l = explode("-", $layout['value'] );
	if( in_array("sidebar1" , $l) ){
		$es_primary_sidebar_fields = array(
			'name' => 'Primary Widget Area',
			'id' => $prefix . 'primary_widget',
			'type' => 'checkbox',
			'validate_func'=>'replace_primary_widget_area',					// radio box
			'std' => '',
			'label' => 'This will add a widget area that replaces the Primary Widget Area for this page.'
		);
	}
	if( in_array("sidebar2" , $l) ){
		$es_secondary_sidebar_fields = array(
			'name' => 'Secondary Widget Area',
			'id' => $prefix . 'secondary_widget',
			'type' => 'checkbox',
			'validate_func'=>'replace_secondary_widget_area',					// radio box
			'std' => '',
			'label' => 'This will add a widget area that replaces the Secondary Widget Area for this page.'
		);
	}
}

if( is_array($es_primary_sidebar_fields) || is_array($es_secondary_sidebar_fields) ){
	$sidebar_fields = array();

	if( is_array($es_primary_sidebar_fields) ){ $sidebar_fields[] = $es_primary_sidebar_fields; }
	if( is_array($es_secondary_sidebar_fields) ){ $sidebar_fields[] = $es_secondary_sidebar_fields; }

	$meta_boxes[] = array(
		'id' => 'sidebar-settings',							// meta box id, unique per meta box
		'title' => 'Sidebar Settings',			// meta box title
		'pages' => array('page'),	// post types, accept custom post types as well, default is array('post'); optional
		'context' => 'normal',						// where the meta box appear: normal (default), advanced, side; optional
		'priority' => 'high',						// order of meta box: high (default), low; optional

		'fields' => $sidebar_fields
	);
}




if( current_theme_supports('content-layouts') ){

	
	$fields[] =	array(
		'name' => 'Content Layout',
		'id' => $prefix . 'content_layout',
		'type' => 'radio_image',						// radio box
		"std" => 'default',
		"options"=> $layouts,
		'no_image'=>array('default'=>'Default Layout'),
		'desc' => ''
	);



	$meta_boxes[] = array(
		'id' => 'layout-settings',							// meta box id, unique per meta box
		'title' => 'Layout Settings',			// meta box title
		'pages' => array('page','post'),	// post types, accept custom post types as well, default is array('post'); optional
		'context' => 'normal',						// where the meta box appear: normal (default), advanced, side; optional
		'priority' => 'high',						// order of meta box: high (default), low; optional

		'fields' => $fields
	);
}
$meta_boxes = apply_filters('espresso_meta_boxes_after', $meta_boxes);

foreach ($meta_boxes as $meta_box) {
	$my_box = new EspressoMetaBox($meta_box);
}


class ES_Meta_Box_Validate{
	function content_widget_area( $new, $name ){
		global $espresso_framework;
		//wp_die( $name );
		if($new == 'on'){
			$espresso_framework->create_content_sidebar(get_the_ID());
			//$espresso_framework
		} else {
			$espresso_framework->remove_content_sidebar(get_the_ID());
		}
		return $new;
	}

	function replace_primary_widget_area($new, $name){
		global $espresso_framework;
		//wp_die( $name );
		if($new == 'on'){
			$espresso_framework->create_primary_sidebar(get_the_ID());
			//$espresso_framework
		} else {
			$espresso_framework->remove_primary_sidebar(get_the_ID());
		}
		return $new;
	}

	function replace_secondary_widget_area($new, $name){
		global $espresso_framework;
		//wp_die( $name );
		if($new == 'on'){
			$espresso_framework->create_secondary_sidebar(get_the_ID());
			//$espresso_framework
		} else {
			$espresso_framework->remove_secondary_sidebar(get_the_ID());
		}
		return $new;
	}
}

