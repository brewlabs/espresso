<?php
/**
 * based off of http://www.deluxeblogtips.com/2010/04/how-to-create-meta-box-wordpress-post.html
 *
 * @license GNU General Public License
 */

/**
 * Meta Box class
 */
class EspressoMetaBox {

	protected $_meta_box;
	protected $_fields;

	// Create meta box based on given data
	function __construct($meta_box) {
		if (!is_admin()) return;

		// assign meta box values to local variables and add it's missed values
		$this->_meta_box = $meta_box;
		$this->_fields = & $this->_meta_box['fields'];
		$this->add_missed_values();

		add_action('admin_menu', array(&$this, 'add'));	// add meta box
		add_action('save_post', array(&$this, 'save'));	// save meta box's data

		add_action("admin_enqueue_scripts", array(&$this, 'wp_33_patch'));
		// check for some special fields and add needed actions for them
		
		$this->check_field_color();
		$this->check_field_date();
		$this->check_field_time();
	}


	function wp_33_patch(){
		
		wp_enqueue_style('admin-css-espresso', PARENT_URL . '/hopper/css/admin.css');
		$this->check_field_upload();

	}


	/***

	***************** BEGIN UPLOAD **********************/

	// Check field upload and add needed actions
	function check_field_upload() {
		if ($this->has_field('image') || $this->has_field('file')) {
			add_action('post_edit_form_tag', array(&$this, 'add_enctype'));				// add data encoding type for file uploading

			add_action('admin_enqueue_scripts',array(&$this, 'load_jquery_ui_core'));
			
			add_action('admin_head-post.php', array(&$this, 'add_script_upload'));		// add scripts for handling add/delete images
			add_action('admin_head-post-new.php', array(&$this, 'add_script_upload'));
			
			add_action('delete_post', array(&$this, 'delete_attachments'));				// delete all attachments when delete post
			add_action('wp_ajax_es_delete_file', array(&$this, 'delete_file'));			// ajax delete files
			add_action('wp_ajax_es_reorder_images', array(&$this, 'reorder_images'));	// ajax reorder images
		}
	}

	function load_jquery_ui_core(){
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
	}

	// Add data encoding type for file uploading
	function add_enctype() {
		echo ' enctype="multipart/form-data"';
	}

