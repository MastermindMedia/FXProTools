var WooGotoWebinar = function(){
	
	return {
		init:function(){
			
		},
	};
}();

jQuery(document).ready( function($) {
	//console.log('here');
	$('#apyc_woo_gotowebinar_appointment').hide();
	$('#product-type').change(function(){
		var _val = $(this).val();
		if( _val == 'apyc_woo_gotowebinar_appointment' ){
			$( '.options_group.pricing.show_if_simple').show();
			$('#' + _val).show();
			
			console.log(_val);
		}else{
			$('#' + _val).hide();
		}
	});
	
});