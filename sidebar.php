<?php
/**
* 	WARNING: This file is part of the Espresso framework. DO NOT edit
* 	this file under any circumstances. Please do all modifications
* 	in the form of a child theme. 
*
*	ONLY OVERRIDE IF ABSOLUTELY NECESSARY :)
*/
$sidebar_layout = explode("-", espresso_content_layout() );
?>
<?php 
if( in_array("sidebar1" , $sidebar_layout) ) { ?>
<aside id="sidebar1" <?php espresso_content_classes("sidebar1"); ?> >
<div id="sidebar1-inner" class="sidebar1_inner">
	<ul id="sidebar1-ul" class="xoxo sidebar1_ul">
	    <?php
	    $sidebars = get_option( 'espresso_primary_sidebar', array(  ) );

		if ( !empty($sidebars) && in_array( $post->ID, $sidebars ) && is_active_sidebar('primary-widget-area-'.$post->ID) ) {
			dynamic_sidebar( 'primary-widget-area-'.$post->ID ); 	
		}else{
			dynamic_sidebar( 'primary-widget-area' );
		}
	    ?>
	</ul>
</div>
</aside>
<?php } ?>
<?php 
if( in_array("sidebar2" , $sidebar_layout) ) { ?>
<aside id="sidebar2" <?php espresso_content_classes("sidebar2"); ?> >
<div id="sidebar2-inner" class="sidebar2_inner">
	<ul id="sidebar2-ul" class="xoxo sidebar2_ul" >
		<?php
	    $sidebars = get_option( 'espresso_secondary_sidebar', array(  ) );

		if ( !empty($sidebars) && in_array( $post->ID, $sidebars ) && is_active_sidebar('secondary-widget-area-'.$post->ID) ) {
			dynamic_sidebar( 'secondary-widget-area-'.$post->ID ); 	
		}else{
			dynamic_sidebar( 'secondary-widget-area' );
		}
	    ?>
	</ul>
</div>
</aside>
<?php } ?>
