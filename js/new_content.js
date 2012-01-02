(function($) {
	var time_stamp;
	if (!$.cookie) {
		throw new Error('New Content addon needs jquery.cookie.js');
	}
	if ($.cookie('new_content_opt_out')) {
		return;
	}
	
	if (!$.cookie('new_content_shown')) {
		time_stamp = parseInt($.cookie('new_content'), 10);
		
		if (time_stamp) {
			$.ajax({
				url : CCM_DISPATCHER_FILENAME + '/tools/packages/new_content/new_content.php?ts=' + time_stamp,
				dataType: 'json',
				success : function(data) {
					$(function(){
						var div = $('<div>', {id: "new_content_bar", "class": "alert-message block-message warning"});
						$('body').append(div.html(data.message));
						
						div.delegate('a', 'click', function() {
							$.cookie('new_content_shown', true, {path: window.CCM_REL ? CCM_REL : "/"});
						});
						div.delegate('.close', 'click', function(e) {
							e.preventDefault();
							div.remove();
						});
						div.delegate('#new_content_opt_out', 'click', function(e) {
							e.preventDefault();
							$.cookie('new_content_opt_out', true, {expires: 356, path: window.CCM_REL ? CCM_REL : "/"});
							$.cookie('new_content', null);
							div.remove();
						});
					});
				}
			});
		}
	}
	$.cookie('new_content', (new Date()).getTime(), {expires: 90, path: window.CCM_REL ? CCM_REL : "/"});
})(jQuery);
