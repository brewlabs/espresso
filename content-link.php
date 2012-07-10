<?php 
/**
* 	WARNING: This file is part of the Espresso framework. DO NOT edit
* 	this file under any circumstances. Please do all modifications
* 	in the form of a child theme. 
*
*	create content.php or content-{format}.php in your child theme
*/
$the_content = get_the_content();
$regex1 = "/<a[^>]*>/i";
if(!$hasTag = preg_match($regex1,$the_content)){
	$link = $the_content;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php if ( !$hasTag ) { ?>
	<header class="entry-header">
		<h2 class="entry-title"><a href="<?php echo $link; ?>"><?php the_title(); ?></a></h2>
    	<?php get_template_part('meta-header', get_post_format() )?>
	</header>
<?php } else { ?>
	<header class="entry-header">
		<h2 class="entry-title"><?php the_title(); ?></h2>
	    <?php get_template_part('meta-header', get_post_format() )?>
	</header>
	<div class="entry-content">
		<?php the_content();?>
	</div>
<?php } ?>
<?php get_template_part('meta', get_post_format() ); ?>
</article>