<?php
/**
* 	WARNING: This file is part of the Espresso framework. DO NOT edit
* 	this file under any circumstances. Please do all modifications
* 	in the form of a child theme. 
*
*	ONLY OVERRIDE IF ABSOLUTELY NECESSARY :)
*/
if(function_exists('wp_pagenavi')){
	wp_pagenavi();
} else{ 
	espresso_pagenavi();
}

