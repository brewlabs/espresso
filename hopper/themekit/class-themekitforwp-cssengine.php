<?php
/**
 * ThemeKit CSS Engine Class
 *
 * All calls to the class should be setup in the main class ThemeKitForWP
 *
 * @version 1.0
 *
 * @package themekit
 * @author Josh Lyford
 **/
class ThemeKitForWP_CSSEngine {
	
	private $_tk; //Instance of the Class that loaded this class  - ThemeKitForWP
	
	function __construct($instance){
		$this->_tk = $instance;     
	}
	
	function array_identical($a, $b) {
	    return (is_array($a) && is_array($b) && array_diff_assoc($a, $b) === array_diff_assoc($b, $a));
	}
	
	function array_equal($a, $b) {
	    return (is_array($a) && is_array($b) && array_diff($a, $b) === array_diff($b, $a));
	}
	/**
	*
	* Builds the Styles that have been set in ThemeKit Options
	*
	*
	* @since 1.0.0 
	*
	*/
	public function start($css_only = false){
		$saved = get_option( $this->_tk->get_option_name() );
		$default = $this->_tk->get_default_settings();
		$styles ='';
		if ( false == $css_only ) {
			$styles = '<!-- THEMEKITFORWP STYLE OPTIONS '.$this->_tk->get_option_name().'-->
			<style>';
		}
		
		foreach ($this->_tk->get_registered_options() as $k => $v) {
			if( isset($v['selector']) && !is_array( $default[$v[ "id" ]] ) && $saved[$v[ "id" ]] !== $default[$v[ "id" ]] ) {
				$styles.= ' '.$v['selector'].'{';
					$styles .= $this->style_switch($v, $saved);
				$styles.= '}';
			}
			if( isset($v['selector']) && is_array( $default[$v[ "id" ]] )  ) {
				$data= false;
					$data = $this->array_identical( $saved[$v[ "id" ]] , $default[$v[ "id" ]]);
				if( !$data){
				$styles.= ' '.$v['selector'].'{';
					$styles .= $this->style_switch($v, $saved);
				$styles.= '}';
				}
			}
			if( isset($v['multi_selector'])) 
			{
				foreach($v['type'] as $array){
				 if($saved[$array[ "id" ]] !== $default[$array[ "id" ]]){
				
				$styles.= ' '.$array['selector'].'{';
					$styles .= $this->style_switch($array, $saved);
				$styles.= '}';
				}
			}
			}
		}
		if ( false == $css_only ) {
			$styles .='</style><!-- END THEMEKITFORWP STYLE OPTIONS -->';
		}
		return $styles;
	}

