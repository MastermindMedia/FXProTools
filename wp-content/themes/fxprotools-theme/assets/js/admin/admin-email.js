/* global jQuery */
jQuery(function($) {
    // Remove the drafting functions.
    //$(".misc-pub-section.misc-pub-post-status, #minor-publishing-actions, .misc-pub-section.curtime.misc-pub-curtime, .misc-pub-section.misc-pub-visibility").remove();
    $(".hndle span").first().text("Send");
    
    // Change the "Title" label to "Subject".
    $("label[for=title]").text("Enter subject here");
    
    if ($("#post-status-display").text() == "Published") {
        $("#wpbody-content input, #wpbody-content select, #wpbody-content button").prop("disabled", true);
        
        var wait = function () {
            if (!$("#email_content_ifr").contents().find("body").css("background-color", "rgb(230, 230, 230)").find("[contenteditable]").removeAttr("contenteditable").length) {
                setTimeout(wait, 100);
            } else {
                $("#email_content_ifr").contents().find("button, select").prop("disabled", true);
            }
        }
        
        setTimeout(wait, 100);
    }
});