<?php
/*
*
*	Espresso Branding Widget Area - branding
*
*/

$footer_layouts  = explode("-", espresso_footer_widget_layouts() );

if(!in_array("none" , $footer_layouts)){
?>
<section id="footer-widgets" <?php espresso_footer_widget_container(); ?> >
	<div id="footer-widgets-wrap-outer" class="footer_widgets_wrap_outer clearfix">
		<div id="footer-widgets-wrap" class="footer_widgets_wrap clearfix">
			<?php 
			if( in_array("footer1" , $footer_layouts) ) { ?>
			<section id="footer1" <?php espresso_footer_widget_classes("footer1"); ?> >
				<ul  class="xoxo" >
			    	<?php if (! dynamic_sidebar( 'footer1-widget-area' ) ): ?>
						<li>&nbsp;</li>
			    	<?php endif; ?>
				</ul>
			</section>
			<?php } ?>

			<?php 
			if( in_array("footer2" , $footer_layouts) ) { ?>
			<section id="footer2" <?php espresso_footer_widget_classes("footer2"); ?> >
				<ul  class="xoxo" >
			    	<?php if (! dynamic_sidebar( 'footer2-widget-area' ) ): ?>
						<li>&nbsp;</li>
			    	<?php endif; ?>
				</ul>
			</section>
			<?php } ?>

			<?php
			if( in_array("footer3" , $footer_layouts) ) { ?>
			<section id="footer3" <?php espresso_footer_widget_classes("footer3"); ?> >
				<ul  class="xoxo" >
			    	<?php if (! dynamic_sidebar( 'footer3-widget-area' ) ): ?>
						<li>&nbsp;</li>
			    	<?php endif; ?>
				</ul>
			</section>
			<?php } ?>

			<?php 
			if( in_array("footer4" , $footer_layouts) ) { ?>
			<section id="footer4" <?php espresso_footer_widget_classes("footer4"); ?> >
				<ul  class="xoxo" >
			    	<?php if (! dynamic_sidebar( 'footer4-widget-area' ) ): ?>
						<li>&nbsp;</li>
			    	<?php endif; ?>
				</ul>
			</section>
			<?php } ?>
		</div>
	</div>
</section>
<?php } ?>