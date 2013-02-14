<?php
/**
* 
*	Bean Name: Espresso Theme Style Options
* 	Bean Description: Adds the Espresso style options to the menu
*
* 	@since 1.0.0
* 	@package Espresso
*/

//including plugin.php for the is_plugin_active function
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Return if style options page is removed by child theme.
 *
 * @author Josh Lyford
 */
if( ! current_theme_supports('espresso-options-style') )
	return;

/**
 * Get the Espresso Framework class
 *
 * @author Josh Lyford
 */
global $espresso_framework;	


//Create Array of Extra Posts to be used for options

/*

Extra post type remove from Espresso for Version 1.0 release may return at later date.

$args = array( 'post_type' => 'extra_content');
$loop = new WP_Query( $args );
$theme_content = array();
$theme_content[] = array('id'=>"none",'name'=>'Hide Content');
$theme_content[] = array('id'=>"default",'name'=>'Default Content');
while ( $loop->have_posts() ) : $loop->the_post();
	$slide = wp_get_post_terms(get_the_ID(), 'sliders');
	if(empty($slide)){
		$theme_content[] = array( 'id'=>get_the_ID(),'name' => get_the_title() );
	}
endwhile;
*/



/**
 * Load Espresso version of the THEMEKIT - themekit.me
 *
 * @author Josh Lyford
 */
$es_style_options = new EspressoKit();
//set the name used to store options in. {ThemeName}-options.
$es_style_options->set_option_name($espresso_framework->get_option_basename().'-options');
$es_style_options->set_menu_title( apply_filters('espresso-theme-styles-menu-title','Theme Styles') );
//Change the reset button text
$es_style_options->set_reset_text( apply_filters('espresso-theme-styles-reset-button-text','Reset Styles') );


// added filter to add custom fonts from the child theme
$fonts_to_add = array();
$fonts_to_add = apply_filters('espresso_add_google_fonts',$fonts_to_add);

foreach ($fonts_to_add as $font) {
	if(preg_match('/:/', $font)):
        $string = explode(':', $font);
        $font = $string[0];
        $style = ':'.$string[1];
    else:
        $style = '';
    endif;

    $es_style_options->add_font(
		array(  'name' => $font,
				'id' => strtolower(str_replace(' ', '_', $font)),
			    'type'=> 'google',
		        'style' => 'http://fonts.googleapis.com/css?family='.str_replace(' ', '+', $font).$style,
		        'family' => $font,
				'variant'=> $style
		));
}

//Make sure we are using the correct option name.
$es_style_option_name =	$es_style_options->get_option_name();
$es_style_array = array();

//array of descriptions for the options.
$option_text = array(
	'theme_font' => array(
		'name'=>'Theme Font',
		'subtext'=>'', 
		'desc' => 'Sets the base font for the entire theme.<br><strong>Recommended</strong>: 14px to 18px - Standard Font.'),
	'header_font' => array(
		'name'=>'Header Font',
		'subtext'=>'Effects post titles, page titles, widget headers and header tags in content.', 
		'desc' => ''),
	'post_page_color' => array(
		'name'=>'Post & Page Titles',
		'subtext'=>'Page titles do not use the hover', 
		'desc' => ''),
	'post_title_color' => array(
		'name'=>'Post Titles',
		'subtext'=>'', 
		'desc' => ''),
	'page_title_color' => array(
		'name'=>'Page Titles',
		'subtext'=>'', 
		'desc' => ''),
	'link_color' => array(
		'name'=>"Links",
		'subtext'=>'Changes all page links', 
		'desc' => ''),
	'button_page_color' => array(
		'name'=>'Button',
		'subtext'=>'Changing the background will remove the gradient.', 
		'desc' => "The shortcode for this button is [es-button color='styled'] [/es-button]"),
	'styled_box_title_color' => array(
		'name'=>'Box Title',
		'subtext'=>'Sets the styled box title font properties.', 
		'desc' => "To use this style with the es-box shortcode simply use [es-box color='styled'][/es-box]"),
	'styled_box_text_color' => array(
		'name'=>'Box Text',
		'subtext'=>'', 
		'desc' => ''),
	'styled_box_a_color' => array(
		'name'=>'Box Links',
		'subtext'=>'', 
		'desc' => ''),
	'styled_box_bg_color' => array(
		'name'=>'Box Background',
		'subtext'=>'', 
		'desc' => ''),
	'border_demo' => array(
		'name'=>'Box Border',
		'subtext'=>'', 
		'desc' => ''),
	'styled_box_border_space' => array(
		'name'=>'Box Padding',
		'subtext'=>'', 
		'desc' => 'Enter an integer value i.e. 20'),
	'styled_rule_border' => array(
		'name'=>'Rule',
		'subtext'=>'', 
		'desc' => "To use this style with the es-hr shortcode simply use [es-hr style='styled'][/es-hr]"),
	'widget_title_color' => array(
		'name'=>'Widget Title',
		'subtext'=>'', 
		'desc' => ''),
	'widget_text_color' => array(
		'name'=>'Widget Text',
		'subtext'=>'', 
		'desc' => ''),
	'widget_a_color' => array(
		'name'=>'Widget Links',
		'subtext'=>'', 
		'desc' => ''),
	'footer_widget_title_color' => array(
		'name'=>'Footer Widget Title',
		'subtext'=>'', 
		'desc' => ''),
	'footer_widget_text_color' => array(
		'name'=>'Footer Widget Text',
		'subtext'=>'', 
		'desc' => ''),
	'footer_widget_a_color' => array(
		'name'=>'Footer Widget Links',
		'subtext'=>'', 
		'desc' => ''),
	'logo_display' => array(
		'name'=>'Logo Display',
		'subtext'=>'', 
		'desc' => 'Choose how you would like the logo to be displayed.'),
	'logo_font' => array(
		'name'=>'Logo Font',
		'subtext'=>'', 
		'desc' => 'The Logo text can be edited under Settings > General.'),
	'logo_image' => array(
		'name'=>'Logo Image'),
	'logo_area_space' => array(
		'name'=>'Logo Padding',
		'subtext'=>'use this to move your logo up, down, left and right.', 
		'desc' => 'Enter an integer value i.e. 20'),
	'h1_widget_area_space' => array(
		'name'=>'H1 Widget Area Padding',
		'subtext'=>'use this to adjust header widget positioning.', 
		'desc' => 'Enter an integer value i.e. 20'),
	'h1_widget_text_color' => array(
		'name'=>'H1 Widget Text',
		'subtext'=>'', 
		'desc' => ''),
	'h1_widget_align' => array(
		'name'=>'H1 Widget Text Align',
		'subtext'=>'', 
		'desc' => 'Choose text positioning when in header.'),
	'menu_bg_color' => array(
		'name'=>'Menu Background',
		'subtext'=>'', 
		'desc' => ''),
	'menu_bg_hover_color' => array(
		'name'=>'Menu Hover Background',
		'subtext'=>'', 
		'desc' => ''),
	'menu_font' => array(
		'name'=>'Menu Font',
		'subtext'=>'', 
		'desc' => ''),
	'menu_text_page_color' => array(
		'name'=>'Text Color',
		'subtext'=>'', 
		'desc' => ''),
	'post_excerpt' => array(
		'name'=>'Content Display',
		'subtext'=>'', 
		'desc' => ''),
	'post_page_comments' => array(
		'name'=>'Comments',
		'subtext'=>'', 
		'desc' => 'Select if you want to enable/disable comments on posts and/or pages.'),
	'custom_css' => array(
		'name'=>'CSS',
		'subtext'=>'', 
		'desc' => 'Copy a class or id style from the style sheet paste here and edit it to change theme styles.  Anything added to this box will overwrite all other settings.'),
);

