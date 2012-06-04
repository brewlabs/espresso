<?php if( current_theme_supports('espresso-meta-information') ): ?>

<footer class="entry-meta">
    <?php the_tags('Tags: ', ', ', '<br />'); ?>
    Posted in <?php the_category(', ') ?> | 
    <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
	<?php edit_post_link('Edit','<br>',' this page or post.'); ?>
	<?php if (is_single() ) : ?>
		<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries ?>
		<div id="author-info">
			<div id="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyeleven_author_bio_avatar_size', 68 ) ); ?>
			</div><!-- #author-avatar -->
			<div id="author-description">
				<h2><?php printf( esc_attr__( 'About %s', 'twentyeleven' ), get_the_author() ); ?></h2>
				<?php the_author_meta( 'description' ); ?>
				<div id="author-link">
					<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
						<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'twentyeleven' ), get_the_author() ); ?>
					</a>
				</div><!-- #author-link	-->
			</div><!-- #author-description -->
		</div><!-- #entry-author-info -->
		<?php endif; ?>
	<?php endif?>
</footer>

<?php endif?>