<?php
global $espresso_framework, $espresso_body_classes;
/**
 * Define Theme Name/Version Constants
 * 
 **/
define('PARENT_THEME_NAME', 'Espresso');
define('PARENT_THEME_VERSION', '1.0.9');
define('PARENT_THEME_RELEASE_DATE', date_i18n('F j, Y', '1297144800'));
define('ESPRESSO_NO_CLASS', 'enoclass' );
/**
 * Define Directory Location Constants
 */
define('PARENT_DIR', TEMPLATEPATH);
define('CHILD_DIR', STYLESHEETPATH);
define('PARENT_URL', get_template_directory_uri());
define('CHILD_URL', get_stylesheet_directory_uri());

require_once(dirname(__FILE__) . '/hopper/grinder.php');	
	

if ( ! isset( $content_width ) ) 
	$content_width = 500;


function espresso_setup(){

	add_espresso_image_size('Featured','featured',200,200,true);
	add_espresso_image_size('Post Widget','post-widget',75,75,true);
	
	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('espresso-layouts');
	add_theme_support('espresso-meta-information');

	
	/**
	 * ESPRESSO OPTIONS STYLE
	 * 
	 * Loaded in /hopper/grinder/beans/espresso-options-style.php 
	 *
	 * @since 1.0.0
	 * @author Josh Lyford
	 */
	add_theme_support('espresso-options-style');
	//Fonts
	add_theme_support('espresso-fonts-colors'); //Activate Font Color Section
	add_theme_support('espresso-theme-font',array( 'size'=>16 ,'face'=>'verdana' ) );
	add_theme_support('espresso-header-font');
	add_theme_support('espresso-title-styles', array('color'=>'#21759b'), array('color'=>'#d54e21'));
	add_theme_support('espresso-link-styles', array('color'=>'#21759b'), array('color'=>'#d54e21'));
	

	add_theme_support('espresso-styled-button');
	add_theme_support('espresso-button-styles', 
		array('color'=>"#F0F8FF"), 
		array('color'=>"#F0F8FF"), 
		array('color'=>"#003366"), 
		array('color'=>"#0085A6"), 
		array('color'=>"#001C33")
		);
	
	//HEADER
	add_theme_support('espresso-header'); //Activate Font Color Section
	add_theme_support('espresso-logo', array('size'=>40,'face'=>'verdana','color'=>'#000000') , array('15','15','0','0') );
	//HEADER WIDGET
	add_theme_support('espresso-h1-widget', false, array('0','0','0','0') );
	//CONTENT
	add_theme_support('espresso-content');
	//CUSTOM CSS
	add_theme_support('espresso-custom-css');
	
	//=========== END ESPRESSO STYLE OPTIONS SETUP
	
	add_theme_support( 'header-layouts' ,array( 'logo-branding','branding-logo','logo-third-branding','branding-logo-third','logo-above-branding','logo'));
	add_theme_support( 'menu-locations' ,array( 'header-top','header-bottom','above-content','content-top','none'));
	add_theme_support( 'content-layouts' ,array(
	'content-sidebar1',
	'sidebar1-content',
	'content-sidebar1-sidebar2',
	'sidebar2-sidebar1-content',
	'sidebar2-content-sidebar1',
	'content'
	));
	add_theme_support('footer-widgets',array('none','footer1','footer1-footer2','footer1-footer2-footer3','footer1-wide-footer2-footer3','footer1-footer2-footer3-wide','footer1-footer2-footer3-footer4'));
	
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size( get_option('featured_size_w'), get_option('featured_size_h'), get_option('featured_crop') );
	
	add_theme_support( 'post-formats', array( 'aside','image','quote','gallery') );
	
	
	/**
	* Add in Espresso excerpts filters
	*
	* Loaded in /hopper/grinder/beans/espresso-filter-excerpt.php 
	*	
	* @author Josh Lyford
	*/
	add_theme_support('espresso-filters-excerpt');
	
	/**
	* Adds Powered by WordPress & Espresso 
	*
	* @author Josh Lyford
	*/
	add_theme_support('espresso-show-support');
	
	/**
	 * Add in the Espresso Menu Widget.
	 *
	 * Loaded in /hopper/grinder/beans/espresso-widget-nav.php 
	 *
	 * @author Josh Lyford
	 */
	add_theme_support('espresso-widget-nav');
	
	
	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'espresso', TEMPLATEPATH . '/languages' );
	
	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
	
	// Load jQuery
	if ( !is_admin() ) {
	   	add_action('init','espresso_load_scripts');
	}
	
	global $espresso_theme_options,$espresso_framework,$espresso_theme_styles;
	$espresso_theme_options = get_option($espresso_framework->get_option_basename().'-options');

	if( (bool)$espresso_theme_options['hide_meta_info'] ){
		remove_theme_support('espresso-meta-information');
	}

	// Clean up the <head>
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }
    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');

	// This theme uses wp_nav_menu() in one location.
	if( current_theme_supports('menu-locations') ){	
		register_nav_menus( array(
			'primary' => __( 'Primary Navigation', 'espresso' ),
		) );
	}
	do_action('espresso_setup');
	do_action('espresso_load_beans');
	

}
add_action( 'after_setup_theme', 'espresso_setup' );


