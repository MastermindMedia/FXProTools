var Coaching = function(){
	var ajax_url = fx;
	var upcoming_tab_show = null;
	var past_tab_show = null;
	var private_coaching_show = null;
	var $date_num = 0;
	var $date_format = 'M';
	var $timefrom = '';
	var $timefrommeridiem = '';
	var $timeto = '';
	var $timetomeridiem = '';
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
	function _datePickerOnSelect(dateText, inst){
		// var date = $(this).val();
		// console.log(dateText);
        //console.log(inst);
        //console.log(inst.selectedDay);
		//$('.selected_date').val(inst.selectedDay);
		//var selected_month = (inst.selectedMonth + 1);
		//$('.selected_month').val(selected_month);
		//$('.selected_year').val(inst.selectedYear);
		var $content = $('.ajax-reched-woowebinar-time-rage');
		$content.html('<p> Getting time, please wait...</p>');
		_ajaxGetTime(inst).done(function(data){
			//console.log(data);
			$content.html(data);
		});
	}
	function _ajaxGetTime(dateFromDP){
		var time_from = '';
		var time_from_meridiem = '';
		var range_time_from = '';
		var time_to = '';
		var time_to_meridiem = '';
		var range_time_to = '';
		
		time_from = $timefrom;
		time_from_meridiem = $timefrommeridiem;
		range_time_from = time_from + ":00" + " " + time_from_meridiem.toUpperCase();
		
		time_to = $timeto;
		time_to_meridiem = $timetomeridiem;
		range_time_to = time_to + ":00" + " " + time_to_meridiem.toUpperCase();
		//console.log(range_time_from);
		//console.log(range_time_to);
		var ajaxCall = $.ajax({
		  method: "GET",
		  url: ajax_url.ajax_url,
		  data: { 
			'action': 'get_timerange_woowebinar',
			'selectedDate': dateFromDP.selectedDay,
			'selectedMonth': dateFromDP.selectedMonth,
			'selectedYear': dateFromDP.selectedYear,
			'range_time_from':range_time_from,
			'range_time_to':range_time_to
		  }
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
		},
		modal:function(){
			var $resched_modal = $('.resched-webinar-modal-lg');
			var $resched_datepicker = $('#resched-product-datepicker');
						
			$resched_modal.on('shown.bs.modal', function (e) {
				//console.log($date_num);
				var maxDateNum = "+" + $date_num;
				var _arg = {
					minDate: 0,
					maxDate: maxDateNum + $date_format,
					onSelect:function(dateText, inst){
						_datePickerOnSelect(dateText, inst);
					}
				}
				$resched_datepicker.datepicker(_arg);
			});
			$resched_modal.on('hidden.bs.modal', function (e) {
			  // do something...
			  $resched_datepicker.datepicker('destroy');
			});
			$(document).on('click', '.resched-webinar', function(e){
				e.preventDefault();
				var $this = $(this);
				$date_num = $this.data('schednum');
				$date_format = $this.data('scheddate');
				$timefrom = $this.data('timefrom');
				$timefrommeridiem = $this.data('timefrommeridiem');
				$timeto = $this.data('timeto');
				$timetomeridiem = $this.data('timetomeridiem');
				if( $date_format == 'month' ){
					$date_format = 'M';
				}
				if( $date_format == 'day' ){
					$date_format = 'D';
				}
				if( $date_format == 'year' ){
					$date_format = 'Y';
				}
				$('.resched-webinar-modal-lg').modal('show');	
			});
		}
	};
}();

jQuery(document).ready( function($) {
	if( $('#coachingTabs').length >= 1 ){
		Coaching.init();
		Coaching.modal();
	}
});