$option_text = apply_filters('espresso-basic-options-text', $option_text);


//determine the order of the sections
$es_style_order = apply_filters( 'espresso-theme-styles-order', array('fonts','button','box','hr','widget','header','menu','content','custom-css') );
$es_style_global_section_type = apply_filters('espresso-theme-styles-section-type','open');

/**
 * Apply a filter to the Espresso style options array so child themes can add their own options in.
 *
 * @author Josh Lyford
 */
$es_style_array = apply_filters('espresso_options_style_before', $es_style_array);

foreach( $es_style_order as $order ){

	switch( $order ){

		case 'fonts':
			/**
			* Espresso Fonts and Colors Section
			*
			* add_theme_support('espresso-fonts-colors');
			*
			*
			* @since 1.0.0 
			* @author Josh Lyford
			*/
			if( current_theme_supports('espresso-fonts-colors') ){

			$es_style_array[] = array( 
				"name" => "Fonts & Colors",
				"type" => apply_filters('espresso-font-section-type',$es_style_global_section_type)
			);	

			//FILTER TO ADD CUSTOM SETTINGS FROM CHILD THEME
			$es_style_array = apply_filters( 'espresso_font_color_style_before' , $es_style_array );

			/**
			* Font styles on <body>
			*
			* add_theme_support('espresso-theme-font', Default Styles);
			*
			* add_theme_support('espresso-theme-font', array('size'=>'16','face'=>'helvetica'));
			*
			* Uses ThemeKit Font option
			*
			* @since 1.0.0 
			* @author Josh Lyford
			*/
			//Make sure Child Theme supports the font selector
			if( current_theme_supports('espresso-theme-font') ){
				$basefont = get_theme_support('espresso-theme-font');
				$es_style_array[] = array(	
					"name" => $option_text['theme_font']['name'],		
			    	"id" => "theme_font",
					"subtext"=>$option_text['theme_font']['subtext'],
					"std" => $basefont[0],
					"type" => "typography",
					"selector" => "body",
					"style"=>'font',
					"desc"=>$option_text['theme_font']['desc']
				);
			}



			/**
			* h1 h2 h3 h4 h5 h6 Font styles
			*
			* add_theme_support('espresso-header-font', Default);
			*	*NOTE: if no default is supplied it sets the default to Use Theme Font.
			*
			* add_theme_support('espresso-header-font', array('face'=>'Arial') );
			*
			* Uses ThemeKit Font option
			*
			* @since 1.0.0 
			* @author Josh Lyford
			*/
			if( current_theme_supports('espresso-header-font') ){
				$headerfont = get_theme_support('espresso-header-font');
				if(is_array($headerfont) == false){
					$headerfont = array('face'=>'Use Theme Font');
				} else {
					$headerfont = $headerfont[0];
				}
				$desc = $option_text['header_font']['desc'];
				if($headerfont['face'] == 'Use Theme Font'){
					$desc .= " Use Theme Font: if the Theme came with a custom header font style in the stylesheet that will be used. Otherwise the Theme Font option above will be the default font.";
				}
				
				$es_style_array[] = array(	
					"name" => $option_text['header_font']['name'],		
			    	"id" => "header_font",
					"subtext"=>$option_text['header_font']['subtext'],
					"std" =>$headerfont,
					"type" => "typography",
					"selector" => "h1,h2,h3,h4,h5,h6",
					"style"=>'font',
					"desc"=>$desc
				);
			}

			/**
			* Post and Page Title styles
			*
			* add_theme_support('espresso-title-styles', Default Styles, Hover Styles);
			*
			* add_theme_support('espresso-title-styles', array('color'=>'#000000'), array('color'=>'#FFFFFF'));
			*
			* Uses ThemeKit Font option
			*
			* @since 1.0.0 
			* @author Josh Lyford
			*/
			if( current_theme_supports('espresso-title-styles') ){
				$es_title_styles = get_theme_support('espresso-title-styles');
				$title_default = $es_title_styles[0];
				$title_hover = $es_title_styles[1];
				$es_style_array[] = array(
					"name" => $option_text['post_page_color']['name'],
					"subtext"=>$option_text['post_page_color']['subtext'],
					"desc" => $option_text['post_page_color']['desc'],
					"multi_selector" => true,
					"id" => "post_page_color",
					"type" => array(
				     	array(
							"id" => "title",
							"type" => "font_multi",
							"std" => $title_default,
							"meta" => "",
							"selector" => ".entry-title,.entry-title a",
							"style"=>'font',
							"label"=> ""),
				    	array(
							"id" => "title_hover",
							"type" => "font_multi",
							"std" => $title_hover,
							"selector" => ".entry-title a:hover",
							"style"=>'font',
							"meta" => "",
							"label"=> "Hover:")
					)
				);
			}	

			/**
			* Post Title styles
			*
			* add_theme_support('espresso-post-title-styles', Default Styles, Hover Styles);
			*
			* add_theme_support('espresso-post-title-styles', array('color'=>'#000000'), array('color'=>'#FFFFFF'));
			*
			* Uses ThemeKit Font option
			*
			* @since 1.0.0 
			* @author Jared Harbour
			*/
			if( current_theme_supports('espresso-post-title-styles') ){
				$es_title_styles = get_theme_support('espresso-post-title-styles');
				$title_default = $es_title_styles[0];
				$title_hover = $es_title_styles[1];
				$es_style_array[] = array(
					"name" => $option_text['post_title_color']['name'],
					"subtext"=>$option_text['post_title_color']['desc'],
					"desc" => $option_text['post_title_color']['subtext'],
					"multi_selector" => true,
					"id" => "post_title_color",
					"type" => array(
				     	array(
							"id" => "post_title",
							"type" => "font_multi",
							"std" => $title_default,
							"meta" => "",
							"selector" => ".entry-title a",
							"style"=>'font',
							"label"=> ""),
				    	array(
							"id" => "post_title_hover",
							"type" => "font_multi",
							"std" => $title_hover,
							"selector" => ".entry-title a:hover",
							"style"=>'font',
							"meta" => "",
							"label"=> "Hover:")
					)
				);
			}

			/**
			* Page Title styles
			*
			* add_theme_support('espresso-page-title-styles', Default Styles, Hover Styles);
			*
			* add_theme_support('espresso-page-title-styles', array('color'=>'#000000'), array('color'=>'#FFFFFF'));
			*
			* Uses ThemeKit Font option
			*
			* @since 1.0.0 
			* @author Jared Harbour
			*/
			if( current_theme_supports('espresso-page-title-styles') ){
				$es_title_styles = get_theme_support('espresso-page-title-styles');
				$title_default = $es_title_styles[0];
				$es_style_array[] = array(
					"name" => $option_text['page_title_color']['name'],
					"subtext"=>$option_text['page_title_color']['subtext'],
					"desc" => $option_text['page_title_color']['desc'],
					"multi_selector" => true,
					"id" => "page_title_color",
					"type" => array(
				     	array(
							"id" => "page_title",
							"type" => "font_multi",
							"std" => $title_default,
							"meta" => "",
							"selector" => "body.page .entry-title, body.single .entry-title",
							"style"=>'font',
							"label"=> "")
				    	
					)
				);
			}		

			/**
			* Site Wide Link Styles
			*
			* add_theme_support('espresso-link-styles', Default Styles, Hover Styles);
			*
			* add_theme_support('espresso-link-styles', array('color'=>'#000000'), array('color'=>'#FFFFFF'));
			*
			* Uses ThemeKit Font option
			*
			* @since 1.0.0 
			* @author Josh Lyford
			*/
			if( current_theme_supports('espresso-link-styles') ){
				$es_link_styles = get_theme_support('espresso-link-styles');
				$link_default = $es_link_styles[0];
				$link_hover = $es_link_styles[1];			
				$es_style_array[] = array(
					"name" => $option_text['link_color']['name'],
					"subtext"=>$option_text['link_color']['subtext'],
					"desc" => $option_text['link_color']['desc'],
					"multi_selector" => true,
					"id" => "link_color",
					"type" => array(
								array(
									"id" => "link",
									"type" => "font_multi",
									"std" => $link_default,
									"meta" => "",
									"selector" => "a",
									"style"=>'font',
									"label"=> ""),
								array(
									"id" => "link_hover",
									"type" => "font_multi",
									"std" => $link_hover,
									"selector" => "a:hover",
									"style"=>'font',
									"meta" => "",
									"label"=> "Hover:")
								)
				);
			}


			//FILTER TO ADD CUSTOM SETTINGS FROM CHILD THEME
			$es_style_array = apply_filters( 'espresso_font_color_style_after' , $es_style_array );		
			$es_style_array[] = array( "type" => "close");
			}
			//======================== END FONTS AND COLORS SECTION
			break;

		case 'button':
			/**
			* ESPRESSO BUTTON STYLES
			*
			* add_theme_support('espresso-box-button');
			*
			* This is the area for the custom styled button and box shortcodes
			* 
			*
			* @since 1.0.0 
			* @author Jared Harbour
			*/
			if( current_theme_supports('espresso-styled-button') ){

			$es_style_array[] = array( "name" => "Styled Button Options","type" => apply_filters('espresso-button-section-type',$es_style_global_section_type) );

			$es_style_array = apply_filters( 'espresso_button_style_before' , $es_style_array );


			/**
			* Custom style class for [es-button]
			*
			* add_theme_support('espresso-button-styles', Default Text, Hover Text, Default BG, Hover BG, Border Color);
			*
			* add_theme_support('espresso-button-styles', array('color'=>"#F0F8FF"), array('color'=>"#F0F8FF"), array('color'=>"#003366"), array('color'=>"#0085A6"), array('color'=>"#001C33") );
			*
			* @since 1.0.0 
			* @author Josh Lyford
			*/
			if( current_theme_supports('espresso-button-styles') ){
				$es_button_styles = get_theme_support('espresso-button-styles');
				$button_txt_default = $es_button_styles[0];
				$button_txt_hover = $es_button_styles[1];
				$button_bg = $es_button_styles[2];
				$button_bg_hover = $es_button_styles[3];
				$button_border = $es_button_styles[4];

				$button_border_args = array();
				if( is_array($button_border) ){
					$button_border_args = array(
								"id" => "button_border",
								"type" => "font_multi",
								"std" => $button_border,
								"selector" => ".button_styled",
								"style"=>'button-border',
								"meta" => "",
								"label"=> "Border:");
				}

				$button_text_args = array();
				if( is_array($button_txt_default) ){
					$button_text_args = array(
								"id" => "button_text",
								"type" => "font_multi",
								"std" => $button_txt_default,
								"meta" => "",
								"selector" => ".button_styled",
								"style"=>'font',
								"label"=> "Text Color:");
				}

				$button_text_hover_args = array();
				if( is_array($button_txt_hover) ){
					$button_text_hover_args = array(
								"id" => "button_text_hover",
								"type" => "font_multi",
								"std" => $button_txt_hover,
								"meta" => "",
								"selector" => ".button_styled:hover",
								"style"=>'font',
								"label"=> "Text Hover:");
				}

				$button_bg_args = array();
				if( is_array($button_bg) ){
					$button_bg_args = array(
								"id" => "button_bg",
								"type" => "font_multi",
								"std" => $button_bg,
								"selector" => ".button_styled",
								"style"=>'button-background',
								"meta" => "",
								"label"=> "Background:");
				}

				$button_bg_hover_args = array();
				if( is_array($button_bg_hover) ){
					$button_bg_hover_args = array(
								"id" => "button_bg_hover",
								"type" => "font_multi",
								"std" => $button_bg_hover,
								"selector" => ".button_styled:hover",
								"style"=>'button-background',
								"meta" => "",
								"label"=> "Background Hover:");
				}

				
				$es_style_array[] = array(
					"name" => $option_text['button_page_color']['name'],
					"subtext"=>$option_text['button_page_color']['subtext'],
					"desc" => $option_text['button_page_color']['desc'],
					"multi_selector" => true,
					"id" => "button_page_color",
					"type" => array(
						$button_text_args,
						$button_text_hover_args,
						$button_bg_args,
						$button_bg_hover_args,
						$button_border_args
						
						)
			     );
			}

			//FILTER TO ADD CUSTOM SETTINGS FROM CHILD THEME
			$es_style_array = apply_filters( 'espresso_button_style_after' , $es_style_array );		
			$es_style_array[] = array( "type" => "close");
			}
			//======================== END BUTTON SECTION
			break;

		case 'box':
			/**
			* ESPRESSO BOX STYLES
			*
			* add_theme_support('espresso-box-button');
			*
			* This is the area for the custom styled button and box shortcodes
			* 
			*
			* @since 1.0.0 
			* @author Jared Harbour
			*/
			if( current_theme_supports('espresso-styled-box') ){

			$es_style_array[] = array( "name" => "Styled Box Options","type" => apply_filters('espresso-box-section-type',$es_style_global_section_type) );

			$es_style_array = apply_filters( 'espresso_box_style_before' , $es_style_array );

			/**
			* Custom style class for [es-box]
			*
			* add_theme_support('espresso-box-styles', 
			*		array('size'=>18, 'face'=>'arial' ,'color'=>"#000"),					//box title color
			*		array('size'=>14, 'face'=>'arial' ,'color'=>"#000"),					//box text
			*		array('underline' => 'underline' ,'color'=>"#000"),						//box link
			*		array('underline' => '','color'=>"#000"),								//box link hover
			*		"#e7e4e4",																//box bg color
			*		array( "width" => "1" , "style" => "solid" , "color" => "#cccccc" ),	//box border
			*		array(10,10,10,10)														//box padding
			*		);
			*
			* @since 1.0.0 
			* @author Jared Harbour
			*/

			if( current_theme_supports('espresso-box-styles') ){
				$es_box_styles = get_theme_support('espresso-box-styles');
				
				$box_title_font_default = $es_box_styles[0];
				$box_text_default = $es_box_styles[1];
				$box_link_default = $es_box_styles[2];
				$box_link_hover_default = $es_box_styles[3];
				$box_bg_color = $es_box_styles[4];
				$box_border = $es_box_styles[5];
				$box_padding = $es_box_styles[6];


				$es_style_array[] = array(
					"name" => $option_text['styled_box_title_color']['name'],
					"subtext"=>$option_text['styled_box_title_color']['subtext'],
					"desc" => $option_text['styled_box_title_color']['desc'],
					"multi_selector" => true,
					"id" => "styled_box_title_color",
					"type" => array(
				     	array(
							"id" => "styled_box_title",
							"type" => "font_multi",
							"std" => $box_title_font_default,
							"meta" => "",
							"selector" => ".box_styled .box-title",
							"style"=>'font',
							"label"=> "")
					)
				);

				$es_style_array[] = array(
					"name" => $option_text['styled_box_text_color']['name'],
					"subtext"=>$option_text['styled_box_text_color']['subtext'],
					"desc" => $option_text['styled_box_text_color']['desc'],
					"multi_selector" => true,
					"id" => "styled_box_text_color",
					"type" => array(
				     	array(
							"id" => "styled_box_text",
							"type" => "font_multi",
							"std" => $box_text_default,
							"meta" => "",
							"selector" => ".box_styled",
							"style"=>'font',
							"label"=> "")
					)
				);

				$es_style_array[] = array(
					"name" => $option_text['styled_box_a_color']['name'],
					"subtext"=>$option_text['styled_box_a_color']['subtext'],
					"desc" => $option_text['styled_box_a_color']['desc'],
					"multi_selector" => true,
					"id" => "styled_box_a_color",
					"type" => array(
				     	array(
							"id" => "styled_box_a",
							"type" => "font_multi",
							"std" => $box_link_default,
							"meta" => "",
							"selector" => ".box_styled a",
							"style"=>'font',
							"label"=> ""),
				    	array(
							"id" => "styled_box_a_hover",
							"type" => "font_multi",
							"std" => $box_link_hover_default,
							"selector" => ".box_styled a:hover",
							"style"=>'font',
							"meta" => "",
							"label"=> "Hover:")
					)
				);

				$es_style_array[] = array( 	
					"name" => $option_text['styled_box_bg_color']['name'],
					"desc" => $option_text['styled_box_bg_color']['desc'],
					"subtext" => $option_text['styled_box_bg_color']['subtext'],
					"id" => "styled_box_bg_color",
					"type" => "colorpicker",
					"std" => $box_bg_color,
					"selector" => ".box_styled",
					"style"=> "background-color"
					);

				$es_style_array[] = array(
			        "name" => $option_text['border_demo']['name'],
					"desc" => $option_text['border_demo']['desc'],
					"subtext" => $option_text['border_demo']['subtext'],
			        "id" => "border_demo",
			        "type" => "border",
			        "selector" => ".box_styled",
			        "style" => "espresso-styled-box-border",
			        "std" => $box_border
				);

				$es_style_array[] = array( 
					"name" => $option_text['styled_box_border_space']['name'],
					"desc" => $option_text['styled_box_border_space']['desc'],
					"subtext" => $option_text['styled_box_border_space']['subtext'],
					"id" => "styled_box_border_space",
					"std" => "",
					"style"=>"padding",
					"selector"=>".box_styled",
					"type" => array( 
						array(  
							'id' => 'top',
							'type' => 'text',
							'std' => $box_padding[0],
							'meta' => 'px',
							'label'=>'Top: '
							),
						array(
							'id' => 'bottom',
							'type' => 'text',
							'std' => $box_padding[1],
							'meta' => 'px',
							'label'=>'Bottom: '
								),
						array(  
							'id' => 'left',
							'type' => 'text',
							'std' => $box_padding[2],
							'meta' => 'px',
							'label'=>'Left: '
							),
						array(  
							'id' => 'right',
							'type' => 'text',
							'std' => $box_padding[3],
							'meta' => 'px',
							'label'=>'Right: '
							)
					)
			);

			}

			//FILTER TO ADD CUSTOM SETTINGS FROM CHILD THEME
			$es_style_array = apply_filters( 'espresso_box_style_after' , $es_style_array );		
			$es_style_array[] = array( "type" => "close");
			}
			//======================== END BOX SECTION
			break;

		case 'hr':
			/**
			* ESPRESSO H-RULE STYLES
			*
			* add_theme_support('espresso-styled-rule');
			*
			* This is the area for the custom styled horizontal rule options
			* 
			*
			* @since 1.0.0 
			* @author Jared Harbour
			*/
			if( current_theme_supports('espresso-styled-rule') ){

			$es_style_array[] = array( "name" => "Styled Horizontal Rule Options","type" => apply_filters('espresso-hr-section-type',$es_style_global_section_type) );

			$es_style_array = apply_filters( 'espresso_rule_style_before' , $es_style_array );

			/**
			* Custom style class for [es-hr]
			*
			* add_theme_support('espresso-rule-styles', array( "width" => "2" , "style" => "solid" , "color" => "#cccccc" ));
			*
			* @since 1.0.0 
			* @author Jared Harbour
			*/

			if( current_theme_supports('espresso-rule-styles') ){
				$es_rule_styles = get_theme_support('espresso-rule-styles');
				
				$rule_border = $es_rule_styles[0];

				$es_style_array[] = array(
			        "name" => $option_text['styled_rule_border']['name'],
					"desc" => $option_text['styled_rule_border']['desc'],
					"subtext" => $option_text['styled_rule_border']['subtext'],
			        "id" => "styled_rule_border",
			        "type" => "border",
			        "selector" => ".hr_styled",
			        "style" => "espresso-styled-rule-border",
			        "std" => $rule_border
				);


			}

			//FILTER TO ADD CUSTOM SETTINGS FROM CHILD THEME
			$es_style_array = apply_filters( 'espresso_rule_style_after' , $es_style_array );		
			$es_style_array[] = array( "type" => "close");
			}
			//======================== END H-RULE SECTION
			break;

		case 'widget':
			$es_style_array = apply_filters( 'espresso_add_section_before_widget' , $es_style_array );

			/**
			* ESPRESSO WIDGET STYLES
			*
			* add_theme_support('espresso-widget-styles');
			*
			* This is the area for the custom styled horizontal rule options
			* 
			*
			* @since 1.0.0 
			* @author Jared Harbour
			*/
			if( current_theme_supports('espresso-widget-styles') ){

			$es_style_array[] = array( "name" => "Widget Styles","type" => apply_filters('espresso-widget-section-type',$es_style_global_section_type) );

			$es_style_array = apply_filters( 'espresso_widget_style_before' , $es_style_array );

			/**
			* Custom style class for Espresso Widgets
			*
			* add_theme_support('espresso-widget-settings', array( "width" => "2" , "style" => "solid" , "color" => "#cccccc" ));
			*
			* @since 1.0.0 
			* @author Jared Harbour
			*/

			if( current_theme_supports('espresso-widget-settings') ){
				$es_widget_styles = get_theme_support('espresso-widget-settings');
				
				$widget_title_font_default = $es_widget_styles[0];
				$widget_text_default = $es_widget_styles[1];
				$widget_link_default = $es_widget_styles[2];
				$widget_link_hover_default = $es_widget_styles[3];

				$es_style_array[] = array(
					"name" => $option_text['widget_title_color']['name'],
					"desc" => $option_text['widget_title_color']['desc'],
					"subtext" => $option_text['widget_title_color']['subtext'],
					"multi_selector" => true,
					"id" => "widget_title_color",
					"type" => array(
				     	array(
							"id" => "widget_title",
							"type" => "font_multi",
							"std" => $widget_title_font_default,
							"meta" => "",
							"selector" => ".widget-title, .widget-title a",
							"style"=>'font',
							"label"=> "")
					)
				);

				$es_style_array[] = array(
					"name" => $option_text['widget_text_color']['name'],
					"desc" => $option_text['widget_text_color']['desc'],
					"subtext" => $option_text['widget_text_color']['subtext'],
					"multi_selector" => true,
					"id" => "widget_text_color",
					"type" => array(
				     	array(
							"id" => "widget_text",
							"type" => "font_multi",
							"std" => $widget_text_default,
							"meta" => "",
							"selector" => ".widget-container",
							"style"=>'font',
							"label"=> "")
					)
				);

				$es_style_array[] = array(
					"name" => $option_text['widget_a_color']['name'],
					"desc" => $option_text['widget_a_color']['desc'],
					"subtext" => $option_text['widget_a_color']['subtext'],
					"multi_selector" => true,
					"id" => "widget_a_color",
					"type" => array(
				     	array(
							"id" => "widget_a",
							"type" => "font_multi",
							"std" => $widget_link_default,
							"meta" => "",
							"selector" => ".widget-container a",
							"style"=>'font',
							"label"=> ""),
				    	array(
							"id" => "widget_a_hover",
							"type" => "font_multi",
							"std" => $widget_link_hover_default,
							"selector" => ".widget-container a:hover",
							"style"=>'font',
							"meta" => "",
							"label"=> "Hover:")
					)
				);


			}

			/**
			* Custom style class for Espresso Footer Widgets
			*
			* add_theme_support('espresso-widget-settings', array( "width" => "2" , "style" => "solid" , "color" => "#cccccc" ));
			*
			* @since 1.0.0 
			* @author Jared Harbour
			*/
			if( current_theme_supports('espresso-footer-widget-settings') ){
				$es_footer_widget_styles = get_theme_support('espresso-footer-widget-settings');
				
				$widget_footer_title_font_default = $es_footer_widget_styles[0];
				$widget_footer_text_default = $es_footer_widget_styles[1];
				$widget_footer_link_default = $es_footer_widget_styles[2];
				$widget_footer_link_hover_default = $es_footer_widget_styles[3];

				$es_style_array[] = array(
					"name" => $option_text['footer_widget_title_color']['name'],
					"desc" => $option_text['footer_widget_title_color']['desc'],
					"subtext" => $option_text['footer_widget_title_color']['subtext'],
					"multi_selector" => true,
					"id" => "footer_widget_title_color",
					"type" => array(
				     	array(
							"id" => "footer_widget_title",
							"type" => "font_multi",
							"std" => $widget_footer_title_font_default,
							"meta" => "",
							"selector" => ".widget-title-footer, .widget-title-footer a",
							"style"=>'font',
							"label"=> "")
					)
				);

				$es_style_array[] = array(
					"name" => $option_text['footer_widget_text_color']['name'],
					"desc" => $option_text['footer_widget_text_color']['desc'],
					"subtext" => $option_text['footer_widget_text_color']['subtext'],
					"multi_selector" => true,
					"id" => "footer_widget_text_color",
					"type" => array(
				     	array(
							"id" => "footer_widget_text",
							"type" => "font_multi",
							"std" => $widget_footer_text_default,
							"meta" => "",
							"selector" => ".widget-container-footer",
							"style"=>'font',
							"label"=> "")
					)
				);

				$es_style_array[] = array(
					"name" => $option_text['footer_widget_a_color']['name'],
					"desc" => $option_text['footer_widget_a_color']['desc'],
					"subtext" => $option_text['footer_widget_a_color']['subtext'],
					"multi_selector" => true,
					"id" => "footer_widget_a_color",
					"type" => array(
				     	array(
							"id" => "footer_widget_a",
							"type" => "font_multi",
							"std" => $widget_footer_link_default,
							"meta" => "",
							"selector" => ".widget-container-footer a",
							"style"=>'font',
							"label"=> ""),
				    	array(
							"id" => "footer_widget_a_hover",
							"type" => "font_multi",
							"std" => $widget_footer_link_hover_default,
							"selector" => ".widget-container-footer a:hover",
							"style"=>'font',
							"meta" => "",
							"label"=> "Hover:")
					)
				);


			}

			//FILTER TO ADD CUSTOM SETTINGS FROM CHILD THEME
			$es_style_array = apply_filters( 'espresso_widget_style_after' , $es_style_array );		
			$es_style_array[] = array( "type" => "close");
			}
			//======================== END WIDGET SECTION
			$es_style_array = apply_filters( 'espresso_add_section_after_widget' , $es_style_array );
			break;

		case 'header':
			/**
			* ESPRESSO HEADER STYLES
			*
			* add_theme_support('espresso-header');
			*
			* This is the style area for the default espresso header
			* Includes the logo uploader and H1 widget area settings
			* 
			*
			* @since 1.0.0 
			* @author Josh Lyford
			*/
			if( current_theme_supports('espresso-header') ){

			$es_style_array[] = array( "name" => "Header","type" => apply_filters('espresso-header-section-type',$es_style_global_section_type) );

			$es_style_array = apply_filters( 'espresso_header_style_before' , $es_style_array );

			/**
			* Espresso Custom Logo Styles
			*
			* add_theme_support('espresso-logo', Logo Text, Logo Padding);
			*
			* add_theme_support('espresso-logo', array('size'=>40,'face'=>'verdana','color'=>'#000000') , array('15','15','0','0') );
			*
			* 
			*
			* @since 1.0.0 
			* @author Josh Lyford
			*/
			if( current_theme_supports('espresso-logo') ){

			$es_logo_styles = get_theme_support('espresso-logo');
			$logo_text = $es_logo_styles[0];
			$logo_padding = $es_logo_styles[1];

			$es_style_array['logo_display'] = array( 
				"name" => $option_text['logo_display']['name'],
				"desc" => $option_text['logo_display']['desc'],
				"subtext" => $option_text['logo_display']['subtext'],
				"id" => "logo_display",
				"type" => "radio",
				"std" => "text",
				"no_reset"=>true,
				"selector"=>" #site-title a",
				"style"=>"espresso-logo-image",
				"options"=> array(
					"text" => "Text Only",
					"textimage" => "Text with Uploaded Image to the left",
					"image" => "Uploaded Image Only"
				)
			);

			$es_style_array[] = array(	
					"name" => $option_text['logo_font']['name'],
					"desc" => $option_text['logo_font']['desc'],
					"subtext" => $option_text['logo_font']['subtext'],
					"id" => "logo_font",
					"std" =>$logo_text,
					"type" => "typography",
					"selector" => "#site-title a,#site-title a:hover,#site-title a:visited",
					"style"=>'font'
					
				);


			$es_style_array[] = array(	
				"name" => "Logo Image",		
				"id" => "logo_image",
				"no_reset"=>true,
				"std" => "",
				"type" => "upload"
			);

			$es_style_array[] = array( 
				"name" => $option_text['logo_area_space']['name'],
				"desc" => $option_text['logo_area_space']['desc'],
				"subtext" => $option_text['logo_area_space']['subtext'],
				"id" => "logo_area_space",
				"std" => "",
				"style"=>"padding",
				"selector"=>"#site-title",
				"type" => array( 
					array(  
						'id' => 'top',
						'type' => 'text',
						'std' => $logo_padding[0],
						'meta' => 'px',
						'label'=>'Top: '
						),
					array(
						'id' => 'bottom',
						'type' => 'text',
						'std' => $logo_padding[1],
						'meta' => 'px',
						'label'=>'Bottom: '
							),
					array(  
						'id' => 'left',
						'type' => 'text',
						'std' => $logo_padding[2],
						'meta' => 'px',
						'label'=>'Left: '
						),
					array(  
						'id' => 'right',
						'type' => 'text',
						'std' => $logo_padding[3],
						'meta' => 'px',
						'label'=>'Right: '
						),
				)
			);


			}
			//END ESPRESSO LOGO



			/**
			* Espresso H1 Widget Settings
			*
			* add_theme_support('espresso-h1-widget');
			*
			*
			* @since 1.0.0 
			* @author Josh Lyford
			*/
			if( current_theme_supports('espresso-h1-widget') ){

			$es_h1_widget_styles = get_theme_support('espresso-h1-widget');

			$h1_text_default = $es_h1_widget_styles[0];
			$h1_padding_default = $es_h1_widget_styles[1];

			$es_style_array[] = array( 
				"name" => $option_text['h1_widget_area_space']['name'],
				"desc" => $option_text['h1_widget_area_space']['desc'],
				"subtext" => $option_text['h1_widget_area_space']['subtext'],
				"id" => "h1_widget_area_space",
				"std" => "",
				"style"=>"padding",
				"selector"=>"#branding .xoxo",
				"type" => array( 
					array(  
						'id' => 'top',
						'type' => 'text',
						'std' => $h1_padding_default[0],
						'meta' => 'px',
						'label'=>'Top: '
						),
					array(
						'id' => 'bottom',
						'type' => 'text',
						'std' => $h1_padding_default[1],
						'meta' => 'px',
						'label'=>'Bottom: '
							),
					array(  
						'id' => 'left',
						'type' => 'text',
						'std' => $h1_padding_default[2],
						'meta' => 'px',
						'label'=>'Left: '
						),
					array(  
						'id' => 'right',
						'type' => 'text',
						'std' => $h1_padding_default[3],
						'meta' => 'px',
						'label'=>'Right: '
						),
				)
			);

			if(is_array($h1_text_default)){
				$es_style_array[] = array(
					"name" => $option_text['h1_widget_text_color']['name'],
					"desc" => $option_text['h1_widget_text_color']['desc'],
					"subtext" => $option_text['h1_widget_text_color']['subtext'],
					"multi_selector" => true,
					"id" => "h1_widget_text_color",
					"type" => array(
				     	array(
							"id" => "h1_widget_text",
							"type" => "font_multi",
							"std" => $h1_text_default,
							"meta" => "",
							"selector" => ".widget-container-branding",
							"style"=>'font',
							"label"=> "")
					)
				);
			}



			$es_style_array[] = array( 
				"name" => $option_text['h1_widget_align']['name'],
				"desc" => $option_text['h1_widget_align']['desc'],
				"subtext" => $option_text['h1_widget_align']['subtext'],
				"id" => "h1_widget_align",
				"type" => "radio",
				"std" => "left",
				"no_reset"=>true,
				"selector"=>" #branding .xoxo",
				"style"=>"espresso-alignment-text",
				"options"=> array(
					"left" => "Text to the left ",
					"right" => "Text to the right",
					"center" => "Text in the center"
				)
			);

			}

			$es_style_array = apply_filters( 'espresso_header_style_after' , $es_style_array );

			$es_style_array[] = array( "type" => "close" );
			}
			//============= END ESPRESSO HEADER STYLES
			break;

		case 'menu':
			/**
			* Espresso MENU Styles Simple
			*
			* add_theme_support('espresso-menu');
			*
			*
			* @since 1.0.0 
			* @author Josh Lyford
			*/
			if( current_theme_supports('menu-styles-simple') ){

			$es_style_array[] = array( 
				"name" => "Menu Style Options",
				"type" => apply_filters('espresso-menu-section-type',$es_style_global_section_type)
			);

			$es_style_array[] = array( 	
				"name" => $option_text['menu_bg_color']['name'],
				"desc" => $option_text['menu_bg_color']['desc'],
				"subtext" => $option_text['menu_bg_color']['subtext'],
				"id" => "menu_bg_color",
				"type" => "colorpicker",
				"std" => "#000000",
				"selector" => ".espresso-menu,.espresso-menu li,.espresso-menu li li,.espresso-menu li li li",
				"style"=> "background-color"
				);

			$es_style_array[] = array( 	
				"name" => $option_text['menu_bg_hover_color']['name'],
				"desc" => $option_text['menu_bg_hover_color']['desc'],
				"subtext" => $option_text['menu_bg_hover_color']['subtext'],
				"id" => "menu_bg_hover_color",
				"type" => "colorpicker",
				"std" => "#333333",
				"selector" => ".espresso-menu .li-level-1.current-menu-item,.espresso-menu .li-level-1.current-menu-ancestor,.espresso-menu li:hover,.espresso-menu li.sfHover",
				"style"=> "background-color"
				);	

			$es_style_array[] = array(	
				"name" => $option_text['menu_font']['name'],
				"desc" => $option_text['menu_font']['desc'],
				"subtext" => $option_text['menu_font']['subtext'],
				"id" => "menu_font",
				"std" =>array('size'=>12,'face'=>'Use Theme Font','style'=>'normal'),
				"type" => "typography",
				"selector" => ".espresso-menu a",
				"style"=>'font'
			);

			//Color Picker
			$es_style_array[] = array(
				"name" => $option_text['menu_text_page_color']['name'],
				"desc" => $option_text['menu_text_page_color']['desc'],
				"subtext" => $option_text['menu_text_page_color']['subtext'],
				"multi_selector" => true,
				"id" => "menu_text_page_color",
				"type" => array(
					
					array(
						"id" => "menu_text",
						"type" => "font_multi",
						"std" => array('color'=>"#333333"),
						"meta" => "",
						"selector" => ".espresso-menu a,.espresso-menu a:visited",
						"style"=>'font',
						"label"=> "Text Color:"),
					array(
						"id" => "menu_text_hover",
						"type" => "font_multi",
						"std" => array('color'=>"#FFFFFF"),
						"meta" => "",
						"selector" => ".espresso-menu a:hover,.espresso-menu li.sfHover a.a-level-1,.espresso-menu .li-level-1.current-menu-item .a-level-1,.espresso-menu .li-level-1.current-menu-ancestor .a-level-1",
						"style"=>'font',
						"label"=> "Text Hover:"),
			)	
			);
				
			$es_style_array[] = array( "type" => "close" );
			}
			//==== END MENU STYLES
			break;

		case 'content':
			/**
			* Espresso Content Settings
			*
			* add_theme_support('espresso-content');
			*
			*
			* @since 1.0.0 
			* @author Josh Lyford
			*/
			if( current_theme_supports('espresso-content') ){
				
				$es_style_array[] = array( "name" => "Content","type" => apply_filters('espresso-content-section-type',$es_style_global_section_type) );

				$es_style_array = apply_filters( 'espresso_content_style_before' , $es_style_array );

				$es_style_array[] = array( 
					"name" => $option_text['post_excerpt']['name'],
					"desc" => $option_text['post_excerpt']['desc'],
					"subtext" => $option_text['post_excerpt']['subtext'],
					"id" => "post_excerpt",
					"type" => "radio",
					"no_reset"=>true,
					"std"=>"excerpt",
					"options" => array(
						"content" => "Show Full Content", 
						"excerpt" => "Show the Excerpt") 
				);
				$es_style_array[] = array( 
					"name" => $option_text['post_page_comments']['name'],
					"desc" => $option_text['post_page_comments']['desc'],
					"subtext" => $option_text['post_page_comments']['subtext'],
					"id" => "post_page_comments",
					"type" => "radio",
					"no_reset"=>true,
					"std"=>"post",
					"options" => array(
						"post" => "Allow comments on posts only", 
						"page" => "Allow comments on pages only", 
						"both" => "Allow comments on pages and posts", 
						"none" => "Don't allow any comments") 
					);
					
				$es_style_array[] = array( 
					"name" => "Hide Post Meta Information",
					"desc" => "Post Meta information includes the date the article was posted, the post authors name, tags, categories, and comments.",
					"id" => "hide_meta_info",
					"type" => "checkbox",
					"std" => "",
					"cbtext"=> ""
				);

				$es_style_array = apply_filters( 'espresso_content_style_after' , $es_style_array );	

				$es_style_array[] = array( "type" => "close" );
			}
			break;

		case 'custom-css':
			/**
			* Espresso Custom CSS
			*
			* add_theme_support('espresso-custom-css');
			*
			*
			* @since 1.0.0 
			* @author Josh Lyford
			*/
			if(current_theme_supports('espresso-custom-css')){

				$es_style_array[] = array( "name" => "Custom CSS","type" => apply_filters('espresso-custom-css-section-type',$es_style_global_section_type) );
				$es_style_array = apply_filters( 'espresso_custom_css_style_before' , $es_style_array );	

				$loadEspressoCSS = true;
				if ( is_plugin_active('jetpack/jetpack.php')) {

					$active_modules = Jetpack::get_active_modules();
					//print_r($active_modules);

					if( in_array('custom-css', $active_modules) ){
						$loadEspressoCSS = false;

					}

					$es_style_array[] = array("desc" => 'It looks like you have Jetpack enabled on your blog.  If you want to add some custom CSS check out the <a href="'.site_url('wp-admin/themes.php?page=editcss').'">Custom CSS</a> page.',
						"type" => "section_description"
					);

				}

				if( $loadEspressoCSS ){

					$es_style_array[] = array(
						"name" => $option_text['custom_css']['name'],
						"desc" => $option_text['custom_css']['desc'],
						"subtext" => $option_text['custom_css']['subtext'],
						"id" => "custom_css",
						"type" => "textarea",
						"no_reset"=>true,
						"std" => ""
						);

				}

				$es_style_array = apply_filters( 'espresso_custom_css_style_after' , $es_style_array );
				$es_style_array[] = array( "type" => "close" );
			}
			break;

	}

}



					
//Filter to add Child Theme Style Options
$es_style_array = apply_filters('espresso_options_style_after',$es_style_array);

