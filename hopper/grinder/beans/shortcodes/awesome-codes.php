<?php

/* ----------------------------------------------------------------- */
/* -------------------------- HR ------------------------ */
/* ----------------------------------------------------------------- */





add_shortcode('es-hr', array('EspressoHRule','espresso_shortcode'));
add_filter('espresso_shortcode_box',array('EspressoHRule','espresso_create_support_box'));

class EspressoHRule{	
	function espresso_shortcode( $attr, $content = null ) {
		extract(shortcode_atts(array(
			'top' => false,
			'style' => 'default'
		), $attr));
		$top_link="<!-- Espresso HR -->";
		if( false !== $top){
			$top_link = "<a href='#top' class='scrollTop'>top</a>";
		}
		
	   return "<div class='hr hr_$style first'>$top_link</div>";
	}
	
	function espresso_create_support_box($boxes){
		$box = array(
			'id'=>'es-hr',
			'title'=> 'Horizontal Rule',
			'code'=>'[es-hr]',
			'content'=> array('EspressoHRule','espresso_support_box_content')
		);
		
		$boxes[] = $box;
		
		return $boxes;
	}
	
	function espresso_support_box_content(){
		?>
		<p>Create Horizontal Rule's to break up content</p>
		<h5>Creating a Rule</h5>
		<p>	
			All HR need's is an open shortcode.<br>Open: <b>[es-hr]</b>
		</p>
		<p>The Horizontal rule supports several options.
			<ul>
				<li>top: show link to top of page. [es-hr top="true"]
				<p>default: false</p>
				</li>
				<li>style: Style of the horizontal rule [es-hr style="default"]
				<p>default: default</p>
				</li>
			</ul>
		</p>
		<h5>Example code:</h5>
		<p><b>[es-hr]</b></p>
		<p>For more info check out: <a href="#">Using the Super Button Shortcode</a>.
		<?php
	}
}




/* ----------------------------------------------------------------- */
/* -------------------------- Super Buttons ------------------------ */
/* ----------------------------------------------------------------- */





add_shortcode('es-button', array('EspressoSuperButton','espresso_shortcode'));
add_filter('espresso_shortcode_box',array('EspressoSuperButton','espresso_create_support_box'));

class EspressoSuperButton{	
	function espresso_shortcode( $attr, $content = null ) {
		extract(shortcode_atts(array(
			'size' => 'medium',
			'link' => '#',
			'color' => 'default',
			'target' => ''
		), $attr));
		$the_target = ' ';
		if(strlen($target) > 0){
			$the_target .= 'target="'.$target.'"';
		}
		
	   return "<a href='$link'$the_target><span class='button_$size button_$color download'>". espresso_remove_wpautop($content) . "</span></a>";
	}
	
	function espresso_create_support_box($boxes){
		$box = array(
			'id'=>'es-button',
			'title'=> 'Super Button',
			'code'=>'[es-button]',
			'content'=> array('EspressoSuperButton','espresso_support_box_content')
		);
		
		$boxes[] = $box;
		
		return $boxes;
	}
	
	function espresso_support_box_content(){
		?>
		<p>Create buttons to get visitor's attention</p>
		<h5>Creating a Button</h5>
		<p>	
			All buttons need an Open and Close shortcode.<br>Open: <b>[es-button]</b><br>Close: <b>[/es-button]</b>
		</p>
		<p>The Super Button supports several options. All options are put on the open part of the shortcode.
			<ul>
				<li>link: Add url you would like to link to. [es-box link="http://google.com"]
				<p>default: #</p>
				</li>
				<li>size: What size button to create. [es-box size="small"]
				<p>default: medium<br>values: small, medium. large</p>
				</li>
				<li>color: Style of button. [es-box color="fancyblue"]
				<p>default: Theme Default - styled by the theme<br>values: fancyblue, fancyyellow, fancywhite, fancygray, fancygreen, fancypink, fancydarkgray</p>
				</li>
				<li>target: Adds a target to the button. [es-box target="_blank"]
				<p>default: none<br>values: _blank, _self, _parent</p>
				</li>
			</ul>
		</p>
		<h5>Example code:</h5>
		<p><b>[es-button link="http://google.com" color="fancyblue"]Google[/es-button]</b></p>
		<p>For more info check out: <a href="#">Using the Super Button Shortcode</a>.
		<?php
	}
}




/* ----------------------------------------------------------------- */
/* -------------------------- Awesome Box -------------------------- */
/* ----------------------------------------------------------------- */

add_shortcode('es-box', array('EspressoAwesomeBox','es_box'));
add_filter('espresso_shortcode_box',array('EspressoAwesomeBox','espresso_awesome_box_create'));

class EspressoAwesomeBox{	
	function es_box( $attr, $content = null ) {
		extract(shortcode_atts(array(
			'w' => '',
			'color' => 'default',
			'title' => '',
			'position'=>'',
			'text'=>'left',
		), $attr));
	   	if( isset($title) && $title !==''){
			$title = "<h4 class='box-title'>$title</h4>";
		}
	 	$class = '';
		// used for $current_home = 'current';
		$w1 = array(
		        '75'  => True,
				'75%'  => True,
		        );

		// used for $current_users = 'current';
		$w2 = array(
		        '50'  => True,
				'50%'  => True,
		        );

		// used for $current_forum = 'current';
		$w3 = array(
		        '25'  => True,
				'25%'  => True,
		        );
		$w4 = array(
		        '33'  => True,
				'33%'  => True,
		        );
		if(empty($w))
			$class = 'full';
		else if(isset($w1[$w]))
		    $class = 'three_fourth';
		else if(isset($w2[$w]))
		    $class = 'one_half';
		else if(isset($w3[$w]))
		    $class = 'one_fourth';
		else if(isset($w4[$w]))
		    $class = 'one_third';    



	  	return "<div class='$class box_$color $position text_$text es_box'>$title<div class='box_text'>". espresso_remove_wpautop($content) . "</div></div>";
	}
	
	
	
