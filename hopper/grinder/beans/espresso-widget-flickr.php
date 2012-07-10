<?php
/**
* Bean Name: Flickr Widget
* Bean Description: Display the latest images posted to Flickr.
* Sort Order: 1
*/

class Espresso_Flickr extends WP_Widget {

	function Espresso_Flickr() {
		$widget_ops = array('description' => 'This Flickr widget populates photos from a Flickr ID.' );

		parent::WP_Widget(false, __(apply_filters('espresso-widget-title', 'Espresso Flickr'), 'espresso'),$widget_ops);      
	}

	function widget($args, $instance) {  
		extract( $args );
		$id = $instance['id'];
		$number = $instance['number'];
		$type = $instance['type'];
		$sorting = $instance['sorting'];
		$size = $instance['size'];
		$title = $instance['title'];
		echo "{$before_widget}{$before_title}". esc_html($title) . "{$after_title}"; ?>
            
        <div class="espresso_flickr_images espresso_flickr_<?php echo $size; ?> clearfix">
            <?php if($type === "user_set") :?>
                <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=<?php echo $sorting; ?>&amp;&amp;layout=x&amp;source=<?php echo $type; ?>&amp;set=<?php echo $id; ?>&amp;size=<?php echo $size; ?>"></script> 
            <?php else:?>
            <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=<?php echo $sorting; ?>&amp;&amp;layout=x&amp;source=<?php echo $type; ?>&amp;<?php echo $type; ?>=<?php echo $id; ?>&amp;size=<?php echo $size; ?>"></script> 
            <?php endif; ?>       
        </div>

	   <?php			
	   echo $after_widget;
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {    
		$instance = wp_parse_args( (array) $instance, array( 'id' => '', 'set_id'=> '', 'title' => '', 'number' => 6,'size'=>'s','sorting'=>'latest','type'=>'user') );
	    
		$title = esc_attr( $instance['title'] );
		$id = esc_attr($instance['id']);
        $set_id = esc_attr($instance['set_id']);
		$number = esc_attr($instance['number']);
		$type = esc_attr($instance['type']);
		$sorting = esc_attr($instance['sorting']);
		$size = esc_attr($instance['size']);
		
		
			echo '<p><label for="' . $this->get_field_id( 'title' ) . '">' . esc_html__( 'Title:', 'espresso' ) . '
			<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . $title . '" />
			</label></p>';
		?>
        <p>
            <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Flickr ID (<a href="http://www.idgettr.com">idGettr</a>):','espresso'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo $id; ?>" class="widefat" id="<?php echo $this->get_field_id('id'); ?>" />
        </p>
       	<p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number:','espresso'); ?></label>
            <select name="<?php echo $this->get_field_name('number'); ?>" class="widefat" id="<?php echo $this->get_field_id('number'); ?>">
                <?php for ( $i = 1; $i <= 10; $i += 1) { ?>
                <option value="<?php echo $i; ?>" <?php if($number == $i){ echo "selected='selected'";} ?>><?php echo $i; ?></option>
                <?php } ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Type:','espresso'); ?></label>
            <select name="<?php echo $this->get_field_name('type'); ?>" class="widefat" id="<?php echo $this->get_field_id('type'); ?>">
                <option value="user" <?php if($type == "user"){ echo "selected='selected'";} ?>><?php _e('User', 'espresso'); ?></option>
                <option value="group" <?php if($type == "group"){ echo "selected='selected'";} ?>><?php _e('Group', 'espresso'); ?></option>  
                <option value="user_set" <?php if($type == "user_set"){ echo "selected='selected'";} ?>><?php _e('User Set', 'espresso'); ?></option>            
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('sorting'); ?>"><?php _e('Sorting:','espresso'); ?></label>
            <select name="<?php echo $this->get_field_name('sorting'); ?>" class="widefat" id="<?php echo $this->get_field_id('sorting'); ?>">
                <option value="latest" <?php if($sorting == "latest"){ echo "selected='selected'";} ?>><?php _e('Latest', 'espresso'); ?></option>
                <option value="random" <?php if($sorting == "random"){ echo "selected='selected'";} ?>><?php _e('Random', 'espresso'); ?></option>            
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Size:','espresso'); ?></label>
            <select name="<?php echo $this->get_field_name('size'); ?>" class="widefat" id="<?php echo $this->get_field_id('size'); ?>">
                <option value="s" <?php if($size == "s"){ echo "selected='selected'";} ?>><?php _e('Square', 'espresso'); ?></option>
                <option value="m" <?php if($size == "m"){ echo "selected='selected'";} ?>><?php _e('Medium', 'espresso'); ?></option>
                <option value="t" <?php if($size == "t"){ echo "selected='selected'";} ?>><?php _e('Thumbnail', 'espresso'); ?></option>
            </select>
        </p>
		<?php
	}
} 

add_action('widgets_init', create_function('', "register_widget('Espresso_Flickr');"));
?>