	// Add scripts for handling add/delete images
	function add_script_upload() {
		global $post;
		echo '
		<style type="text/css">
		.es-images li {margin: 0 10px 10px 0; float: left; width: 150px; height: 100px; text-align: center; border: 3px solid #ccc; cursor: move; position: relative}
		.es-images img {width: 150px; height: 100px}
		.es-images a {position: absolute; bottom: 0; right: 0; color: #fff; background: #000; font-weight: bold; padding: 5px}
		</style>
		';
		
		echo '
		<script type="text/javascript">
		jQuery(document).ready(function($) {
		';
		
		echo '
			// add more file
			$(".es-add-file").click(function(){
				var $first = $(this).parent().find(".file-input:first");
				$first.clone().insertAfter($first).show();
				return false;
			});
		';
		
		echo '
			// delete file
			$(".es-delete-file").click(function(){
				var $parent = $(this).parent(),
					data = $(this).attr("rel");
				$.post(ajaxurl, {action: \'es_delete_file\', data: data}, function(response){
					if (response == "0") {
						alert("' . __('File has been successfully deleted.') . '");
						$parent.remove();
					}
					if (response == "1") {
						alert("' . __("You don't have permission to delete this file.") . '");
					}
				});
				return false;
			});
		';
		
		foreach ($this->_fields as $field) {
			if ('image' != $field['type']) continue;
			
			$id = $field['id'];
			$nonce_delete = wp_create_nonce('es_ajax_delete_file');
			echo "
			// thickbox upload
			$('#es_upload_$id').click(function(){
				backup = window.send_to_editor;
				window.send_to_editor = function(html) {
					var el = $(html).is('a') ? $('img', html) : $(html),
						img_url = el.attr('src'),
						img_id = el.attr('class');
					
					img_id = img_id.slice((img_id.search(/wp-image-/) + 9));
					
					html = '<li id=\"item_' + img_id + '\">';
					html += '<img src=\"' + img_url + '\" />';
					html += '<a title=\"" . __('Delete this image') . "\" class=\"es-delete-file\" href=\"#\" rel=\"{$post->ID}!$id!' + img_id + '!$nonce_delete\">" . __('Delete') . "</a>';
					html += '<input type=\"hidden\" name=\"{$id}[]\" value=\"' + img_id + '\" />';
					html += '</li>';
					
					$('#es-images-$id').append($(html));
					
					tb_remove();
					window.send_to_editor = backup;
				}
				tb_show('', 'media-upload.php?post_id={$post->ID}; ?>&type=image&TB_iframe=true');
				
				return false;
			});
			";
			
			echo "
			// sort
			$('#es-images-$id').sortable({
				placeholder: 'ui-state-highlight',
				update: function (){
					var order = $('#es-images-$id').sortable('serialize'),
						data = order + '!' + $('#es-data-$id').val();
					$.post(ajaxurl, {action: 'es_reorder_images', data: data}, function(response){
						if (response == '0') {
							alert('" . __('Order saved.') . "');
						}
						if (response == '1') {
							alert(\"" . __("You don't have permission to reorder images.") . "\");
						}
					});
				}
			});
			";
		}
		
		echo '});
		</script>
		';
	}

	// Delete all attachments when delete post
	function delete_attachments($post_id) {
		$attachments = get_posts(array(
			'numberposts' => -1,
			'post_type' => 'attachment',
			'post_parent' => $post_id
		));
		if (!empty($attachments)) {
			foreach ($attachments as $att) {
				wp_delete_attachment($att->ID);
			}
		}
	}

	// Ajax callback for deleting files. Modified from a function used by "Verve Meta Boxes" plugin (http://goo.gl/LzYSq)
	function delete_file() {
		if (!isset($_POST['data'])) die();

		list($post_id, $key, $attach_id, $nonce) = explode('!', $_POST['data']);

		if (!wp_verify_nonce($nonce, 'es_ajax_delete_file')) {
			die('1');
		}

		wp_delete_attachment($attach_id);
		delete_post_meta($post_id, $key, $attach_id);

		die('0');
	}
	
	// Ajax callback for reordering images
	function reorder_images() {
		if (!isset($_POST['data'])) die();

		list($order, $post_id, $key, $nonce) = explode('!',$_POST['data']);

		if (!wp_verify_nonce($nonce, 'es_ajax_sort_file')) {
			die('1');
		}

		parse_str($order, $items);
		$items = $items['item'];
		$order = 0;
		$meta = array();
		foreach ($items as $item) {
			wp_update_post(array(
				'ID' => $item,
				'post_parent' => $post_id,
				'menu_order' => $order
			));
			$order++;
			$meta[] = $item;
		}
		delete_post_meta($post_id, $key);
		foreach ($meta as $value) {
			add_post_meta($post_id, $key, $value);
		}

		die('0');
	}

	/******************** END UPLOAD **********************/

	/******************** BEGIN COLOR PICKER **********************/

	// Check field color
	function check_field_color() {
		if ($this->has_field('color') && $this->is_edit_page()) {
			add_action('admin_enqueue_scripts',array(&$this, 'espresso_load_farbtastic'));
		}
	}
	function espresso_load_farbtastic(){
		wp_enqueue_style('farbtastic');	// enqueue built-in script and style for color picker
		wp_enqueue_script('farbtastic');
		add_action('admin_head', array(&$this, 'add_script_color'));	// add our custom script for color picker
	}

	// Custom script for color picker
	function add_script_color() {
		$ids = array();
		foreach ($this->_fields as $field) {
			if ('color' == $field['type']) {
				$ids[] = $field['id'];
			}
		}
		echo '
		<script type="text/javascript">
		jQuery(document).ready(function($){
		';
		foreach ($ids as $id) {
			echo "
			$('#picker-$id').farbtastic('#$id');
			$('#select-$id').click(function(){
				$('#picker-$id').toggle();
				return false;
			});
			";
		}
		echo '
		});
		</script>
		';
	}

	/******************** END COLOR PICKER **********************/

	/******************** BEGIN DATE PICKER **********************/

	// Check field date
	function check_field_date() {
		if ($this->has_field('date') && $this->is_edit_page()) {
			// add style and script, use proper jQuery UI version
			add_action('admin_enqueue_scripts',array(&$this, 'espresso_add_scripts_for_date'));

			
		}
	}
	function espresso_add_scripts_for_date(){
		wp_enqueue_style('es-jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/' . $this->get_jqueryui_ver() . '/themes/base/jquery-ui.css');
		wp_enqueue_script('es-jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/' . $this->get_jqueryui_ver() . '/jquery-ui.min.js', array('jquery'));
		add_action('admin_head', array(&$this, 'add_script_date'));
	}

	// Custom script for date picker
	function add_script_date() {
		$dates = array();
		foreach ($this->_fields as $field) {
			if ('date' == $field['type']) {
				$dates[$field['id']] = $field['format'];
			}
		}
		echo '
		<script type="text/javascript">
		jQuery(document).ready(function($){
		';
		foreach ($dates as $id => $format) {
			echo "$('#$id').datepicker({
				dateFormat: '$format',
				showButtonPanel: true
			});";
		}
		echo '
		});
		</script>
		';
	}

	/******************** END DATE PICKER **********************/

	/******************** BEGIN TIME PICKER **********************/

	// Check field time
	function check_field_time() {
		if ($this->has_field('time') && $this->is_edit_page()) {
			// add style and script, use proper jQuery UI version
			add_action('admin_enqueue_scripts',array(&$this, 'espresso_add_scripts_for_time'));

			
		}
	}
	function espresso_add_scripts_for_time(){
		wp_enqueue_style('es-jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/' . $this->get_jqueryui_ver() . '/themes/base/jquery-ui.css');
		wp_enqueue_script('es-jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/' . $this->get_jqueryui_ver() . '/jquery-ui.min.js', array('jquery'));
		wp_enqueue_script('es-timepicker', 'https://github.com/trentrichardson/jQuery-Timepicker-Addon/raw/master/jquery-ui-timepicker-addon.js', array('es-jquery-ui'));
		add_action('admin_head', array(&$this, 'add_script_time'));
	}

	// Custom script and style for time picker
	function add_script_time() {
		// style
		echo '
		<style type="text/css">
		.ui-timepicker-div {font-size: 0.9em;}
		.ui-timepicker-div .ui-widget-header {margin-bottom: 8px;}
		.ui-timepicker-div dl {text-align: left;}
		.ui-timepicker-div dl dt {height: 25px;}
		.ui-timepicker-div dl dd {margin: -25px 0 10px 65px;}
		.ui-timepicker-div td {font-size: 90%;}
		</style>
		';

		// script
		$times = array();
		foreach ($this->_fields as $field) {
			if ('time' == $field['type']) {
				$times[$field['id']] = $field['format'];
			}
		}
		echo '
		<script type="text/javascript">
		jQuery(document).ready(function($){
		';
		foreach ($times as $id => $format) {
			echo "$('#$id').timepicker({showSecond: true, timeFormat: '$format'})";
		}
		echo '
		});
		</script>
		';
	}

	/******************** END TIME PICKER **********************/

	/******************** BEGIN META BOX PAGE **********************/

	// Add meta box for multiple post types
	function add() {
		foreach ($this->_meta_box['pages'] as $page) {
			add_meta_box($this->_meta_box['id'], $this->_meta_box['title'], array(&$this, 'show'), $page, $this->_meta_box['context'], $this->_meta_box['priority']);
		}
	}

	// Callback function to show fields in meta box
	function show() {
		global $post;

		wp_nonce_field(basename(__FILE__), 'es_meta_box_nonce');
		echo '<table class="form-table tk-form">';

		foreach ($this->_fields as $field) {
			$meta = get_post_meta($post->ID, $field['id'], !$field['multiple']);
			$meta = !empty($meta) ? $meta : $field['std'];
			
			$meta = is_array($meta) ? array_map('esc_attr', $meta) : esc_attr($meta);

			echo '<tr>';
			// call separated methods for displaying each type of field
			call_user_func(array(&$this, 'show_field_' . $field['type']), $field, $meta);
			echo '</tr>';
		}
		echo '</table>';
	}

	/******************** END META BOX PAGE **********************/

	/******************** BEGIN META BOX FIELDS **********************/

	function show_field_begin($field, $meta) {
		echo "<th style='width:20%'><label for='{$field['id']}'>{$field['name']}</label><p class='tk-meta-desc'>{$field['desc']}</p></th><td valign='top'>";
	}

	function show_field_end($field, $meta) {
		echo "</td>";
	}

	function show_field_text($field, $meta) {
		$this->show_field_begin($field, $meta);
		echo "<input type='text' name='{$field['id']}' id='{$field['id']}' value='$meta' size='30' style='{$field['style']}' />";
		$this->show_field_end($field, $meta);
	}

	function show_field_textarea($field, $meta) {
		$this->show_field_begin($field, $meta);
		echo "<textarea name='{$field['id']}' cols='60' rows='15' style='{$field['style']}'>$meta</textarea>";
		$this->show_field_end($field, $meta);
	}

	function show_field_select($field, $meta) {
		if (!is_array($meta)) $meta = (array) $meta;
		$this->show_field_begin($field, $meta);
		echo "<select name='{$field['id']}" . ($field['multiple'] ? "[]' multiple='multiple' style='{$field['style']}'" : "'") . ">";
		foreach ($field['options'] as $key => $value) {
			echo "<option value='$key'" . selected(in_array($key, $meta), true, false) . ">$value</option>";
		}
		echo "</select>";
		$this->show_field_end($field, $meta);
	}

	function show_field_radio($field, $meta) {
		$this->show_field_begin($field, $meta);
		foreach ($field['options'] as $key => $value) {
			echo "<div class='espresso-box'><input type='radio' name='{$field['id']}' value='$key'" . checked($meta, $key, false) . " /> $value </div>";
		}
		$this->show_field_end($field, $meta);
	}
	
	function show_field_radio_image($field, $meta) {
		//$this->show_field_begin($field, $meta);
		foreach ($field['no_image'] as $key => $value) {
			echo "<div class='espresso-box'><input type='radio' name='{$field['id']}' value='$key'" . checked($meta, $key, false) . " /> $value </div>";
		}
		
		echo '<ul class="image-radio-option">';
		foreach ($field['options'] as $key => $value) {
			echo "<li><label class='description'>
				<input type='radio' name='{$field['id']}' value='$key'" . checked($meta, $key, false) . " />
				<span>";?>
					<img src="<?php echo esc_url( $value['thumbnail'] ); ?>"/>
					<?php echo $value['label']; ?>
				</span>
				</label> 
			</li>
			<?php
		}
		echo '</ul>';
		//$this->show_field_end($field, $meta);
	}

	function show_field_checkbox($field, $meta) {
		$this->show_field_begin($field, $meta);
		echo "<input type='checkbox' name='{$field['id']}'" . checked(!empty($meta), true, false) . " /> {$field['label']}</td>";
	}

	function show_field_wysiwyg($field, $meta) {
		$this->show_field_begin($field, $meta);
		echo "<textarea name='{$field['id']}' class='theEditor' cols='60' rows='15' style='{$field['style']}'>$meta</textarea>";
		$this->show_field_end($field, $meta);
	}

	function show_field_file($field, $meta) {
		global $post;

		if (!is_array($meta)) $meta = (array) $meta;

		$this->show_field_begin($field, $meta);
		echo "{$field['desc']}<br />";

		if (!empty($meta)) {
			$nonce = wp_create_nonce('es_ajax_delete_file');
			echo '<div style="margin-bottom: 10px"><strong>' . __('Uploaded files') . '</strong></div>';
			echo '<ol>';
			foreach ($meta as $att) {
				if (wp_attachment_is_image($att)) continue; // what's image uploader for?
				echo "<li>" . wp_get_attachment_link($att) . " (<a class='es-delete-file' href='#' rel='{$post->ID}!{$field['id']}!$att!$nonce'>" . __('Delete') . "</a>)</li>";
			}
			echo '</ol>';
		}

		// show form upload
		echo "<div style='clear: both'><strong>" . __('Upload new files') . "</strong></div>
			<div class='new-files'>
				<div class='file-input'><input type='file' name='{$field['id']}[]' /></div>
				<a class='es-add-file' href='#'>" . __('Add more file') . "</a>
			</div>
		</td>";
	}

	function show_field_image($field, $meta) {
		global $post;

		if (!is_array($meta)) $meta = (array) $meta;

		$this->show_field_begin($field, $meta);
		echo "{$field['desc']}<br />";
		
		$nonce_delete = wp_create_nonce('es_ajax_delete_file');
		$nonce_sort = wp_create_nonce('es_ajax_sort_file');

		echo "<input type='hidden' id='es-data-{$field['id']}' value='{$post->ID}!{$field['id']}!$nonce_sort' />
			  <ul id='es-images-{$field['id']}' class='es-images'>";
		
		foreach ($meta as $att) {
			$src = wp_get_attachment_image_src($att, 'full');
			$src = $src[0];

			echo "<li id='item_{$att}'>
					<img src='$src' />
					<a title='" . __('Delete this image') . "' class='es-delete-file' href='#' rel='{$post->ID}!{$field['id']}!$att!$nonce_delete'>" . __('Delete') . "</a>
					<input type='hidden' name='{$field['id']}[]' value='$att' />
				</li>";
		}
		echo '</ul>';
		
		echo "<a href='#' style='float: left; clear: both; margin-top: 10px' id='es_upload_{$field['id']}' class='es_upload button'>" . __('Upload new image') . "</a>";
	}

	function show_field_color($field, $meta) {
		if (empty($meta)) $meta = '#';
		$this->show_field_begin($field, $meta);
		echo "<input type='text' name='{$field['id']}' id='{$field['id']}' value='$meta' size='8' style='{$field['style']}' />
			  <a href='#' id='select-{$field['id']}'>" . __('Select a color') . "</a>
			  <div style='display:none' id='picker-{$field['id']}'></div>";
		$this->show_field_end($field, $meta);
	}

	function show_field_checkbox_list($field, $meta) {
		if (!is_array($meta)) $meta = (array) $meta;
		$this->show_field_begin($field, $meta);
		$html = array();
		foreach ($field['options'] as $key => $value) {
			$html[] = "<input type='checkbox' name='{$field['id']}[]' value='$key'" . checked(in_array($key, $meta), true, false) . " /> $value";
		}
		echo implode('<br />', $html);
		$this->show_field_end($field, $meta);
	}

	function show_field_date($field, $meta) {
		$this->show_field_text($field, $meta);
	}

	function show_field_time($field, $meta) {
		$this->show_field_text($field, $meta);
	}

	/******************** END META BOX FIELDS **********************/

	/******************** BEGIN META BOX SAVE **********************/

	// Save data from meta box
	function save($post_id) {
		global $post_type;
		$post_type_object = get_post_type_object($post_type);

		if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)						// check autosave
		|| (!isset($_POST['post_ID']) || $post_id != $_POST['post_ID'])			// check revision
		|| (!in_array($post_type, $this->_meta_box['pages']))					// check if current post type is supported
		|| (!check_admin_referer(basename(__FILE__), 'es_meta_box_nonce'))		// verify nonce
		|| (!current_user_can($post_type_object->cap->edit_post, $post_id))) {	// check permission
			return $post_id;
		}

		foreach ($this->_fields as $field) {
			$name = $field['id'];
			$type = $field['type'];
			$old = get_post_meta($post_id, $name, !$field['multiple']);
			$new = isset($_POST[$name]) ? $_POST[$name] : ($field['multiple'] ? array() : '');

			// validate meta value
			if (class_exists('ES_Meta_Box_Validate') && method_exists('ES_Meta_Box_Validate', $field['validate_func'])) {
				$new = call_user_func(array('ES_Meta_Box_Validate', $field['validate_func']), $new, $name);
			}

			// call defined method to save meta value, if there's no methods, call common one
			$save_func = 'save_field_' . $type;
			if (method_exists($this, $save_func)) {
				call_user_func(array(&$this, 'save_field_' . $type), $post_id, $field, $old, $new);
			} else {
				$this->save_field($post_id, $field, $old, $new);
			}
		}
	}

	// Common functions for saving field
	function save_field($post_id, $field, $old, $new) {
		$name = $field['id'];

		delete_post_meta($post_id, $name);
		if (empty($new)) return;
		
		if ($field['multiple']) {
			foreach ($new as $add_new) {
				add_post_meta($post_id, $name, $add_new, false);
			}
		} else {
			update_post_meta($post_id, $name, $new);
		}
		
	}

	function save_field_wysiwyg($post_id, $field, $old, $new) {
		$new = wpautop($new);
		$this->save_field($post_id, $field, $old, $new);
	}

	function save_field_file($post_id, $field, $old, $new) {
		$name = $field['id'];
		if (empty($_FILES[$name])) return;

		$this->fix_file_array($_FILES[$name]);

		foreach ($_FILES[$name] as $position => $fileitem) {
			$file = wp_handle_upload($fileitem, array('test_form' => false));

			if (empty($file['file'])) continue;
			$filename = $file['file'];

			$attachment = array(
				'post_mime_type' => $file['type'],
				'guid' => $file['url'],
				'post_parent' => $post_id,
				'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
				'post_content' => ''
			);
			$id = wp_insert_attachment($attachment, $filename, $post_id);
			if (!is_wp_error($id)) {
				wp_update_attachment_metadata($id, wp_generate_attachment_metadata($id, $filename));
				add_post_meta($post_id, $name, $id, false);	// save file's url in meta fields
			}
		}
	}

	/******************** END META BOX SAVE **********************/

	/******************** BEGIN HELPER FUNCTIONS **********************/

	// Add missed values for meta box
	function add_missed_values() {
		// default values for meta box
		$this->_meta_box = array_merge(array(
			'context' => 'normal',
			'priority' => 'high',
			'pages' => array('post')
		), $this->_meta_box);

		// default values for fields
		foreach ($this->_fields as & $field) {
			$multiple = in_array($field['type'], array('checkbox_list', 'file', 'image')) ? true : false;
			$std = $multiple ? array() : '';
			$format = 'date' == $field['type'] ? 'yy-mm-dd' : ('time' == $field['type'] ? 'hh:mm' : '');
			$style = 'width: 97%';
			if ('select' == $field['type']) $style = 'height: auto';
			
			$field = array_merge(array(
				'multiple' => $multiple,
				'std' => $std,
				'desc' => '',
				'format' => $format,
				'style' => $style,
				'validate_func' => ''
			), $field);
		}
	}

	// Check if field with $type exists
	function has_field($type) {
		foreach ($this->_fields as $field) {
			if ($type == $field['type']) return true;
		}
		return false;
	}

	// Check if current page is edit page
	function is_edit_page() {
		global $pagenow;
		if (in_array($pagenow, array('post.php', 'post-new.php'))) return true;
		return false;
	}

	/**
	 * Fixes the odd indexing of multiple file uploads from the format:
	 *	 $_FILES['field']['key']['index']
	 * To the more standard and appropriate:
	 *	 $_FILES['field']['index']['key']
	 */
	function fix_file_array(&$files) {
		$output = array();
		foreach ($files as $key => $list) {
			foreach ($list as $index => $value) {
				$output[$index][$key] = $value;
			}
		}
		$files = $output;
	}
	
	// Get proper jQuery UI version to not conflict with WP admin scripts
	function get_jqueryui_ver() {
		global $wp_version;
		if (version_compare($wp_version, '3.1', '>=')) {
			return '1.8.10';
		}
		
		return '1.7.3';
	}

	/******************** END HELPER FUNCTIONS **********************/
}

?>
