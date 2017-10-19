var Coaching = function(){
	var ajax_url = fx;
	var upcoming_tab_show = null;
	var past_tab_show = null;
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
	return {
		init:function(){
			if(upcoming_tab_show == null){
				//show the upcoming ajax events
				//console.log('show the upcoming ajax events');
				$('#ajax-coach-upcoming-webinars').html('<p>Loading webinars please wait</p>');
				ajaxGetUpcomingWebinar().done(function(data){
					//console.log(data);
					if( !isJson(data) ){
						$('#ajax-coach-upcoming-webinars').html(data);
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
					$('#ajax-coach-history-webinars').html('<p>Loading webinars please wait</p>');
					ajaxGetPastWebinar().done(function(data){
						//console.log(data);
						if( !isJson(data) ){
							$('#ajax-coach-history-webinars').html(data);
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