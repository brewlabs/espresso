<?php 

/* The following code was written exclusively for MOJO-Themes.com
   Use at your own discretion and free will.
   Author: Brady Nord ( www.bradynord.com, @bradynord )
   Version: 1.0 - 11/18/2010
      

/* ----------------------------------------------------------------- */
/* ---------------------- Boxes No Icons --------------------------- */
/* ----------------------------------------------------------------- */

add_filter('widget_text', 'do_shortcode');

/* ------- Boxes - Alert ( Yellow ) --------*/
function alertbox($atts, $content=null, $code="") {  
	
	$return = '<div class="alert">';
	
	$return .= espresso_remove_wpautop($content);
	
	$return .= '</div>';
	
	return $return;

}


add_shortcode('alert' , 'alertbox' );

/* ------- Boxes - News ( Grey ) --------*/

function newsbox($atts, $content=null, $code="") {  

	$return = '<div class="news">';
	
	$return .= espresso_remove_wpautop($content);
	
	$return .= '</div>';
	
	return $return;

}

add_shortcode('news' , 'newsbox' );


/* ------- Boxes - Info ( Blue ) --------*/

function infobox($atts, $content=null, $code="") {  

	$return = '<div class="info">';
	
	$return .= espresso_remove_wpautop($content);
	
	$return .= '</div>';
	
	return $return;

}

add_shortcode('info' , 'infobox' );


/* ------- Boxes - Warning ( Red ) --------*/

function warningbox($atts, $content=null, $code="") {  

	$return = '<div class="warning">';
	
	$return .= espresso_remove_wpautop($content);
	
	$return .= '</div>';
	
	return $return;

}

add_shortcode('warning' , 'warningbox' );


/* ------- Boxes - Download ( Green ) --------*/

function downloadbox($atts, $content=null, $code="") {  

	$return = '<div class="download">';
	
	$return .= espresso_remove_wpautop($content);
	
	$return .= '</div>';
	
	return $return;

}

add_shortcode('download' , 'downloadbox' );



/* ----------------------------------------------------------------- */
/* ------------------------- Drop Caps ----------------------------- */
/* ----------------------------------------------------------------- */

/* ------- Drop Cap Small --------*/

function dropcap($atts, $content=null, $code="") {  

	$return = '<div class="dropcap-small">';
	
	$return .= espresso_remove_wpautop($content);
	
	$return .= '</div>';
	
	return $return;

}

add_shortcode('dropcap-small' , 'dropcap' );

/* ------- Drop Cap Large --------*/

function dropcap2($atts, $content=null, $code="") {  

	$return = '<div class="dropcap-big">';
	
	$return .= espresso_remove_wpautop($content);
	
	$return .= '</div>';
	
	return $return;

}

add_shortcode('dropcap-big' , 'dropcap2' );




/* ----------------------------------------------------------------- */
/* ------------------------ Sticky Notes --------------------------- */
/* ----------------------------------------------------------------- */

/* ------- Sticky Note Left Aligned --------*/

function stickyleft($atts, $content=null, $code="") {  

	$return = '<div class="stickyleft">';
	
	$return .= espresso_remove_wpautop($content);
	
	$return .= '</div>'; 
	
	return $return;

}

add_shortcode('stickyleft' , 'stickyleft' );


/* ------- Sticky Note Right Aligned --------*/

function stickyright($atts, $content=null, $code="") {  

	$return = '<div class="stickyright">';
	
	$return .= espresso_remove_wpautop($content);
	
	$return .= '</div>';
	
	return $return;

}

add_shortcode('stickyright' , 'stickyright' );





















/* ----------------------------------------------------------------- */
/* -------------------------- Columns ------------------------------ */
/* ----------------------------------------------------------------- */


/* ------- 1/2 --------*/

function one_half( $atts, $content = null ) {
   
   return '<div class="one_half">' . espresso_remove_wpautop($content) . '</div>';

}

add_shortcode('one_half', 'one_half');

function one_half_last( $atts, $content = null ) {
   
   return '<div class="one_half last">' . espresso_remove_wpautop($content) . '</div>
   
   <div class="clearboth"></div>';

}

add_shortcode('one_half_last', 'one_half_last');


/* ------- 1/3 --------*/

function one_third( $atts, $content = null ) {
   
   return '<div class="one_third">' . espresso_remove_wpautop($content) . '</div>';

}

add_shortcode('one_third', 'one_third');

function one_third_last( $atts, $content = null ) {
   
   return '<div class="one_third last">' . espresso_remove_wpautop($content) . '</div>
   
   <div class="clearboth"></div>';

}

add_shortcode('one_third_last', 'one_third_last');


/* ------- 1/4 --------*/

function one_fourth( $atts, $content = null ) {
   
   return '<div class="one_fourth">' . espresso_remove_wpautop($content) . '</div>';

}

