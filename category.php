<?php 
/**
* The category template file.
*
* @package WordPress
* @subpackage Espresso
*/
get_template_part('espresso-template-before'); ?>
<header class="page-header">
	<h1 class="page-title"><?php
		printf( __( 'Archives: %s', 'espresso' ), '<span>' . single_cat_title( '', false ) . '</span>' );
	?></h1>
	<?php $categorydesc = category_description(); if ( ! empty( $categorydesc ) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' ); ?>
</header>
<?php /* Start the Loop */ ?>
<?php while ( have_posts() ) : the_post(); ?>
	
	<?php get_template_part( 'content', get_post_format() ); ?>
	
<?php endwhile; ?>
	<?php get_template_part( 'menu', 'pagelinks'); ?>
<?php get_template_part('espresso-template-after'); ?>