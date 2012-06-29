<?php
/**
 * ThemeKit Form Engine
 *
 * All calls to the class should be setup in the main class ThemeKitForWP
 *
 * @version 1.0
 *
 * @package themekit
 * @author Josh Lyford
 **/
class ThemeKitForWP_Engine {
	
	private $_tk; //Instance of the Class that loaded this class  - ThemeKitForWP
	private $_section = 0;
	private $_saved_options;
	
	function __construct( $instance ) {
		$this->_tk = $instance;     
	}
	
	/**
	*
	* ThemekitWP options Engine
	*
	* @since 1.0.0 
	*
	*/
	function start() {
		$this->_saved_options = $tk_options =  get_option( $this->_tk->get_option_name() );
		$i=0;
	 	foreach ($this->_tk->get_registered_options() as $value) {
			switch ( $value['type'] ) {
			
				case "section":
					$this->open_section( $value );
				break;
			
				case "open":
					$this->open_nosections( $value );
				break;
				
				case "close":
					$this->close_section( $value );
				break;
			 	
				case "title":
					$this->create_title( $value );
				break;
				
				case "description":
					$this->create_description( $value );
				break;

				case "section_description":
					$this->create_section_description( $value );
				break;
				
				case "html":
					$this->create_html( $value );
				break;
				
				case 'text':
					$this->create_text_input( $value );
				break;
			 	
				case 'textarea':
			 		$this->create_textarea( $value );
				break;
				
				case 'tinymce':
			 		$this->create_tinymce( $value );
				break;
				
			 	case 'select':
					$this->create_select( $value );
			 	break;
				case "checkbox": 
					$this->create_checkbox( $value );
				break; 
				case "radio": 
					$this->create_radio( $value );
				break; 
				
				case "radio-image": 
					$this->create_radio_image( $value );
				break;
				
				case 'upload2':
					$this->simple_image_uploader( $value );
				break;
				
				case 'upload':
					$this->wp_media_uploader( $value );
				break;
				
				case 'colorpicker':
					$this->create_color_picker( $value );
				break;
				case "border":
		 			$this->create_border_controller( $value );
				break;
				case "typography":
					//$default = $value['std'];
					//$typography_stored = $tk_options[ $value['id'] ];
					$this->create_font_selection( $value );
				break;
				case "cssdump":
					$this->create_css_dump($value);
				break;
				
				case "typography_old":
				break;
				   	
		 
			}
			 // if TYPE is an array, formatted into smaller inputs... ie smaller values
	        if ( is_array($value['type'])) {
        		$this->create_multi_option_input( $value );
			}
		}
	
	}
	
	/**
	*
	* Open HTML for option
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $v option currently being created
	*/
	private function form_element_start( $v ) { ?>
		<div class="tk_input tk_text">
			<div class="tkcontent">
				<div class="tkholder">
		
	<?php }

	/**
	*
	* Open HTML for option
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $v option currently being created
	*/
	private function form_element_start_simple( $v ) { ?>
		<div class="tk_input">
			<div class="tkcontent-simple">
				<div class="tkholder-simple">
		
	<?php }
	/**
	*
	* Open HTML for option
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $v option currently being created
	*/
	private function form_element_start_simple_edit( $v ) { ?>
		<div class="tk_input">
			<div class="tkcontent-simple-edit">
				<div class="tkholder-simple-edit">
		
	<?php }
	
