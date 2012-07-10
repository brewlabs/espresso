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
	add_theme_page( 'Import & Export', 'Import & Export','administrator' , 'export-theme', 'espresso_import_export'); 
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
	if ( isset( $_REQUEST['action'] ) && 'save' == $_REQUEST['action'] &&	check_admin_referer( 'espresso-export' )) {
		$data2 = base64_decode($_REQUEST['import_settings']);
		$data2 = maybe_unserialize($data2);
		if(is_array($data2)){
			foreach ($data2 as $key => $value) {
			    update_option($key, $value);
			}
		}
	
	}
	global $espresso_framework;
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
				<p>Images are not moved with this import/export. Those will have to be moved manually. At least for now.</p>
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
			<br><br><br><br>
		</div>
	</div>
	<?php
}