<?php
/**
 * ThemeKit Options Save Class
 *
 * All calls to the class should be setup in the main class ThemeKitForWP
 *
 * @version 1.0
 *
 * @package themekit
 * @author Josh Lyford
 **/
class ThemeKitForWP_OptionsSave {
	
	private $_tk; //Instance of the Class that loaded this class  - ThemeKitForWP
	private $save_data = array();
	
	function __construct($instance){
		$this->_tk = $instance;     
	}
	
	/**
	*
	* Update a Single Themekit Option in the DB
	*
	*
	* @since 1.0.0 
	*
	* @param string $name option name to be updated
	* @param string|int|array $value new value for option
	*/
	public function update_option( $name, $value = null ){
		$saved = get_option( $this->_tk->get_option_name() );
		
		if( $value == null){
			//Not Sure if Unset is the best option here
			unset($saved[$name]);
		} else {
			$saved[$name] = $value;	
		}
		return update_option($this->_tk->get_option_name() , $saved );
	}
	
	
	/**
	*
	* Save Options Values to DB
	*
	*
	* @since 1.0.0 
	*
	* @access private
	* @param bool $default if true Load's default settings. 
	*/
	function save($default = false){
		if ( $default == true ||  isset( $_REQUEST['action'] ) && 'save' == $_REQUEST['action'] &&	check_admin_referer( $this->_tk->get_option_name() )) {
		 	$save_data['google_font_list'] = array();
			$fontlist= $this->_tk->get_fonts();
			foreach ($this->_tk->get_registered_options() as $key => $value) {
							
							$id = isset($value['id']) ? $value['id'] : null;

							if ( is_array($value['type']) && $value['type'] != 'upload') {
								foreach($value['type'] as $array){
									if($array['type'] == 'text'){
										
									$mid = $array['id']; 
									$multidata[$mid] = isset($_REQUEST[$value['id'].':'.$mid]) ? stripslashes($_REQUEST[$value['id'].':'.$mid]) : stripslashes($array['std']) ;
									}
									if($array['type'] == 'font_multi'){
										$mid = $array['id']; 
										$inherit = isset( $array['std']['face']) && $array['std']['face'] == 'Use Theme Font' ? true: false;
										$fontlist= $this->_tk->get_fonts($inherit);
										$typography_array = array();    
										if( isset($_REQUEST[$array['id'] . '_size']) ){
											$typography_array['size'] = $_REQUEST[$array['id'] . '_size'];
										} else {
											if(isset($array['std']['size'])){
												$typography_array['size']  = $array['std']['size'];
											}
										}

										if( isset($_REQUEST[$array['id'] . '_face']) ){
											$typography_array['face'] = stripslashes($_REQUEST[$array['id'] . '_face']);
										} else {
											if(isset($array['std']['face'])){
												$typography_array['face']  = $array['std']['face'];
											}
										}

										if( isset($_REQUEST[$array['id'] . '_style']) ){
											$typography_array['style'] = $_REQUEST[$array['id'] . '_style'];
										} else {
											if(isset($array['std']['style'])){
												$typography_array['style']  = $array['std']['style'];
											}
										}
										if( isset($_REQUEST[$array['id'] . '_color']) ){
											$typography_array['color'] = $_REQUEST[$array['id'] . '_color'];
										} else {
											if(isset($array['std']['color'])){
												$typography_array['color']  = $array['std']['color'];
											}
										}
										if( isset($_REQUEST[$array['id'] . '_underline']) ){
											$typography_array['underline'] = $_REQUEST[$array['id'] . '_underline'];
										} else {
											if(isset($array['std']['underline'])){
												$typography_array['underline']  = $array['std']['underline'];
											}
										}
										$save_data[$mid ] = $typography_array;
										if(isset($typography_array['face']) && $fontlist[$typography_array['face']]['type'] == 'google' && !in_array($typography_array['face'], $save_data['google_font_list'])){
											array_push($save_data['google_font_list'],urlencode($typography_array['face']).$fontlist[$typography_array['face']]['variant']  );
										}
										//update_option($id,$typography_array);
									
								
									}
									
								}  
								if(!empty($multidata) ){
									$save_data[$id]  = $multidata;             
								}
							}
							elseif($value['type'] == 'checkbox'){
								 if(isset( $_REQUEST[$id])){
									 $save_data[$id] =  $_REQUEST[ $id ] ;
									//update_option( $id, $_REQUEST[ $id] );
								 } else { 
									$save_data[$id] = $value['std'];
									//update_option( $id, 'false' ); 
								 }
							} 
							elseif($value['type'] == 'radio'){
								 if(isset( $_REQUEST[$id])){
									 $save_data[$id] = $_REQUEST[ $id ];
									//update_option( $id, $_REQUEST[ $id] );
								 } else { 
									$save_data[$id] = $value['std'];
									//update_option( $id, 'false' ); 
								 }
							}
							elseif($value['type'] == 'select'){
								 if(isset( $_REQUEST[$id])){
									 $save_data[$id] = htmlentities($_REQUEST[ $id] );
									//update_option( $id, htmlentities($_REQUEST[ $id] ));
								 } else {
									$save_data[$id] = $value['std'];
									//delete_option( htmlentities( $id )); 
								 }

							} 
							elseif($value['type'] == 'upload'){
								 if(isset( $_REQUEST[$id])){
									 $save_data[$id] = $_REQUEST[ $id];
									//update_option( $id, htmlentities($_REQUEST[ $id] ));
								 } else {
									$save_data[$id] = false;
									//delete_option( htmlentities( $id )); 
								 }

							}
							elseif($value['type'] == 'upload2' ){
								$override['test_form'] = false;
								$override['action'] = 'tk_save';

								 if(!empty( $_FILES[$id]['name'])){ //New upload     
										$image_id = media_handle_upload($id, 0, array('post_title'=>'Option: '.$value['name']));
									    /* 
										$uploaded_file = wp_handle_upload($_FILES['attachement_' . $id ],$override); 
										$uploaded_file['option_name']  = $value['name'];
										$upload_tracking[] = $uploaded_file;
										//update_option( $id , $uploaded_file['url'] );
										//getimagesize($uploaded_file['file']);
										$imageInfo = getimagesize($uploaded_file['file']);
										$thumb	= image_resize($uploaded_file['file'], 100, 100);
										$thumbImage = explode('/',$thumb);
										$info = wp_upload_dir();
										$thumbImage = $info['url'] .'/'. $thumbImage[count($thumbImage) - 1];
										$save_data[$id] = array('url'=>$uploaded_file['url'], 'width'=> $imageInfo[0], 'height'=> $imageInfo[1], 'mini'=> $thumbImage);
									*/	 
										$save_data[$id] = $image_id;
										}
								 elseif(isset( $_REQUEST[ $id .'_id'])){ // No new file, just the already saved file
										/*
									   $image_array = array();
									   $image_array['url'] = $_REQUEST[ $id .'_url'];
									   $image_array['width'] = $_REQUEST[ $id .'_width'];
									   $image_array['height'] = $_REQUEST[ $id .'_height'];
									   $image_array['mini'] = $_REQUEST[ $id .'_mini'];
									   $save_data[$id] = $image_array;
										*/
										$save_data[$id] = $_REQUEST[ $id .'_id'];
									   //update_option( $id , $_REQUEST[$id] );
									}
							}elseif($value['type'] == 'typography'){
								$inherit = isset( $value['std']['face']) && $value['std']['face'] == 'Use Theme Font' ? true: false;
								$fontlist= $this->_tk->get_fonts($inherit);
								$typography_array = array();    
								if( isset($_REQUEST[$value['id'] . '_size']) ){
									$typography_array['size'] = $_REQUEST[$value['id'] . '_size'];
								} else {
									if(isset($value['std']['size'])){
										$typography_array['size']  = $value['std']['size'];
									}
								}
								
								if( isset($_REQUEST[$value['id'] . '_face']) ){
									$typography_array['face'] = stripslashes($_REQUEST[$value['id'] . '_face']);
								} else {
									if(isset($value['std']['face'])){
										$typography_array['face']  = $value['std']['face'];
									}
								}
								
								if( isset($_REQUEST[$value['id'] . '_style']) ){
									$typography_array['style'] = $_REQUEST[$value['id'] . '_style'];
								} else {
									if(isset($value['std']['style'])){
										$typography_array['style']  = $value['std']['style'];
									}
								}
								if( isset($_REQUEST[$value['id'] . '_color']) ){
									$typography_array['color'] = $_REQUEST[$value['id'] . '_color'];
								} else {
									if(isset($value['std']['color'])){
										$typography_array['color']  = $value['std']['color'];
									}
								}
								if( isset($_REQUEST[$value['id'] . '_underline']) ){
									$typography_array['underline'] = $_REQUEST[$value['id'] . '_underline'];
								} else {
									if(isset($value['std']['underline'])){
										$typography_array['underline']  = $value['std']['underline'];
									}
								}
								$save_data[$id] = $typography_array;

								if(is_array($typography_array['face']) && array_key_exists('name', $typography_array['face'])){
									$font_name = $typography_array['face']['name'];	
								}

								if(isset($font_name)){
									if(isset($typography_array['face']) && $fontlist[$typography_array['face']]['type'] == 'google' && !in_array($font_name, $save_data['google_font_list'])){
										array_push($save_data['google_font_list'],urlencode($fontlist[$typography_array['face']]['name']).$fontlist[$typography_array['face']]['variant']  );
									}
								}
								
								
								//update_option($id,$typography_array);

							}
							elseif($value['type'] == 'border'){

								$border_array = array();    
								if(isset($_REQUEST[$value['id'] . '_width'])){
									$border_array['width'] = stripslashes($_REQUEST[$value['id'] . '_width']);

									$border_array['style'] = $_REQUEST[$value['id'] . '_style'];

									$border_array['color'] = $_REQUEST[$value['id'] . '_color'];
								} else {
									$border_array = $value['std'];
								}

								$save_data[$id] = $border_array;

							}
							elseif($value['type'] != 'multicheck'){
								 if(isset( $_REQUEST[ $id ])){
									$save_data[$id] = $_REQUEST[ $id ];
									//update_option( $id, $_REQUEST[$id] );
								 } else {
									if(isset($value['std'])){
										$save_data[$id] = $value['std']; 
									}
									//delete_option( $id); 
								 }
							}

							else  // Multicheck
							{
								foreach($value['options'] as $mc_key => $mc_value){
									$up_opt = $id . '_' . $mc_key;
									 if(isset( $_REQUEST[ $up_opt ])){
										$save_data[ $up_opt ] = stripslashes($_REQUEST[ $up_opt ]);
										//update_option( $up_opt, $_REQUEST[ $up_opt ] );

									 }  else {
										
										$save_data[ $up_opt ] = stripslashes($mc_value['std']);
										//update_option($up_opt, 'false' );
									 }
								}
							}
					}
					if(false == $default){
						update_option($this->_tk->get_option_name() , $save_data );
						$this->_tk->options_updated = true;
					} else {
						return $save_data;
					}
			} 
			else if( isset( $_REQUEST['action'] ) && 'reset' == $_REQUEST['action'] && 	check_admin_referer( $this->_tk->get_option_name() ) ) {
					//delete_option( $this->_tk->get_option_name());
					$default = $this->_tk->get_default_settings_init();
					$saved = get_option($this->_tk->get_option_name());
				
					if(is_array($saved)){
						foreach ($this->_tk->get_registered_options() as $key => $value) {
							if( is_array($value['type'] )){
									foreach($value['type'] as $array){
										if($array['type'] == 'text' && ! isset($array['no_reset'])){
											$saved[ $value['id'] ] = $default[ $value['id'] ];
										}
										if($array['type'] == 'font_multi' && ! isset($array['no_reset'])){
											$saved[ $array['id'] ] = $default[ $array['id'] ];
										}
																	}
							}
							elseif(! isset($value['no_reset']) && isset($value['id'])  ){
									$saved[ $value['id'] ] = $default[ $value['id'] ];
							}
						}
					
					}
				
				update_option( $this->_tk->get_option_name(), $saved );
				$this->_tk->options_updated = true;
			}
	}
	
	/**
	*
	* Create Archived Option - AJAX
	*
	* Currently not used
	*
	* @since 1.0.0 
	*
	*/	
	public function ajax_archive(){
		$archive  = get_option( $this->_tk->get_option_name() );
		$archive_holder = get_option( $this->_tk->get_option_name().'-archives' );
		$new_archive = $this->_tk->get_option_name().'-'. time();
		$archive_holder[] = $new_archive;			
	//	update_option($this->_tk->get_option_name().'-archives',$archive_holder );
	//	update_option($new_archive, $archive );
		die( json_encode($archive_holder) );
	}	
		
} // END Save Class
?>
