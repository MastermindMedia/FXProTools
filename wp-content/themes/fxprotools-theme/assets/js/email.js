jQuery(function ($) {
   var ajaxUrl = fx.ajax_url;
   var mailContainer = $("#mailContainer");
   
   $.post(ajaxUrl, {
       action: "email_inbox_count"
   }, function (response) {
       $("#unreadCount").text(response);
       
       $.post(ajaxUrl, {
           action: "email_" + EMAIL_TYPE
       }, function (response) {
           mailContainer.empty();
           
           if (response.length == 0) {
               mailContainer.append("<tr><td colspan=\"3\">No emails found.</td></td>");
           }
           
           response.forEach(function (mail) {
                var m = mail;
                var contentRow;
                var content;
                
                var openMail = function(e) {
                    if (contentRow.prev().hasClass("unread")) {
                        contentRow.prev().removeClass("unread").addClass("read");
                        
                        $.post(ajaxUrl, {
                            action: "email_read",
                            id: m.id
                        }, function (response) {
                            $("#unreadCount").text(parseInt($("#unreadCount").text()) - 1);
                        });
                    }
                    
                    contentRow.children().slideToggle();
                    e.stopPropagation();
                    e.preventDefault();
                }
                
                mailContainer.append(
                    $("<tr />")
                        .addClass(mail.status)
                        .append(
                            $("<td />").append($("<input />").attr("type", "checkbox")).addClass("text-center")
                        )
                        .append(
                            $("<td />").append($("<a />").text(mail.subject).attr("href", "#").click(openMail))
                        )
                        .append(
                            $("<td />").append(moment(mail.modified).fromNow()).addClass("text-center")
                        )
                    );
                
                mailContainer.append(
                    contentRow = $("<tr />")
                        .append(
                            content = $("<td />").attr("colspan", 3).html(mail.content).hide()
                        )
                );
                
                if (EMAIL_TYPE == "inbox")
                {
                    content.append($("<a href=\"#\" class=\"btn btn-danger pull-right\">Delete</a>").click(function (e) {
                        $(this).text("Deleting...").attr("disabled", "disabled");
                        
                        $.post(ajaxUrl, {
                            action: "email_delete",
                            id: m.id
                        }, function (response) {
                            $.merge(contentRow, contentRow.prev()).fadeOut();
                        });
                    }));
                }
           });
       });
       
   });
});