add_shortcode('one_fourth', 'one_fourth');

function one_fourth_last( $atts, $content = null ) {
   
   return '<div class="one_fourth last">' . espresso_remove_wpautop($content) . '</div>
   
   <div class="clearboth"></div>';

}
add_shortcode('one_fourth_last', 'one_fourth_last');

/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Shortcodes
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

add_shortcode( 'post_date', 'genesis_post_date_shortcode' );
/**
 * Produces the date of post publication.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string),
 *   format (date format, default is value in date_format option field),
 *   label (text following 'before' output, but before date).
 *
 * Output passes through 'genesis_post_date_shortcode' filter before returning.
 *
 * @since 1.1.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function genesis_post_date_shortcode( $atts ) {

	$defaults = array(
		'after'  => '',
		'before' => '',
		'format' => get_option( 'date_format' ),
		'label'  => '',
	);

	$atts = shortcode_atts( $defaults, $atts, 'post_date' );

	$display = ( 'relative' === $atts['format'] ) ? genesis_human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' ' . __( 'ago', 'genesis' ) : get_the_time( $atts['format'] );

	$output = sprintf( '<span class="date published time" title="%5$s">%1$s%3$s%4$s%2$s</span> ', $atts['before'], $atts['after'], $atts['label'], $display, get_the_time( 'c' ) );

	return $output;

}

add_shortcode( 'post_time', 'genesis_post_time_shortcode' );
/**
 * Produces the time of post publication.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string),
 *   format (date format, default is value in date_format option field),
 *   label (text following 'before' output, but before date).
 *
 * Output passes through 'genesis_post_time_shortcode' filter before returning.
 *
 * @since 1.1.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function genesis_post_time_shortcode( $atts ) {

	$defaults = array(
		'after'  => '',
		'before' => '',
		'format' => get_option( 'time_format' ),
		'label'  => '',
	);

	$atts = shortcode_atts( $defaults, $atts, 'post_time' );
	$output = sprintf( '<span class="date published time" title="%5$s">%1$s%3$s%4$s%2$s</span> ', $atts['before'], $atts['after'], $atts['label'], get_the_time( $atts['format'] ), get_the_time( 'c' ) );

	return apply_filters( 'genesis_post_time_shortcode', $output, $atts );

}

add_shortcode( 'post_modified_date', 'genesis_post_modified_date_shortcode' );
/**
 * Produce the post last modified date.
 *
 * Supported shortcode attributes are:
 *  * after (output after date, default is empty string),
 *  * before (output before date, default is empty string),
 *  * format (date format, default is value in date_format option field),
 *  * label (text following 'before' output, but before date).
 *
 * Output passes through 'genesis_post_modified_date_shortcode' filter before returning.
 *
 * @since 2.1.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function genesis_post_modified_date_shortcode( $atts ) {

	$defaults = array(
		'after'  => '',
		'before' => '',
		'format' => get_option( 'date_format' ),
		'label'  => '',
	);

	$atts = shortcode_atts( $defaults, $atts, 'post_modified_date' );

	$display = ( 'relative' === $atts['format'] ) ? genesis_human_time_diff( get_the_modified_time( 'U' ), current_time( 'timestamp' ) ) . ' ' . __( 'ago', 'genesis' ) : get_the_modified_time( $atts['format'] );

	
	$output = sprintf( '<span class="date updated time" title="%5$s">%1$s%3$s%4$s%2$s</span> ', $atts['before'], $atts['after'], $atts['label'], $display, get_the_modified_time( 'c' ) );
	

	/**
	 * Change the output of the post_modified_date shortcode.
	 *
	 * @since 2.1.0
	 *
	 * @param string $output Markup containing post last modification date.
	 * @param array $atts {
	 *     Shortcode attributes after mergining with default values.
	 *
	 *     @type string $after Output after date.
	 *     @type string $before Output before date.
	 *     @type string $format Date format, could be 'relative'.
	 *     @type string $label Text following 'before' output, but before date.
	 * }
	 */
	return apply_filters( 'genesis_post_modified_date_shortcode', $output, $atts );

}

