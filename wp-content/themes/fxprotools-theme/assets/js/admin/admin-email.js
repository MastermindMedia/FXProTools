/* global jQuery */
jQuery(function($) {
    // Remove the drafting functions.
    //$(".misc-pub-section.misc-pub-post-status, #minor-publishing-actions, .misc-pub-section.curtime.misc-pub-curtime, .misc-pub-section.misc-pub-visibility").remove();
    $(".hndle span").first().text("Send");
    
    // Change the "Title" label to "Subject".
    $("label[for=title]").text("Enter subject here");
    
    if ($("#post-status-display").text() == "Published") {
        $("#wpbody-content input, #wpbody-content select, #wpbody-content button").prop("disabled", true);
        var elem = $("<div />").css("background-color", "rgba(0, 0, 0, 0.25)").css("z-index", "1000").appendTo("body");
        
        setInterval(function() {
            elem.offset($("#wp-email_content-wrap").offset()).width($("#wp-email_content-wrap").width()).height($("#wp-email_content-wrap").height());
        }, 100);
    }
});