<?php
/**
 * Bean Name: Espresso Functions
 * Bean Description: Espresso Helper Functions
 */

add_action( "get_template_part_menu","espresso_menu_being_loaded",10,2);
function espresso_menu_being_loaded( $slug, $name ){
	global $espresso_menu_template;
	$espresso_menu_template = $name;
}


function espresso_menu_classes( $menu_location ){
	global $espresso_framework;
	$class = $espresso_framework->get_menu_classes($menu_location);
	$class[] = "nav-$menu_location";
	$class = apply_filters("espresso_{$menu_location}_class", $class, $menu_location);
	echo 'class="' . join( ' ', $class ) .'"';
}


function espresso_get_layout_option(){
	global $espresso_framework;
	return apply_filters('espresso_layout_option',$espresso_framework->get_layout_option());
}

function espresso_content_classes( $section ){
	global $espresso_framework;
	$page_layout = espresso_content_layout();
	$class = $espresso_framework->get_content_classes( $page_layout );
	global $post;
	//echo $section . ' - '. $page_layout . ' '.$post->ID . ' ';
	$class = isset( $class[$section] ) ? $class[$section] : array(ESPRESSO_NO_CLASS);
	$class = apply_filters("espresso_{$section}_class", $class, $page_layout);
	// Separates classes with a single space, collates classes for body element
	echo 'class="' . join( ' ', $class ) . '"';
}

function espresso_content_layout($post_id = false){
	global $post;
	$espresso_layout = espresso_get_layout_option();
	$content_layout_filter = apply_filters('espresso_content_layout','');
	if(! empty(	$content_layout_filter )){
		return $content_layout_filter;
	}
	if( is_page() || is_single() ) {
		 if(false !== $post_id || !empty($post)){
		$get_post = false !== $post_id  ? $post_id : $post->ID;
		$current_layout =  get_post_meta($post->ID, 'espresso_content_layout', true);
		}
		
		if(( empty($current_layout) || $current_layout == 'default' ) ){
			return $espresso_layout['content_layout'];
		} else {
			return trim($current_layout);
		}
	}
	
	return $espresso_layout['content_layout']; 
}

function espresso_content_container(){
	global $espresso_framework;
	$page_layout = espresso_content_layout();
	$class = $espresso_framework->get_content_classes( $page_layout );
	if ( isset( $class['container'] ) ) {
		$return_class = $class['container'];
	} else {
		$return_class = array();
		$return_class[] = 'container_16';
	}
	$return_class[] = 'clearfix';
	//$return_class[] = 'content-container';
	echo 'class="' . join( ' ', $return_class ) . '"';
}


function espresso_header_layout(){
	$espresso_layout = espresso_get_layout_option();
	return $espresso_layout['header_layout'];
}

function espresso_footer_widget_layouts(){
	$espresso_layout = espresso_get_layout_option();
	return $espresso_layout['footer_widgets'];
}

function espresso_footer_layouts(){
	$espresso_layout = espresso_get_layout_option();
	return $espresso_layout['footer_layout'];
}

function espresso_header_container(){
	global $espresso_framework;
	$page_layout = espresso_header_layout();
	$class = $espresso_framework->get_header_classes( $page_layout );
	if ( isset( $class['container'] ) ) {
		$return_class = $class['container'];
	} else {
		$return_class = array();
		$return_class[] = 'container_16';
	}
	$return_class[] = 'clearfix';
	$return_class[] = 'header_container';
	echo 'class="' . join( ' ', $return_class ) . '"';
}


function espresso_footer_widget_container(){
	global $espresso_framework;
	$page_layout = espresso_footer_widget_layouts();
	$class = $espresso_framework->get_footer_widget_classes( $page_layout );
	if ( isset( $class['container'] ) ) {
		$return_class = $class['container'];
	} else {
		$return_class = array();
		$return_class[] = 'container_16';
	}
	$return_class[] = 'clearfix';
	$return_class[] = $page_layout;
	//$return_class[] = 'footer-widgets-container';
	echo 'class="' . join( ' ', $return_class ) . '"';
}

function espresso_footer_container(){
	global $espresso_framework;
	$page_layout = espresso_footer_layouts();
	$class = $espresso_framework->get_footer_classes( $page_layout );
	if ( isset( $class['container'] ) ) {
		$return_class = $class['container'];
	} else {
		$return_class = array();
		$return_class[] = 'container_16';
	}
	$return_class[] = 'clearfix';
	//$return_class[] = 'footer-container';
	echo 'class="' . join( ' ', $return_class ) . '"';
}