add_shortcode( 'post_modified_time', 'genesis_post_modified_time_shortcode' );
/**
 * Produce the post last modified time.
 *
 * Supported shortcode attributes are:
 *  * after (output after time, default is empty string),
 *  * before (output before time, default is empty string),
 *  * format (date format, default is value in date_format option field),
 *  * label (text following 'before' output, but before time).
 *
 * Output passes through 'genesis_post_modified_time_shortcode' filter before returning.
 *
 * @since 2.1.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function genesis_post_modified_time_shortcode( $atts ) {

	$defaults = array(
		'after'  => '',
		'before' => '',
		'format' => get_option( 'time_format' ),
		'label'  => '',
	);

	$atts = shortcode_atts( $defaults, $atts, 'post_modified_time' );

	
	$output = sprintf( '<span class="date updated time" title="%5$s">%1$s%3$s%4$s%2$s</span> ', $atts['before'], $atts['after'], $atts['label'], get_the_modified_time( $atts['format'] ), get_the_modified_time( 'c' ) );
	

	/**
	 * Change the output of the post_modified_time shortcode.
	 *
	 * @since 2.1.0
	 *
	 * @param string $output Markup containing post last modification time.
	 * @param array $atts {
	 *     Shortcode attributes after mergining with default values.
	 *
	 *     @type string $after Output after time.
	 *     @type string $before Output before time.
	 *     @type string $format Date format, could be 'relative'.
	 *     @type string $label Text following 'before' output, but before time.
	 * }
	 */
	return apply_filters( 'genesis_post_modified_time_shortcode', $output, $atts );

}

add_shortcode( 'post_author', 'genesis_post_author_shortcode' );
/**
 * Produces the author of the post (unlinked display name).
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string).
 *
 * Output passes through 'genesis_post_author_shortcode' filter before returning.
 *
 * @since 1.1.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function genesis_post_author_shortcode( $atts ) {

	$defaults = array(
		'after'  => '',
		'before' => '',
	);

	$atts = shortcode_atts( $defaults, $atts, 'post_author' );

	$author = get_the_author();

	$output = sprintf( '<span class="author vcard">%2$s<span class="fn">%1$s</span>%3$s</span>', esc_html( $author ), $atts['before'], $atts['after'] );
	

	return apply_filters( 'genesis_post_author_shortcode', $output, $atts );

}

add_shortcode( 'post_author_link', 'genesis_post_author_link_shortcode' );
/**
 * Produces the author of the post (link to author URL).
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string).
 *
 * Output passes through 'genesis_post_author_link_shortcode' filter before returning.
 *
 * @since 1.1.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function genesis_post_author_link_shortcode( $atts ) {

	$defaults = array(
		'after'    => '',
		'before'   => '',
	);

	$atts = shortcode_atts( $defaults, $atts, 'post_author_link' );

	$url = get_the_author_meta( 'url' );

	//* If no url, use post author shortcode function.
	if ( ! $url )
		return genesis_post_author_shortcode( $atts );

	$author = get_the_author();

	
	$link = '<a href="' . esc_url( $url ) . '" rel="author external">' . esc_html( $author ) . '</a>';
	$output = sprintf( '<span class="author vcard">%2$s<span class="fn">%1$s</span>%3$s</span>', $link, $atts['before'], $atts['after'] );
	

	return apply_filters( 'genesis_post_author_link_shortcode', $output, $atts );

}

add_shortcode( 'post_author_posts_link', 'genesis_post_author_posts_link_shortcode' );
/**
 * Produces the author of the post (link to author archive).
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string).
 *
 * Output passes through 'genesis_post_author_posts_link_shortcode' filter before returning.
 *
 * @since 1.1.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function genesis_post_author_posts_link_shortcode( $atts ) {

	$defaults = array(
		'after'  => '',
		'before' => '',
	);

	$atts = shortcode_atts( $defaults, $atts, 'post_author_posts_link' );

	$author = get_the_author();
	$url    = get_author_posts_url( get_the_author_meta( 'ID' ) );

	
	$link   = sprintf( '<a href="%s" rel="author">%s</a>', esc_url( $url ), esc_html( $author ) );
	$output = sprintf( '<span class="author vcard">%2$s<span class="fn">%1$s</span>%3$s</span>', $link, $atts['before'], $atts['after'] );
	

	return apply_filters( 'genesis_post_author_posts_link_shortcode', $output, $atts );

}

add_shortcode( 'post_comments', 'genesis_post_comments_shortcode' );
/**
 * Produces the link to the current post comments.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string),
 *   hide_if_off (hide link if comments are off, default is 'enabled' (true)),
 *   more (text when there is more than 1 comment, use % character as placeholder
 *     for actual number, default is '% Comments')
 *   one (text when there is exactly one comment, default is '1 Comment'),
 *   zero (text when there are no comments, default is 'Leave a Comment').
 *
 * Output passes through 'genesis_post_comments_shortcode' filter before returning.
 *
 * @since 1.1.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function genesis_post_comments_shortcode( $atts ) {

	$defaults = array(
		'after'       => '',
		'before'      => '',
		'hide_if_off' => 'enabled',
		'more'        => __( '% Comments', 'genesis' ),
		'one'         => __( '1 Comment', 'genesis' ),
		'zero'        => __( 'Leave a Comment', 'genesis' ),
	);
	$atts = shortcode_atts( $defaults, $atts, 'post_comments' );

	if ( ( ! comments_open() ) && 'enabled' === $atts['hide_if_off'] )
		return;

	// Darn you, WordPress!
	ob_start();
	comments_number( $atts['zero'], $atts['one'], $atts['more'] );
	$comments = ob_get_clean();

	$comments = sprintf( '<a href="%s">%s</a>', get_comments_link(), $comments );

	$output = '<span class="entry-comments-link">' . $comments . '</span>';

	return $output;

}

add_shortcode( 'post_tags', 'genesis_post_tags_shortcode' );
/**
 * Produces the tag links list.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is 'Tagged With: '),
 *   sep (separator string between tags, default is ', ').
 *
 * Output passes through 'genesis_post_tags_shortcode' filter before returning.
 *
 * @since 1.1.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function genesis_post_tags_shortcode( $atts ) {

	$defaults = array(
		'after'  => '',
		'before' => __( 'Tagged With: ', 'genesis' ),
		'sep'    => ', ',
	);
	$atts = shortcode_atts( $defaults, $atts, 'post_tags' );

	$tags = get_the_tag_list( $atts['before'], trim( $atts['sep'] ) . ' ', $atts['after'] );

	//* Do nothing if no tags
	if ( ! $tags )
		return;

	
	$output = '<span class="tags">' . $tags . '</span>';

	return apply_filters( 'genesis_post_tags_shortcode', $output, $atts );

}

add_shortcode( 'post_categories', 'genesis_post_categories_shortcode' );
/**
 * Produces the category links list.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is 'Tagged With: '),
 *   sep (separator string between tags, default is ', ').
 *
 * Output passes through 'genesis_post_categories_shortcode' filter before returning.
 *
 * @since 1.1.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function genesis_post_categories_shortcode( $atts ) {

	$defaults = array(
		'sep'    => ', ',
		'before' => __( 'Filed Under: ', 'genesis' ),
		'after'  => '',
	);

	$atts = shortcode_atts( $defaults, $atts, 'post_categories' );

	$cats = get_the_category_list( trim( $atts['sep'] ) . ' ' );

	if ( genesis_html5() )
		$output = sprintf( '<span %s>', genesis_attr( 'entry-categories' ) ) . $atts['before'] . $cats . $atts['after'] . '</span>';
	else
		$output = '<span class="categories">' . $atts['before'] . $cats . $atts['after'] . '</span>';

	return apply_filters( 'genesis_post_categories_shortcode', $output, $atts );

}

add_shortcode( 'post_terms', 'genesis_post_terms_shortcode' );
/**
 * Produces the linked post taxonomy terms list.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is 'Tagged With: '),
 *   sep (separator string between tags, default is ', '),
 *    taxonomy (name of the taxonomy, default is 'category').
 *
 * Output passes through 'genesis_post_terms_shortcode' filter before returning.
 *
 * @since 1.6.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string|boolean Shortcode output or false on failure to retrieve terms
 */
