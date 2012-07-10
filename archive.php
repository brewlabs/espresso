<?php 
/**
* The template for displaying Archive pages.
*
* @package WordPress
* @subpackage Espresso
*/
get_template_part('espresso-template-before'); ?>
	<?php
		/* Queue the first post, that way we know
		 * what date we're dealing with (if that is the case).
		 *
		 * We reset this later so we can run the loop
		 * properly with a call to rewind_posts().
		 */
		if ( have_posts() )
			the_post();
	?>
	<header class="page-header">
		<h1 class="page-title">
			<?php if ( is_day() ) : ?>
				<?php printf( __( 'Daily Archives: %s', 'espresso' ), '<span>' . get_the_date() . '</span>' ); ?>
			<?php elseif ( is_month() ) : ?>
				<?php printf( __( 'Monthly Archives: %s', 'espresso' ), '<span>' . get_the_date( 'F Y' ) . '</span>' ); ?>
			<?php elseif ( is_year() ) : ?>
				<?php printf( __( 'Yearly Archives: %s', 'espresso' ), '<span>' . get_the_date( 'Y' ) . '</span>' ); ?>
			<?php else : ?>
				<?php _e( 'Blog Archives', 'espresso' ); ?>
			<?php endif; ?>
		</h1>
	</header>
	 <?php echo tag_description(); ?> 
	<?php
		/* Since we called the_post() above, we need to
		 * rewind the loop back to the beginning that way
		 * we can run the loop properly, in full.
		 */
		rewind_posts();
	?>
	<?php /* Start the Loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>

		<?php
			/* Include the Post-Format-specific template for the content.
			 * If you want to overload this in a child theme then include a file
			 * called loop-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'content', get_post_format() );
		?>

	<?php endwhile; ?>

<?php get_template_part('espresso-template-after'); ?>