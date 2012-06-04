<?php 
/**
* 	WARNING: This file is part of the Espresso framework. DO NOT edit
* 	this file under any circumstances. Please do all modifications
* 	in the form of a child theme. 
*
*	create header-content.php in your child theme
*
*	If you overwrite this file make sure you either copy the code below into your new file or use the filter 'espresso_header_layout_options' to remove these area's
*/
$header_layouts  = explode("-", espresso_header_layout() );
?>
<section id="logo-branding" class="clearfix logo_branding">
<?php
/*
*
*	Espresso Logo Area - logo
*	
*/
if( in_array("logo" , $header_layouts) ) {  ?>
	<section id="logo" <?php espresso_header_classes("logo"); ?> >
		<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'h4'; ?>
		<?php echo "<$heading_tag id='site-title' >"; ?>
		<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		<?php echo "</$heading_tag>"; ?>
	</section> <!-- END #logo -->
<?php } ?>

<?php
/*
*
*	Espresso Branding Widget Area - branding
*
*/
if( in_array("branding" , $header_layouts) ) { ?>
<section id="branding" <?php espresso_header_classes("branding"); ?> >
	<ul  class="xoxo h1-widget" >
    	<?php if (! dynamic_sidebar( 'branding-widget-area' ) ): ?>
			<li>&nbsp;</li>
    	<?php endif; ?>
	</ul>
</section><!-- END #branding -->
<?php } ?>

<?php 
/*
*
*	Espresso Branding Widget Area - branding2
*
*/
if( in_array("branding2" , $header_layouts) ) { ?>
<section id="branding2" <?php espresso_header_classes("branding2"); ?> >
	<ul  class="xoxo" >
    	<?php if (! dynamic_sidebar( 'branding2-widget-area' ) ): ?>
			<li>&nbsp;</li>
    	<?php endif; ?>
	</ul>
</section><!-- END #branding2 -->
<?php } ?>

</section><!-- END #logo-branding .logo_branding -->