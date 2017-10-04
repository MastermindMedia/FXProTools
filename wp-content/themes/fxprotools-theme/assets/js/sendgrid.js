jQuery(document).ready(function($){
	$('.fx-sendgrid').submit(function(e){
		$.ajax({
			url: fx.ajax_url,
			type : 'post',
			data : {
				action : 'fx_sendgrid_capture_email',
				email : $('.fx-sendgrid').find('input[name="email"]').val(),
				funnel_id : $('.fx-sendgrid').find('input[name="funnel_id"]').val(), 
			},
			success : function( response ) {
				response = JSON.parse( response );
				if(response.status == "OK"){
					var redirect_to = $('.fx-sendgrid').find('input[name="redirect_to"]').val();
					window.location.replace( redirect_to );
				}
				else{
					alert("Sending email information failed.");
				}
			}
		});
		return false;
		e.preventDefault();
	});
});