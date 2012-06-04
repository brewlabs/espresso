<?php
/**
 * ThemeKit Fonts Class
 *
 * All calls to the class should be setup in the main class ThemeKitForWP
 *
 * @version 1.0
 *
 * @package themekit
 * @author Josh Lyford
 **/
class ThemeKitForWP_Fonts {
	//Font Storage Class
	
	private $_fonts = array();
	private $_tk; //Instance of the Class that loaded this class  - ThemeKitForWP
	private	$_group_types = array('standard','google');
	
	function __construct($instance){
		$this->_tk = $instance;	
		$this->build_font_list();	
	}
	
	/**
	*
	* Builds Default ThemeKit Font Array
	*
	*
	* @since 1.0.0 
	*
	* @access private
	*/
	private function build_font_list(){
		$fonts = array();
		$universal_fonts = array(
	        'Georgia',
	        'Helvetica',
	        'Times New Roman',
	        'Arial',
	        'Arial Narrow',
	        'Impact',
	        'Palatino Linotype',
	        'Courier New',
	        'Century Gothic',
	        'Lucida Sans Unicode',
			'Lucida Grande',
			'Verdana',
			'Trebuchet',
			'Trebuchet MS',
			'Tahoma'
	    );

	    foreach($universal_fonts as $font):
	        $fonts[strtolower(str_replace(' ', '_', $font))] = array(
	            'name' => $font,
	            'id' => strtolower(str_replace(' ', '_', $font)),
	            'family' => $font,
				"type" => "standard",
				"warn"=> 0
	        );
	    endforeach;
	
		
		
		/*
		*
		*	Google Fonts
		*
		*/
		$google_fonts = array(
	        'Sue Ellen Francisco',
	        'Aclonica',
	        'Damion',
	        'News Cycle',
	        'Swanky and Moo Moo',
	        'Wallpoet',
	        'Over the Rainbow',
	        'Special Elite',
	        'Quattrocento Sans',
	        'Smythe',
	        'The Girl Next Door',
	        'Sue Ellen Francisco',
	        'Dawning of a New Day',
	        'Waiting for the Sunrise',
	        'Annie Use Your Telescope',
	        'Bangers',
	        'VT323',
	        'Six Caps',
	        'EB Garamond',
	        'Miltonian',
	        'Miltonian Tattoo',
	        'Sunshiney',
	        'Indie Flower',
	        'Sniglet:800',
	        'Terminal Dosis Light',
	        'Anonymous Pro',
	        'Bevan',
	        'Nova Square',
	        'Nova Oval',
	        'Nova Slim',
	        'Nova Mono',
	        'Nova Round',
	        'Nova Cut',
	        'Nova Flat',
	        'Nova Script',
	        'Lekton',
	        'MedievalSharp',
	        'Michroma',
	        'Philosopher',
	        'Kenia',
	        'Maiden Orange',
	        'Kristi',
	        'Astloch',
	        'Architects Daughter',
	        'Cuprum',
	        'Crimson Text',
	        'Cabin',
	        'Quattrocento',
	        'Expletus Sans',
	        'PT Serif',
	        'PT Serif Caption',
	        'Josefin Slab',
	        'UnifrakturMaguntia',
	        'Radley',
	        'Crafty Girls',
	        'Vibur',
	        'Geo',
	        'Luckiest Guy',
	        'Anton',
	        'IM Fell Double Pica SC',
	        'IM Fell Great Primer SC',
	        'IM Fell DW Pica',
	        'IM Fell Double Pica',
	        'IM Fell French Canon',
	        'IM Fell English SC',
	        'IM Fell Great Primer',
	        'IM Fell DW Pica SC',
	        'IM Fell English',
	        'IM Fell French Canon SC',
	        'Cousine',
	        'Just Another Hand',
	        'Molengo',
	        'Raleway:100',
	        'Old Standard TT',
	        'Mountains of Christmas',
	        'Homemade Apple',
	        'Coda',
	        'Neucha',
	        'League Script',
	        'Unkempt',
	        'Walter Turncoat',
	        'Cherry Cream Soda',
	        'Calligraffitti',
	        'Permanent Marker',
	        'Josefin Sans',
	        'Lato',
	        'Meddon',
	        'Kranky',
	        'Rock Salt',
	        'Arimo',
	        'Covered By Your Grace',
	        'Just Me Again Down Here',
	        'Neuton',
	        'Schoolbell',
	        'OFL Sorts Mill Goudy TT',
	        'Syncopate',
	        'Droid Sans',
	        'Inconsolata',
	        'Tinos',
	        'Droid Serif',
	        'Vollkorn',
	        'Reenie Beanie',
	        'Cardo',
	        'Arvo',
	        'Droid Sans Mono',
	        'Merriweather',
	        'Yanone Kaffeesatz',
	        'Candal',
	        'Cantarell',
	        'Gruppo',
	        'Lobster',
	        'PT Sans',
	        'PT Sans Narrow',
	        'PT Sans Caption',
	        'Chewy',
	        'Coming Soon',
	        'Pacifico',
	        'Orbitron',
	        'Tangerine',
	        'Allerta Stencil',
	        'Allerta',
	        'Fontdiner Swanky',
	        'Ubuntu',
	        'Nobile',
	        'Slackey',
	        'Bentham',
	        'Crushed',
	        'Puritan',
	        'Corben:bold',
	        'Dancing Script',
	        'Kreon',
	        'Amaranth',
	        'Irish Grover',
	        'Cabin Sketch:bold',
	        'UnifrakturCook:bold',
	        'Buda:light',
	        'Coda:800',
	        'Coda Caption:800',
	        'Vast Shadow'
	    );

	    sort($google_fonts);
	    
	    foreach($google_fonts as $font):
	        if(preg_match('/:/', $font)):
	            $string = explode(':', $font);
	            $font = $string[0];
	            $style = ':'.$string[1];
	        else:
	            $style = '';
	        endif;
	        $fonts[strtolower(str_replace(' ', '_', $font))] = array(
	            'name' => $font,
	            'id' => strtolower(str_replace(' ', '_', $font)),
				'type'=> 'google',
	            'style' => 'http://fonts.googleapis.com/css?family='.str_replace(' ', '+', $font).$style,
	            'family' => $font,
				'variant'=> $style
	        );
	    endforeach;
		
		$this->_fonts = $fonts;	
	}
	
