<?php
/**
 * Bean Name: Excerpt Filters
 * Bean Description: Filter Settings for WordPress Excerpt
 */



/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 */
if(current_theme_supports('espresso-filters-excerpt')){	
	function espresso_excerpt_length( $length ) {
		return 40;
	}
	add_filter( 'excerpt_length', 'espresso_excerpt_length' );

	/**
	 * Returns a "Continue Reading" link for excerpts
	 *
	 */
	function espresso_continue_reading_link() {
		return apply_filters( 'espresso_excerpt_more_link', ' <a href="'. get_permalink() . '">' . __( 'Read More', 'espresso' ) . '</a>');
	}

	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and espresso_continue_reading_link().
	 *
	 * To override this in a child theme, remove the filter and add your own
	 * function tied to the excerpt_more filter hook.
	 *
	 */
	function espresso_auto_excerpt_more( $more ) {
		return ' &hellip;' . espresso_continue_reading_link();
	}
	add_filter( 'excerpt_more', 'espresso_auto_excerpt_more' );

	/**
	 * Adds a pretty "Continue Reading" link to custom post excerpts.
	 *
	 * To override this link in a child theme, remove the filter and add your own
	 * function tied to the get_the_excerpt filter hook.
	 *
	 */
	function espresso_custom_excerpt_more( $output ) {
		if ( has_excerpt() && ! is_attachment() ) {
			$output .= espresso_continue_reading_link();
		}
		return $output;
	}
	add_filter( 'get_the_excerpt', 'espresso_custom_excerpt_more' );
}