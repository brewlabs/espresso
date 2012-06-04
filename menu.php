<?php global $espresso_menu_location; 
if( $espresso_menu_location =="above-content"){
	echo "<section id='menu-$espresso_menu_location' class='menu_$espresso_menu_location'>
		<div id='menu-above-content-container' class='container_16 clearfix'>
			<div id='menu-above-content-wrap-outer' class='menu_above-content_wrap_outer clearfix'>
				<div id='menu-above-content-wrap' class='menu_above-content_wrap clearfix'>
			";
			
}

?>


<nav id="<?php echo "nav-".$espresso_menu_location; ?>" <?php espresso_menu_classes( $espresso_menu_location ); ?> >
	<?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
	<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'espresso' ); ?>"><?php _e( 'Skip to content', 'espresso' ); ?></a></div>
	<?php if(has_nav_menu('primary')) { ?>
	<?php wp_nav_menu( array( 'container_class' => 'espresso-menu clearfix', 'theme_location' => 'primary' ,'menu_class'=>'sf-menu ul-level-1 clearfix','walker'=> new Espresso_Walker_Nav_Menu() ) ); ?>
	<?php } ?>
</nav>

<?php
if( $espresso_menu_location =="above-content"){
	echo "</div></div></div></section>";
}
?>