function espresso_header_classes( $section ){
	global $espresso_framework;
	$header_layout = espresso_header_layout();
	$class = $espresso_framework->get_header_classes( $header_layout );
	$class = isset( $class[$section] ) ? $class[$section] : array(ESPRESSO_NO_CLASS);
	$class[] = $section;
	$class = apply_filters("espresso_{$section}_class", $class, $header_layout);
	// Separates classes with a single space, collates classes for body element
	echo 'class="' . join( ' ', $class ) . '"';
}

function espresso_footer_classes( $section ){
	global $espresso_framework;
	//$header_layout = espresso_footer_layout();
	$class = $espresso_framework->get_footer_classes( 'footer-content' );
	$class = isset( $class[$section] ) ? $class[$section] : array(ESPRESSO_NO_CLASS);
	$class[] = "footer_content";
	$class = apply_filters("espresso_{$section}_class", $class, 'footer-content');
	// Separates classes with a single space, collates classes for body element
	echo 'class="' . join( ' ', $class ) . '"';
}

function espresso_footer_widget_classes( $section ){
	global $espresso_framework;
	$page_layout = espresso_footer_widget_layouts();
	$class = $espresso_framework->get_footer_widget_classes( $page_layout );
	$class = isset( $class[$section] ) ? $class[$section] : array(ESPRESSO_NO_CLASS);
	$class[]="footer_widgets";
	$class = apply_filters("espresso_{$section}_class", $class, $page_layout);
	// Separates classes with a single space, collates classes for body element
	echo 'class="' . join( ' ', $class ) . '"';
}

function espresso_show_excerpt(){
	global $espresso_theme_options;
	if($espresso_theme_options['post_excerpt'] =="excerpt" ){
		return true;
	}
	return false;
}

function espresso_load_menu( $position ){
	global $espresso_framework, $espresso_menu_location;
	if( current_theme_supports('menu-locations')  ){	
		$espresso_layout = $espresso_framework->get_layout_option();
		$espresso_menu_location = $espresso_layout['menu_location'];
		if( $position == $espresso_layout['menu_location'] && isset($espresso_layout['menu_location']) ){
			$espresso_menu_location = $espresso_layout['menu_location'];
			get_template_part('menu', $position );
		}
	}
	if( current_theme_supports('load-menu-location') ){
	$autoload = get_theme_support('load-menu-location');
		if( in_array($position, $autoload[0] ) ){
			$espresso_menu_location = $position;
			get_template_part('menu', $position );
		}
	
	}
	
}


function add_espresso_image_size($display_name, $name, $width, $height, $crop ){
	global $espresso_framework;
	$swidth = get_option("{$name}_size_w");
	if(!$swidth){
		update_option("{$name}_size_w",$width);
		$swidth = $width;
	}
	
	$sheight = get_option("{$name}_size_h");
	if(!$sheight){
		update_option("{$name}_size_h",$height);
		$sheight = $height;
	}
	
	$scrop = get_option("{$name}_crop");
	if(!$scrop){
		update_option("{$name}_crop",$crop);
		$scrop = $crop;
	}
	add_image_size( $name, $swidth, $sheight, $scrop );
	$espresso_framework->add_image_size($display_name, $name, $width, $height, $crop );
}

function espresso_image_sizes() {
	global $_wp_additional_image_sizes;

	if ( $_wp_additional_image_sizes )
		return $_wp_additional_image_sizes;

	return array();
}



function espresso_comments_template( $what, $whatwhat ){
	global $espresso_framework;
	$theme_options = get_option($espresso_framework->get_option_basename().'-options' );
	$comm = $theme_options['post_page_comments']; 
	if ( ($comm == "post" && is_single() || $comm == "page" && is_page() || $comm == "both") ) : 
		comments_template( $what, $whatwhat );
	endif;
};



function espresso_add_body_classes($classes) {
	$background = get_background_image();
	$color = get_background_color();
	if ( ! $background && ! $color )
		$classes[]= 'default-bg';

	if(! is_child_theme() )
		$classes[]= 'espresso';	
	
	return $classes;
}
add_filter('body_class','espresso_add_body_classes');

/**
 * This function loads the admin JS files
 *
 */
add_action('admin_enqueue_scripts', 'espresso_load_admin_scripts');
function espresso_load_admin_scripts() {
	wp_enqueue_script('espresso_js', PARENT_URL.'/hopper/js/admin.js');	
}



/**
* Replace WP autop formatting 
*
* @author Josh Lyford
*/
if (!function_exists( "espresso_remove_wpautop")) {
	function espresso_remove_wpautop($content) { 
		$content = do_shortcode( shortcode_unautop( $content ) ); 
		$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content);
		return $content;
	}
}




