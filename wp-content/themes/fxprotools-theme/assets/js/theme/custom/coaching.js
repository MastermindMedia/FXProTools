var Coaching = function(){
	var ajax_url = fx;
	var current_active_tab = null;
	function isJson(str) {
		try {
			JSON.parse(str);
		} catch (e) {
			return false;
		}
		return true;
	}
	
	return {
		init:function(){
			if(current_active_tab == null){
				//show the upcoming ajax events
				console.log('show the upcoming ajax events');
			}
			$('.nav-tabs a').on('show.bs.tab', function (e) {
				current_active_tab = 1;
				console.log('show');
				e.target // newly activated tab
				e.relatedTarget // previous active tab
				console.log(e);
				console.log(e.target.text);
				console.log(e.relatedTarget.text);
			});
		}
	};
}();

jQuery(document).ready( function($) {
	if( $('#coachingTabs').length >= 1 ){
		Coaching.init();
	}
});