/**
* Register all the scripts for espresso
*
*
* @since 1.0.0 
* @author Jared Harbour
*/
function espresso_load_scripts(){
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'superfish', PARENT_URL.'/hopper/js/superfish.js', array('jquery'), '1.4.8', true );
	wp_enqueue_script( 'supersubs', PARENT_URL.'/hopper/js/supersubs.js', array('jquery','superfish'), '1.4.8', true );

	wp_enqueue_script( 'espresso', PARENT_URL.'/hopper/js/functions.js', array('jquery'), '1.4.8', true );

	if( current_theme_supports('responsive-design') ){
		wp_enqueue_script( 'adapt', PARENT_URL.'/hopper/js/adapt.min.js', array('jquery'), '1.4.8', true );
	}
}

/**
* Register all the sidebar area's used in Espresso
*
*
* @since 1.0.0 
* @author Josh Lyford
*/
function espresso_widget_areas_init(){
	
	// Area 1, located at the top of the sidebar.

	$bPrimaryWidget = apply_filters( 'espresso_primary_before_widget', '<li id="%1$s" class="widget-container %2$s">' );
	$aPrimaryWidget = apply_filters( 'espresso_primary_after_widget', '</li>' );
	$bPrimaryTitle = apply_filters( 'espresso_primary_before_title', '<h4 class="widget-title">' );
	$aPrimaryTitle = apply_filters( 'espresso_primary_after_title', '</h4>' );

	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'espresso' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'espresso' ),
		'before_widget' => $bPrimaryWidget,
		'after_widget' => $aPrimaryWidget,
		'before_title' => $bPrimaryTitle,
		'after_title' => $aPrimaryTitle
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.

	$bSecondaryWidget = apply_filters( 'espresso_secondary_before_widget', '<li id="%1$s" class="widget-container %2$s">' );
	$aSecondaryWidget = apply_filters( 'espresso_secondary_after_widget', '</li>' );
	$bSecondaryTitle = apply_filters( 'espresso_secondary_before_title', '<h4 class="widget-title">' );
	$aSecondaryTitle = apply_filters( 'espresso_secondary_after_title', '</h4>' );

	register_sidebar( array(
		'name' => __( 'Secondary Widget Area', 'espresso' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area', 'espresso' ),
		'before_widget' => $bSecondaryWidget,
		'after_widget' => $aSecondaryWidget,
		'before_title' => $bSecondaryTitle,
		'after_title' => $aSecondaryTitle
	) );

	/**
	* Enable Header Widget Area One
	*
	* This is actually called branding in the header-content.php file
	*
	* add_theme_support('espresso-h1-widget');
	*
	* @since 1.0.0 
	* @author Josh Lyford
	*/
	if( current_theme_supports('espresso-h1-widget') ){
		register_sidebar( array(
			'name' => __( 'Header Widget Area', 'espresso' ),
			'id' => 'branding-widget-area',
			'description' => __( 'The header widget area', 'espresso' ),
			'before_widget' => '<li id="%1$s" class="widget-container-branding %2$s">',
			'after_widget' => '</li>',
			'before_title' => '<h4 class="widget-title-branding">',
			'after_title' => '</h4>',
		) );
	}
	
	
	
	/**
	* Enable Header Widget Area Two
	*
	* This is actually called branding2 in the header-content.php file
	*
	* add_theme_support('espresso-h2-widget');
	*
	* @since 1.0.0 
	* @author Josh Lyford
	*/
	if( current_theme_supports('espresso-h2-widget') ){
		register_sidebar( array(
			'name' => __( 'H2 Widget Area', 'espresso' ),
			'id' => 'branding2-widget-area',
			'description' => __( 'The branding widget area', 'espresso' ),
			'before_widget' => '<li id="%1$s" class="widget-container-branding %2$s">',
			'after_widget' => '</li>',
			'before_title' => '<h4 class="widget-title-branding">',
			'after_title' => '</h4>',
		) );
	}
	
	// Footer widgets

	$bFooterOneWidget = apply_filters( 'espresso_footer_one_before_widget', '<li id="%1$s" class="widget-container-footer %2$s">' );
	$aFooterOneWidget = apply_filters( 'espresso_footer_one_after_widget', '</li>' );
	$bFooterOneTitle = apply_filters( 'espresso_footer_one_before_title', '<h4 class="widget-title-footer">' );
	$aFooterOneTitle = apply_filters( 'espresso_footer_one_after_title', '</h4>' );

	register_sidebar( array(
		'name' => __( 'Footer Widget One', 'espresso' ),
		'id' => 'footer1-widget-area',
		'description' => __( 'The footer widget area', 'espresso' ),
		'before_widget' => $bFooterOneWidget,
		'after_widget' => $aFooterOneWidget,
		'before_title' => $bFooterOneTitle,
		'after_title' => $aFooterOneTitle
	) );

	$bFooterTwoWidget = apply_filters( 'espresso_footer_two_before_widget', '<li id="%1$s" class="widget-container-footer %2$s">' );
	$aFooterTwoWidget = apply_filters( 'espresso_footer_two_after_widget', '</li>' );
	$bFooterTwoTitle = apply_filters( 'espresso_footer_two_before_title', '<h4 class="widget-title-footer">' );
	$aFooterTwoTitle = apply_filters( 'espresso_footer_two_after_title', '</h4>' );

	register_sidebar( array(
		'name' => __( 'Footer Widget Two', 'espresso' ),
		'id' => 'footer2-widget-area',
		'description' => __( 'The footer widget area', 'espresso' ),
		'before_widget' => $bFooterTwoWidget,
		'after_widget' => $aFooterTwoWidget,
		'before_title' => $bFooterTwoTitle,
		'after_title' => $aFooterTwoTitle
	) );

	$bFooterThreeWidget = apply_filters( 'espresso_footer_three_before_widget', '<li id="%1$s" class="widget-container-footer %2$s">' );
	$aFooterThreeWidget = apply_filters( 'espresso_footer_three_after_widget', '</li>' );
	$bFooterThreeTitle = apply_filters( 'espresso_footer_three_before_title', '<h4 class="widget-title-footer">' );
	$aFooterThreeTitle = apply_filters( 'espresso_footer_three_after_title', '</h4>' );

	register_sidebar( array(
		'name' => __( 'Footer Widget Three', 'espresso' ),
		'id' => 'footer3-widget-area',
		'description' => __( 'The footer widget area', 'espresso' ),
		'before_widget' => $bFooterThreeWidget,
		'after_widget' => $aFooterThreeWidget,
		'before_title' => $bFooterThreeTitle,
		'after_title' => $aFooterThreeTitle
	) );

	$bFooterFourWidget = apply_filters( 'espresso_footer_four_before_widget', '<li id="%1$s" class="widget-container-footer %2$s">' );
	$aFooterFourWidget = apply_filters( 'espresso_footer_four_after_widget', '</li>' );
	$bFooterFourTitle = apply_filters( 'espresso_footer_four_before_title', '<h4 class="widget-title-footer">' );
	$aFooterFourTitle = apply_filters( 'espresso_footer_four_after_title', '</h4>' );

	register_sidebar( array(
		'name' => __( 'Footer Widget Four', 'espresso' ),
		'id' => 'footer4-widget-area',
		'description' => __( 'The footer widget area', 'espresso' ),
		'before_widget' => $bFooterFourWidget,
		'after_widget' => $aFooterFourWidget,
		'before_title' => $bFooterFourTitle,
		'after_title' => $aFooterFourTitle
	) );

	$bPostWidget = apply_filters( 'espresso_post_before_widget', '<li id="%1$s" class="widget-container %2$s">' );
	$aPostWidget = apply_filters( 'espresso_post_after_widget', '</li>' );
	$bPostTitle = apply_filters( 'espresso_post_before_title', '<h4 class="widget-title">' );
	$aPostTitle = apply_filters( 'espresso_post_after_title', '</h4>' );

	register_sidebar( array(
		'name' => __( 'After Single Posts Widget Area', 'espresso' ),
		'id' => 'post-widget-area',
		'description' => __( 'This area displays below the single posts', 'espresso' ),
		'before_widget' => $bPostWidget,
		'after_widget' => $aPostWidget,
		'before_title' => $bPostTitle,
		'after_title' => $aPostTitle
	) );

	$primary = get_option( 'espresso_primary_sidebar', array( ) );

	if(!empty($primary)){
		
		$primary_sidebars = new WP_Query( array('posts_per_page'=>-1,'post__in'=>$primary,'post_type'=> 'page'));
		// The Loop
		while( $primary_sidebars->have_posts() ) : $primary_sidebars->the_post();
			
			register_sidebar( array(
				'name' => 'Primary Sidebar: '.get_the_title(get_the_ID()),
				'id' => 'primary-widget-area-'.get_the_ID(),
				'description' => __( 'Primary Widget Area for page '.get_the_title(get_the_ID()), 'espresso' ),
				'before_widget' => $bPrimaryWidget,
				'after_widget' => $aPrimaryWidget,
				'before_title' => $bPrimaryTitle,
				'after_title' => $aPrimaryTitle
			) );

		endwhile;
		wp_reset_postdata();
	}

	$secondary = get_option( 'espresso_secondary_sidebar', array( ) );

	if(!empty($secondary)){
		
		$secondary_sidebars = new WP_Query( array('posts_per_page'=>-1,'post__in'=>$secondary,'post_type'=> 'page'));
		// The Loop
		while( $secondary_sidebars->have_posts() ) : $secondary_sidebars->the_post();
		register_sidebar( array(
			'name' => 'Secondary Sidebar: '.get_the_title(get_the_ID()),
			'id' => 'secondary-widget-area-'.get_the_ID(),
			'description' => __( 'Secondary Widget Area for page '.get_the_title(get_the_ID()), 'espresso' ),
			'before_widget' => $bSecondaryWidget,
			'after_widget' => $aSecondaryWidget,
			'before_title' => $bSecondaryTitle,
			'after_title' => $aSecondaryTitle
		) );
		endwhile;
		wp_reset_postdata();
	}

	
	$sidebars = get_option( 'espresso_content_sidebar', array( ) );	
	
	if(!empty($sidebars)){
		$comma_separated = implode(",", $sidebars);
		//	wp_die(print_r($comma_separated));
		// Create a new instance
		$second_query = new WP_Query( array('posts_per_page'=>-1,'post__in'=>$sidebars,'post_type'=> 'page'));
		// The Loop
		while( $second_query->have_posts() ) : $second_query->the_post();
		register_sidebar( array(
			'name' => get_the_title(get_the_ID()).' Content',
			'id' => 'content-widget-area-'.get_the_ID(),
			'description' => __( 'Content widget area', 'espresso' ),
			'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
			'after_widget' => '</li>',
			'before_title' => '<h4 class="widget-title">',
			'after_title' => '</h4>',
		) );
		endwhile;
		wp_reset_postdata();
	}
	
	do_action('espresso_register_widgets');
	
	
}
//=== END espresso_widget_areas_init();
add_action('widgets_init','espresso_widget_areas_init');

