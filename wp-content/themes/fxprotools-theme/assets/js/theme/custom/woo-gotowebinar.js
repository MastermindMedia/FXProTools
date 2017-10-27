var PublicGotoWebinar = function(){
	
	return {
		init:function(){
			
		},
		date_picker:function(){
			var _arg = {
				minDate: 0,
				maxDate: "+12M"
			}
			$('#product-datepicker').datepicker(_arg);
		},
	};
}();

jQuery(document).ready( function($) {
	PublicGotoWebinar.date_picker();
});