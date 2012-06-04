<?php 
/**
* 	WARNING: This file is part of the Espresso framework. DO NOT edit
* 	this file under any circumstances. Please do all modifications
* 	in the form of a child theme. 
*
*	create content.php or content-{format}.php in your child theme
*/
?>
<?php

get_template_part( 'content', get_post_format() );

if(is_active_sidebar('post-widget-area')){
	echo"<ul id='content-sidebar' class='content_sidebar'>";
	dynamic_sidebar( 'post-widget-area' ); 
	echo "</ul>"; 
}

espresso_comments_template( '', true ); 

?>
	