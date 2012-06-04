<?php
/**
 * Bean Name: Shortcode Embeds
 * Bean Description: Easily embed videos and more from sites like YouTube, Vimeo, and SlideShare.
 */

function espresso_load_shortcodes() {
	foreach ( EspressoGrinder::glob_php( dirname( __FILE__ ) . '/shortcodes' ) as $file ) {
		include $file;
	}
}
add_filter('widget_text', 'do_shortcode');
espresso_load_shortcodes();