function genesis_post_terms_shortcode( $atts ) {

	$defaults = array(
			'after'    => '',
			'before'   => __( 'Filed Under: ', 'genesis' ),
			'sep'      => ', ',
			'taxonomy' => 'category',
	);

	$atts = shortcode_atts( $defaults, $atts, 'post_terms' );

	$terms = get_the_term_list( get_the_ID(), $atts['taxonomy'], $atts['before'], trim( $atts['sep'] ) . ' ', $atts['after'] );

	if ( is_wp_error( $terms ) )
			return;

	if ( empty( $terms ) )
			return;

	if ( genesis_html5() )
		$output = sprintf( '<span %s>', genesis_attr( 'entry-terms' ) ) . $terms . '</span>';
	else
		$output = '<span class="terms">' . $terms . '</span>';

	return apply_filters( 'genesis_post_terms_shortcode', $output, $terms, $atts );

}

add_shortcode( 'post_edit', 'genesis_post_edit_shortcode' );
/**
 * Produces the edit post link for logged in users.
 *
 * Supported shortcode attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is 'Tagged With: '),
 *   link (link text, default is '(Edit)').
 *
 * Output passes through 'genesis_post_edit_shortcode' filter before returning.
 *
 * @since 1.1.0
 *
 * @param array|string $atts Shortcode attributes. Empty string if no attributes.
 * @return string Shortcode output
 */
function genesis_post_edit_shortcode( $atts ) {

	if ( ! apply_filters( 'genesis_edit_post_link', true ) )
		return;

	$defaults = array(
		'after'  => '',
		'before' => '',
		'link'   => __( '(Edit)', 'genesis' ),
	);

	$atts = shortcode_atts( $defaults, $atts, 'post_edit' );

	//* Darn you, WordPress!
	ob_start();
	edit_post_link( $atts['link'], $atts['before'], $atts['after'] );
	$edit = ob_get_clean();

	$output = $edit;

	return apply_filters( 'genesis_post_edit_shortcode', $output, $atts );

}
