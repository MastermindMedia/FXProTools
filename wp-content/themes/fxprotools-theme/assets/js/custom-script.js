jQuery(document).ready( function($) {
	
	$('#order_review_heading').appendTo('.col-1');
	$('#order_review').appendTo('.col-1');
	$('.checkout-sidebar').appendTo('.col-2');
	$('.woocommerce').addClass('checkout-holder');
	//$('.woocommerce-billing-fields > h3').html('STEP 1: ENTER ACCOUNT DETAILS');
	$('#mobile').val('324234234324423').hide();
	$('.woocommerce-additional-fields').hide();

	$('.form-row').each(function(){
		$(this).addClass('form-group row');
	});

	$('.form-row input, .form-row select').each(function(){
		$(this).addClass('form-control');
		$(this).wrap('<span class="input-wrapper"></span>')
	});

	$('#billing_first_name_field, #billing_last_name_field, #billing_email_field, #billing_phone_field, #account_password_field, #billing_address_1_field, #billing_city_field, #billing_state_field, #billing_postcode_field, #billing_country_field').each(function(){
		$(this).find('label').addClass('col-md-3 col-form-label');
		$(this).find('.input-wrapper').addClass('col-md-9');
	});

	//checkout field grouping
	var checkout_panel_1 = [
		'#billing_first_name_field',
		'#billing_last_name_field', 
		'#billing_email_field',
		'#billing_phone_field', 
		'#account_password_field'
	];

	var checkout_panel_2 = [
		'#billing_address_1_field',
		'#billing_city_field', 
		'#billing_state_field',
		'#billing_postcode_field', 
		'#billing_country_field'
	];

	$('.woocommerce-billing-fields__field-wrapper')
		.append('<div id="checkout-panel-1" class="panel panel-default"><div class="panel-heading">STEP 1: ENTER ACCOUNT DETAILS</div><div class="panel-body"></div></div>');
	for (i = 0; i < checkout_panel_1.length; i++) {
		if($(checkout_panel_1[i]).length){
			var html = $(checkout_panel_1[i]).html();
			$(checkout_panel_1[i]).remove();
		    $("#checkout-panel-1 .panel-body").append('<div class="form-group row" id="'+ checkout_panel_1[i] +'">'+ html +'</div>');
		}	
	}

	$('.woocommerce-billing-fields__field-wrapper').append('<div id="checkout-panel-2" class="panel panel-default"><div class="panel-heading">STEP 2: ENTER BILLING ADDRESS</div><div class="panel-body"></div></div>');
	for (i = 0; i < checkout_panel_2.length; i++) {
		var html = $(checkout_panel_2[i]).html();
		$(checkout_panel_2[i]).remove();
	    $("#checkout-panel-2 .panel-body").append('<div class="form-group row" id="'+ checkout_panel_2[i] +'">'+ html +'</div>');
	}
	
	$('#checkout-panel-3').each(function(){
		$('.woocommerce-checkout-review-order-table').clone().insertAfter("#checkout-panel-3 h5");
	});

});

// Events
$(document).on('click', 'a[href="#trial-products"]', function(e) {
	e.preventDefault();
	if (this.hash !== "")
	var hash = this.hash;
	$('html, body').animate({
		scrollTop: $(hash).offset().top - 30
	}, 600);
});

$(document).on('.fx-course-navigation ul li a, .fx-table-lessons a', function(){
	var lesson_id = $(this).data('previous-lesson-id');
	var lesson_link = $(this).attr('href');

	if( lesson_id > 1){
		$.ajax({
			url: fx.ajax_url,
			type : 'post',
			data : {
				action : 'lms_lesson_complete',
				lesson_id : lesson_id
			},
			success : function( response ) {
				if(response == '1'){
					window.location = lesson_link;
				}
				else{
					popup_alert("Course Lesson","Please finish the previous lesson first.");
				}
			}
		});
		return false;
	}
});

// Functions
function popup_alert($title, $message){
	$('#alert-modal .modal-title').html($title);
	$('#alert-modal .modal-body p').html($message);
	$('#alert-modal').modal('show');
}