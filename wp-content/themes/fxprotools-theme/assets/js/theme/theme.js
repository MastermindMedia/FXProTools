var Coaching=function(){function e(e){try{JSON.parse(e)}catch(e){return!1}return!0}function a(){return $.ajax({method:"GET",url:c.ajax_url,data:{action:"coach_get_webinars"}})}function t(){return $.ajax({method:"GET",url:c.ajax_url,data:{action:"coach_get_history_webinars"}})}function n(){return $.ajax({method:"GET",url:c.ajax_url,data:{action:"coach_get_private_coaching"}})}function r(e){return $.ajax({method:"POST",url:c.ajax_url,data:{action:"resched_webinar",post_data:e}})}function o(e,a){$(".selected_date").val(a.selectedDay);var t=a.selectedMonth+1;$(".selected_month").val(t),$(".selected_year").val(a.selectedYear);var n=$(".ajax-reched-woowebinar-time-rage");n.html("<p> Getting time, please wait...</p>"),i(a).done(function(e){n.html(e)})}function i(e){var a="",t="";return a=m+":00 "+p.toUpperCase(),t=g+":00 "+f.toUpperCase(),$.ajax({method:"GET",url:c.ajax_url,data:{action:"get_timerange_woowebinar",selectedDate:e.selectedDay,selectedMonth:e.selectedMonth,selectedYear:e.selectedYear,range_time_from:a,range_time_to:t}})}var c=fx,d=null,l=null,s=null,u=0,h="M",m="",p="",g="",f="",w="",b="",_=$(".resched-button");return{init:function(){if(null==d){var r=$("#ajax-coach-upcoming-webinars");r.html("<p>Loading webinars please wait</p>"),a().done(function(a){e(a)?"no-webinar"==(a=jQuery.parseJSON(a)).status&&r.html("<p>"+a.msg+"</p>"):r.html(a)})}$(".nav-tabs a").on("show.bs.tab",function(a){if(d=1,a.target,a.relatedTarget,"#past"==a.target.hash&&null==l&&(l=1,(r=$("#ajax-coach-history-webinars")).html("<p>Loading webinars please wait</p>"),t().done(function(a){e(a)?"no-webinar"==(a=jQuery.parseJSON(a)).status&&r.html("<p>"+a.msg+"</p>"):r.html(a)})),"#private-coaching"==a.target.hash&&null==s){s=1;var r=$("#ajax-coach-private-coaching-webinar");r.html("<p>Loading private coaching webinars please wait</p>"),n().done(function(a){e(a)?"no-webinar"==(a=jQuery.parseJSON(a)).status&&r.html("<p>"+a.msg+"</p>"):r.html(a)})}})},modal:function(){var e=$(".resched-webinar-modal-lg"),a=$("#resched-product-datepicker");_.hide(),e.on("shown.bs.modal",function(e){$(".current-date").html(w),$(".current-time").html(b);var t={minDate:0,maxDate:"+"+u+h,onSelect:function(e,a){o(0,a)}};a.datepicker(t)}),e.on("hidden.bs.modal",function(e){a.datepicker("destroy"),$(".ajax-reched-woowebinar-time-rage").html("")}),$(document).on("click",".resched-webinar",function(e){e.preventDefault();var a=$(this);u=a.data("schednum"),h=a.data("scheddate"),m=a.data("timefrom"),p=a.data("timefrommeridiem"),g=a.data("timeto"),f=a.data("timetomeridiem"),w=a.data("currentdate"),b=a.data("currenttime"),"month"==h&&(h="M"),"day"==h&&(h="D"),"year"==h&&(h="Y"),$(".resched-webinar-modal-lg").modal("show")}),$(document).on("click",_,function(e){e.preventDefault();var a=$(".resched-form").serialize();console.log(a),r(a).done(function(e){console.log(e)})}),$(document).on("click",".webinar_time",function(e){e.preventDefault();var a=$(this).data("time");$(".selected_time").val(a),_.show()})}}}();jQuery(document).ready(function(e){e("#coachingTabs").length>=1&&(Coaching.init(),Coaching.modal())});
function popup_alert(e,l){$("#alert-modal .modal-title").html(e),$("#alert-modal .modal-body p").html(l),$("#alert-modal").modal("show")}jQuery(document).ready(function(e){new Clipboard(".btn-copy");e("#order_review_heading").appendTo(".col-1"),e("#order_review").appendTo(".col-1"),e(".checkout-sidebar").appendTo(".col-2"),e(".woocommerce").addClass("checkout-holder"),e("#mobile").val("324234234324423").hide(),e(".woocommerce-additional-fields").hide(),e(".form-row").each(function(){e(this).addClass("form-group row")}),e(".form-row input, .form-row select").each(function(){e(this).addClass("form-control"),e(this).wrap('<span class="input-wrapper"></span>')}),e("#billing_first_name_field, #billing_last_name_field, #billing_email_field, #billing_phone_field, #account_username_field, #account_password_field, #billing_address_1_field, #billing_city_field, #billing_state_field, #billing_postcode_field, #billing_country_field").each(function(){e(this).find("label").addClass("col-md-3 col-form-label"),e(this).find(".input-wrapper").addClass("col-md-9")});var l=["#billing_first_name_field","#billing_last_name_field","#billing_email_field","#billing_phone_field","#account_username_field","#account_password_field"],o=["#billing_address_1_field","#billing_city_field","#billing_state_field","#billing_postcode_field","#billing_country_field"];for(e(".woocommerce-billing-fields__field-wrapper").append('<div id="checkout-panel-1" class="panel panel-default"><div class="panel-heading">STEP 1: ENTER ACCOUNT DETAILS</div><div class="panel-body"></div></div>'),i=0;i<l.length;i++)if(e(l[i]).length){n=e(l[i]).html();e(l[i]).remove(),e("#checkout-panel-1 .panel-body").append('<div class="form-group row" id="'+l[i]+'">'+n+"</div>")}for(e(".woocommerce-billing-fields__field-wrapper").append('<div id="checkout-panel-2" class="panel panel-default"><div class="panel-heading">STEP 2: ENTER BILLING ADDRESS</div><div class="panel-body"></div></div>'),i=0;i<o.length;i++){var n=e(o[i]).html();e(o[i]).remove(),e("#checkout-panel-2 .panel-body").append('<div class="form-group row" id="'+o[i]+'">'+n+"</div>")}e("#checkout-panel-3").each(function(){e(".woocommerce-checkout-review-order-table").clone().insertAfter("#checkout-panel-3 h5")})}),$(document).on("click",".xs-toggle-nav",function(e){$(this).toggleClass("open"),$("body").toggleClass("xs-nav-open"),e.preventDefault()}),$(document).on("click",".fx-board-list.w-toggle li",function(){var e=$(".fx-board-list.w-toggle li");e.removeClass("open").find(".content").slideUp("fast"),e.find(".icon").removeClass("fa-angle-up").addClass("fa-angle-down"),$(this).addClass("open"),$(this).find(".icon").toggleClass("fa-angle-up fa-angle-down"),$(this).find(".content").slideToggle("fast")}),$(document).on("click",".scroll-to",function(e){if(e.preventDefault(),""!==this.hash)var l=this.hash;$("html, body").animate({scrollTop:$(l).offset().top-30},600)}),$(document).on("click",'input[name="f2-survey"]',function(){$(".f2-group-options").fadeOut("normal",function(){$(".f2-group-form").fadeIn()})}),$(document).on("click",".funnel-accordion .funnel-title",function(){$(this).find(".help-caption").text(function(e,l){return"(Click To Close)"==l?"(Click To Expand)":"(Click To Close)"})}),$(document).on("click",".skip-referral",function(e){e.preventDefault();var l=fx.ajax_url;$.post(l,{action:"skip_referral"}).done(function(e){e.success&&(window.location.href=$(".skip-referral").attr("href"))})});
function search(){$("#emailSearchForm").submit()}jQuery(function(e){function i(){var i=[];return e(".email-select:checked").each(function(){i.push(e(this).data("id"))}),i}function n(){var i=!1;return e("#compose").find("select, input, textarea").each(function(){e(this).is(":visible")&&(i=i||!e(this).val())}),isSms||(i=i||!tinymce.get("body").getContent()),i}var t=fx.ajax_url;if(e(".email-select").change(function(){var i=0==e(".email-select:not(:checked)").length;e("#selectAll").prop("checked",i)}),e("#selectAll").change(function(){e(this).prop("checked")?e(".email-select").prop("checked",!0):e(".email-select").prop("checked",!1)}),e("[data-email-action=mark-read]").click(function(){var n=i();0!=n.length&&e.post(t,{action:"email_read",ids:n.join(",")},function(){e(".email-select:checked").prop("checked",!1),n.forEach(function(i){e("[data-id="+i+"]").parent().parent().removeClass("unread")})})}),e("[data-email-action=delete]").click(function(){var n=i();0!=n.length&&e.post(t,{action:"email_delete",ids:n.join(",")},function(){n.forEach(function(i){e("[data-id="+i+"]").parent().parent().remove()})})}),e("#emailContentArea a").click(function(i){e(this).attr("href",window.location.href+"&redirect="+encodeURIComponent(e(this).attr("href")))}),e("#compose").length){e("#recipient_product").select2({dropdownParent:e("#compose")}),e("#recipient_individual_user").select2({dropdownParent:e("#compose")}),e("#recipient_individual_type").change(function(){switch(e(this).val()){case"email":case"sms":e("#recipient_individual_name").parents(".form-group").show(),e("#recipient_individual_email").parents(".form-group").show(),e("#recipient_individual_user").parents(".form-group").hide();break;case"user":e("#recipient_individual_name").parents(".form-group").hide(),e("#recipient_individual_email").parents(".form-group").hide(),e("#recipient_individual_user").parents(".form-group").show()}}).change(),e("#email_recipient_type").change(function(){var i={all:[],group:["recipient_group"],product:["recipient_product"],individual:["recipient_individual_type","recipient_individual_name","recipient_individual_email","recipient_individual_user"]};for(var n in i)i[n].forEach(function(i){e("#"+i).parents(".form-group").hide()});i[e(this).val()].forEach(function(i){e("#"+i).parents(".form-group").show()}),"individual"==e(this).val()&&e("#recipient_individual_type").change()}).change(),isSms||tinymce.init({selector:"#body",menubar:!1,statusbar:!1,plugins:"link",setup:function(e){e.on("change",function(){e.save()})}});var a=!1;setInterval(function(){a||n()?e("#compose").find("button").prop("disabled",!0):e("#compose").find("button").prop("disabled",!1)},500),e("#compose").find("button").click(function(){n()||(a=!0,e("#compose").find("input, select, textarea").prop("disabled",!0),isSms||tinymce.get("body").setMode("readonly"),e.post(t,{action:isSms?"send_sms":"send_email",email_recipient_type:e("#email_recipient_type").val(),sms_recipient_type:e("#email_recipient_type").val(),recipient_group:e("#recipient_group").val(),recipient_product:e("#recipient_product").val(),recipient_individual_type:e("#recipient_individual_type").val(),recipient_individual_name:e("#recipient_individual_name").val(),recipient_individual_email:e("#recipient_individual_email").val(),recipient_individual_sms:e("#recipient_individual_email").val(),recipient_individual_user:e("#recipient_individual_user").val(),subject:e("#subject").val(),body:e("#body").val()},function(i){"OK"!=i.trim()?alert("Error: "+i):isSms?(alert("SMS sent."),window.location.href="/my-account/sent-sms"):(alert("Email sent."),window.location.href="/my-account/sent"),a=!1,e("#compose").find("input, select, textarea").prop("disabled",!1),tinymce.get("body").setMode("design")}))})}});
$(document).on(".fx-course-navigation ul li a, .fx-table-lessons a",function(){var s=$(this).data("previous-lesson-id"),e=$(this).attr("href");if(s>1)return $.ajax({url:fx.ajax_url,type:"post",data:{action:"lms_lesson_complete",lesson_id:s},success:function(s){"1"==s?window.location=e:popup_alert("Course Lesson","Please finish the previous lesson first.")}}),!1});
var Modal=function(){function a(a){try{JSON.parse(a)}catch(a){return!1}return!0}function e(){return $.ajax({method:"GET",url:r.ajax_url,data:{action:"get_webinars"}})}function n(a){return $.ajax({method:"POST",url:r.ajax_url,data:{action:"register_webinars",post_data:a}})}var r=fx;return{init:function(){$(".webinar-modal-lg").on("shown.bs.modal",function(n){$(".ajax-webinars").html("<p>Getting Webinars, please wait...</p>"),$(".webinar-register-now").hide(),e().done(function(e){a(e)?"no-webinar"==(e=jQuery.parseJSON(e)).status&&$(".ajax-webinars").html("<p>"+e.msg+"</p>"):$(".ajax-webinars").html(e)})}),$(".webinar-modal-lg").on("hidden.bs.modal",function(a){$(".ajax-webinars").html("")}),$(".reserve-your-seat").click(function(a){a.preventDefault(),$(".webinar-modal-lg").modal("show")})},registerNow:function(){$(document).on("click",".webinar-register-now",function(e){e.preventDefault(),$(".ajax-webinar-lists").hide(),$(".ajax-webinars-msg").html("<p>Registering to webinar please wait</p>"),n($(".register-webinar").serialize()).done(function(e){$(".ajax-webinars-msg").html(""),a(e)&&("error"==(e=jQuery.parseJSON(e)).status?(console.log(e),$.each(e.msg,function(a,e){$(".ajax-webinars-msg").append("<p>"+e+"</p>")})):(console.log(e),$(".ajax-webinars-msg").html("<p>"+e.msg+"</p>"),$.each(e.webinar_ret,function(a,e){$("."+a+"-info").html(""),$("."+a+"-info").html("<p>"+e.msg+"</p>")}))),$(".ajax-webinar-lists").show()})})}}}(),ModalRegisterNow=void 0;jQuery(document).ready(function(a){Modal.init(),Modal.registerNow()});
$(document).ready(function(){function e(){n&&t?$('.fx-renewal button[type="submit"]').prop("readonly",!1).prop("disabled",!1):$('.fx-renewal button[type="submit"]').prop("readonly",!0).prop("disabled",!0)}function r(){var e=$("#pwd-verify"),r=$(".fx-renewal #pwd"),o=$("#pwd-icon-verify");""==e.val()?(input_class="has-feedback ",icon_class="",t=!1):r.val()==e.val()?(input_class="has-feedback has-success",icon_class="glyphicon-ok",t=!0):(input_class="has-feedback has-error",icon_class="glyphicon-remove",t=!1),e.parent(".has-feedback").removeClass(function(e,r){return(r.match(/(^|\s)has-\S+/g)||[]).join(" ")}).addClass(input_class),o.removeClass(function(e,r){return(r.match(/(^|\s)glyphicon-\S+/g)||[]).join(" ")}).addClass(icon_class)}var o=fx.ajax_url,s=$(".fx-renewal .overlay"),a=$(".fx-renewal .ajax-response"),n=!1,t=!1;$(".fx-renewal form").on("submit",function(e){e.preventDefault(),s.show();var r={action:"fx_renew_password",fx_action:"renew_password",new_password:$(".fx-renewal #pwd").val(),confirm_password:$("#pwd-verify").val()},n=$(".fx-renewal #redirect_to").val()?$(".fx-renewal #redirect_to").val():"/dashboard";return $.post(o,r,function(){s.hide()}).done(function(e){if(e.success){var r=3,o="<h2>Password successfully updated!</h2><p>You will be redirected in <strong>%s</strong> seconds.</p>";a.html(o.replace(/%s/g,r)).show();var s=setInterval(function(){1==r&&(o=o.replace(/seconds/g,"second")),a.html(o.replace(/%s/g,r)),0==r&&(clearInterval(s),window.open(n,"_self")),r--},1e3)}else a.html("<h2>Password update failed. Refresh this page and please try again.</h2>").show()}),!1}),$("#pwd-verify").on("keyup",function(){r(),e()});var c={};c.common={onLoad:function(){$(".password-verdict").text("Start typing password")},onScore:function(o,s,a){var t,c;return void 0===a||a<=o.ui.scores[3]||void 0!=o.instances.errors&&o.instances.errors.length>0?(t="glyphicon-remove",c="has-feedback has-error",n=!1):(t="glyphicon-ok",c="has-feedback has-success",n=!0),$(".fx-renewal #pwd").parent(".has-feedback").removeClass(function(e,r){return(r.match(/(^|\s)has-\S+/g)||[]).join(" ")}).addClass(c),$("#pwd-icon").removeClass(function(e,r){return(r.match(/(^|\s)glyphicon-\S+/g)||[]).join(" ")}).addClass(t),r(),e(),a},maxChar:50},c.ui={showVerdicts:!1,showProgressBar:!1,showErrors:!0,showPopover:!0,popoverError:function(e){var r="<div><strong>Oops!</strong><ul class='error-list' style='margin-bottom: 0;'>";return jQuery.each(e.instances.errors,function(e,o){r+="<li>"+o+"</li>"}),r+="</ul></div>"},popoverPlacement:"top"},c.rules={activated:{wordNotEmail:!0,wordMinLength:!0,wordMaxLength:!1,wordInvalidChar:!1,wordSimilarToUsername:!0,wordSequences:!0,wordTwoCharacterClasses:!1,wordRepetitions:!1,wordLowercase:!1,wordUppercase:!1,wordOneNumber:!1,wordThreeNumbers:!1,wordOneSpecialChar:!1,wordTwoSpecialChar:!1,wordUpperLowerCombo:!1,wordLetterNumberCombo:!1,wordLetterNumberCharCombo:!1}},void 0!=jQuery.fn.pwstrength&&$(".fx-renewal #pwd").pwstrength(c)});
!function(e,r,i){e(r).ready(function(){function r(e,r){return-1!==e.indexOf("?")?e+(-1!==e.indexOf(r)?"":"&"+r):e+(-1!==e.indexOf(r)?"":"?"+r)}$youtube="youtube.com",$vimeo="vimeo.com",$auto_start=e('*[data-ptoautostart*="yes"]'),$disable_controls=e('*[data-ptodisablecontrols*="yes"]'),$disable_related=e('*[data-ptodisablerelated*="yes"]'),$hide_info=e('*[data-ptohideinfo*="yes"]'),$disable_sharing=e('*[data-ptodisablesharing*="yes"]');var i={autoplay:"autoplay=1",disablecontrols:"controls=0",disablerelvideos:"rel=0",hideinfo:"showinfo=0",disablesharing:null},s={autoplay:"autoplay=1",disablecontrols:null,disablerelvideos:null,hideinfo:"title=0&byline=0&portrait=0",disablesharing:function(){e(".fx-video-container iframe").contents().find(".sidedock").hide()}};e(".fx-video-container iframe").is(":visible")&&($auto_start.length>0&&$auto_start.each(function(){if($iframe=e(this).find("iframe"),$src=$iframe.attr("src"),-1!==$src.indexOf($youtube))$new_src=$src.replace($src,r($src,i.autoplay)),$iframe.attr("src",$new_src);else{if(-1===$src.indexOf($vimeo))return;$new_src=$src.replace($src,r($src,s.autoplay)),$iframe.attr("src",$new_src)}}),$disable_controls.length>0&&$disable_controls.each(function(){$iframe=e(this).find("iframe"),$src=$iframe.attr("src"),-1!==$src.indexOf($youtube)&&($new_src=$src.replace($src,r($src,i.disablecontrols)),$iframe.attr("src",$new_src))}),$disable_related.length>0&&$disable_related.each(function(){if($iframe=e(this).find("iframe"),$src=$iframe.attr("src"),-1!==$src.indexOf($youtube))$new_src=$src.replace($src,r($src,i.disablerelvideos)),$iframe.attr("src",$new_src);else if(-1===$src.indexOf($vimeo))return}),$hide_info.length>0&&$hide_info.each(function(){if($iframe=e(this).find("iframe"),$src=$iframe.attr("src"),-1!==$src.indexOf($youtube))$new_src=$src.replace($src,r($src,i.hideinfo)),$iframe.attr("src",$new_src);else{if(-1===$src.indexOf($vimeo))return;$new_src=$src.replace($src,r($src,s.hideinfo)),$iframe.attr("src",$new_src)}}),$disable_sharing.length>0&&$disable_sharing.each(function(){if($iframe=e(this).find("iframe"),$src=$iframe.attr("src"),-1!==$src.indexOf($youtube));else{if(-1===$src.indexOf($vimeo))return;s.disablesharing()}}))})}(jQuery,document,window);
jQuery(document).ready(function(n){n(".fx-sendgrid").submit(function(i){return n.ajax({url:fx.ajax_url,type:"post",data:{action:"fx_sendgrid_capture_email",email:n(".fx-sendgrid").find('input[name="email"]').val(),funnel_id:n(".fx-sendgrid").find('input[name="funnel_id"]').val(),affiliate_user_id:n(".fx-sendgrid").find('input[name="affiliate_user_id"]').val(),name:n(".fx-sendgrid").find('input[name="name"]').val(),contact:n(".fx-sendgrid").find('input[name="contact"]').val()},success:function(i){if("OK"==(i=JSON.parse(i)).status){var e=n(".fx-sendgrid").find('input[name="redirect_to"]').val();window.location.href=e}else alert("Sending email information failed.")}}),!1})});
jQuery(document).ready(function(t){t(".btn-pause").on("click",function(){return t.ajax({url:fx.ajax_url,type:"post",data:{action:"fx_customer_pause_account",subscription_id:t(this).data("subscription-id")},success:function(t){"success"==t.status?window.location=fx.logout_url:alert("Pause subscription fail. Please contact support.")}}),!1})});
jQuery(document).ready(function(o){var t=o(window),e=o("#pto--floating-video");if(e.length>0){var i=o("#pto--floating-video iframe"),f=e.offset().top,n=Math.floor(f+e.outerHeight()/2);t.on("resize",function(){f=e.offset().top,n=Math.floor(f+e.outerHeight()/2)}).on("scroll",function(){i.toggleClass("is-sticky",t.scrollTop()>n)})}});
!function(t,o,e){var n=function(t){this.init(t)};n.prototype.init=function(o){this.data=[],o.each(t.proxy(function(o,e){var n=t(e),i=new playerjs.Player(e);i.on("ready",function(){i.unmute(),this.add(n,i)},this)},this)),this.listen()},n.prototype.add=function(t,o){var e=t.offset().top,n=e+t.height();this.data.push({top:e,bottom:n,$elem:t,player:o})},n.prototype.scrolled=function(){var o=t(e),n=o.scrollTop(),i=n+o.height();t.each(t.map(this.data,function(t,o){var e=0;if(t.top<=i&&t.bottom>=n){var r=t.bottom-t.top;e=t.bottom>i?(i-t.top)/r:t.top<n?(t.bottom-n)/r:1}return{p:e,t:t.top,player:t.player}}).sort(function(t,o){return t.p>o.p?-1:t.p<o.p?1:t.t<o.t?-1:t.t>o.t?1:0}),function(t,o){0===t&&o.p>.25?o.player.play():o.player.pause()})},n.prototype.resized=function(){t.each(this.data,function(t,o){o.top=o.$elem.offset().top,o.bottom=o.top+o.$elem.height()}),this.scrolled()},n.prototype.listen=function(o,n){var i=t(e);i.on("scroll",t.proxy(function(){if(0===this.data.length)return!1;this.scrolled()},this)),i.on("resize",t.proxy(function(){if(0===this.data.length)return!1;this.resized()},this))},t(o).ready(function(){var o=[];o=t('*[data-ptoaction*="pto--scrolling-video"]').data("ptourl"),t('*[data-ptoaction*="pto--scrolling-video"]').length>0&&t.embedly.oembed(o).progress(function(o){if(!o.html)return!1;var e=t('<div class="tailor-responsive-embed"></div>');e.append(o.html),t(".fx-video-container").append(e)}).done(function(){new n(t("iframe"))})}),t.embedly.defaults.key="3ee528c9eb4b4908b268ce1ace120c92"}(jQuery,document,window);
var PublicGotoWebinar=function(){function e(e,t){$(".selected_date").val(t.selectedDay);var a=t.selectedMonth+1;$(".selected_month").val(a),$(".selected_year").val(t.selectedYear),$(".ajax-woowebinar-time-rage").html("<p> Getting time, please wait...</p>"),o(t).done(function(e){$(".ajax-woowebinar-time-rage").html(e)})}function o(e){var o="",a="",n="",i="",r="",_="";return woo_webinar.hasOwnProperty("_woogotowebinar_range_time_from")&&(o=woo_webinar._woogotowebinar_range_time_from),woo_webinar.hasOwnProperty("_woogotowebinar_range_time_from_meridiem")&&(a=woo_webinar._woogotowebinar_range_time_from_meridiem),n=o+":00 "+a.toUpperCase(),woo_webinar.hasOwnProperty("_woogotowebinar_range_time_to")&&(i=woo_webinar._woogotowebinar_range_time_to),woo_webinar.hasOwnProperty("_woogotowebinar_range_time_to_meridiem")&&(r=woo_webinar._woogotowebinar_range_time_to_meridiem),_=i+":00 "+r.toUpperCase(),$.ajax({method:"GET",url:t.ajax_url,data:{action:"get_timerange_woowebinar",selectedDate:e.selectedDay,selectedMonth:e.selectedMonth,selectedYear:e.selectedYear,range_time_from:n,range_time_to:_}})}var t=fx;return{init:function(){},time_click:function(){$(document).on("click",".webinar_time",function(e){e.preventDefault();var o=$(this).data("time");$(".selected_time").val(o),$(".webinar_single_add_to_cart_button").removeAttr("disabled"),console.log(o)})},date_picker:function(){var o="",t="";woo_webinar.hasOwnProperty("_woogotowebinar_scheduling_window_num")&&(o="+"+woo_webinar._woogotowebinar_scheduling_window_num),woo_webinar.hasOwnProperty("_woogotowebinar_scheduling_window_date")&&("month"==woo_webinar._woogotowebinar_scheduling_window_date&&(t="M"),"day"==woo_webinar._woogotowebinar_scheduling_window_date&&(t="D"),"year"==woo_webinar._woogotowebinar_scheduling_window_date&&(t="Y"));var a={minDate:0,maxDate:o+t,onSelect:function(o,t){e(0,t)}};$("#product-datepicker").datepicker(a)}}}();jQuery(document).ready(function(e){e(".webinar_single_add_to_cart_button").attr("disabled","disabled"),PublicGotoWebinar.date_picker(),PublicGotoWebinar.time_click()});
//# sourceMappingURL=theme.js.map
