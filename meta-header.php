<?php if( current_theme_supports('espresso-meta-information') ): ?>

<div class="entry-meta">
<?php
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s" pubdate>%3$s</time></a> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%4$s" title="%5$s">%6$s</a></span>', 'espresso' ),
		get_permalink(),
		get_the_date( 'c' ),
		get_the_date(),
		get_author_posts_url( get_the_author_meta( 'ID' ) ),
		sprintf( esc_attr__( 'View all posts by %s', 'espresso' ), get_the_author() ),
		get_the_author()
	);
?>
</div><!-- .entry-meta -->

<?php endif?>
