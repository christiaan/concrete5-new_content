(function($) {
	var shown, time_stamp;
	if (!$.cookie) {
		throw new Error('New Content addon needs jquery.cookie.js');
	}
	
	shown = $.cookie('new_content_shown');
	if (!shown) {
		time_stamp = parseInt($.cookie('new_content'), 10);
		
		if (time_stamp) {
			$.ajax({
				url : CCM_DISPATCHER_FILENAME + '/tools/packages/new_content/new_content.php?ts=' + time_stamp,
				dataType: 'json',
				success : function(data) {
					$(function(){
						var div = $('<div>').html(data.message);
						$('body').append(div);
					});
				}
			});
		}
	}
	// $.cookie('new_content_shown', null, {path: window.CCM_REL ? CCM_REL : "/"});
	$.cookie('new_content', (new Date()).getTime(), {expires: 90, path: window.CCM_REL ? CCM_REL : "/"});
})(jQuery);
