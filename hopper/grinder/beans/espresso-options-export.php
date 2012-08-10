<?php
/**
 * Bean Name: Espresso Export
 * Bean Description: Export your theme settings
 *  
 * @since 1.0.0
 * @author Josh Lyford
 */

/**
 * Add the Import/Export menu item under Theme sectons
 *
 * @return void
 * @author Josh Lyford
 */
function espresso_export(){
	add_theme_page( 'Style Import & Export', 'Style Import & Export', 'administrator', 'export-theme', 'espresso_import_export'); 
}
//Add menu last
add_action('admin_menu', 'espresso_export', 200);


/**
 * The Import/Export page
 *
 * @return void
 * @author Josh Lyford
 */
function espresso_import_export(){
	global $espresso_framework;

	//$old_names = array('whipplehill-magazine-theme','whipplehill-magazine-theme','whipplehill-magazine-theme','whipplehill-magazine-theme','whipplehill-magazine-theme');

	if ( isset( $_REQUEST['action'] ) && 'save' == $_REQUEST['action'] && check_admin_referer( 'espresso-export' )) {
		espresso_import_options($_REQUEST['import_settings']);
	}

	if ( isset( $_REQUEST['action'] ) && 'save-default' == $_REQUEST['action'] && check_admin_referer( 'espresso-export' )) {
		$theme_defaults = get_site_option( $espresso_framework->get_option_basename().'-default-styles', array() );
		$new_defaults = array();

		$new_defaults[] = array('name' => $_REQUEST['option_name'], 'settings_hash' => $_REQUEST['hash']);

		foreach($theme_defaults as $style){
			$new_defaults[] = $style;
		}

		update_site_option($espresso_framework->get_option_basename().'-default-styles', $new_defaults);

		echo 'network saved!';

	}
	
	$theme_options =  get_option($espresso_framework->get_option_basename().'-options');
	$theme_layout =  get_option($espresso_framework->get_option_basename().'-layout');
	
	$db = array(
		$espresso_framework->get_option_basename().'-options' => $theme_options,
		$espresso_framework->get_option_basename().'-layout' => $theme_layout,
	);

	$db = apply_filters('espresso-import-export-options', $db);
	
	$output = serialize($db);	
	$data = base64_encode($output);							
	?>
	<div class="wrap tk_wrap" id='themekit-options'>
		<div id="icon-themes" class="icon32"><br></div>
		<h2>Import &amp; Export Theme Styles</h2>
		<div class="tk_opts">
			<form method="post"  enctype="multipart/form-data" >
				<p>Images are not moved with this import/export. Those will have to be moved manually.</p>
				<h4>Import Options</h4>
				<textarea cols="50" rows="15" id="import_settings" name="import_settings"></textarea>
					<br>
					<input type="hidden" name="action" value="save" />
					<span class="submit">
						<input class="button-primary" name="save" type="submit" value="Save Import" />
					</span>
				<h4>Export Options</h4>
				<textarea cols="50" rows="15"><?php echo $data; ?></textarea>
				
				<?php wp_nonce_field( 'espresso-export' ); ?>
			</form>
			<?php if( is_multisite() && current_theme_supports('espresso-network-save-options') && is_super_admin() ): ?>
			
				<form method="post"  enctype="multipart/form-data" >
					<h4>Save Current Options as Network Default</h4>
					<p>Clicking the button below will save this sites design on the network.  Each new site that gets created and gets this theme applied will use this design instead of the default.</p>
						<input type="hidden" name="action" value="save-default" />
						<input type="hidden" name="hash" value="<?php echo $data; ?>" />
						<label for="option_name"><?php _e('Design Name:', 'espresso'); ?></label>
						<input type="text" class="widefat" id="option_name" name="option_name" value="" style="width:300px;"/>
						<span class="submit">
							<input class="button-primary" name="save-default" type="submit" value="Save Default Design" />
						</span>
					<?php wp_nonce_field( 'espresso-export' ); ?>
				</form>

			<?php endif; ?>


			<br><br><br><br>
		</div>
	</div>
	<?php
}