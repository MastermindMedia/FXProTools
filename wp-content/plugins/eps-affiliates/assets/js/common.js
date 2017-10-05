$(document).ready(function(){

	$( ".date_time_picker" ).datepicker();

  $('[data-toggle="tooltip"]').tooltip();   
  
   
    

});

$(function () {
     $('.bxslider').bxSlider({
      pager: false, // disables pager
      slideWidth: 150,
    
    });
     
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "rtl": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": 300,
      "hideDuration": 2000,
      "timeOut": 5000,
      "extendedTimeOut": 1000,
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
  
    $('.navbar-toggle').click(function () {
        $('.navbar-nav').toggleClass('slide-in');
        $('.side-body').toggleClass('body-slide-in');
        $('#search').removeClass('in').addClass('collapse').slideUp(200);

        /// uncomment code for absolute positioning tweek see top comment in css
        //$('.absolute-wrapper').toggleClass('slide-in');
        
    });
    
     $('.auto_complete').on('keyup click',function(){
  		var autoArray = [];
    	var path 			 = $(this).attr('data-path');
    	var search_key = $(this).val();
    	if (path != '#' && search_key!=undefined) {
    		$.ajax({
			   	type :'POST',
			   	data : {
			   		action:path,
            tree_mode : $('#tree-mode').val(),
			   	},
			   	url:ajax_object.ajaxurl,
			   	success: function(data){
							var arr = JSON.parse(data);
							var i 	= 0;
							var data_array = [];
							$('.auto_complete').typeahead({
                source: arr,
              });
			   	}
			  });
    	}
    });
/*
 * -------------------------------------------
* Data tables for user downlines
 * -------------------------------------------
*/
  if ($('.custom-data-tables').length) {

      var table; 
      table = $(".custom-data-tables").DataTable({
       "processing": true, 
       "serverSide": true, 
       "pageLength": 50,
       "order": [], 
       "ajax": { 
          "url"   : ajax_object.ajaxurl,
          "type"  : "POST",
          "data"  :{
            action:'afl_user_downlines_data_table',
          }   
        }, 
        "columnDefs": [{ 
          "targets": [0,1,2,3], 
          "orderable": false, 
        }], 
      }); 
  }
/*
 * -------------------------------------------
* Data tables for user refred members
 * -------------------------------------------
*/
  if ($('.refered-members').length) {

      var table; 
      table = $(".refered-members").DataTable({
       "processing": true, 
       "serverSide": true, 
       "pageLength": 50,
       "order": [], 
       "ajax": { 
          "url"   : ajax_object.ajaxurl,
          "type"  : "POST",
          "data"  :{
            action:'afl_user_refered_downlines_data_table',
          }   
        }, 
        "columnDefs": [{ 
          "targets": [0,1,2,3], 
          "orderable": false, 
        }], 
      }); 
  }
/*
* -------------------------------------------
* Data tables for ewallet summary
* -------------------------------------------
*/
if ($('.custom-ewallet-summary-table').length) {
      var table; 
      table = $(".custom-ewallet-summary-table").DataTable({
      "bFilter" : false, 
      "bInfo": false,
      "searching": false,
      "paging": false,
      "pageLength": 50,
       "processing": true, 
       "serverSide": true, 
       "order": [], 
       "ajax": { 
          "url"   : ajax_object.ajaxurl,
          "type"  : "POST",
          "data"  :{
            action:'afl_user_ewallet_summary_data_table',
          }   
        }, 
        "columnDefs": [{ 
          "targets": [0,1,2], 
          "orderable": false, 
        }], 
      }); 
  }

/*
* -------------------------------------------
* Data tables for ewallet transaction
* -------------------------------------------
*/
if ($('.custom-ewallet-all-trans-table').length) {
      var table; 
      table = $(".custom-ewallet-all-trans-table").DataTable({
       "processing": true, 
       "serverSide": true, 
       "pageLength": 50,
       "order": [], 
       "ajax": { 
          "url"   : ajax_object.ajaxurl,
          "type"  : "POST",
          "data"  :{
            action:'afl_user_ewallet_all_transaction_data_table',
          }   
        }, 
        "columnDefs": [{ 
          "targets": [0,1,2], 
          "orderable": false, 
        }], 
      }); 
  }
/*
* -------------------------------------------
* Data tables for ewallet Income report 
* -------------------------------------------
*/
if ($('.custom-ewallet-income-table').length) {
      var table; 
      table = $(".custom-ewallet-income-table").DataTable({
       "processing": true, 
       "serverSide": true, 
       "pageLength": 50,
       "order": [], 
       "ajax": { 
          "url"   : ajax_object.ajaxurl,
          "type"  : "POST",
          "data"  :{
            action:'afl_user_ewallet_income_data_table',
          }   
        }, 
        "columnDefs": [{ 
          "targets": [0,1,2], 
          "orderable": false, 
        }], 
      }); 
  }
/*
* -------------------------------------------
* Data tables for ewallet Expense report 
* -------------------------------------------
*/
if ($('.custom-ewallet-expense-table').length) {
      var table; 
      table = $(".custom-ewallet-expense-table").DataTable({
       "processing": true, 
       "serverSide": true,
       "pageLength": 50, 
       "order": [], 
       "ajax": { 
          "url"   : ajax_object.ajaxurl,
          "type"  : "POST",
          "data"  :{
            action:'afl_user_ewallet_expense_data_table',
          }   
        }, 
        "columnDefs": [{ 
          "targets": [0,1,2], 
          "orderable": false, 
        }], 
      }); 
  }

/*
* -------------------------------------------
* Data tables for business transaction summary  
* ------------------------------------------- 
*/
if ($('.custom-business-summary-table').length) {
      var table; 
      table = $(".custom-business-summary-table").DataTable({
      "bFilter" : false, 
      "bInfo": false,
      "searching": false,
      "paging": false,
      "pageLength": 50,
       "processing": true, 
       "serverSide": true, 
       "order": [], 
       "ajax": { 
          "url"   : ajax_object.ajaxurl,
          "type"  : "POST",
          "data"  :{
            action:'afl_admin_business_summary_data_table',
          }   
        }, 
        "columnDefs": [{ 
          "targets": [0,1,2], 
          "orderable": false, 
        }], 
      }); 
  }
  /*
* -------------------------------------------
* Data tables for business All transaction
* -------------------------------------------
*/
if ($('.custom-business-all-trans-table').length) {
      var table; 
      table = $(".custom-business-all-trans-table").DataTable({
       "processing": true, 
       "serverSide": true, 
       "pageLength": 50,
       "order": [], 
       "ajax": { 
          "url"   : ajax_object.ajaxurl,
          "type"  : "POST",
          "data"  :{
            action:'afl_admin_business_all_transaction_data_table',
          }   
        }, 
        "columnDefs": [{ 
          "targets": [0,1,2,3,4,5,6], 
          "orderable": false, 
        }], 
      }); 
  }


/*
* -------------------------------------------
* Data tables for business income report
* -------------------------------------------
*/
if ($('.custom-business-income-history-table').length) {
      var table; 
      table = $(".custom-business-income-history-table").DataTable({
       "processing": true, 
       "serverSide": true, 
       "pageLength": 50,
       "order": [], 
       "ajax": { 
          "url"   : ajax_object.ajaxurl,
          "type"  : "POST",
          "data"  :{
            action:'afl_admin_business_income_history_data_table',
          }   
        }, 
        "columnDefs": [{ 
          "targets": [0,1,2,3,4,5,6], 
          "orderable": false, 
        }], 
      }); 
  }
/*
* -------------------------------------------
* Data tables for business expense report
* -------------------------------------------
*/
if ($('.custom-business-expense-history-table').length) {
      var table; 
      table = $(".custom-business-expense-history-table").DataTable({
       "processing": true, 
       "serverSide": true, 
       "pageLength": 50,
       "order": [], 
       "ajax": { 
          "url"   : ajax_object.ajaxurl,
          "type"  : "POST",
          "data"  :{
            action:'afl_admin_business_expense_history_data_table',
          }   
        }, 
        "columnDefs": [{ 
          "targets": [0,1,2,3,4,5,6], 
          "orderable": false, 
        }], 
      }); 
  }
/*
  * -------------------------------------------
  * On click Holding tank user
  * -------------------------------------------
*/
   $('.holding-tank-profiles li').click(function(){
    $('#seleted-user-id').val($(this).attr('data-user-id'));
    $('.progress').css('width','0px');
    $('#holding-tank-change-model').modal('show');
   });

   $('#place-user').click(function() {
    if ($('#choose-parent').val() == '') {
      $('.notification').html('please choose the parent');
      $('.notification').css('color', 'red');
    } else {
      //load the availbale free spaces
         var parent     = $('#choose-parent').val();
         var sponsor    = $('#current-user-id').val();
         var user_id    = $('#seleted-user-id').val();
         var tree_mode  = $('#tree-mode').val();

         if (user_id != '' && sponsor!= '' && parent!='' ){
          var position = $('input[name="free_space"]:checked').attr('id');
          if (position) {
            $.ajax({
              type :'POST',
              data : {
                action:'afl_place_user_from_tank',
                user_id:user_id,
                sponsor:sponsor,
                parent:parent,
                position :position, 
                tree_mode :tree_mode, 
              },
              url:ajax_object.ajaxurl,
              beforeSend:function(){
                  for(var i = 1; i <=100 ; i++){
                    $('.progress').css('width',i+'%');
                  }
              },
              complete:function(){
                  $('.progress').css('width','100%');

              },
              success: function(data){
                var data = JSON.parse(data);
                $('.progress').css('width','100%');
                if (data['status'] == 1) {
                  $('.notification').html('Member Placed successfully');
                   setTimeout(function() { window.location.reload(true); }, 500 );
                }
              }
            });
          } else {
            $('.notification').html('Unable to select a position.You cannot place a member without the position.');
            $('.notification').css('color', 'red');
          }
          
         }
    }
   });

  $('#choose-parent').change(function(){
    if ($('#choose-parent').val() !=''){
      $.ajax({
        type :'POST',
        data : {
          action:'afl_get_available_free_space',
          sponsor : $('#current-user-id').val(),
          uid     : $('#seleted-user-id').val(),
          parent  : $('#choose-parent').val(),
          tree_mode : $('#tree-mode').val(),

        },
        url:ajax_object.ajaxurl,
        success: function(data){
            $('#available-free-spaces').html(data);
        }
      });
    }
  });

  $('div.pricingTable').on('click', function(){
    $(this).parent().parent().find('div.pricingTable').removeClass('selected');
    $(this).addClass('selected');
    $(this).find('input[type="radio"]').prop("checked", true);
    
  });
/*
 * -------------------------------------------------------------
 * On clicking the auto placement button
 * get the uid
 * user automatically place under a user
 * -------------------------------------------------------------
*/  
 $('#auto-place-user').click(function (){
    var sponsor = $('#current-user-id').val();
    var uid     = $('#seleted-user-id').val();
    var choose_sponsor  = $('#choose-parent').val();
    if ( choose_sponsor ) {
      sponsor = choose_sponsor.match(/\((\d+)\)/)[1];
    }
    
    $.ajax({
      type :'POST',
      data : {
        action:'afl_auto_place_user_ajax',
        sponsor : sponsor,
        uid     : $('#seleted-user-id').val(),
        tree_mode : $('#tree-mode').val(),
      },
      url:ajax_object.ajaxurl,
      beforeSend:function(){
          for(var i = 1; i <=100 ; i++){
            $('.progress').css('width',i+'%');
          }
      },
      complete:function(){
        $('.progress').css('width','100%');

      },
      success: function(data){
        $('.progress').css('width','100%');
        $('.notification').html('Completed');

        setTimeout(function() { window.location.reload(true); }, 500 );
      }
    });

 });


//document ends here
});
  