	/**
	*
	* Add Font to ThemeKit Font List
	*
	* Currently only supports text input
	*
	* @since 1.0.0 
	*
	* @param array $font option currently being created
	*
	* 	$fonts['Yanone Kaffeesatz'] = array(
	*		"name" =>"Yanone Kaffeesatz",
	*		"family"=> "'Yanone Kaffeesatz', arial, serif",
	*		"type" => "google",
	*		"warn"=> 0,
	*		'variant' => ':r,b'
	*	);
	*/
	public function add_font( $font ){
		$this->_fonts[$font['name']] = $font;
	}
	
	public function remove_font(){
	
	}
	
	/**
	*
	* Remove All fonts from list so New fonts can be added.
	*
	*
	* @since 1.0.0 
	*
	*/
	public function remove_all_fonts(){
		$this->_fonts = array();
	}
	
	/**
	*
	* Return Current Registered Font Array
	*
	* Currently only supports text input
	*
	* @since 1.0.0 
	*
	* @return array - font list
	*/
	public function get_fonts( $inherit = false ){
		$font_list = $this->_fonts;
		if($inherit == true){
			
			
			$font_list['Use Theme Font']= array(
				"name" =>"Use Theme Font",
				"family"=> "inherit",
				"type" => "standard",
				"warn"=> 0,
			);
		}
		return $font_list;
	}
	
	/**
	*
	* Add A new font Section to Drop Down List
	*
	*
	* @since 1.0.0 
	*
	* @param string $type name of new group ex: Google
	*/
	public function add_group_type( $type ){
		array_push($this->_group_types, $type);
	}
	
	/**
	*
	* Get Current Font Groups
	*
	*
	* @since 1.0.0 
	*
	* @return array - ThemeKit Fonts groups
	*/
	public function get_group_types( ){
		return $this->_group_types;
	}
	
}