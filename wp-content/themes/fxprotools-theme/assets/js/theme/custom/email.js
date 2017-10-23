jQuery(function ($) {
    if (typeof(EMAIL_TYPE) == 'undefined') {
        return;
    }
    
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
    
    if ($("#modalCompose").length) {
        for (var id in ALL_PRODUCTS) {
            $("#recipient_product").append($("<option />").attr("value", id).text(ALL_PRODUCTS[id]));
        }
        
        $("#recipient_product").select2({
			dropdownParent: $("#modalCompose")
		});
        
        for (var id in ALL_USERS) {
            $("#recipient_individual_user").append($("<option />").attr("value", id).text(ALL_USERS[id]));
        }
        
        $("#recipient_individual_user").select2({
			dropdownParent: $("#modalCompose")
		});
		
		$("#recipient_individual_type").change(function() {
		    switch ($(this).val()) {
		        case "email":
		            $("#recipient_individual_name").parents(".form-group").show();
		            $("#recipient_individual_email").parents(".form-group").show();
		            $("#recipient_individual_user").parents(".form-group").hide();
		            break;
		        case "user":
		            $("#recipient_individual_name").parents(".form-group").hide();
		            $("#recipient_individual_email").parents(".form-group").hide();
		            $("#recipient_individual_user").parents(".form-group").show();
		            break;
		    }
		}).change();
		
		$("#email_recipient_type").change(function() {
		    var recipientTypes = {
		        "all": [],
		        "group": ["recipient_group"],
		        "product": ["recipient_product"],
		        "individual": ["recipient_individual_type", "recipient_individual_name", "recipient_individual_email", "recipient_individual_user"]
	        };
	        
	        for (var type in recipientTypes) {
	            recipientTypes[type].forEach(function (field) {
	                $("#" + field).parents(".form-group").hide();
	            });
	        }
	        
            recipientTypes[$(this).val()].forEach(function (field) {
                $("#" + field).parents(".form-group").show();
            });
            
            if ($(this).val() == "individual") {
                $("#recipient_individual_type").change();
            }
		}).change();
		
		tinymce.init({ selector:'#body', menubar: false, statusbar: false,
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            }
        });
        
        var submitting = false;
        
        function checkForErrors() {
        	var hasError = false;
        	
        	$("#modalCompose").find("select, input, textarea").each(function() {
        		if ($(this).is(":visible")) {
    			    hasError = hasError || !$(this).val();
        		}
        	});
        	
        	hasError = hasError || !tinymce.get("body").getContent();
        	return hasError;
        }
        
        setInterval(function() {
            if (submitting || checkForErrors()) {
                $("#modalCompose").find("button").prop("disabled", true);
            } else {
                $("#modalCompose").find("button").prop("disabled", false);
            }
        }, 500);
        
        $("#modalCompose").find("button").click(function() {
            if (!checkForErrors()) {
                submitting = true;
                
                $("#modalCompose").find("input, select").prop("disabled", true);
                tinymce.get("body").setMode('readonly');
                
                $.post(ajaxUrl, {
                    action: "send_email",
                    email_recipient_type: $("#email_recipient_type").val(),
                    recipient_group: $("#recipient_group").val(),
                    recipient_product: $("#recipient_product").val(),
                    recipient_individual_type: $("#recipient_individual_type").val(),
                    recipient_individual_name: $("#recipient_individual_name").val(),
                    recipient_individual_email: $("#recipient_individual_email").val(),
                    recipient_individual_user: $("#recipient_individual_user").val(),
                    subject: $("#subject").val(),
                    body: $("#body").val(),
                }, function (response) {
                    if (response != "OK") {
                        alert("Error: " + response);
                    } else {
                        alert("Email sent.");
                        window.location.reload();
                    }
                    
                    submitting = false;
                    $("#modalCompose").find("input, select").prop("disabled", false);
                    tinymce.get("body").setMode('design');
                });
            }
        });
    }
});