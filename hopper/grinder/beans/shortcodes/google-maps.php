<?php


add_shortcode('es-map', array('EspressoGoogleMaps','espresso_shortcode'));
add_filter('espresso_shortcode_box',array('EspressoGoogleMaps','espresso_create_support_box'));

class EspressoGoogleMaps{	
	function espresso_shortcode( $attr, $content = null ) {
		extract(shortcode_atts(array(
	         'width' => '578',
	         'height' => '200',
	         'color' => 'green',
	         'zoom' => '13',
	         'align' => 'center'
	     ), $attr));

	    ob_start();

	    $address = $content;
	    $address_url = preg_replace('/[^a-zA-Z0-9_ -]/s', '+', $address)
	    ?>
	    <img class="align<?php echo $align; ?> tf-googlemaps" src="http://maps.google.com/maps/api/staticmap?center=<?php echo $address_url; ?>&zoom=<?php echo $zoom; ?>&size=<?php echo $width; ?>x<?php echo $height; ?>&markers=color:<?php echo $color; ?>|<?php echo $address_url; ?>&sensor=false">
	
<!--	http://www.google.com/maps?q=<?php echo $address_url; ?>&hl=en&t=h&z=17 -->
	
	    <?php

	    $output = ob_get_contents();
	    ob_end_clean();
	    return $output;
	}
	
	function espresso_create_support_box($boxes){
		$box = array(
			'id'=>'es-map',
			'title'=> 'Google Maps',
			'code'=>'[es-map]',
			'content'=> array('EspressoGoogleMaps','espresso_support_box_content')
		);
		
		$boxes[] = $box;
		
		return $boxes;
	}
	
	function espresso_support_box_content(){
		?>
		<p>Place a Google Map on any page or in a Widget</p>
		<h5>Creating a Map</h5>
		[es-map]address of map[/es-map]
		<?php
	}
}
