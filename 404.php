<?php 
/**
* The template for displaying 404 pages (Not Found).
*
* @package WordPress
* @subpackage Espresso
*/
get_template_part('espresso-template-before'); ?>

<article id="post-0" class="post error404 not-found">
	<header class="entry-header">
		<h1 class="entry-title"><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'espresso' ); ?></h1>
	</header>

	<div class="entry-content">
		<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.', 'espresso' ); ?></p>

		<?php get_search_form(); ?>

	
	</div><!-- .entry-content -->
</article><!-- #post-0 -->

<?php get_template_part('espresso-template-after'); ?>