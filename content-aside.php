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
    <?php get_template_part('meta-header', get_post_format() )?>
</header>
<div class="entry-content">
	<?php 
		if( has_post_thumbnail() && !is_single() ){
			
  	    	echo "<div class='post-thumbnail'>"; 
				the_post_thumbnail('featured');
			echo "</div>";
	    }
	    the_content();
	?>
</div>
<?php get_template_part('meta', get_post_format() ); ?>
</article>