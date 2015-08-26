<?php
/**
* 	WARNING: This file is part of the Espresso framework. DO NOT edit
* 	this file under any circumstances. Please do all modifications
* 	in the form of a child theme. 
*
*	ONLY OVERRIDE IF ABSOLUTELY NECESSARY :)
*/
?><!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie ie6 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<!-- the "no-js" class is for Modernizr. -->
<head id="espresso-framework" data-template-set="html5-espresso-framework" >

	<meta charset="<?php bloginfo('charset'); ?>">
	
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<meta name="viewport" content="width=device-width">
	
	<?php if (is_search()) { ?>
	<meta name="robots" content="noindex, nofollow" /> 
	<?php } ?>

	<title><?php
		if( defined('WPSEO_VERSION') ){
			wp_title( '' );
		} else{
			/*
		 	* Print the <title> tag based on what is being viewed.
		 	*/
			global $page, $paged;

			wp_title( '|', true, 'right' );

			// Add the blog name.
			bloginfo( 'name' );

			// Add the blog description for the home/front page.
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";

			// Add a page number if necessary:
			if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'espresso' ), max( $paged, $page ) );
		}
		?></title>
	
	<!--  Mobile Viewport meta tag
	j.mp/mobileviewport & davidbcalhoun.com/2010/viewport-metatag 
	device-width : Occupy full width of the screen in its current orientation
	initial-scale = 1.0 retains dimensions instead of zooming out if page height > device height
	maximum-scale = 1.0 retains dimensions instead of zooming in if page width < device width -->
	<!-- Uncomment to use use thoughtfully!
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
	-->
	
	<link rel="shortcut icon" href="<?php echo CHILD_URL; ?>/images/favicon.ico">
	<!-- This is the traditional favicon.
		 - size: 16x16 or 32x32
		 - transparency is OK
		 - see wikipedia for info on browser support: http://mky.be/favicon/ -->
	<?php  if( current_theme_supports('espresso-touch-icon') ) { ?>
	<link rel="apple-touch-icon" href="<?php echo CHILD_URL; ?>/images/apple-touch-icon.png">
	<!-- The is the icon for iOS's Web Clip.
		 - size: 57x57 for older iPhones, 72x72 for iPads, 114x114 for iPhone4's retina display (IMHO, just go ahead and use the biggest one)
		 - To prevent iOS from applying its styles to the icon name it thusly: apple-touch-icon-precomposed.png
		 - Transparency is not recommended (iOS will put a black BG behind the icon) -->
	
	<!-- CSS: screen, mobile & print are all in the same file -->
	<?php } ?>
	<?php 
	if( !current_theme_supports('responsive-design') ){
		$grid = apply_filters('espresso_grid','960');
		if(!isset($grid)){$grid = 960;}

		$url = PARENT_URL.'/hopper/css/'.$grid.'.min.css';
		echo "<link id='es_grid_css' class='{$grid}' rel='stylesheet' href='{$url}'>";
		if($grid === 'fluid'){
			echo '<script>var fluid_css = true;</script>';
		}
	}
	
	?>

	
	
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
	
	<!-- all our JS is at the bottom of the page, except for Modernizr. -->
	<script src="<?php echo get_template_directory_uri(); ?>/hopper/js/modernizr-1.7.min.js"></script>
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

	<?php wp_head(); 
		if(current_theme_supports('espresso-custom-css')){
			global $espresso_theme_options;
			$custom_css = isset($espresso_theme_options['custom_css']) ? $espresso_theme_options['custom_css'] : '' ;
			if(!empty($custom_css) ){
				echo"<!-- CUSTOM CSS --><style>$custom_css</style><!-- CUSTOM CSS -->";
			}
		}
	?>
</head>
<body <?php body_class(); ?>>