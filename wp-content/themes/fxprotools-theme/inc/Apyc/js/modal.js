var Modal = function(){
	var ajax_url = fx;

	function ajaxGetWebinar(){
		var ajaxCall = $.ajax({
		  method: "GET",
		  url: ajax_url.ajax_url,
		  data: { 'action': 'get_webinars' }
		});
		return ajaxCall;
	}
	function ajaxRegisterWebinar(body){
		var ajaxCall = $.ajax({
		  method: "POST",
		  url: ajax_url.ajax_url,
		  data: { 'action': 'register_webinars', 'post_data' : body }
		});
		return ajaxCall;
	}
	return {
		init:function(){
			//$(document).on('click','#reserve-your-seat',function(e){
			$('.webinar-modal-lg').on('shown.bs.modal', function (e) {
				//$('.ajax-webinars').html('<p>Getting Webinars, please wait...</p>');
				$('.webinar-register-now').hide();
				ajaxGetWebinar().done(function(data){
					$('.ajax-webinars').html(data);
					//$('.webinar-register-now').show();
				});
			})
			$('.webinar-modal-lg').on('hidden.bs.modal', function (e) {
				$('.ajax-webinars').html('');
			})
			$('.reserve-your-seat').click(function(e){
				e.preventDefault();
				$('.webinar-modal-lg').modal('show');	
			});
		},
		registerNow:function(){
			$('.webinar-register-now').on('click', function(e){
				e.preventDefault();
				var post_data = $(".register-webinar").serialize();
				ajaxRegisterWebinar(post_data).done(function(data){
					console.log(data);
				});;
			});
		}
	};
}();

var ModalRegisterNow = function(){
	
}();
jQuery(document).ready( function($) {
	Modal.init();
	Modal.registerNow();
});