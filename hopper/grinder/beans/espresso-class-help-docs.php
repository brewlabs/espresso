<?php
/**
 * Bean Name: Espresso Docs Page
 * Bean Description: Creates a Docs page to be used by shortcodes etc...
 *
 * @since 1.0.0
 * @package Espresso
 * @author Josh Lyford
 */
class EspressoHelpDocs{

	static function load_espresso_shortcode_docs(){
		add_theme_page("Theme Help", "Theme Help", 'administrator', 'shortcodehelp',array('EspressoHelpDocs','espresso_shortcode_docs'));
	}

	function espresso_shortcode_docs(){ ?>
	<style>
	.data-inside{
		background: #fff;
		border: solid 1px #ddd;
		padding: 15px 15px 10px;
		font-size: 1.2em;
	}
	.data-inside p, .data-inside h5, .data-inside ul{
		margin: 0 0 1em;
	}
	.data-inside ul li{
		margin: 0 0 15px 15px;

	}
	.data-inside ul li p{
		color: #999;
	}
	</style>
	<div class="wrap">
	<div id="icon-themes" class="icon32"><br></div>
		<h2>Theme Help</h2>
		<?php 
			$support_box = false;
			$support_box = apply_filters('espresso_support_box', $support_box); 
			if(false  !== $support_box){
				foreach($support_box as $box){
					EspressoHelpDocs::postbox( $box['id'],$box['title'],$box['content'] );
				}
			}
		?>
		<h2>Shortcode's</h2>
		<?php 
		$support_box_sc = false;
		$support_box_sc = apply_filters('espresso_shortcode_box', $support_box_sc); 
		if(false  !== $support_box_sc){
			foreach($support_box_sc as $box){
				$code = isset($box['code']) ? $box['code'] : "";
				EspressoHelpDocs::postbox( $box['id'],$box['title'],$box['content'],$code);
			}
		}
		?>
	</div>
	<?php
	}


	/**
	 * Create a postbox widget
	 */
	function postbox($id, $title, $content,$code="") { ?>
	<h3><span><?php echo $title; ?></span> <small style="color:#999; font-weight: normal;"><?php echo $code; ?></small></h3>
	<div class="data-inside">
		<?php 
		if(is_array($content)){
			call_user_func($content);
		}else{
			echo $content;
		} ?>
	</div>
	<?php 
	}

}
add_action('admin_menu',array('EspressoHelpDocs','load_espresso_shortcode_docs'),100);