function espresso_get_and_add_body_classes($classes){
	global $espresso_body_classes;
	$espresso_body_classes = implode(' ',$classes);	
	return $classes;
}
add_filter('body_class','espresso_get_and_add_body_classes', 9999);


if ( ! function_exists( 'espresso_comment' ) ) :
	
	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own echobase_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 */
	function espresso_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 40 ); ?>
				<?php printf( __( '%s <span class="says">says:</span>', 'espresso' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
			</div><!-- .comment-author .vcard -->
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'espresso' ); ?></em>
				<br />
			<?php endif; ?>

			<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php
					/* translators: 1: date, 2: time */
					printf( __( '%1$s at %2$s', 'echobase' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'espresso' ), ' ' );
				?>
			</div><!-- .comment-meta .commentmetadata -->

			<div class="comment-body"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</div><!-- #comment-##  -->

		<?php
				break;
			case 'pingback'  :
			case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'espresso' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'espresso' ), ' ' ); ?></p>
		<?php
				break;
		endswitch;
	}
endif;


// Presstrends
function espresso_presstrends() {

// Add your PressTrends and Theme API Keys
$api_key = 'eu1x95k67zut64gsjb5qozo7whqemtqiltzu';
$auth = 'ijgpjjmcnrtgcrucg0bp6ejbojrtrjhxx';

// NO NEED TO EDIT BELOW
$data = get_transient( 'presstrends_data' );
if (!$data || $data == ''){
$api_base = 'http://api.presstrends.io/index.php/api/sites/add/auth/';
$url = $api_base . $auth . '/api/' . $api_key . '/';
$data = array();
$count_posts = wp_count_posts();
$count_pages = wp_count_posts('page');
$comments_count = wp_count_comments();
$theme_data = get_theme_data(get_stylesheet_directory() . '/style.css');
$plugin_count = count(get_option('active_plugins'));
$all_plugins = get_plugins();
$plugin_name = '';
foreach($all_plugins as $plugin_file => $plugin_data) {
	
	$plugin_name .= $plugin_data['Name'];
	$plugin_name .= '&';
}
$data['url'] = stripslashes(str_replace(array('http://', '/', ':' ), '', site_url()));
$data['posts'] = $count_posts->publish;
$data['pages'] = $count_pages->publish;
$data['comments'] = $comments_count->total_comments;
$data['approved'] = $comments_count->approved;
$data['spam'] = $comments_count->spam;
$data['theme_version'] = $theme_data['Version'];
$data['theme_name'] = $theme_data['Name'];
$data['site_name'] = str_replace( ' ', '', get_bloginfo( 'name' ));
$data['plugins'] = $plugin_count;
$data['plugin'] = urlencode($plugin_name);
$data['wpversion'] = get_bloginfo('version');
foreach ( $data as $k => $v ) {
$url .= $k . '/' . $v . '/';
}
$response = wp_remote_get( $url );
set_transient('presstrends_data', $data, 60*60*24);
}}

if( !defined('WH_TIMEOUT_OVERRIDE') ){
	add_action('admin_init', 'espresso_presstrends');
}

