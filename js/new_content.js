(function($) {
	var time_stamp;
	if (!$.cookie) {
		throw new Error('New Content addon needs jquery.cookie.js');
	}
	
	if (!$.cookie('new_content_shown')) {
		time_stamp = parseInt($.cookie('new_content'), 10);
		
		if (time_stamp) {
			$.ajax({
				url : CCM_DISPATCHER_FILENAME + '/tools/packages/new_content/new_content.php?ts=' + time_stamp,
				dataType: 'json',
				success : function(data) {
					$(function(){
						var link = $('<a>').html(data.message).
							attr('href', (window.CCM_REL ? CCM_REL : "/") + "new_content/" + time_stamp).
							bind('click', function() {
								 $.cookie('new_content_shown', true, {path: window.CCM_REL ? CCM_REL : "/"});
							}),
						div = $('<div>');
						$('body').append(div.append(link));
					});
				}
			});
		}
	}
	$.cookie('new_content', (new Date()).getTime(), {expires: 90, path: window.CCM_REL ? CCM_REL : "/"});
})(jQuery);