	/**
	*
	* Ending HTML for option
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $v option currently being created
	*/
	private function form_element_end( $v ) { ?>
				</div>
			</div>
			<div class="info-left">
				<label for="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></label>
				<?php if(isset($v['subtext'])){
					echo '<p>'.$v['subtext'].'</p>';
				}?>
				</div>
				<div class="info-right">
				<?php echo isset($v['desc']) ? $v['desc'] : ""; ?>
			</div>
			<div class="clearfix"></div>
		</div>
	<?php }
	private function form_element_end_simple( $v ) { ?>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	<?php }
	private function form_element_end_simple_edit( $v ) { ?>
				</div>
			</div>
			<div class="info-left">
				<label for="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></label>
				<?php if(isset($v['subtext'])){
					echo '<p>'.$v['subtext'].'</p>';
				}?>
				</div>
			<div class="clearfix"></div>
		</div>
	<?php }
	/**
	*
	* Start of Options Section
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/
	private function open_section( $value )	{
		$this->_section++; 
		$section =  preg_replace("/[^a-zA-Z]/", "", $this->_tk->get_option_name() ) . $this->_section; 
		?>
		<div class="tk_slide tk_switch">
			<div class="tk_header" id="<?php echo $section ?>">
				<span class="submit"><input class="button-primary" name="save<?php echo $this->_section; ?>" type="submit" value="Save changes" /></span>
				<h3><?php echo isset($value['name']) ? $value['name'] : "&nbsp;" ; ?></h3>
			</div>
			<div class="tk_options">

	<?php }
	
	
	/**
	*
	* Start of Options w/o Open Close ability
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/
	private function open_nosections( $value ) {	
		$this->_section++; ?>
		<div class="tk_open tk_switch">
			<div class="tk_header">
				<span class="submit"><input class="button-primary" name="save<?php echo $this->_section; ?>" type="submit" value="Save changes" /></span>
				<h3><?php echo isset($value['name']) ? $value['name'] : "&nbsp;" ; ?></h3>
			</div>
			<div class="tk_options">
	<?php }
	
	/**
	*
	* End Options Section
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/
	private function close_section( $value ) { ?>
			</div>
		</div>	
	<?php }
	
	/**
	*
	* Option Page Title 
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/
	private function create_title( $value ) { ?>
		<h3 class='tktitle'><?php echo $value['desc']; ?></h3>		
	<?php }
	
	/**
	*
	* Option Description 
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/
	private function create_description( $value ) { ?>
		<p><?php echo $value['desc']; ?></p>		
	<?php }

	private function create_section_description( $value ){
		$this->form_element_start_simple( $value ); 
		?>
		<p><?php echo $value['desc']; ?></p>
		<?php
		$this->form_element_end_simple( $value ); 
	}
	
	
	/**
	*
	* Option HTML 
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/
	private function create_html( $value ) { 
		echo $value['code'];
	 }
	
	
	
	
	
	/**
	*
	* Text Input
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/
	private function create_text_input( $value ) {	
		$this->form_element_start( $value ); ?>
			
		 		<input class="text" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( isset($this->_saved_options[ $value['id'] ] ) && $this->_saved_options[ $value['id'] ] != "") { echo stripslashes($this->_saved_options[ $value['id'] ] ); } else { echo $value['std']; } ?>" />
		 			
	<?php $this->form_element_end( $value );
	}
	
	/**
	*
	* TextArea
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/
	private function create_textarea( $value ) {
	
		$this->form_element_start( $value ); ?>
		<textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if (  $this->_saved_options[ $value['id']] != "" && isset($this->_saved_options[ $value['id']] )) { echo stripslashes( $this->_saved_options[ $value['id']] ); 
			} 
			else { echo $value['std']; } ?></textarea>
	
	<?php 
	
	$this->form_element_end( $value );
	}
	
	


	
	/**
	*
	* Tinymce
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/
	private function create_tinymce( $value ) {	
		$this->form_element_start_simple_edit( $value ); 
			wp_tiny_mce(false,array('editor_selector'=>$value['id'] ));	?>
			<a id="edButtonHTML" class="active hide-if-no-js" onclick="switchEditors.go('<?php $value['id']; ?>', 'html');"><?php _e('HTML'); ?></a>
						<a id="edButtonPreview" class="hide-if-no-js" onclick="switchEditors.go('<?php $value['id']; ?>', 'tinymce');"><?php _e('Visual'); ?></a>
				<textarea name="<?php echo $value['id']; ?>" class="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if (  $this->_saved_options[ $value['id']] != "" && isset($this->_saved_options[ $value['id']] )) { echo stripslashes( $this->_saved_options[ $value['id']] ); 
					} 
					else { echo $value['std']; } ?></textarea>
	<?php $this->form_element_end_simple_edit( $value );
	}
	
	
	/**
	*
	* CSS Dump
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/
	private function create_css_dump( $value ) {	
		$this->form_element_start( $value ); 
		$css =  $this->_tk->get_css();
		$css = trim($css);
		$css =  str_replace("\t",'',$css);
		
		?>
		<style><?php echo $css; ?></style>
		<textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php echo $css; ?></textarea>
	
	<?php $this->form_element_end( $value );
	}
	

	/**
	*
	* Select
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/
	private function create_select( $value ) {	
		$this->form_element_start( $value ); ?>
				<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
				<?php foreach ($value['options'] as $option) { ?>
					<option value="<?php echo $option['id']; ?>" <?php if ( isset($this->_saved_options[ $value['id'] ]) && $this->_saved_options[ $value['id'] ] == $option['id']) { echo 'selected="selected"'; } ?>>
						<?php echo $option['name']; ?>
					</option>
				<?php } ?>
				</select>
				<?php $this->form_element_end( $value );
	}
	
	/**
	*
	* Checkbox
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/
	private function create_checkbox( $value ) {	
		$this->form_element_start( $value ); 
		$checked = "";
		if( isset($this->_saved_options[ $value['id']]) && true ==  $this->_saved_options[ $value['id']]){ 
			$checked = "checked=\"checked\""; 	
		} else { 
			if($value['std'] == true){
				$checked = 	"checked=\"checked\""; 
			}	
		} ?>
		<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> /> 
		<?php if(isset($value['cbtext'])) { echo "<span class='cbtext'>". $value['cbtext']."</span>";  }?>
		<?php $this->form_element_end( $value );
	}
	
	/**
	*
	* Radio Button
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/			
	private function create_radio( $v ) {
		$this->form_element_start( $v ); 
		foreach ($v['options'] as $key => $option) { 
			$checked = '';
			if(isset($this->_saved_options[ $v['id']]) &&  $this->_saved_options[ $v['id']] != '')  {
				if ($this->_saved_options[ $v['id']]  == $key) { 
					$checked = ' checked'; 
			   	} 
			} else {
				if ($v['std'] == $key) { $checked = ' checked'; }
			} ?>
			<input class="tk_radio" type="radio" name="<?php echo $v['id']; ?>" value="<?php echo $key ?>" <?php echo $checked ?> /><?php echo $option ?><br />
			<?php
		}
	 	$this->form_element_end( $v );
	}			
	
	
	
	/**
	*
	* Radio Image
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/			
	private function create_radio_image( $v ) {
		$this->form_element_start_simple( $v ); 
		if(array_key_exists('name', $v)){
		?>
			
				<label for="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></label>
				
			<?php } ?>
		<div class='clear image-radio-option'>
			<ul>	
		<?php
		
		foreach ($v['options'] as $key => $option) { 
	 		$checked = '';
			if(isset($this->_saved_options[ $v['id']]) &&  $this->_saved_options[ $v['id']] != '')  {
				if ($this->_saved_options[ $v['id']]  == $option['value']) { 
					$checked = ' checked'; 
			   	} 
			} else {
				if ($v['std'] == $option['value']) { $checked = ' checked'; }
			} ?>	<li><label class="description">
			<input class="tk_radio" type="radio" name="<?php echo $v['id']; ?>" value="<?php echo $option['value'] ?>" <?php echo $checked ?> />
			<span>
				<img src="<?php echo esc_url( $option['thumbnail'] ); ?>"/>
				<?php echo $option['label']; ?>
			</span>
			</label></li>
			
			<?php
		}?></ul></div>
		<div class="clear">
		<?php if(isset($v['subtext'])){
			echo '<p>'.$v['subtext'].'</p>';
		}?>
		<?php echo isset($v['desc']) ? $v['desc'] : ""; ?>
		</div>
		<?php
		$this->form_element_end_simple( $v );
	}			
	
	
	/**
	*
	* Multiple Input Option
	*
	* Currently only supports text input
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/			
	private function create_multi_option_input( $v ) {
		$this->form_element_start( $v ); 
		$saved_opt = isset( $this->_saved_options[ $v['id'] ]) ? $this->_saved_options[ $v['id'] ]: null ;
		$count= 0;
		foreach ($v['type'] as $array) {
			$count++;
        	$id = $array['id']; 
            $std = $array['std'];
            $meta = $array['meta'];
            $label = $array['label'];
			
			if ( isset($saved_opt[$id]) && $saved_opt[$id] != $std ) { $std = $saved_opt[$id]; } 
            if( $array['type'] == 'text' ) { ?>
				<span class="meta-two"><?php echo $label; ?></span>
                <input class="input-text-small <?php echo $meta; ?>" name="<?php echo $v['id'].':'.$id; ?>" id="<?php echo $v['id'].':'.$id; ?>" type="text" value="<?php echo $std; ?>" />  
                <span class="meta-two"><?php echo $meta; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            }

		   if( $array['type'] == 'font_multi' ) { 
				$style = 'float:left;';
				$style .= ($count > 1) ? 'padding: 0 15px 15px;' : '';
				$style .= ($count % 2) ? 'clear:left;' : ''; 

				?>
				
				<div style="<?php echo $style;?> ">
				<?php if( strlen($label) > 0 ): ?>
					<span class="meta-two"><?php echo $label; ?></span>
				<?php endif; ?>
				<?php
				$this->create_font_selection( $array, true ); ?><span class="meta-two"><?php echo $meta; ?></span>

				</div>

				<?php
			}


      	}
        $this->form_element_end( $v );
    }
	
	
	/**
	*
	* Color Picker
	*
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/
	private function create_color_picker( $value ) {	
		$this->form_element_start( $value ); ?>
		<input class="cpcontroller" data-id="<?php echo $value['id']; ?>" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php if ( isset($this->_saved_options[ $value['id']]) && $this->_saved_options[ $value['id']] != "") { echo stripslashes( $this->_saved_options[ $value['id']]  ); } else { echo $value['std']; } ?>" />
		<input type='hidden' value='<?php echo $value['std'];?>' id='default_<?php echo $value['id']; ?>'/>
		<span class="submit"><input name="reset" class="inline-reset" type="button" data-type="cp" data-id="<?php echo $value['id']; ?>" title="Reset to Default Value" value="Reset" /></span>	
		<div id="pickholder_<?php echo $value['id']; ?>" class="colorpick clearfix">
			<a class="close-picker">x</a>
			<div id="<?php echo $value['id']; ?>_colorpicker" class="colorpicker_space"></div>
		</div>
		<?php $this->form_element_end( $value );
	}
	
	/**
	*
	* Border
	*
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/
	private function create_border_controller( $value ) {
		$output ='';
		$default = $value['std'];
		$border_stored = isset($this->_saved_options[ $value['id'] ]) ? $this->_saved_options[ $value['id'] ]: null;
		
		/* Border Width */
		$val = $default['width'];
		if ( $border_stored['width'] != "") { $val = $border_stored['width']; }
				
