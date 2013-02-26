<?php

function espresso_update_check() {
	global $wp_version;
	
	$espresso_update = get_transient('espresso-update');
	
	if( defined('NO_ESPRESSO_UPDATE') )
		return false;
	
	if ( !$espresso_update ) {
		$url = 'http://themebrewers.com/api/';
		$options = array(
			'body' => array(
				'version' => PARENT_THEME_VERSION,
				'wp_version' => $wp_version,
				'php_version' => phpversion(),
				'action' => 'theme_update', 
				'slug' => 'espresso',
				'user-agent' => "WordPress/$wp_version;" . home_url()
			)
		);
		
		$response = wp_remote_post($url, $options);
		$espresso_update = wp_remote_retrieve_body($response);
		
		// If an error occurred, return FALSE, store for 1 hour
		if ( $espresso_update == 'error' || is_wp_error($espresso_update) || !is_serialized($espresso_update) ) {
			set_transient('espresso-update', array('new_version' => PARENT_THEME_VERSION), 60*60);  //60*60); // store for 1 hour
			return FALSE;
		}
			
		// Else, unserialize
		$espresso_update = maybe_unserialize($espresso_update);
		//	wp_die(print_r($espresso_update) );
		
		
	
		// And store in transient
		set_transient( 'espresso-update', $espresso_update, 60*60*24);//60*60*24); // store for 24 hours
	}
	delete_transient('espresso-update');
	
	//	wp_die(print_r($espresso_update) );
	// If we're already using the latest version, return FALSE
	if ( version_compare(PARENT_THEME_VERSION, $espresso_update['new_version'], '>=') )
		return FALSE;
		
	return $espresso_update;
}



add_action('admin_notices', 'espresso_update_admin');
function espresso_update_admin() {
	$espresso_update = espresso_update_check();
	if ( !is_super_admin() || !$espresso_update )
		return false;
	
	$update_url = wp_nonce_url('update.php?action=upgrade-theme&amp;theme=espresso', 'upgrade-theme_espresso');
	$update_onclick = __('Upgrading Espresso will overwrite the current installed version. Are you sure you want to upgrade?. "Cancel" to stop, "OK" to upgrade.', 'espresso');
	
	echo '<div id="update-nag">';
	printf( __('Espresso %s is available. Please <a href="%s" onclick="return esFrame.answer_confirm(\'%s\');">update now</a>.', 'espresso'), esc_html( $espresso_update['new_version'] ), 
	 $update_url, esc_js( $update_onclick ) );
	echo '</div>';
}




/**
 * This function filters the value that is returned when
 * WordPress tries to pull theme update transient data. It uses
 * genesis_update_check() to check to see if we need to do an 
 * update, and if so, adds the proper array to the $value->response
 * object. WordPress handles the rest.
 *
 * @since 1.1
 */
add_filter('site_transient_update_themes', 'espresso_update_push');
add_filter('transient_update_themes', 'espresso_update_push');
function espresso_update_push($value) {

	
	$espresso_update = espresso_update_check();
	
	if ( $espresso_update ) {
		$value->response['espresso'] = $espresso_update;
	}
	
	return $value;
	
}




add_filter('update_theme_complete_actions', 'espresso_update_action_links', 10, 2);
function espresso_update_action_links($actions, $theme) {

	if ( $theme != 'espresso' )
		return $actions;
	global $espresso_framework;

	return sprintf( '<a href="%s">%s</a>', menu_page_url( $espresso_framework->get_option_basename().'-layout', 0 ), __('Click here to complete the upgrade', 'espresso') );

}





/**
 * This function clears out the Genesis update transient data
 * so that the server will do a fresh version check when the
 * update is complete, or when the user loads certain admin pages.
 *
 * It also disables the update nag on those pages, as well.
 *
 * @since 1.1
 */
add_action('load-update.php', 'espresso_clear_update_transient');
add_action('load-themes.php', 'espresso_clear_update_transient');
function espresso_clear_update_transient() {
	
	delete_transient('espresso-update');
	remove_action('admin_notices', 'espresso_update_admin');
	
}


/**
 * Bean Name: Espresso Updates
 * Bean Description: Auto Updates Espresso from themebrewers.com when a new version shows up.
 */
/**
* Remove bean code file no longer needed as updates now come from wp.org
*/