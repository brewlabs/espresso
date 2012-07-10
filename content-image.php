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
<?php 
	$args = array( 'post_type' => 'attachment', 'numberposts' => -1,'post_mime_type' => 'image', 'post_status' => null, 'post_parent' => get_the_ID() ); 
	$attachments = get_posts($args);
?>
<header class="entry-header">
	<?php if ( is_single() ) { ?>
		<h2 class="entry-title"><?php the_title(); ?></h2>
	<?php } else { ?>
		<h1 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
	<?php } ?>
	<?php get_template_part('meta-header', get_post_format() )?>
</header><!-- .entry-header -->
<div class="entry-content">
	<?php 
	if($attachments){
		/*
		foreach($attachments as $item){
	    	$img = wp_get_attachment_image_src($item->ID, 'medium');
        	$large_img = wp_get_attachment_image_src($item->ID, 'large');
	    	?>
	    	<div class="post-type-image"><img src="<?php echo $img[0]; ?>" rel="#wp-image-<?php echo $item->ID; ?>"/></div>
	    	<div style="width:<?php echo $large_img[1]; ?>px; height:<?php echo $large_img[2]; ?>px;" class="simple_overlay black" id="wp-image-<?php echo $item->ID; ?>">
	  			<img src="<?php echo $large_img[0]; ?>"/>
	    	</div>
	    	<?php
	    }
	    */
	    the_content();
	}else{
		echo 'this is for the link image...';
		the_content();
	}
	?>
</div>
<?php get_template_part('meta', get_post_format() ); ?>
</article>