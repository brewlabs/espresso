<?php 
/**
* The Template for displaying all single posts.
*
* @package WordPress
* @subpackage Espresso
*/
get_template_part('espresso-template-before'); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php get_template_part( 'content', 'single' );	?>
<?php endwhile; // end of the loop. ?>


<?php get_template_part('espresso-template-after'); ?>