/*
 * -------------------------------------------------------------
 * Expand genealogy tree on click  expense
 * -------------------------------------------------------------
*/
function expandMatrixTree(obj) {
  $(obj).find('i').toggleClass('fa-times-circle fa-plus-circle');
    var $uid = $(obj).attr('data-user-id');

    if($(obj).find('i').hasClass('fa-plus-circle')){
      $('.append-child-'+$uid).html('');
      $(obj).parent().parent().removeClass('hv-item-parent');

    } else{
      $(obj).parent().parent().addClass('hv-item-parent');

      if ($uid != undefined) {
        $.ajax({
          type :'POST',
          data : {
            action:'afl_user_expand_genealogy',
            uid:$uid,
          },
          url:ajax_object.ajaxurl,
          success: function(data){
            if (data.length) {
              $(data).hide().appendTo('.append-child-'+$uid).fadeIn(1000);
              // $('.append-child-'+$uid).append(data).fadeIn('slow');
            }
          }
        });
      }
    }
}
/*
 * -------------------------------------------------------------
 * Expand genealogy tree on click  expense
 * -------------------------------------------------------------
*/
function expandUnilevelTree(obj) {
  $(obj).find('i').toggleClass('fa-times-circle fa-plus-circle');
    var $uid = $(obj).attr('data-user-id');

    if($(obj).find('i').hasClass('fa-plus-circle')){
      $('.append-child-'+$uid).html('');
      $(obj).parent().parent().removeClass('hv-item-parent');

    } else{
      $(obj).parent().parent().addClass('hv-item-parent');

      if ($uid != undefined) {
        $.ajax({
          type :'POST',
          data : {
            action:'afl_unilevel_user_expand_genealogy',
            uid:$uid,
          },
          url:ajax_object.ajaxurl,
          success: function(data){
            if (data.length) {
              $(data).hide().appendTo('.append-child-'+$uid).fadeIn(1000);
              // $('.append-child-'+$uid).append(data).fadeIn('slow');
            }
          }
        });
      }
    }
}


