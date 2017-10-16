/* global jQuery */
jQuery(function($) {
    // Remove the drafting functions.
    //$(".misc-pub-section.misc-pub-post-status, #minor-publishing-actions, .misc-pub-section.curtime.misc-pub-curtime, .misc-pub-section.misc-pub-visibility").remove();
    $(".hndle span").first().text("Send");
    
    // Change the "Title" label to "Subject".
    $("label[for=title]").text("Enter subject here");
});