<?php 
/**
* 	WARNING: This file is part of the Espresso framework. DO NOT edit
* 	this file under any circumstances. Please do all modifications
* 	in the form of a child theme. 
*
*	create loop.php in your child theme
*/
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<?php 
			$format = get_post_format();
			if ( false === $format )
				$format = 'standard';
		
			get_template_part( 'format', $format );
			get_template_part( 'meta-post', $format );
			?>

		</article>
<?php endwhile; ?>
<?php  get_template_part( 'menu', 'pagelinks' );?>
<?php else : ?>
	<h2>Not Found</h2>
<?php endif; ?>