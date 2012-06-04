<?php 
/**
* 	WARNING: This file is part of the Espresso framework. DO NOT edit
* 	this file under any circumstances. Please do all modifications
* 	in the form of a child theme. 
*
*	create content.php or content-{format}.php in your child theme
*/

global $post;

$page_title =  get_post_meta($post->ID, 'espresso_page_title', true);
$page_content_sidebar =  get_post_meta($post->ID, 'espresso_content_sidebar', true);
$page_widgets_only =  get_post_meta($post->ID, 'espresso_page_widgets_only', true);

if(false == $page_widgets_only){
?>

		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<?php 
			if($page_title !== 'hide' ){    ?>
			<header class="entry-header">
				<?php if ( is_front_page() ) { ?>
					<h2 class="entry-title"><?php the_title(); ?></h2>
				<?php } else { ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php } ?>
			<?php //get_template_part('meta-header', get_post_format() )?>
			</header><!-- .entry-header -->
			<?php } ?>
			

			<div class="entry-content clearfix">
				
				<?php the_content(); ?>

				<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
			

			</div>
			
			<?php 
				get_template_part( 'meta','page' );
			 ?>
		</article>	
	

		<?php espresso_comments_template( '', true ); ?>
		<?php 
	}
		if(is_active_sidebar('content-widget-area-'.$post->ID)){
			echo"<ul id='content-sidebar' class='content_sidebar'>";
			dynamic_sidebar( 'content-widget-area-'.$post->ID ); 
			echo "</ul>"; 
		}
		?>

