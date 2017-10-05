var Modal = function(){
	return {
		init:function(){
			//$(document).on('click','#reserve-your-seat',function(e){
			$('.reserve-your-seat').click(function(e){
				e.preventDefault();
				$('.webinar-modal-lg').modal('show');	
			});
		}
	};
}();
jQuery(document).ready( function($) {
	Modal.init();
});