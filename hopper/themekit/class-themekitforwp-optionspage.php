<?php
/**
 * ThemeKit Options Page Class
 *
 * All calls to the class should be setup in the main class ThemeKitForWP
 *
 * @version 1.0
 *
 * @package themekit
 * @author Josh Lyford
 **/
class ThemeKitForWP_OptionsPage {
	
	private $_tk; //Instance of the Class that loaded this class  - ThemeKitForWP

	function __construct($instance){
		$this->_tk = $instance;		
	}
	
	/**
	*
	* Create ThemeKit Options Page	
	*
	*
	* @since 1.0.0 
	*
	*/
	function create() {
		if ( !empty($this->_tk->options_updated) ) echo '<div id="message" class="updated fade"><p><strong>Settings saved.</strong></p></div>';
		//	if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
		$option_created = get_option($this->_tk->get_option_name());
		if( empty( $option_created ) ) {
			update_option( $this->_tk->get_option_name() , $this->_tk->get_default_settings() );
		} ?>
		<div class="wrap tk_wrap" id='themekit-options'>
			<script>var themekitforwp = true;</script>
			<div id="icon-themes" class="icon32"><br></div>
			<h2><?php echo $this->_tk->get_menu_title(); ?></h2>
			<?php if ( false == true ) { ?>
			<div class='view'>view</div>
		 	<div class="view-switch">
				<a href="#"><img id="view-switch-list" src="http://spareurl/frame/wp-includes/images/blank.gif" width="20" height="20" title="List View" alt="List View"></a>
				<a href="#"><img id="view-switch-excerpt" src="http://spareurl/frame/wp-includes/images/blank.gif" width="20" height="20" title="Excerpt View" alt="Excerpt View"></a>
			</div>
			<?php } ?>
	 		<div class="tk_opts">
	 			<?php if( current_theme_supports('espresso-top-reset-button') ): ?>
	 			<form method="post"  enctype="multipart/form-data" >
					<p class="submit">
						<input name="reset" type="submit" value="<?php echo $this->_tk->get_reset_text(); ?>" />
						<input type="hidden" name="action" value="reset" />
					</p>
					<?php wp_nonce_field( $this->_tk->get_option_name() ); ?>
				</form>
				<?php endif; ?>
	 			<form method="post"  enctype="multipart/form-data" >
					<?php $this->_tk->start_engine(); ?>
					<br>
					<input type="hidden" name="action" value="save" />
					<span class="submit">
						<input class="button-primary" name="save" type="submit" value="Save changes" />
					</span>
					<?php wp_nonce_field( $this->_tk->get_option_name() ); ?>
				</form>
				<form method="post"  enctype="multipart/form-data" >
					<p class="submit">
						<input name="reset" type="submit" value="<?php echo $this->_tk->get_reset_text(); ?>" />
						<input type="hidden" name="action" value="reset" />
					</p>
					<?php wp_nonce_field( $this->_tk->get_option_name() ); ?>
				</form>
				<br><br><br><br>
			</div>
		</div>
		<?php 
		$create_archive = false;
		if ( $create_archive ) { ?>
			<div class="create_archive" >archive</div>
		<?php
		}	
	}
	


	function support_files(){
		add_action("admin_enqueue_scripts", array(&$this, 'patch_jareds_code'));
	}	

	/**
	*
	* Attach all Script Files needed for the options page
	*
	*
	* @since 1.0.0 
	*
	*/
	function patch_jareds_code(){
		add_contextual_help($this->_tk->get_options_page(), $this->_tk->get_context_help());	
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('post');
		if(PARENT_THEME_NAME == 'Espresso' && PARENT_URL){
				wp_enqueue_style( "themekit" , PARENT_URL .'/hopper/themekit/kit.css' , false , "1.0" , "all" );
				wp_enqueue_script( "themekit" , PARENT_URL. '/hopper/themekit/kit.js' , false , "1.0" );
		} else {
				wp_enqueue_style( "themekit" , plugins_url('kit.css', __FILE__) , false , "1.0" , "all" );
				wp_enqueue_script( "themekit" , plugins_url('kit.js', __FILE__) , false , "1.0" );
		}
	
		wp_enqueue_script( 'farbtastic' );
		wp_enqueue_style( 'farbtastic' );
		wp_enqueue_style('thickbox');
		add_thickbox();
	}
} //END OPTONS CLASS