	private function style_switch($v, $saved){
		$styles='';
			switch( $v['style'] ){
				case 'add-style':
					$styles .= $v['styles'];
				break;
				case 'background-image':
					$styles .= ' background-image: url("'.$saved[ $v[ "id" ] ].'");';
				break;
				case 'background-color':
					$bgcolor = $saved[ $v[ "id" ] ];
					if($bgcolor == '#'){
						$styles .= ' background-color: transparent;';
					}else{
						$styles .= ' background-color: '. $bgcolor .';';
					}
				break;
				case 'background-multi':
					$bgcolor = $saved[ $v[ "id" ]]["color"];
					if($bgcolor == '#'){
						$styles .= ' background: transparent;';
					}else{
						$styles .= ' background: '. $bgcolor .';';
					}
				break;
				case 'color':
					if($saved[ $v[ "id" ] ] !== '#'){
						$styles .= ' color: '. $saved[ $v[ "id" ] ] .';';
					}
				break;
				case 'padding':
					$styles .= ' padding: '. $saved[ $v[ "id" ] ]["top"] .'px '. $saved[ $v[ "id" ] ]["right"] .'px '. $saved[ $v[ "id" ] ]["bottom"] .'px '. $saved[ $v[ "id" ] ]["left"] .'px; ';
				break;
				case 'border-top':
					$styles .= ' border-top: '. $saved[ $v[ "id" ] ]["color"] .' '. $saved[ $v[ "id" ] ]["style"] .' '. $saved[ $v[ "id" ] ]["width"] .'px;';
				break;
				case 'border-bottom':
					$styles .= ' border-bottom: '. $saved[ $v[ "id" ] ]["color"] .' '. $saved[ $v[ "id" ] ]["style"] .' '. $saved[ $v[ "id" ] ]["width"] .'px;';
				break;
				case 'border-left':
					$styles .= ' border-left: '. $saved[ $v[ "id" ] ]["color"] .' '. $saved[ $v[ "id" ] ]["style"] .' '. $saved[ $v[ "id" ] ]["width"] .'px;';
				break;
				case 'border-right':
					$styles .= ' border-right: '. $saved[ $v[ "id" ] ]["color"] .' '. $saved[ $v[ "id" ] ]["style"] .' '. $saved[ $v[ "id" ] ]["width"] .'px;';
				break;
				case 'button-background':
					if(isset($saved[ $v[ "id" ] ]["color"]) && $saved[ $v[ "id" ] ]["color"] !== '#'){
						$styles .= ' background: '. $saved[ $v[ "id" ] ]["color"] .'; ';
					}
				break;
				case 'button-border':
					if(isset($saved[ $v[ "id" ] ]["color"]) && $saved[ $v[ "id" ] ]["color"] !== '#'){
						$styles .= ' border-color: '. $saved[ $v[ "id" ] ]["color"] .'; ';
					}
				break;
				case 'font':
					//print_r($v);
					$inherit = false;
					if( is_array($v[ "id" ]) ){
						$inherit = $v[ "id" ]['face'] == 'Use Theme Font' ? true: false; 
					}
					$font_list = $this->_tk->get_fonts($inherit);
					
					
					if(isset( $saved[ $v[ "id" ] ]["underline"] )){
						$decor =  $saved[ $v[ "id" ] ]["underline"];
						if($decor == 'underline'){
							$styles .= ' text-decoration: underline; ';
						} elseif($decor =='none'){
							$styles .= ' text-decoration: none; ';
						}
					}
					
					if(isset( $saved[ $v[ "id" ] ]["style"])){
						$style = $saved[ $v[ "id" ] ]["style"];
						if($style == "bold"){
							$styles .= ' font-weight: bold; ';
							$styles .= ' font-style: normal; ';							
						} elseif($style == "bold italic"){
							$styles .= ' font-weight: bold; ';
							$styles .= ' font-style: italic; ';							
						} elseif($style == "italic"){
							$styles .= ' font-weight: normal; ';
							$styles .= ' font-style: italic; ';							
						} else {
							$styles .= ' font-weight: normal; ';
							$styles .= ' font-style: normal; ';
						}
					}
						
					if(isset($saved[ $v[ "id" ] ]["size"])){
						$styles .= ' font-size: '. $saved[ $v[ "id" ] ]["size"] .'px; ';
					}
					
					if(isset($saved[ $v[ "id" ] ]["color"]) && $saved[ $v[ "id" ] ]["color"] !== '#'){
						$styles .= ' color: '. $saved[ $v[ "id" ] ]["color"] .'; ';
					}
					
					if(isset($saved[$v[ "id" ]]["face"] )){
						if(isset($font_list[ $saved[$v[ "id" ]]["face"] ]["family"]) && $font_list[ $saved[$v[ "id" ]]["face"] ]["family"] ){
							$styles .= ' font-family: '. $font_list[ $saved[$v[ "id" ]]["face"] ]["family"] .'; ';
						}
					}
					
				break;
			}
			$filter='';
			$filter .= apply_filters('themekitforwp_css_engine_'.$this->_tk->get_option_name(), $v, $saved );
			if(is_string( $filter )){
				$styles .= $filter;				
			}
		return $styles;
	}



	/**
	*
	* Creates Google Fonts Link to style sheet
	*
	*
	* @since 1.0.0 
	*
	*/
	public function add_google_font_api(){
		$saved = get_option( $this->_tk->get_option_name() );
		if( ! empty( $saved[ 'google_font_list' ] ) ) {

			$font_list = '';
			foreach($saved[ 'google_font_list' ] as $font){
				$font = str_replace('_', ' ', $font);
				$font = ucwords($font);
				$font = str_replace(' ', '+', $font);
				$font_list .= $font.'|';
			}
			
			?>
		 	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $font_list; ?>" rel="stylesheet" type="text/css" />
 			<?php
		}
	}
} //End CSS ENGINE
?>