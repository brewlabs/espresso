if(parent.themekitforwp != undefined && parent.themekitforwp == true)
{
	(function($) { 
		$(document).ready(function(){
			$('.button').each(function(){
				$btn = $(this);
				if($btn.val() == 'Insert into Post'){
				
					$btn.val('Insert into Option');
				}	
			});
			$('.wp-post-thumbnail').hide();
			var dt;
			var prepareMediaItemInit_old = window.prepareMediaItemInit;
			window.prepareMediaItemInit = function( dt )
			{
				var item = $('#media-item-' + dt.id);
				$('.post_excerpt', item).hide();
				$('.post_content',item).hide();
				$('.image-size',item).hide();
				$('.url',item).hide();
				$('.align',item).hide();
				$('.wp-post-thumbnail', item).hide();
				$('.button', item).each(function(){
					$btn = $(this);
					if($btn.val() == 'Insert into Post'){
						$btn.val('Insert into Option');
					}	
				});
			
			
				prepareMediaItemInit_old( dt );
			}
		});
	})(jQuery);
}