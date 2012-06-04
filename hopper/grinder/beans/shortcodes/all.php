<?php 

/* The following code was written exclusively for MOJO-Themes.com
   Use at your own discretion and free will.
   Author: Brady Nord ( www.bradynord.com, @bradynord )
   Version: 1.0 - 11/18/2010
      

/* ----------------------------------------------------------------- */
/* ---------------------- Boxes No Icons --------------------------- */
/* ----------------------------------------------------------------- */

add_filter('widget_text', 'do_shortcode');

/* ------- Boxes - Alert ( Yellow ) --------*/
function alertbox($atts, $content=null, $code="") {  
	
	$return = '<div class="alert">';
	
	$return .= espresso_remove_wpautop($content);
	
	$return .= '</div>';
	
	return $return;

}


add_shortcode('alert' , 'alertbox' );

/* ------- Boxes - News ( Grey ) --------*/

function newsbox($atts, $content=null, $code="") {  

	$return = '<div class="news">';
	
	$return .= espresso_remove_wpautop($content);
	
	$return .= '</div>';
	
	return $return;

}

add_shortcode('news' , 'newsbox' );


/* ------- Boxes - Info ( Blue ) --------*/

function infobox($atts, $content=null, $code="") {  

	$return = '<div class="info">';
	
	$return .= espresso_remove_wpautop($content);
	
	$return .= '</div>';
	
	return $return;

}

add_shortcode('info' , 'infobox' );


/* ------- Boxes - Warning ( Red ) --------*/

function warningbox($atts, $content=null, $code="") {  

	$return = '<div class="warning">';
	
	$return .= espresso_remove_wpautop($content);
	
	$return .= '</div>';
	
	return $return;

}

add_shortcode('warning' , 'warningbox' );


/* ------- Boxes - Download ( Green ) --------*/

function downloadbox($atts, $content=null, $code="") {  

	$return = '<div class="download">';
	
	$return .= espresso_remove_wpautop($content);
	
	$return .= '</div>';
	
	return $return;

}

add_shortcode('download' , 'downloadbox' );



/* ----------------------------------------------------------------- */
/* ------------------------- Drop Caps ----------------------------- */
/* ----------------------------------------------------------------- */

/* ------- Drop Cap Small --------*/

function dropcap($atts, $content=null, $code="") {  

	$return = '<div class="dropcap-small">';
	
	$return .= espresso_remove_wpautop($content);
	
	$return .= '</div>';
	
	return $return;

}

add_shortcode('dropcap-small' , 'dropcap' );

/* ------- Drop Cap Large --------*/

function dropcap2($atts, $content=null, $code="") {  

	$return = '<div class="dropcap-big">';
	
	$return .= espresso_remove_wpautop($content);
	
	$return .= '</div>';
	
	return $return;

}

add_shortcode('dropcap-big' , 'dropcap2' );




/* ----------------------------------------------------------------- */
/* ------------------------ Sticky Notes --------------------------- */
/* ----------------------------------------------------------------- */

/* ------- Sticky Note Left Aligned --------*/

function stickyleft($atts, $content=null, $code="") {  

	$return = '<div class="stickyleft">';
	
	$return .= espresso_remove_wpautop($content);
	
	$return .= '</div>'; 
	
	return $return;

}

add_shortcode('stickyleft' , 'stickyleft' );


/* ------- Sticky Note Right Aligned --------*/

function stickyright($atts, $content=null, $code="") {  

	$return = '<div class="stickyright">';
	
	$return .= espresso_remove_wpautop($content);
	
	$return .= '</div>';
	
	return $return;

}

add_shortcode('stickyright' , 'stickyright' );





















/* ----------------------------------------------------------------- */
/* -------------------------- Columns ------------------------------ */
/* ----------------------------------------------------------------- */


/* ------- 1/2 --------*/

function one_half( $atts, $content = null ) {
   
   return '<div class="one_half">' . espresso_remove_wpautop($content) . '</div>';

}

add_shortcode('one_half', 'one_half');

function one_half_last( $atts, $content = null ) {
   
   return '<div class="one_half last">' . espresso_remove_wpautop($content) . '</div>
   
   <div class="clearboth"></div>';

}

add_shortcode('one_half_last', 'one_half_last');


/* ------- 1/3 --------*/

function one_third( $atts, $content = null ) {
   
   return '<div class="one_third">' . espresso_remove_wpautop($content) . '</div>';

}

add_shortcode('one_third', 'one_third');

function one_third_last( $atts, $content = null ) {
   
   return '<div class="one_third last">' . espresso_remove_wpautop($content) . '</div>
   
   <div class="clearboth"></div>';

}

add_shortcode('one_third_last', 'one_third_last');


/* ------- 1/4 --------*/

function one_fourth( $atts, $content = null ) {
   
   return '<div class="one_fourth">' . espresso_remove_wpautop($content) . '</div>';

}

add_shortcode('one_fourth', 'one_fourth');

function one_fourth_last( $atts, $content = null ) {
   
   return '<div class="one_fourth last">' . espresso_remove_wpautop($content) . '</div>
   
   <div class="clearboth"></div>';

}
add_shortcode('one_fourth_last', 'one_fourth_last');