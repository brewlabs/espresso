<?php 
	class widget_styler_class {
		function widget_styler_class(){
			
			//delete_option('wh_widget_classes');
			
			add_option('wh_widget_classes',serialize(array("default"=>"default")));
			
			//add dropdown to widget
			add_action('in_widget_form', array( &$this, 'show_widget_style_options' ), 10, 3);
			
			add_filter('widget_update_callback',array( &$this, 'update_widget_style_options' ), 10, 3);
			
			add_filter('dynamic_sidebar_params', array( &$this, 'add_widget_class' ));
  		}
  		
  		function show_widget_style_options($widget, $return, $instance){
			?>
		    <p>
		    	<label for="<?php echo $widget->get_field_id('style'); ?>">Select Widget Style:</label>
		    	<select name="<?php echo $widget->get_field_name('style'); ?>" id="<?php echo $widget->get_field_id('style'); ?>" class="widefat">
		            <option value="default" <?php echo selected( $instance['style'], 'default' ) ?>>Default</option> 
		        	
		        	<?php 
		        		$styles = $this->get_registered_style_options();
		        	
		        		foreach ( $styles as $style => $class ) {
							echo "<option value='".$class."'  ".selected( $instance['style'], $class )." >".$style."</option>";
						}
					?>
		        </select>
		        <input type="hidden" value="<?php echo $widget->id; ?>" name="<?php echo $widget->get_field_name('id'); ?>" id="<?php echo $widget->get_field_name('id'); ?>">
		    </p>    
		
		<?php       
		}
		
		function update_widget_style_options($instance, $new_instance, $old_instance){
			$instance['style'] = isset($new_instance['style']) ? $new_instance['style'] : 'default';
			$instance['id'] = $new_instance['id'];
			
			$widget_classes = unserialize(get_option('wh_widget_classes'));
			
			$widget_classes[$instance['id']] = $instance['style'];
						
			update_option('wh_widget_classes',serialize($widget_classes));
			
			//print_r($widget_classes);
				
			return $instance;
		}
		
		function add_widget_class($params){
			global $widget_num;
			global $wp_registered_sidebars, $wp_registered_widgets;
						
			$widget_classes = unserialize(get_option('wh_widget_classes'));
			
			//print_r($widget_classes);
			
			$class = " ".$widget_classes[$params[0]['widget_id']];
			$params[0]['before_widget'] = str_replace('widget-container', 'widget-container'. $class, $params[0]['before_widget']);
			
			return $params;
		
		}
		
		function get_registered_style_options() {
			global $_registered_style_options;
			if ( isset( $_registered_style_options ) )
				return $_registered_style_options;
			return array();
		}
		
		function register_style_options( $styles = array() ) {
			global $_registered_style_options;
		
			add_theme_support( 'widget_style' );
		
			$_registered_style_options = array_merge( (array) $_registered_style_options, $styles );
		}
				
		public function register_style_option( $style, $class ) {
			$this->register_style_options( array( $style => $class ) );
		}
  	}//end class
  	
	global $widget_styler_holder; 
	$widget_styler_holder = new widget_styler_class();

	function tk_register_sidebar_style($style,$class){
		global $widget_styler_holder; 
		$widget_styler_holder->register_style_option($style,$class);
	}
	
	
?>