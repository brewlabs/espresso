<?php
/**
 * Bean Name: Widget Menu
 * Bean Description: 
 */

if(!current_theme_supports('espresso-widget-nav')){
	return;
}


 class Espresso_Nav_Menu_Widget extends WP_Widget {

	function Espresso_Nav_Menu_Widget() {
		$widget_ops = array( 'description' => __('Use this widget to add a styled custom menu as a widget.') );
		parent::WP_Widget( 'nav_menu_es', __(apply_filters('espresso-widget-title', 'Espresso Menu')), $widget_ops );
	}

	function widget($args, $instance) {
		// Get menu
		$nav_menu = wp_get_nav_menu_object( $instance['nav_menu_es'] );

		if ( !$nav_menu )
			return;

		$instance['title'] = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);

		echo $args['before_widget'];

		if ( !empty($instance['title']) )
			echo $args['before_title'] . $instance['title'] . $args['after_title'];

		wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu ,'walker'=> new Espresso_Walker_Nav_Menu(), 'container_class'=>'espresso-menu-widget clearfix','menu_class'=>'sf-menu ul-level-1' ) );

		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['nav_menu_es'] = (int) $new_instance['nav_menu_es'];
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$nav_menu = isset( $instance['nav_menu_es'] ) ? $instance['nav_menu_es'] : '';

		// Get menus
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );

		// If no menus exists, direct the user to go and create some.
		if ( !$menus ) {
			echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php') ) .'</p>';
			return;
		}
		?>
		<!--
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>
	-->
		<p>
			<label for="<?php echo $this->get_field_id('nav_menu_es'); ?>"><?php _e('Select Menu:'); ?></label>
			<select id="<?php echo $this->get_field_id('nav_menu_es'); ?>" name="<?php echo $this->get_field_name('nav_menu_es'); ?>">
		<?php
			foreach ( $menus as $menu ) {
				$selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
				echo '<option'. $selected .' value="'. $menu->term_id .'">'. $menu->name .'</option>';
			}
		?>
			</select>
		</p>
		<?php
	}
}



function espresso_widgets_init() {
	
	register_widget('Espresso_Nav_Menu_Widget');

}
//espresso_widgets_init();
add_action('widgets_init', 'espresso_widgets_init', 1);


