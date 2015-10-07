<?php
class EspressoGrinder {
	
	/*
	* Their can be only one!
	*/
	static function &init() {
		static $instance = false;

		if ( !$instance ) {
			$instance = new EspressoGrinder;
			EspressoGrinder::load_modules();
		}

		return $instance;
	}
	
	// Gear up EspressoGrinder
	function __construct() {
		//Not in admin section peace out
		add_action('grinder_modules_loaded', array('EspressoGrinder','load_themekit_settings') );
	}
	
	function load_themekit_settings(){
		
		if(class_exists('EspressoKit')) {
			$bcsctk = array();
			$bcsctk = apply_filters('espresso_shortcodes_tk', $bcsctk);
			if(!empty( $bcsctk )){
				$sc= new EspressoKit;
				$sc->set_option_name('shortcodes');
				$sc->set_menu_title('Shortcodes');
				//Tell ThemeKit about the options
				$sc->register_options( $bcsctk );
			}
		}
	}
	
	
	/**
 	* Loads the modules.
	*/
	static function load_modules() {
	
		$modules = EspressoGrinder::get_available_modules();
		foreach ( $modules as $module ) {
			if ( empty( $module ) || !EspressoGrinder::is_module( $module[0] ) || did_action( 'espresso_module_loaded_' . $module[0] ) )
				continue;
			require EspressoGrinder::get_module_path( $module[0] , $module[1] );
			do_action( 'espresso_module_loaded_' . $module[0] );
		}

		do_action( 'espresso_modules_loaded' );
	}
	
	/**
	 * List available Jetpack modules. Simply lists .php files in /modules/.
	 * Make sure to tuck away module "library" files in a sub-directory.
	 */
	static function get_available_modules() {
		static $modules = null;

		if ( isset( $modules ) )
			return $modules;

		$files = EspressoGrinder::glob_php( PARENT_DIR . '/hopper/grinder/beans' );

		foreach ( $files as $file ) {
			if ( $headers = EspressoGrinder::get_module( $file  , PARENT_DIR .'/hopper/grinder/beans') ) {
				$modules[] = array( EspressoGrinder::get_module_slug( $file ) , PARENT_DIR .'/hopper/grinder/beans');
			}
		}
		
		if( is_child_theme() ){
		
			$files = EspressoGrinder::glob_php( CHILD_DIR . '/beans' );

			foreach ( $files as $file ) {
				if ( $headers = EspressoGrinder::get_module( $file , CHILD_DIR. '/beans' ) ) {
					$modules[] = array( EspressoGrinder::get_module_slug( $file ), CHILD_DIR. '/beans' );
				}
			}
		}

		return $modules;
	}
	
	/**
	 * Extract a module's full path from its slug.
	 */
	static function get_module_slug( $file ) {
		return str_replace( '.php', '', basename( $file ) );
	}

	/**
	 * Generate a module's path from its slug.
	 */
	static function get_module_path( $slug , $dir) {
		return $dir . "/$slug.php";
	}
	/**
	*
	*/
	static function is_module( $module ) {
		return !validate_file( $module );
	}
	
	
	/**
	 * Load module data from module file. Headers differ from WordPress
	 * plugin headers to avoid them being identified as standalone
	 * plugins on the WordPress plugins page.
	 */
	static function get_module( $module, $dir ) {
		$headers = array(
			'name' => 'Bean Name',
			'modname' => 'Module Name',
			'description' => 'Bean Description',
			'sort' => 'Sort Order',
		);
		$file = EspressoGrinder::get_module_path( EspressoGrinder::get_module_slug( $module  ) , $dir);
		$mod = get_file_data( $file, $headers );

		if ( empty( $mod['sort'] ) )
			$mod['sort'] = 10;
		if ( !empty( $mod['name'] ) || !empty( $mod['modname'] ) )
			return $mod;
		return false;
	}
	
	/**
	 * Returns an array of all PHP files in the specified absolute path.
	 * Equivalent to glob( "$absolute_path/*.php" ).
	 *
	 * @param string $absolute_path The absolute path of the directory to search.
	 * @return array Array of absolute paths to the PHP files.
	 */
	static function glob_php( $absolute_path ) {
		$absolute_path = untrailingslashit( $absolute_path );
		$files = array();
		if ( !$dir = @opendir( $absolute_path ) ) {
			return $files;
		}

		while ( false !== $file = readdir( $dir ) ) {
			if ( '.' == substr( $file, 0, 1 ) || '.php' != substr( $file, -4 ) ) {
				continue;
			}

			$file = "$absolute_path/$file";

			if ( !is_file( $file ) ) {
				continue;
			}

			$files[] = $file;
		}

		closedir( $dir );

		return $files;
	}
	
	
}

add_action( 'espresso_load_beans', array( 'EspressoGrinder', 'init' ) );
//add_action( 'init', array( 'HyperDrive', 'load_modules' ), 100 );