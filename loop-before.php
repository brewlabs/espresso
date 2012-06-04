<?php 
/**
* 	WARNING: This file is part of the Espresso framework. DO NOT edit
* 	this file under any circumstances. Please do all modifications
* 	in the form of a child theme. 
*
*	create loop-before.php in your child theme
*/
//Add support for Yoast Breadcrumbs
if ( function_exists('yoast_breadcrumb') && !is_home() && !is_front_page()) {
	yoast_breadcrumb('<p id="breadcrumbs">','</p>');
}

?>