/*************************** Upload Button ***************************/

jQuery(document).ready(function($) {

	jQuery(".upload-image-button").click(function() {
		formfield = jQuery(this).prev(".upload")
	
		window.send_to_editor = function(html) {
			imgurl = jQuery('img',html).attr('src');
			formfield.val(imgurl);
			tb_remove();
		}

		tb_show('Upload', 'media-upload.php?TB_iframe=true');
		return false;
	});
	
	var urlregexp = new RegExp("'(.*)'");

	jQuery(".upload-video-button").click(function() {
		formfield = jQuery(this).prev(".upload")
	
		window.send_to_editor = function(html) {
			var videourl = html.match(urlregexp)[1];
			formfield.val(videourl);
			tb_remove();
		}

		tb_show('Upload', 'media-upload.php?TB_iframe=true');
		return false;
	});
	
});