/**
 * Espresso page navigation.
 *
 * @param string $pages 
 * @param string $range 
 * @return void
 * @author Josh Lyford
 */
if (!function_exists( "espresso_pagenavi")) {
	function espresso_pagenavi($pages = '', $range = 2)
	{  
	     $showitems = ($range * 2)+1;  

	     global $paged;
	     if(empty($paged)) $paged = 1;

	     if($pages == '')
	     {
	         global $wp_query;
	         $pages = $wp_query->max_num_pages;
	         if(!$pages)
	         {
	             $pages = 1;
	         }
	     }   

	     if(1 != $pages)
	     {
	         echo "<footer class='pagination clearfix'>";
	         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
	         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

	         for ($i=1; $i <= $pages; $i++)
	         {
	             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
	             {
	                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
	             }
	         }

	         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
	         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
	         echo "</footer>\n";
	     }
	}
}


function wp_pagenavi( $args = array() ) {
	echo 'wp_pagenavi';
	if ( !is_array( $args ) ) {
		$argv = func_get_args();
		$args = array();
		foreach ( array( 'before', 'after', 'options' ) as $i => $key )
			$args[ $key ] = $argv[ $i ];
	}

	$args = wp_parse_args( $args, array(
		'before' => '',
		'after' => '',
		'options' => array(),
		'query' => $GLOBALS['wp_query'],
		'type' => 'posts',
		'echo' => true
	) );

	extract( $args, EXTR_SKIP );

	//$options = wp_parse_args( $options, PageNavi_Core::$options->get() );

	$instance = new PageNavi_Call( $args );

	list( $posts_per_page, $paged, $total_pages ) = $instance->get_pagination_args();

	$pages_to_show = 5;
	$larger_page_to_show = 3;
	$larger_page_multiple = 10;
	$pages_to_show_minus_1 = $pages_to_show - 1;
	$half_page_start = floor( $pages_to_show_minus_1/2 );
	$half_page_end = ceil( $pages_to_show_minus_1/2 );
	$start_page = $paged - $half_page_start;

	if ( $start_page <= 0 )
		$start_page = 1;

	$end_page = $paged + $half_page_end;

	if ( ( $end_page - $start_page ) != $pages_to_show_minus_1 )
		$end_page = $start_page + $pages_to_show_minus_1;

	if ( $end_page > $total_pages ) {
		$start_page = $total_pages - $pages_to_show_minus_1;
		$end_page = $total_pages;
	}

	if ( $start_page < 1 )
		$start_page = 1;

	$out = '';
	
			// Text
			// if ( !empty( $options['pages_text'] ) ) {
			// 	$pages_text = str_replace(
			// 		array( "%CURRENT_PAGE%", "%TOTAL_PAGES%" ),
			// 		array( number_format_i18n( $paged ), number_format_i18n( $total_pages ) ),
			// 	$options['pages_text'] );
			// 	$out .= "<span class='pages'>$pages_text</span>";
			// }

			if ( $start_page >= 2 && $pages_to_show < $total_pages ) {
				// First
				$first_text = str_replace( '%TOTAL_PAGES%', number_format_i18n( $total_pages ), $options['first_text'] );
				$out .= $instance->get_single( 1, 'first', $first_text, '%TOTAL_PAGES%' );
			}

			// Previous
			if ( $paged > 1 && !empty( $options['prev_text'] ) )
				$out .= $instance->get_single( $paged - 1, 'previouspostslink', $options['prev_text'] );

			if ( $start_page >= 2 && $pages_to_show < $total_pages ) {
				if ( !empty( $options['dotleft_text'] ) )
					$out .= "<span class='extend'>{$options['dotleft_text']}</span>";
			}

			// Smaller pages
			$larger_pages_array = array();
			if ( $larger_page_multiple )
				for ( $i = $larger_page_multiple; $i <= $total_pages; $i+= $larger_page_multiple )
					$larger_pages_array[] = $i;

			$larger_page_start = 0;
			foreach ( $larger_pages_array as $larger_page ) {
				if ( $larger_page < ($start_page - $half_page_start) && $larger_page_start < $larger_page_to_show ) {
					$out .= $instance->get_single( $larger_page, 'smaller page', $options['page_text'] );
					$larger_page_start++;
				}
			}

			if ( $larger_page_start )
				$out .= "<span class='extend'>{$options['dotleft_text']}</span>";

			// Page numbers
			$timeline = 'smaller';
			foreach ( range( $start_page, $end_page ) as $i ) {
				if ( $i == $paged && !empty( $options['current_text'] ) ) {
					$current_page_text = str_replace( '%PAGE_NUMBER%', number_format_i18n( $i ), $options['current_text'] );
					$out .= "<span class='current'>$current_page_text</span>";
					$timeline = 'larger';
				} else {
					$out .= $instance->get_single( $i, "page $timeline", $options['page_text'] );
				}
			}

			// Large pages
			$larger_page_end = 0;
			$larger_page_out = '';
			foreach ( $larger_pages_array as $larger_page ) {
				if ( $larger_page > ($end_page + $half_page_end) && $larger_page_end < $larger_page_to_show ) {
					$larger_page_out .= $instance->get_single( $larger_page, 'larger page', $options['page_text'] );
					$larger_page_end++;
				}
			}

			if ( $larger_page_out ) {
				$out .= "<span class='extend'>{$options['dotright_text']}</span>";
			}
			$out .= $larger_page_out;

			if ( $end_page < $total_pages ) {
				if ( !empty( $options['dotright_text'] ) )
					$out .= "<span class='extend'>{$options['dotright_text']}</span>";
			}

			// Next
			if ( $paged < $total_pages && !empty( $options['next_text'] ) )
				$out .= $instance->get_single( $paged + 1, 'nextpostslink', $options['next_text'] );

			if ( $end_page < $total_pages ) {
				// Last
				$out .= $instance->get_single( $total_pages, 'last', $options['last_text'], '%TOTAL_PAGES%' );
			}
			

		
	
	$out = $before . "<div class='wp-pagenavi'>\n$out\n</div>" . $after;

	$out = apply_filters( 'wp_pagenavi', $out );

	if ( !$echo )
		return $out;

	echo $out;
}


