<?php if( current_theme_supports('espresso-meta-information') ): ?>

<footer class="entry-meta">
    <?php the_tags('Tags: ', ', ', '<br />'); ?>
    Posted in <?php the_category(', ') ?> | 
    <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
	<?php edit_post_link('Edit','<br>',' this page or post.'); ?>
</footer>

<?php endif?>