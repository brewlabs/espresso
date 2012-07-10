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
		<h1 class="page-title author"><?php printf( __( 'Author Archives: %s', 'espresso' ), '<span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( "ID" ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h1>
	</header>

	<?php
		/* Since we called the_post() above, we need to
		 * rewind the loop back to the beginning that way
		 * we can run the loop properly, in full.
		 */
		rewind_posts();
	?>
	<?php
	// If a user has filled out their description, show a bio on their entries.
	if ( get_the_author_meta( 'description' ) ) : ?>
	<div id="author-info">
		<div id="author-avatar">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'espresso_author_bio_avatar_size', 60 ) ); ?>
		</div><!-- #author-avatar -->
		<div id="author-description">
			<h2><?php printf( __( 'About %s', 'espresso' ), get_the_author() ); ?></h2>
			<?php the_author_meta( 'description' ); ?>
		</div><!-- #author-description	-->
	</div><!-- #entry-author-info -->
	<?php endif; ?>

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