		$this->form_element_start( $value ); ?>
		
		<select  name="<?php echo $value['id']; ?>_width" id="<?php echo $value['id']; ?>_width">
			<?php
			for ($i = 0; $i < 21; $i++){ 
				if($val == $i){ $active = 'selected="selected"'; } else { $active = ''; }
				$output .= '<option value="'. $i .'" ' . $active . '>'. $i .'px</option>'; 
			}
			echo $output;
			$output = "";
			?>
		</select>
		
		<?php
		/* Border Style */
		$val = $default['style'];
		if ( $border_stored['style'] != "") { $val = $border_stored['style']; }
		$solid = ''; $dashed = ''; $dotted = '';
		if($val == 'solid'){ $solid = 'selected="selected"'; }
		if($val == 'dashed'){ $dashed = 'selected="selected"'; }
		if($val == 'dotted'){ $dotted = 'selected="selected"'; }
		?>
		<select class="" name="<?php echo $value['id']; ?>_style" id="<?php echo $value['id']; ?>_style">';
			<option value="solid" <?php echo $solid; ?>>Solid</option>
			<option value="dashed" <?php echo $dashed; ?>>Dashed</option>
			<option value="dotted" <?php echo $dotted; ?>>Dotted</option>
		</select>
		<?php
		/* Border Color */
		$val = $default['color'];
		if ( $border_stored['color'] != "") { $val = $border_stored['color']; }	
		?>		
		<input class="cpcontroller" data-id="<?php echo $value['id']; ?>" name="<?php echo $value['id']; ?>_color" id="<?php echo $value['id']; ?>_color" type="text" value="<?php echo $val; ?>" />
		<span class="submit"><input name="reset" class="inline-reset" type="button" data-type="border" data-id="<?php echo $value['id']; ?>" title="Reset to Default Value" value="Reset" /></span>
		<input type='hidden' value='<?php echo $value['std']['width'];?>' id='default_<?php echo $value['id']; ?>_width'/>
		<input type='hidden' value='<?php echo $value['std']['style'];?>' id='default_<?php echo $value['id']; ?>_style'/>
		<input type='hidden' value='<?php echo $value['std']['color'];?>' id='default_<?php echo $value['id']; ?>_color'/>
		<div id="pickholder_<?php echo $value['id']; ?>" class="colorpick clearfix">
			<a class="close-picker">x</a>
			<div id="<?php echo $value['id']; ?>_colorpicker" class="colorpicker_space"></div>
		</div>
		<?php $this->form_element_end( $value );
	}
	
	/**
	*
	* Font
	*
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/
	private function create_font_selection( $value , $skip_form_elements = false) {
		$font_stored = isset($this->_saved_options[ $value['id'] ]) ? $this->_saved_options[ $value['id'] ]: null;
		$font_default = $value['std'];
		if(isset($font_default['color'])){
			$font_color = isset($font_stored['color']) ? $font_stored['color'] : $font_default['color'];
		}
	
		$output = '';
		if(!$skip_form_elements){
			$this->form_element_start( $value );
		}
		if(isset($font_default['size'])){  
			$font_size = isset($font_stored['size']) ? $font_stored['size'] : $font_default['size'];
			?>
				<select name="<?php echo $value['id']; ?>_size" id="<?php echo $value['id']; ?>_size">
				<?php for ($i = 9; $i < 71; $i++){ 
					if($font_size == $i){ $active = 'selected="selected"'; } else { $active = ''; }
					$output .= '<option value="'. $i .'" ' . $active . '>'. $i .'px</option>'; 
					}
				echo $output;
				$output='';
				?>
				</select>
		<?php 
		}
		if(isset($font_default['face'])){  
				$inherit = $font_default['face'] == 'Use Theme Font' ? true : false; 
				$fonts  = $this->_tk->get_fonts( $inherit );
				$types = $this->_tk->get_group_types();
			
			$font_face = isset($font_stored['face']) ? $font_stored['face'] : $font_default['face'];
			
			?>
		<select class="" name="<?php echo $value['id']; ?>_face" id="<?php echo $value['id']; ?>_face">
		<?php
			foreach($types as $type){
				echo '<optgroup label="'.ucfirst($type).'">';
				foreach ($fonts as $font => $info) {
					if($type == $info['type']){
					$selected = ($font == $font_face) ? 'selected="selected"' : '';
				 	echo '<option value="'.$font.'" '. $selected .'  >'. $info['name'] .'</option>';
					}					
				}
				echo '</optgroup>';
			}
		}
		?></select>
		<?php
		if(isset($font_default['style'])){ 
				$font_style = isset($font_stored['style']) ? $font_stored['style'] : $font_default['style'];
			
			/* Font Weight */
						$val = $font_default['style'];
						if ( isset($font_stored['style'] ) && $font_stored['style'] != "") { $val = $font_stored['style']; }
							$normal = ''; $italic = ''; $bold = ''; $bolditalic = '';
						if($val == 'normal'){ $normal = 'selected="selected"'; }
						if($val == 'italic'){ $italic = 'selected="selected"'; }
						if($val == 'bold'){ $bold = 'selected="selected"'; }
						if($val == 'bold italic'){ $bolditalic = 'selected="selected"'; }

						$output .= '<select class="" name="'. $value['id'].'_style" id="'. $value['id'].'_style">';
						$output .= '<option value="normal" '. $normal .'>Normal</option>';
						$output .= '<option value="italic" '. $italic .'>Italic</option>';
						$output .= '<option value="bold" '. $bold .'>Bold</option>';
						$output .= '<option value="bold italic" '. $bolditalic .'>Bold/Italic</option>';
						$output .= '</select>';

			
				echo $output;
			}
				$output = '';
			if(isset($font_default['underline'])){ 
				$val = $font_default['underline'];
				if ( $font_stored['underline'] != "") { $val = $font_stored['underline']; } 
					$normal = ''; $underline = ''; $bold = ''; $bolditalic = '';
				if($val == 'none'){ $normal = 'selected="selected"'; }
				if($val == 'underline'){ $underline = 'selected="selected"'; }
				
				
				?>
				<select class="" name="<?php echo $value['id']; ?>_underline" id="<?php echo $value['id']; ?>_underline">
					<option value='none' <?php echo $normal;?> >Normal</option>
					<option value='underline' <?php echo $underline;?> >Underline</option>
				</select>
				<?php
			}
		
		
			?>
			
			<?php if( isset($font_default['color']) ) { ?>
			<input class="cpcontroller" data-id="<?php echo $value['id']; ?>" name="<?php echo $value['id']; ?>_color" id="<?php echo $value['id']; ?>_color" type="text" value="<?php echo $font_color; ?>" />
			
				<!--<span class="submit"><input name="reset" class="inline-reset" type="button" data-type="font" data-id="<?php echo $value['id']; ?>" title="Reset to Default Value" value="Reset" /></span>-->
			
			<div id="pickholder_<?php echo $value['id']; ?>" class="colorpick clearfix">
				<a class="close-picker">x</a>
				<div id="<?php echo $value['id']; ?>_colorpicker" class="colorpicker_space">
			
				</div>
			</div>
				<input type='hidden' value='<?php echo $font_default['color'];?>' id='default_<?php echo $value['id']; ?>_color'/>
				<?php } ?>
				<?php if(isset($font_default['size'])){ ?>
				<input type='hidden' value='<?php echo $font_default['size'];?>' id='default_<?php echo $value['id']; ?>_size'/>
				<?php } ?>
				<?php if(isset($font_default['face'])){ ?>
				<input type='hidden' value='<?php echo $font_default['face'];?>' id='default_<?php echo $value['id']; ?>_face'/>
				<?php } ?>
				<?php if(isset($font_default['style'])){ ?>
				<input type='hidden' value='<?php echo $font_default['style'];?>' id='default_<?php echo $value['id']; ?>_style'/>
				<?php } ?>
				<?php if(isset($font_default['underline'])){ ?>
				<input type='hidden' value='<?php echo $font_default['underline'];?>' id='default_<?php echo $value['id']; ?>_underline'/>
				<?php } ?>
				
				<?php 
				if(!$skip_form_elements){
				$this->form_element_end( $value );
				}
	}
				
	/**
	*
	* Image Upload Option using WP Media Library
	*
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/			
	private function wp_media_uploader( $value ) {
		$image_stored = isset($this->_saved_options[ $value['id'] ]) ? $this->_saved_options[ $value['id'] ]: null;
		$this->form_element_start( $value ); 
		// Save Post ID and create function to return first attachment to the post.
		$id= $value['id'];
		$post_ID = $this->create_empty_post($value);
		$button_value = 'Select an Image';
		?>
		<div>
			<input type="hidden" option="<?php echo $post_ID; ?>" name="<?php echo $id; ?>" class="upload_input" value="<?php echo $image_stored; ?>"/>
			<div class='upload-image' id='holder-<?php echo $post_ID; ?>' nonce='<?php echo wp_create_nonce( "set_post_thumbnail-$post_ID" ); ?>'>
				<?php 
				if( isset( $image_stored ) && false != $image_stored ) {
					$temp_image = $this->get_upload_image_html( $image_stored );
					if( false != $temp_image ) {
						$button_value = 'Remove';
						echo $temp_image;
					}
				} ?>
			</div>
			<span class="submit"><input name="save" type="button" value="<?php echo $button_value;?>" data="<?php echo $value['name']; ?>" class="tk_image_upload button upload_save" id="tkbtn-<?php echo $post_ID; ?>" rel="<?php echo $post_ID; ?>"/></span>
		</div>
		<?php	
		$this->form_element_end( $value );	
	}
	
	/**
	*
	* Create Empty Post of type ThemeKitForWP to hold images
	*
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	* @return int post_id
	*/			
	private function create_empty_post( $value ) {
		global $wpdb;
		$_id = 0;
		$args ='';
		$postname = "tkwp-". $this->_tk->get_option_name().'-' . $value['id'];
		$postname = preg_replace('/[^A-Za-z0-9- ]/', '', $postname);
		$args= array('post_type'=> 'themekitforwp' ,'post_name'=> $postname,'post_status' => 'draft', 'comment_status' => 'closed', 'ping_status' => 'closed' );
		// Look in the database for a "silent" post that meets our criteria.
		$query = 'SELECT ID FROM ' . $wpdb->posts . ' WHERE post_parent = 0';
		foreach ( $args as $k => $v ) {
			$query .= ' AND ' . $k . ' = "' . $v . '"';
		} // End FOREACH Loop
		$query .= ' LIMIT 1';
		$_posts = $wpdb->get_row( $query );
		
		//If we have a post get it's id. Otherwise create a new one.
		if(count($_posts)){
			$_id = $_posts->ID;
		} else {
			$_title = ucwords($this->_tk->get_theme_name() .' '. $value['name'] );
			//Strip out any % encoded octets
			$_title = preg_replace('|%[a-fA-F0-9][a-fA-F0-9]|', '', $_title);
			//Limit to A-Z,a-z,0-9,'-'
			$_title = preg_replace('/[^A-Za-z0-9- ]/', '', $_title);
			$_post_data = array( 'post_title' => $_title ,'posts_per_page'=>1);
			$_post_data = array_merge( $_post_data, $args );
			$_id = wp_insert_post( $_post_data );
		}
		return $_id;
	}
	
	/**
	*
	* Get The HTML to show uploaded image.
	*
	*
	* @since 1.0.0 
	*
	* @param int $post_ID post id to get image for
	* @return html - sends back false if no post_id passed in. 
	*/
	public function get_upload_image_html( $post_ID = null ) {
		$img = false;
		$thumb_ID = isset($post_ID) ? $post_ID : intval( $_POST['post_id'] );
		$src = wp_get_attachment_image_src( $thumb_ID, 'mini' );
		if ( false !== $src ) {
			$srcfull = wp_get_attachment_image_src( $thumb_ID, 'full' );
			$img = '<div id="'. $post_ID.'_preview"><a title="Large Preview" href="'.$srcfull[0].'" class="thickbox" target="_blank"><div class="img-mini" style="background-image:url('.$src[0].');"> </div></a></div>';
		}
		if ( ! isset( $post_ID ) ) {
			die($img);
		} else {
			return $img;
		}
	}

	/**
	*
	* Simple Image Upload
	*
	* replaced by wp_media_uploader
	*
	* @since 1.0.0 
	*
	* @access private
	* @param array $value option currently being created
	*/
	private function simple_image_uploader( $value ) {
		$upload =isset($this->_saved_options[ $value[ 'id' ] ]) ? $this->_saved_options[ $value[ 'id' ] ] : 0;
		$id = $value[ 'id' ];
		$this->form_element_start( $value ); 
		?>
		<div>
		<input type="file" name="<?php echo $id; ?>" class="upload_input" />
		<span class="submit"><input name="save" type="submit" value="Upload" class="button upload_save" /></span>
		</div>
			<?php
			$src = wp_get_attachment_image_src( $upload, 'mini' );
			if(false !== $src){
			$srcfull = wp_get_attachment_image_src( $upload, 'full' );
		echo '<br><div id="'. $id.'_preview"><a title="Large Preview" href="'.$srcfull[0].'" class="thickbox" target="_blank"><div class="img-mini" style="background-image:url('.$src[0].');"> </div></a>';
			?>
			<span class="submit"><input name="reset" class="inline-reset" type="button" data-type="image" data-id="<?php echo $value['id']; ?>" title="Reset to Default Value" value="Remove" /></span>
			<div class="small">Images are stored in the Media Library.</div>
			<input type="hidden" class="upload-input-text" id="<?php echo $id; ?>_id" name="<?php echo $id; ?>_id" value="<?php  echo $upload; ?>"/>
		</div>
	 	<?php 
		} else {
			$this->_tk->update_option( $id );
		}
		$this->form_element_end( $value );
	}

} // End Engine Class
?>