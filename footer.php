<?php 
	$f_order = apply_filters('espresso_footer_order',array('widgets','content'));
	foreach($f_order as $item){
		switch($item){
			case 'widgets':
				do_action('espresso_before_footer_widgets');
				get_template_part('footer','widgets');
				get_template_part('footer','widgets-after');
				do_action('espresso_after_footer_widgets');
				break;

			case 'content':
				do_action('espresso_before_footer_content');
				?>
				<div id="footer-container" <?php espresso_footer_container();?>>
					<div id="footer-wrap-outer" class="footer_wrap_outer clearfix">
						<div id="footer-wrap" class="footer_wrap clearfix">
							<?php get_template_part('footer','content'); ?>
						</div>
					</div>
				</div>
				<?php
				do_action('espresso_after_footer_content');
				break;
		}
	}