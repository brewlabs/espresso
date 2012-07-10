<?php 
/**
* 	WARNING: This file is part of the Espresso framework. DO NOT edit
* 	this file under any circumstances. Please do all modifications
* 	in the form of a child theme. 
*
*	create content.php or content-{format}.php in your child theme
*/
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<header class="entry-header">
	<?php if ( is_single() ) { ?>
		<h2 class="entry-title"><?php the_title(); ?></h2>
	<?php } else { ?>
		<h1 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
	<?php } ?>
	<?php get_template_part('meta-header', get_post_format() )?>
</header><!-- .entry-header -->
<div class="entry-content clearfix">
	<?php 
		if( has_post_thumbnail() && !is_single() ){
			
  	    	echo "<div class='post-thumbnail'>"; 
				the_post_thumbnail('featured');
			echo "</div>";
	    }
		if( espresso_show_excerpt() && !is_single() ){
			the_excerpt();
		} else{
			the_content();
		} 
	?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'espresso' ), 'after' => '</div>' ) ); ?>
</div>
<?php get_template_part('meta', get_post_format() ); ?>
</article>
