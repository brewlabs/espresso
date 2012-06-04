jQuery(document).ready(function($) {
	$label = $('#pageparentdiv label[for="page_template"]');
	$ptag = $label.prev();

	$("#pageparentdiv #page_template").remove();
	$label.remove();
	$ptag.remove();	
});