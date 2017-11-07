var Coaching = function(){
	var ajax_url = fx;
	var upcoming_tab_show = null;
	var past_tab_show = null;
	var private_coaching_show = null;
	function isJson(str) {
		try {
			JSON.parse(str);
		} catch (e) {
			return false;
		}
		return true;
	}
	function ajaxGetUpcomingWebinar(){
		var ajaxCall = $.ajax({
		  method: "GET",
		  url: ajax_url.ajax_url,
		  data: { 'action': 'coach_get_webinars' }
		});
		return ajaxCall;
	}
	function ajaxGetPastWebinar(){
		var ajaxCall = $.ajax({
		  method: "GET",
		  url: ajax_url.ajax_url,
		  data: { 'action': 'coach_get_history_webinars' }
		});
		return ajaxCall;
	}
	function ajaxGetPrivateCoaching(){
		var ajaxCall = $.ajax({
		  method: "GET",
		  url: ajax_url.ajax_url,
		  data: { 'action': 'coach_get_private_coaching' }
		});
		return ajaxCall;
	}
	return {
		init:function(){
			if(upcoming_tab_show == null){
				//show the upcoming ajax events
				//console.log('show the upcoming ajax events');
				var content = $('#ajax-coach-upcoming-webinars');
				
				content.html('<p>Loading webinars please wait</p>');
				ajaxGetUpcomingWebinar().done(function(data){
					//console.log(data);
					if( !isJson(data) ){
						content.html(data);
					}else{
						data = jQuery.parseJSON(data);
						if( data.status == 'no-webinar' ){
							content.html('<p>' + data.msg + '</p>');
						}
					}
				});
			}
			$('.nav-tabs a').on('show.bs.tab', function (e) {
				upcoming_tab_show = 1;
				//console.log('show');
				e.target // newly activated tab
				e.relatedTarget // previous active tab
				//test
				//console.log(e);
				//console.log(e.target.text);
				//console.log(e.relatedTarget.text);
				if( e.target.hash == '#past' 
					&& past_tab_show  == null
				){
					past_tab_show = 1;
					var content = $('#ajax-coach-history-webinars');
					
					content.html('<p>Loading webinars please wait</p>');
					ajaxGetPastWebinar().done(function(data){
						//console.log(data);
						if( !isJson(data) ){
							content.html(data);
						}else{
							data = jQuery.parseJSON(data);
							if( data.status == 'no-webinar' ){
								content.html('<p>' + data.msg + '</p>');
							}
						}
					});
				}
				if( e.target.hash == '#private-coaching' 
					&& private_coaching_show  == null
				){
					private_coaching_show = 1;
					
					var content = $('#ajax-coach-private-coaching-webinar');
					
					content.html('<p>Loading private coaching webinars please wait</p>');
					ajaxGetPrivateCoaching().done(function(data){
						//console.log(data);
						if( !isJson(data) ){
							content.html(data);
						}else{
							data = jQuery.parseJSON(data);
							if( data.status == 'no-webinar' ){
								content.html('<p>' + data.msg + '</p>');
							}
						}
					});
				}
			});
		}
	};
}();

jQuery(document).ready( function($) {
	if( $('#coachingTabs').length >= 1 ){
		Coaching.init();
	}
});