class PageNavi_Call {

	protected $args;

	function __construct( $args ) {
		$this->args = $args;
	}

	function __get( $key ) {
		return $this->args[ $key ];
	}

	function get_pagination_args() {
		global $numpages;

		$query = $this->query;

		switch( $this->type ) {
		case 'multipart':
			// Multipart page
			$posts_per_page = 1;
			$paged = max( 1, absint( get_query_var( 'page' ) ) );
			$total_pages = max( 1, $numpages );
			break;
		case 'users':
			// WP_User_Query
			$posts_per_page = $query->query_vars['number'];
			$paged = max( 1, floor( $query->query_vars['offset'] / $posts_per_page ) + 1 );
			$total_pages = max( 1, ceil( $query->total_users / $posts_per_page ) );
			break;
		default:
			// WP_Query
			$posts_per_page = intval( $query->get( 'posts_per_page' ) );
			$paged = max( 1, absint( $query->get( 'paged' ) ) );
			$total_pages = max( 1, absint( $query->max_num_pages ) );
			break;
		}

		return array( $posts_per_page, $paged, $total_pages );
	}

	function get_single( $page, $class, $raw_text, $format = '%PAGE_NUMBER%' ) {
		if ( empty( $raw_text ) )
			return '';

		$text = str_replace( $format, number_format_i18n( $page ), $raw_text );

		return "<a href='" . esc_url( $this->get_url( $page ) ) . "' class='$class'>$text</a>";
	}

	function get_url( $page ) {
		return ( 'multipart' == $this->type ) ? get_multipage_link( $page ) : get_pagenum_link( $page );
	}
}

# http://core.trac.wordpress.org/ticket/16973
if ( !function_exists( 'get_multipage_link' ) ) :
function get_multipage_link( $page = 1 ) {
	global $post, $wp_rewrite;

	if ( 1 == $page ) {
		$url = get_permalink();
	} else {
		if ( '' == get_option('permalink_structure') || in_array( $post->post_status, array( 'draft', 'pending') ) )
			$url = add_query_arg( 'page', $page, get_permalink() );
		elseif ( 'page' == get_option( 'show_on_front' ) && get_option('page_on_front') == $post->ID )
			$url = trailingslashit( get_permalink() ) . user_trailingslashit( $wp_rewrite->pagination_base . "/$page", 'single_paged' );
		else
			$url = trailingslashit( get_permalink() ) . user_trailingslashit( $page, 'single_paged' );
	}

	return $url;
}
endif;

/**
 * Espresso Import Options
 *
 * @param mixed $import_data 
 * @return void
 * @author Jared Harbour
 */
if (!function_exists( 'espresso_import_options')) {
	function espresso_import_options($import_data){
		global $espresso_framework;

		$data = base64_decode($import_data);
		$unserialized_data = maybe_unserialize($data);

		if(is_array($unserialized_data)){
			foreach ($unserialized_data as $key => $value) {
			    $key = str_replace ( 'whipplehill-magazine-theme' , $espresso_framework->get_option_basename() , $key );

			    update_option($key, $value);
			}
		}
	}
}