	function espresso_awesome_box_create($boxes){
		$box = array(
			'id'=>'es-box',
			'title'=> 'Awesome Box',
			'code'=>'[es-box]',
			'content'=> array('EspressoAwesomeBox','espresso_awesome_box_content')
			
			
		);
		
		$boxes[] = $box;
		
		return $boxes;
	}
	
	function espresso_awesome_box_content(){
		?>
		<p>Create boxes around content in posts, pages and widgets with ease. The Awesome box allows you to split content area's up by using percentage's.</p>
		<h5>Creating a Box</h5>
		<p>	
			All boxes need an Open and Close shortcode.<br>Open: <b>[es-box]</b><br>Close: <b>[/es-box]</b>
		</p>
		<p>The Awesome box supports several options. All options are put on the open part of the shortcode.
			<ul>
				<li>title: Add a title to box. [es-box title="My Awesome Box"]
				<p>default: none
				</li>
				<li>w: Width of box in %. [es-box w="75"]
				<p>default: 100<br>value: 75, 50, 25, 33</p>
				</li>
				<li>text: Text alignment in box. [es-box text="center"]
				<p>default: left - text is left aligned<br>values: left, center, right</p>
				</li>
				<li>color: Style of box. [es-box color="fancyblue"]
				<p>default: none - great for creating columns<br>values: fancyred, fancyblue, fancyyellow, fancygray, fancygreen</p>
				</li>
				<li>position: Needed to make the last box fit. [es-box position="last"]
				<p>default: none<br>value: last</p>
				</li>
				
			</ul>
		</p>
		<p>For more info check out: <a href="#">Using the Awesome Box Shortcode</a>.
		<?php
	}
}






/* ----------------------------------------------------------------- */
/* -------------------------- Awesome Col -------------------------- */
/* ----------------------------------------------------------------- */

add_shortcode('es-col', array('EspressoColumn','es_box'));
add_filter('espresso_shortcode_box',array('EspressoColumn','espresso_awesome_box_create'));

class EspressoColumn{	
	function es_box( $attr, $content = null ) {
		extract(shortcode_atts(array(
			'w' => '',
			'color' => 'default',
			'title' => '',
			'position'=>'',
			'text'=>'left',
		), $attr));
	   	if( isset($title) && $title !==''){
			$title = "<h6 class='box-title'>$title</h6>";
		}
	 	$class = '';
		// used for $current_home = 'current';
		$w1 = array(
		        '75'  => True,
				'75%'  => True,
		        );

		// used for $current_users = 'current';
		$w2 = array(
		        '50'  => True,
				'50%'  => True,
		        );

		// used for $current_forum = 'current';
		$w3 = array(
		        '25'  => True,
				'25%'  => True,
		        );
		$w4 = array(
		        '33'  => True,
				'33%'  => True,
		        );
		$w5 = array(
		        '20'  => True,
				'20%'  => True,
		        );
		$w6 = array(
		        '66'  => True,
				'66%'  => True,
		        );
		if(empty($w))
			$class = 'full';
		else if(isset($w1[$w]))
		    $class = 'three_fourth';
		else if(isset($w2[$w]))
		    $class = 'one_half';
		else if(isset($w3[$w]))
		    $class = 'one_fourth';
		else if(isset($w4[$w]))
		    $class = 'one_third';    
		else if(isset($w5[$w]))
		    $class = 'one_fifth';
		else if(isset($w6[$w]))
		    $class = 'two_thirds';

	  	return "<div class='$class box_$color $position text_$text clearfix'>$title". espresso_remove_wpautop($content) . "</div>";
	}
	
	
	
	function espresso_awesome_box_create($boxes){
		$box = array(
			'id'=>'es-col',
			'title'=> 'Content Column',
			'code'=>'[es-col]',
			'content'=> array('EspressoColumn','espresso_awesome_box_content')
			
			
		);
		
		$boxes[] = $box;
		
		return $boxes;
	}
	
	function espresso_awesome_box_content(){
		?>
		<p>Split's a Content area into columns to create custom layouts</p>
		<h5>Creating a Column</h5>
		<p>	
			All column's need an Open and Close shortcode.<br>Open: <b>[es-col]</b><br>Close: <b>[/es-col]</b>
		</p>
		<p>The content column shortcode supports several options. All options are put on the open part of the shortcode.
			<ul>
				<li>w: Width of box in %. [es-col w="75"]
				<p>default: 100<br>value: 75, 50, 25, 33</p>
				</li>
				<li>text: Text alignment in box. [es-col text="center"]
				<p>default: left - text is left aligned<br>values: left, center, right</p>
				</li>
				<li>position: Needed on the first column. [es-col position="first"]
				<p>default: none<br>value: first</p>
				</li>
				
			</ul>
		</p>
		<h5>Example Layout: 50,25,25</h5>
		<p><b>[es-col w="50" position="first"]</b> 1/2 a page wide <b>[/es-col] [es-col w="25"]</b> 1/4 a page wide <b>[/es-col] [es-col w="25"]</b> 1/4 a page wide <b>[/es-col]</b></p>	
		<p>For more info check out: <a href="#">Using the Content Column Shortcode</a>.
		<?php
	}
}


















