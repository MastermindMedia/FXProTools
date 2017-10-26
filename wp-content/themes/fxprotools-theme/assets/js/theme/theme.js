var Coaching=function(){function a(a){try{JSON.parse(a)}catch(a){return!1}return!0}function n(){return $.ajax({method:"GET",url:i.ajax_url,data:{action:"coach_get_webinars"}})}function t(){return $.ajax({method:"GET",url:i.ajax_url,data:{action:"coach_get_history_webinars"}})}var i=fx,r=null,o=null;return{init:function(){null==r&&($("#ajax-coach-upcoming-webinars").html("<p>Loading webinars please wait</p>"),n().done(function(n){a(n)||$("#ajax-coach-upcoming-webinars").html(n)})),$(".nav-tabs a").on("show.bs.tab",function(n){r=1,n.target,n.relatedTarget,"#past"==n.target.hash&&null==o&&(o=1,$("#ajax-coach-history-webinars").html("<p>Loading webinars please wait</p>"),t().done(function(n){a(n)||$("#ajax-coach-history-webinars").html(n)}))})}}}();jQuery(document).ready(function(a){a("#coachingTabs").length>=1&&Coaching.init()});
function popup_alert(l,i){$("#alert-modal .modal-title").html(l),$("#alert-modal .modal-body p").html(i),$("#alert-modal").modal("show")}jQuery(document).ready(function(l){l("#order_review_heading").appendTo(".col-1"),l("#order_review").appendTo(".col-1"),l(".checkout-sidebar").appendTo(".col-2"),l(".woocommerce").addClass("checkout-holder"),l("#mobile").val("324234234324423").hide(),l(".woocommerce-additional-fields").hide(),l(".form-row").each(function(){l(this).addClass("form-group row")}),l(".form-row input, .form-row select").each(function(){l(this).addClass("form-control"),l(this).wrap('<span class="input-wrapper"></span>')}),l("#billing_first_name_field, #billing_last_name_field, #billing_email_field, #billing_phone_field, #account_password_field, #billing_address_1_field, #billing_city_field, #billing_state_field, #billing_postcode_field, #billing_country_field").each(function(){l(this).find("label").addClass("col-md-3 col-form-label"),l(this).find(".input-wrapper").addClass("col-md-9")});var e=["#billing_first_name_field","#billing_last_name_field","#billing_email_field","#billing_phone_field","#account_password_field"],o=["#billing_address_1_field","#billing_city_field","#billing_state_field","#billing_postcode_field","#billing_country_field"];for(l(".woocommerce-billing-fields__field-wrapper").append('<div id="checkout-panel-1" class="panel panel-default"><div class="panel-heading">STEP 1: ENTER ACCOUNT DETAILS</div><div class="panel-body"></div></div>'),i=0;i<e.length;i++)if(l(e[i]).length){a=l(e[i]).html();l(e[i]).remove(),l("#checkout-panel-1 .panel-body").append('<div class="form-group row" id="'+e[i]+'">'+a+"</div>")}for(l(".woocommerce-billing-fields__field-wrapper").append('<div id="checkout-panel-2" class="panel panel-default"><div class="panel-heading">STEP 2: ENTER BILLING ADDRESS</div><div class="panel-body"></div></div>'),i=0;i<o.length;i++){var a=l(o[i]).html();l(o[i]).remove(),l("#checkout-panel-2 .panel-body").append('<div class="form-group row" id="'+o[i]+'">'+a+"</div>")}l("#checkout-panel-3").each(function(){l(".woocommerce-checkout-review-order-table").clone().insertAfter("#checkout-panel-3 h5")})}),$(document).on("click",".fx-board-list.w-toggle li",function(){$(".fx-board-list.w-toggle li").removeClass("open"),$(this).addClass("open"),$(this).find(".icon").toggleClass("fa-angle-up fa-angle-down"),$(this).find(".content").slideToggle("fast")}),$(document).on("click",".scroll-to",function(l){if(l.preventDefault(),""!==this.hash)var i=this.hash;$("html, body").animate({scrollTop:$(i).offset().top-30},600)}),$(document).on("click",'input[name="f2-survey"]',function(){$(".f2-group-options").fadeOut("normal",function(){$(".f2-group-form").fadeIn()})});
jQuery(function(e){function i(){var i=!1;return e("#modalCompose").find("select, input, textarea").each(function(){e(this).is(":visible")&&(i=i||!e(this).val())}),i=i||!tinymce.get("body").getContent()}if("undefined"!=typeof EMAIL_TYPE){var t=fx.ajax_url,n=e("#mailContainer");if(e.post(t,{action:"email_inbox_count"},function(i){e("#unreadCount").text(i),e.post(t,{action:"email_"+EMAIL_TYPE},function(i){n.empty(),0==i.length&&n.append('<tr><td colspan="3">No emails found.</td></td>'),i.forEach(function(i){var a,d,o=i;n.append(e("<tr />").addClass(i.status).append(e("<td />").append(e("<input />").attr("type","checkbox")).addClass("text-center")).append(e("<td />").append(e("<a />").text(i.subject).attr("href","#").click(function(i){a.prev().hasClass("unread")&&(a.prev().removeClass("unread").addClass("read"),e.post(t,{action:"email_read",id:o.id},function(i){e("#unreadCount").text(parseInt(e("#unreadCount").text())-1)})),a.children().slideToggle(),i.stopPropagation(),i.preventDefault()}))).append(e("<td />").append(moment(i.modified).fromNow()).addClass("text-center"))),n.append(a=e("<tr />").append(d=e("<td />").attr("colspan",3).html(i.content).hide())),"inbox"==EMAIL_TYPE&&d.append(e('<a href="#" class="btn btn-danger pull-right">Delete</a>').click(function(i){e(this).text("Deleting...").attr("disabled","disabled"),e.post(t,{action:"email_delete",id:o.id},function(i){e.merge(a,a.prev()).fadeOut()})}))})})}),e("#modalCompose").length){for(var a in ALL_PRODUCTS)e("#recipient_product").append(e("<option />").attr("value",a).text(ALL_PRODUCTS[a]));e("#recipient_product").select2({dropdownParent:e("#modalCompose")});for(var a in ALL_USERS)e("#recipient_individual_user").append(e("<option />").attr("value",a).text(ALL_USERS[a]));e("#recipient_individual_user").select2({dropdownParent:e("#modalCompose")}),e("#recipient_individual_type").change(function(){switch(e(this).val()){case"email":e("#recipient_individual_name").parents(".form-group").show(),e("#recipient_individual_email").parents(".form-group").show(),e("#recipient_individual_user").parents(".form-group").hide();break;case"user":e("#recipient_individual_name").parents(".form-group").hide(),e("#recipient_individual_email").parents(".form-group").hide(),e("#recipient_individual_user").parents(".form-group").show()}}).change(),e("#email_recipient_type").change(function(){var i={all:[],group:["recipient_group"],product:["recipient_product"],individual:["recipient_individual_type","recipient_individual_name","recipient_individual_email","recipient_individual_user"]};for(var t in i)i[t].forEach(function(i){e("#"+i).parents(".form-group").hide()});i[e(this).val()].forEach(function(i){e("#"+i).parents(".form-group").show()}),"individual"==e(this).val()&&e("#recipient_individual_type").change()}).change(),tinymce.init({selector:"#body",menubar:!1,statusbar:!1,setup:function(e){e.on("change",function(){e.save()})}});var d=!1;setInterval(function(){d||i()?e("#modalCompose").find("button").prop("disabled",!0):e("#modalCompose").find("button").prop("disabled",!1)},500),e("#modalCompose").find("button").click(function(){i()||(d=!0,e("#modalCompose").find("input, select").prop("disabled",!0),tinymce.get("body").setMode("readonly"),e.post(t,{action:"send_email",email_recipient_type:e("#email_recipient_type").val(),recipient_group:e("#recipient_group").val(),recipient_product:e("#recipient_product").val(),recipient_individual_type:e("#recipient_individual_type").val(),recipient_individual_name:e("#recipient_individual_name").val(),recipient_individual_email:e("#recipient_individual_email").val(),recipient_individual_user:e("#recipient_individual_user").val(),subject:e("#subject").val(),body:e("#body").val()},function(i){"OK"!=i?alert("Error: "+i):(alert("Email sent."),window.location.reload()),d=!1,e("#modalCompose").find("input, select").prop("disabled",!1),tinymce.get("body").setMode("design")}))})}}});
$(document).on(".fx-course-navigation ul li a, .fx-table-lessons a",function(){var s=$(this).data("previous-lesson-id"),e=$(this).attr("href");if(s>1)return $.ajax({url:fx.ajax_url,type:"post",data:{action:"lms_lesson_complete",lesson_id:s},success:function(s){"1"==s?window.location=e:popup_alert("Course Lesson","Please finish the previous lesson first.")}}),!1});
var Modal=function(){function a(a){try{JSON.parse(a)}catch(a){return!1}return!0}function e(){return $.ajax({method:"GET",url:r.ajax_url,data:{action:"get_webinars"}})}function n(a){return $.ajax({method:"POST",url:r.ajax_url,data:{action:"register_webinars",post_data:a}})}var r=fx;return{init:function(){$(".webinar-modal-lg").on("shown.bs.modal",function(n){$(".ajax-webinars").html("<p>Getting Webinars, please wait...</p>"),$(".webinar-register-now").hide(),e().done(function(e){a(e)?"no-webinar"==(e=jQuery.parseJSON(e)).status&&$(".ajax-webinars").html("<p>"+e.msg+"</p>"):$(".ajax-webinars").html(e)})}),$(".webinar-modal-lg").on("hidden.bs.modal",function(a){$(".ajax-webinars").html("")}),$(".reserve-your-seat").click(function(a){a.preventDefault(),$(".webinar-modal-lg").modal("show")})},registerNow:function(){$(document).on("click",".webinar-register-now",function(e){e.preventDefault(),$(".ajax-webinar-lists").hide(),$(".ajax-webinars-msg").html("<p>Registering to webinar please wait</p>"),n($(".register-webinar").serialize()).done(function(e){$(".ajax-webinars-msg").html(""),a(e)&&("error"==(e=jQuery.parseJSON(e)).status?(console.log(e),$.each(e.msg,function(a,e){$(".ajax-webinars-msg").append("<p>"+e+"</p>")})):(console.log(e),$(".ajax-webinars-msg").html("<p>"+e.msg+"</p>"),$.each(e.webinar_ret,function(a,e){$("."+a+"-info").html(""),$("."+a+"-info").html("<p>"+e.msg+"</p>")}))),$(".ajax-webinar-lists").show()})})}}}(),ModalRegisterNow=void 0;jQuery(document).ready(function(a){Modal.init(),Modal.registerNow()});
"use strict";!function(t,o,e){var i=function(t){this.init(t)};i.prototype.init=function(o){this.data=[],o.each(t.proxy(function(o,e){var i=t(e),n=new playerjs.Player(e);n.on("ready",function(){n.unmute(),this.add(i,n)},this)},this)),this.listen()},i.prototype.add=function(t,o){var e=t.offset().top,i=e+t.height();this.data.push({top:e,bottom:i,$elem:t,player:o})},i.prototype.scrolled=function(){var o=t(e),i=o.scrollTop(),n=i+o.height();t.each(t.map(this.data,function(t,o){var e=0;if(t.top<=n&&t.bottom>=i){var r=t.bottom-t.top;e=t.bottom>n?(n-t.top)/r:t.top<i?(t.bottom-i)/r:1}return{p:e,t:t.top,player:t.player}}).sort(function(t,o){return t.p>o.p?-1:t.p<o.p?1:t.t<o.t?-1:t.t>o.t?1:0}),function(t,o){0===t&&o.p>.25?o.player.play():o.player.pause()})},i.prototype.resized=function(){t.each(this.data,function(t,o){o.top=o.$elem.offset().top,o.bottom=o.top+o.$elem.height()}),this.scrolled()},i.prototype.listen=function(o,i){var n=t(e);n.on("scroll",t.proxy(function(){if(0===this.data.length)return!1;this.scrolled()},this)),n.on("resize",t.proxy(function(){if(0===this.data.length)return!1;this.resized()},this))}}(jQuery,document,window);
jQuery(document).ready(function(n){n(".fx-sendgrid").submit(function(e){return n.ajax({url:fx.ajax_url,type:"post",data:{action:"fx_sendgrid_capture_email",email:n(".fx-sendgrid").find('input[name="email"]').val(),funnel_id:n(".fx-sendgrid").find('input[name="funnel_id"]').val()},success:function(e){if("OK"==(e=JSON.parse(e)).status){var i=n(".fx-sendgrid").find('input[name="redirect_to"]').val();window.location.href=i}else alert("Sending email information failed.")}}),!1})});
jQuery(document).ready(function(o){var t=o(window),e=o("#pto--floating-video"),i=o("#pto--floating-video iframe"),f=e.offset().top,n=Math.floor(f+e.outerHeight()/2);t.on("resize",function(){f=e.offset().top,n=Math.floor(f+e.outerHeight()/2)}).on("scroll",function(){i.toggleClass("is-sticky",t.scrollTop()>n)})});
jQuery(document).ready(function(t){t(".btn-pause").on("click",function(){return t.ajax({url:fx.ajax_url,type:"post",data:{action:"fx_customer_pause_account",subscription_id:t(this).data("subscription-id")},success:function(t){"success"==t.status?window.location=fx.logout_url:alert("Pause subscription fail. Please contact support.")}}),!1})});
//# sourceMappingURL=theme.js.map
