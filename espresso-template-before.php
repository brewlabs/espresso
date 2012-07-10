<?php get_header(); ?>
<!-- template-before-header loads here --> 
<?php get_template_part('template','before-header'); ?>
<?php
$espresso_header_layout = espresso_header_layout();
if( $espresso_header_layout !== 'none' ) { ?>
	<header id="header">
		<div id="header-container" <?php espresso_header_container(); ?> > 
			<div id="header-wrap-outer" class="header_wrap_outer clearfix">
				<div id="header-wrap" class="header_wrap clearfix">
					<?php get_template_part('headerarea','before'); ?><!-- headerarea-before loads here -->
					<?php espresso_load_menu( 'header-top' ); ?><!-- nav-header-top -->
					<?php get_template_part( 'header', 'content' ); ?>
					<?php espresso_load_menu( 'header-bottom' ); ?><!-- nav-header-bottom -->
					<?php get_template_part('headerarea','after'); ?><!-- headerarea-after loads here -->
				</div><!-- END #header-wrap .header_warp -->
			</div><!-- END #header-wrap-outer .header_wrap_outer -->
		</div><!-- END #header-container .header_container -->
	</header><!-- END #header -->
<?php } ?>
<?php espresso_load_menu( 'above-content' ); ?>
<!-- template-before-content loads here --> 
<?php get_template_part('template','before-content'); ?>
<section id="content-area" class="content_area clearfix">
	<div id="ca-container" <?php espresso_content_container(); ?>>
		<div id="ca-wrap-outer" class="ca_wrap_outer clearfix">
			<div id="ca-wrap" class="ca_wrap clearfix">
				<?php get_template_part('contentarea','before'); ?><!-- contentarea-before loads here --> 
				<?php espresso_load_menu( 'content-top' ); ?><!-- nav-content-top --> 
				<div id="content" <?php espresso_content_classes("content"); ?>>
					<div id="content-inner" class="content_inner">
						<?php get_template_part('loop','before'); ?><!-- loop-before loads here --> 
