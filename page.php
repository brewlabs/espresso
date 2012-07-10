<?php 
/**
* The template for displaying all pages.
*
* @package WordPress
* @subpackage Espresso
*/
get_template_part('espresso-template-before'); ?>

<?php the_post(); ?>

<?php get_template_part( 'content', 'page' ); ?>


<?php get_template_part('espresso-template-after'); ?>