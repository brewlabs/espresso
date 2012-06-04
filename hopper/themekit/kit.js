//Comments Test SVN
//var themekitforwp = true;
(function($) { 

	$(document).ready(function(){
		//	$('.tk_slide .tk_options').slideUp();
		$('.tk_slide .tk_header').live('click', function(e){
			var clicktype = $(e.target).attr('type');
			if(clicktype != 'submit'){
			var $obj = $(this);	
			$obj.removeClass('minus');
			$obj.siblings('.tk_options').slideToggle('slow',function(){
				if($(this).css('display') == 'none'){
					setUserSetting( $obj.attr('id') , 'minus');
					$obj.addClass('minus');
				} else {
					setUserSetting( $obj.attr('id') , '');
				}
				
			});	
		}
		});
		
		$('.tk_slide .tk_header').each(function(i){
			var $obj = $(this);
			var setting = getUserSetting($obj.attr('id'));
			if(setting == 'minus' ) {
				$obj.siblings('.tk_options').toggle();
				$obj.addClass('minus');
				//alert($obj.attr('id'));
			} 
		});
		
		$('.view').click(function(){
			$('.tk_switch').each(function(i){
				var $panel = $(this);
				if($panel.hasClass('tk_slide')){
					$panel.removeClass('tk_slide').addClass('tk_open');
					$panel.children('.tk_header').removeClass('minus');
					$panel.children('.tk_options').css('display','');
				} else {
					$panel.removeClass('tk_open').addClass('tk_slide');
				}
			});
			
			
		});
		
		$('#view-switch-list').click(function(e){
			e.preventDefault();
			$('.tk_switch').each(function(i){
				var $panel = $(this);
					$panel.removeClass('tk_slide').addClass('tk_open');
					$panel.children('.tk_header').removeClass('minus');
					$panel.children('.tk_options').css('display','');
				
			});
			
		});
		$('#view-switch-excerpt').click(function(e){
			e.preventDefault();
			$('.tk_switch').each(function(i){
				var $panel = $(this);
					$panel.removeClass('tk_open').addClass('tk_slide');
				
			});
			
		});
		
		
		
		
		$('.tk_image_upload').click(function(e) {
			$tkbtn = $(this);
			formfield = $tkbtn.attr('data');
			formID = $tkbtn.attr('rel');
			val = $tkbtn.val()
			if(val == 'Remove' ){
		 		$(':input[option='+formID+']').val('');
				$tkbtn.val('Select an Image');
				$('#holder-'+formID).html('');
			} else {
				tb_show(formfield, 'media-upload.php?post_id='+formID+'&type=image&TB_iframe=true');
	 		}
			e.preventDefault();
		});


		window.original_send_to_editor = window.send_to_editor;

		window.send_to_editor = function(html) {
			var id = 0;

			if(isNaN(html)){
				var string = $(html).children('img').attr('class');
				var cl = string.split(' ');
				$.each(cl,function( intIndex, s ){
					var find = 'wp-image-';
					if(s.substr(0,find.length) == find ){
						var a = s.split('-');
						id = a[a.length-1];
					}
				});		
			} else {
				id = html;
			}

			if(typeof formID !== "undefined"){
				$(':input[option='+formID+']').val(id);
		 	
			 	imgurl = jQuery('img',id).attr('src');
			 	
			 	$('#tkbtn-'+formID).val('Remove');
				
				$.post(ajaxurl, {
					action:"tk_get_upload_image_html", post_id: id
				}, function(str){
					if ( str == '0' ) {
						alert( setPostThumbnailL10n.error );
					} else {
						$('#holder-'+formID).html(str);
					}
				});
		 		tb_remove();
			}else{
				window.original_send_to_editor(html);
			}
		}

		
		
		
		
		//Build ColorPickers
		$('.cpcontroller').each(function(i){
			var $element = $(this);
			var id = $element.attr('data-id'); 
			var $holder = $('#pickholder_' + id);
			var $fb = $('#'+ id +'_colorpicker').farbtastic($element);
			$element.focus(function(){
				var p = $element.position();
				$holder.css('top',p.right+"px").css('left',p.left+"px").toggle('slow');
			})
			.blur(function(){
				var p = $element.position();
				$holder.css('top',p.right+"px").css('left',p.left+"px").toggle('slow');
			})
			.keyup(function(){
				var _hex = $element.val(), hex = _hex;
				if ( hex[0] != '#' ){
					hex = '#' + hex;
				}
				hex = hex.replace(/[^#a-fA-F0-9]+/, '');
				if ( hex != _hex ){
					$element.val(hex);
				}
				if ( hex.length == 4 || hex.length == 7 ){
						var cp = $.farbtastic('#'+ id +'_colorpicker');
						cp.setColor(hex);
				}
			});
			$holder.hide();			
		});
		
		$('.create_archive').click(function(){
			var clickedObject = $(this);
			var data = {
				action: 'tk_handle_ajax_archive'
			}

			$.getJSON(ajaxurl, data, function(response) {
				var elements = '<ul>';
				$.each(response, function(i,item){
					var ele = item.split('-');
					var date = new Date(ele[ele.length-1]*1000);
					// hours part from the timestamp
					var hours = date.getHours();
					// minutes part from the timestamp
					var minutes = date.getMinutes();
					// seconds part from the timestamp
					var seconds = date.getSeconds();

					// will display time in 10:30:23 format
					var formattedTime = hours + ':' + minutes + ':' + seconds;
					elements += '<li>'+ item + ' : ' + date +'</li>';
				});
				elements += '</ul>';
				clickedObject.append(elements);
				
				/*
				var response = response.split('|');
				var id = response[0];
				var name = response[1]
				var value = response[2];
				var html = '';
				html += '<div class="string_option" id="'+name+'"><span>'+name+':</span> '+value+'</div>';
				jQuery('#'+id+'_return').find('.string_builder_empty').hide();
				jQuery('#'+id+'_return').append(html);
				*/
			});
			return false; 
		});
		
		var removedImage ='';
		
		WPSetThumbnailHTML = function(html){
			$newHTML =  $(html);
			$removelink = 	$newHTML.find('#remove-post-thumbnail').removeAttr('onclick').attr('rel', formID);
			
			//alert(html);
		}
		
		$("#remove-post-thumbnail").live('click',function(){
				postID = $(this).attr('rel');
				nonce = $('#holder-'+postID).attr('nonce');
				$.post(ajaxurl, {
					action:"set-post-thumbnail", post_id: postID, thumbnail_id: -1, _ajax_nonce: nonce, cookie: encodeURIComponent(document.cookie)
				}, function(str){
					if ( str == '0' ) {
						alert( setPostThumbnailL10n.error );
					} else {
						WPSetThumbnailHTML(str);
					}
				}
				);
		});
		
		WPRemoveThumbnail = function(nonce){
			var ev = arguments[0] || window.event,
			origEl = ev.target || ev.srcElement;
			alert(this.event);
			$.post(ajaxurl, {
				action:"set-post-thumbnail", post_id: removedImage, thumbnail_id: -1, _ajax_nonce: nonce, cookie: encodeURIComponent(document.cookie)
			}, function(str){
				if ( str == '0' ) {
					alert( setPostThumbnailL10n.error );
				} else {
					WPSetThumbnailHTML(str);
				}
			}
			);
		};
		
		//Build the Reset Button Actions
		$(".inline-reset").click(function(e){
			var $reset = $(this);
			var id = $reset.attr("data-id");
		
			switch($reset.attr('data-type')){
				case "cp":
					e.preventDefault();
					var cp = $.farbtastic('#'+ id +'_colorpicker');
					cp.setColor($('#default_'+ id ).val());
				break;
				case "border":
					e.preventDefault();
					var cp = $.farbtastic('#'+ id +'_colorpicker');
					cp.setColor($('#default_'+ id + '_color').val());
					$('#' + id +'_style').val($('#default_'+ id + '_style').val());
					$('#' + id +'_width').val($('#default_'+ id + '_width').val());
					//alert('reset border');
				break;
				
				case "image":
					$('#'+ id +'_id').val("");
					$('#'+ id +'_preview').toggle();
					
				break;
				
							
			}
			
			
		})
		
		
	});
})(jQuery);