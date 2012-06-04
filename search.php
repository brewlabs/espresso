<?php 
/**
* The main template file.
*
* @package WordPress
* @subpackage Espresso
*/
get_template_part('espresso-template-before'); ?>

<?php /* Start the Loop */ ?>
<?php while ( have_posts() ) : the_post(); ?>
	
	<?php get_template_part( 'content', get_post_format() ); ?>
	
<?php endwhile; ?>
<br>
<?php get_template_part( 'menu', 'pagelinks'); ?>
<?php get_template_part('espresso-template-after'); ?>