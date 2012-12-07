						<?php get_template_part('loop','after'); ?><!-- loop-after loads here --> 
					</div>
				</div>
				<?php get_sidebar(); ?>
				<?php get_template_part('contentarea','after'); ?><!-- contentarea-after loads here --> 
			</div>
		</div>
	</div>
</section>
	<?php get_template_part( 'template','after-content'); ?><!-- template-after-content loads here --> 
	<footer id="footer">
		<div id="footer-main-wrap-outer" class="footer_main_wrap_outer clearfix">
			<div id="footer-main-wrap" class="footer_main_wrap clearfix">
				<?php get_template_part('footerarea','before'); ?><!-- footerarea-before loads here --> 
				<?php get_footer(); ?>
				<?php get_template_part('footerarea','after'); ?><!-- footerarea-after loads here --> 
			</div>
		</div>
	</footer>
	<?php get_template_part('template','after-footer'); ?><!-- template-after-footer loads here --> 
	<?php wp_footer(); ?>
	<?php
		global $espresso_body_classes;
	?>
	<script>jQuery('body').addClass('<?php echo $espresso_body_classes; ?>');</script>
	</body>
</html>