/*
 * -------------------------------------------------------------
 * Expand genealogy tree on click  expense
 * -------------------------------------------------------------
*/
  function expandToggleMatrixTree(obj) {
    $(obj).find('i').toggleClass('fa-times-circle fa-plus-circle');
      var $uid = $(obj).attr('data-user-id');

      if($(obj).find('i').hasClass('fa-plus-circle')){
        $('.append-child-'+$uid).html('');
        $(obj).parent().parent().removeClass('hv-item-parent');

      } else{
        $(obj).parent().parent().addClass('hv-item-parent');

        if ($uid != undefined) {
          $.ajax({
            type :'POST',
            data : {
              action:'afl_user_expand_toggle_genealogy',
              uid:$uid,
            },
            url:ajax_object.ajaxurl,
            success: function(data){
              if (data.length) {
                $(data).hide().appendTo('.append-child-'+$uid).fadeIn(1000);
                // $('.append-child-'+$uid).append(data).fadeIn('slow');
              }
            }
          });
        }
      }
  }
/*
 * -------------------------------------------------------------
 * Expand unilevel genealogy tree on click  expense
 * -------------------------------------------------------------
*/
  function expandToggleUnilevelTree(obj) {
    $(obj).find('i').toggleClass('fa-times-circle fa-plus-circle');
      var $uid = $(obj).attr('data-user-id');

      if($(obj).find('i').hasClass('fa-plus-circle')){
        $('.append-child-'+$uid).html('');
        $(obj).parent().parent().removeClass('hv-item-parent');

      } else{
        $(obj).parent().parent().addClass('hv-item-parent');

        if ($uid != undefined) {
          $.ajax({
            type :'POST',
            data : {
              action:'afl_unilevel_user_expand_toggle_genealogy',
              uid:$uid,
            },
            url:ajax_object.ajaxurl,
            success: function(data){
              if (data.length) {
                $(data).hide().appendTo('.append-child-'+$uid).fadeIn(1000);
                // $('.append-child-'+$uid).append(data).fadeIn('slow');
              }
            }
          });
        }
      }
  }