//Register Options With EspressoKit
$es_style_options->register_options($es_style_array);

/**
* Add Theme Styles to Admin Menu Bar
*
* 
* @since 1.0.0 
* @author Josh Lyford
*/
function espresso_admin_bar_render_option() {
	global $wp_admin_bar, $espresso_framework;
	$page = $espresso_framework->get_option_basename().'-options';
	$wp_admin_bar->add_menu( 
		array(
			'parent' => 'appearance', // use 'false' for a root menu, or pass the ID of the parent menu
			'id' => 'theme_options', // link ID, defaults to a sanitized title value
			'title' => __( apply_filters('espresso-theme-styles-menu-title','Theme Styles') ), // link title
			'href' => admin_url( 'themes.php' ).'?page='.$page, // name of file
			'meta' => false 
		)
	);
}
//ADD FILTER FOR FUNCTION ABOVE
add_action( 'wp_before_admin_bar_render', 'espresso_admin_bar_render_option' );
	

/**
* Add Custom CSS hooks to EspressoKit via themekitforwp_css_engine_{option name} filter
*
* @return string
* @since 1.0.0
* @author Josh Lyford
**/
function espresso_css_engine($reg_option, $saved){
	$styles = '';

	switch( $reg_option['style'] ) {
		case 'espresso-alignment-text':
			$styles .= ' text-align: '.$saved[ $reg_option[ "id" ]].';';
		
		break;
		case 'espresso-logo-image':
			if ($saved[ $reg_option[ "id" ]] =="image" ){
					if(isset($saved['logo_image'])){
					$logo = wp_get_attachment_image_src($saved['logo_image'],'full');
						if(false !== $logo){
							$styles.= "background: transparent url(".$logo[0].") top left no-repeat;";
							$styles.=  "text-indent: -9999px; display: block; width:".$logo[1]."px; height:".$logo[2]."px;";
						}
					}
			}
			if ($saved[ $reg_option[ "id" ]] =="textimage" ){
				if(isset($saved['logo_image'])){
					$logo = wp_get_attachment_image_src($saved['logo_image'],'full');
					if(false !== $logo){
							$styles.=  "background: transparent url(".$logo[0].") top left no-repeat;";
							$styles.=  "display: block; padding-left: ".( $logo[1] + 10) ."px; line-height: ".$logo[2]."px; height: ".$logo[2]."px;";
					}
				}
			}
		break;
		case 'espresso-styled-box-border':
			$styles .= 'border: '.$saved[ $reg_option[ "id" ] ]['color'].' '.$saved[ $reg_option[ "id" ] ]['style'].' '.$saved[ $reg_option[ "id" ] ]['width'].'px;';
		break;
		case 'espresso-styled-rule-border':
			$styles .= 'border-bottom: '.$saved[ $reg_option[ "id" ] ]['color'].' '.$saved[ $reg_option[ "id" ] ]['style'].' '.$saved[ $reg_option[ "id" ] ]['width'].'px;';
		break;
	}
	$filter = apply_filters('espresso_options_css', $reg_option, $saved );
	if(is_string( $filter )){
		$styles .= $filter;				
	}
	
	return $styles;
}
//ADD FILTER FOR FUNCTION ABOVE
add_filter("themekitforwp_css_engine_$es_style_option_name",'espresso_css_engine', 10, 2);