/*
 * ----------------------------------------------------------------
 * Add error class
 * ----------------------------------------------------------------
*/

 function inform_error (id = '') {
  $('#'+id).addClass('required error');
  $('#'+id).parent('div').addClass('has-error');
 }

/*
 * -------------------------------------------------------------
 * Increment the progress bar
 * -------------------------------------------------------------
*/
  function progressBarIncrement () {
    var width   = $('.progress-bar').css('width');
    parentWidth = $('.progress-bar').offsetParent().width(),
    
    
    percent = Math.round(100 * parseInt(width) / parseInt(parentWidth));
    percent = percent + 4;
     if ( width == undefined)
      percent = 1;
    
    if (percent <= 98) {
       $('#message').html('authenticating API....');
       $("#progress").html('<div class="progress-bar" role="progressbar"  aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>');
       $('.progress-bar').css('transition-duration','300ms');
       $('.progress-bar').css( 'width' ,percent+'%');
    }
  }
/*
 * -------------------------------------------------------------
 * Toggle holding tank node to left
 * -------------------------------------------------------------
*/
  function _toggle_holding_node_left(object){
    var toggle_left_id = $(object).attr('data-toggle-uid');
    var sponsor        = $('#sponsor').val(); 
    var tree           = $('#tree').val();
    $.ajax({
      type :'POST',
      data : {
        action:'afl_user_holding_genealogy_toggle_left',
        uid:toggle_left_id,
        sponsor:sponsor,
        tree:tree

      },
      url:ajax_object.ajaxurl,
      success: function(data){
         data = JSON.parse(data);
        if (data!=null) {
         $('.toggle-save-placement-button').attr('data-toggle-uid',data.uid)
         html_tag = _theme_toggle_holding_genealogy_user(data);
         $(object).parent('.toggle-user-placement-toggle-area').html(html_tag);
        }
      }
    });
  }
/*
 * -------------------------------------------------------------
 * Toggle holding tank node to right
 * -------------------------------------------------------------
*/
  function _toggle_holding_node_right(object){
    var toggle_right_id = $(object).attr('data-toggle-uid');
    var sponsor         = $('#sponsor').val(); 
    var tree            = $('#tree').val();
    
      $.ajax({
        type :'POST',
        data : {
          action:'afl_user_holding_genealogy_toggle_right',
          uid:toggle_right_id,
          sponsor:sponsor,
          tree:tree

        },
        url:ajax_object.ajaxurl,
        success: function(data){
            data = JSON.parse(data);
          if (data!=null) {
            $('.toggle-save-placement-button').attr('data-toggle-uid',data.uid)
            html_tag = _theme_toggle_holding_genealogy_user(data);
            $(object).parent('.toggle-user-placement-toggle-area').html(html_tag);
          }
        }
      });
  }
/*
 * -------------------------------------------------------------
 * Place user toggel genealogy selected position
 * -------------------------------------------------------------
*/
  function _toggle_holding_node_place(object){
    var place_holding_uid       = $(object).attr('data-toggle-uid');
    var place_holding_parent    = $(object).attr('data-toggle-parent');
    var place_holding_position  = $(object).attr('data-toggle-position');
    var tree_mode               = $('#tree').val(); 
    var sponsor                 = $('#sponsor').val(); 
    if ( place_holding_uid == 0) {
      alert('Please choose a holding user.');
      return false;
    }
    $.confirm({
      title: 'Confirm',
      content: 'Really you want to place the holding user to this parent?',
      icon: 'fa fa-question-circle',
      animation: 'scale',
      closeAnimation: 'scale',
      opacity: 0.5,
      buttons: {
        'confirm': {
            text: 'Proceed',
            btnClass: 'btn-blue',
            action: function () {
              $.ajax({
                type :'POST',
                data : {
                  action:'afl_place_user_from_tank',
                  user_id:place_holding_uid,
                  sponsor:sponsor,
                  parent:place_holding_parent,
                  position :place_holding_position, 
                  tree_mode :tree_mode, 
                },
                url:ajax_object.ajaxurl,
                success: function(data){
                  var data = JSON.parse(data);
                  if (data['status'] == 1) {
                    $.alert('Success. the member has been placed successfully.');
                  }
                   setTimeout(function() { window.location.reload(true); }, 500 );
                }
              });
            }
        },
        cancel: function () {
        },
      }
    });

  }

/* -------------------------------------------------------------------------------------- */
/*
 * ------------------------------------------------------------
 * Theme 
 * ------------------------------------------------------------
*/
  function _theme_toggle_holding_genealogy_user (json_data) {
      var html_tag = '';
      html_tag += '<span class="toggle-left-arrow" data-toggle-uid="'+json_data.uid+'" onclick="_toggle_holding_node_left(this)">';
      html_tag += '<i class="fa fa-caret-left fa-5x"></i>';
      html_tag += '</span>';
      html_tag += '<div class="holding-toggle-user-image">';
      html_tag += '<img src="'+json_data.image_url+'">';
      html_tag += '</div>';
      html_tag += '<span class="toggle-right-arrow" data-toggle-uid="'+json_data.uid+'" onclick="_toggle_holding_node_right(this)">';
      html_tag += '<i class="fa fa-caret-right fa-5x"></i>';
      html_tag += '</span>';
      html_tag += '<p>';
      html_tag += json_data.user_login;
      html_tag += '</p>';
      html_tag += '</div>';
      return html_tag;
  }
/* -------------------------------------------------------------------------------------- */