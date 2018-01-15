/*========================================================================
| sUS (simpleUserSystem) - A simple user system developed in OOP PHP
| This system also uses the full Bootstrap and jQuery libraries
| ########################################################################
| Copyright (C) 2012, Mark Eriksson
| http://www.mark-eriksson.com
| ########################################################################
| This program is free software: you can redistribute it and/or modify
| it under the terms of the GNU General Public License as published by
| the Free Software Foundation, either version 3 of the License, or
| (at your option) any later version.
| ########################################################################
| This program is distributed in the hope that it will be useful,
| but WITHOUT ANY WARRANTY; without even the implied warranty of
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
| GNU General Public License for more details.
\=======================================================================*/

var susurl = "sUS_JSURL"; //sUS_JSURL
var ajaxerror = "An error occurred with the jQuery AJAX call request. Please try again soon.";

$(function(){
	$("form#sUS_LoginForm").submit(function(){
		$.ajax({
			type: "POST",
			url: susurl+"/inc/login.php",
			data: $(this).serialize(),
			success: function(r){
				if (r == "success")
				{
					window.location.reload(true);
				}
				else
				{
					DDA(r);
				}
			},
			error: function(){
				DDA(ajaxerror);
			}
		});
		
		return false;
	});
	
	$("form#sUS_RegisterForm").submit(function(){
		$.ajax({
			type: "POST",
			url: susurl+"/inc/register.php",
			data: $(this).serialize(),
			success: function(r){
				if (r == "success")
				{
					$("form#sUS_RegisterForm").fadeOut("slow", function(){
						$("div.span9").append("<div class=\"alert alert-success\"><strong>Yay!</strong> You have successfully registered! You can now log in using the form on the left hand side.</div>");
						$("input#sUS_LoginFormUsername").focus();
					});
				}
				else
				{
					DDA(r);
				}
			},
			error: function(){
				DDA(ajaxerror);
			}
		});
		
		return false;
	});
	
	$("form#sUS_ResetForm").submit(function(){
		$.ajax({
			type: "POST",
			url: susurl+"/inc/reset.php",
			data: $(this).serialize(),
			success: function(r){
				if (r == "success")
				{
					$("form#sUS_ResetForm").fadeOut("slow", function(){
						$("p#sUS_ForgotText1").hide();
						$("div.span9").append("<div class=\"alert alert-success\"><strong>Success!</strong> We have just sent you a confirmation link to the email address you provided, follow that link to change your password.</div>");
					});
				}
				else
				{
					DDA(r);
				}
			},
			error: function(){
				DDA(ajaxerror);
			}
		});
		
		return false;
	});
	
	$("form#sUS_ResetKeyForm").submit(function(){
		$.ajax({
			type: "POST",
			url: susurl+"/inc/reset_submit.php",
			data: $(this).serialize(),
			success: function(r){
				if (r == "success")
				{
					$("form#sUS_ResetKeyForm").fadeOut("slow", function(){
						$("p#sUS_ForgotKeyText1").hide();
						$("div.span9").append("<div class=\"alert alert-success\"><strong>Success!</strong> Your password has been successfully reset! You can now login on the left hand side.</div>");
						$("input#sUS_LoginFormUsername").focus();
					});
				}
				else
				{
					DDA(r);
				}
			},
			error: function(){
				DDA(ajaxerror);
			}
		});
		
		return false;
	});
	
	$("form#sUS_EditPasswordForm").submit(function(){
		$.ajax({
			type: "POST",
			url: susurl+"/inc/edit_password.php",
			data: $(this).serialize(),
			success: function(r){
				if (r == "success")
				{
					$("form#sUS_EditPasswordForm").fadeOut("slow", function(){
						$("p#sUS_EditPasswordText1").hide();
						$("div.span9").append("<div class=\"alert alert-success\"><strong>Success!</strong> Your password has been successfully changed! You may however be asked to login again.</div>");
					});
				}
				else
				{
					DDA(r);
				}
			},
			error: function(){
				DDA(ajaxerror);
			}
		});
		
		return false;
	});
	
	$("form#sUS_EditEmailForm").submit(function(){
		$.ajax({
			type: "POST",
			url: susurl+"/inc/edit_email.php",
			data: $(this).serialize(),
			success: function(r){
				if (r == "success")
				{
					$("form#sUS_EditEmailForm").fadeOut("slow", function(){
						$("p#sUS_EditEmailText1").hide();
						$("div.span9").append("<div class=\"alert alert-success\"><strong>Success!</strong> Your email address has been successfully changed!</iv>");
					});
				}
				else
				{
					DDA(r);
				}
			},
			error: function(){
				DDA(ajaxerror);
			}
		});
		
		return false;
	});
	
	$("form#sUS_EditProfileForm").submit(function(){
		$.ajax({
			type: "POST",
			url: susurl+"/inc/edit_profile.php",
			data: $(this).serialize(),
			success: function(r){
				if (r == "success")
				{
					$("form#sUS_EditProfileForm").fadeOut("slow", function(){
						$("p#sUS_EditProfileText1").hide();
						$("div.span9").append("<div class=\"alert alert-success\"><strong>Success!</strong> Your profile details have been successfully updated!</iv>");
					});
				}
				else
				{
					DDA(r);
				}
			},
			error: function(){
				DDA(ajaxerror);
			}
		});
		
		return false;
	});
	
	$("form#sUS_WallPostForm").submit(function(){
		$.ajax({
			type: "POST",
			url: susurl+"/inc/wall_post.php",
			data: $(this).serialize(),
			success: function(r){
				if (r.indexOf("success") != -1)
				{
					$("div#sUS_WallPostDialog").modal('hide');
					$("div#wall").load(susurl+"/inc/wall_posts.php?UserID=" + (r.replace("success_", "")));
					ResetForm($("#sUS_WallPostForm"));
				}
				else
				{
					DDA(r);
				}
			},
			error: function(){
				DDA(ajaxerror);
			}
		});
		
		return false;
	});
	
	$("form#sUS_ContactForm").submit(function(){
		$.ajax({
			type: "POST",
			url: susurl+"/inc/contact.php",
			data: $(this).serialize(),
			success: function(r){
				if (r == "success")
				{
					$("form#sUS_ContactForm").fadeOut("slow", function(){
						$("div.span9").append("<div class=\"alert alert-success\"><strong>Success!</strong> Thanks for contacting us! We will try to respond within 48 hours.</div>");
						$("p#sUS_ContactText1").hide();
					});
				}
				else
				{
					DDA(r);
				}
			},
			error: function(){
				DDA(ajaxerror);
			}
		});
		
		return false;
	});
	
	$("form#sUS_MessagesNewForm").submit(function(){
		$.ajax({
			type: "POST",
			url: susurl+"/inc/newmessage.php",
			data: $(this).serialize(),
			success: function(r){
				if (r == "success")
				{
					$("div#sUS_MessagesNewDialog").modal('hide');
					$("div#sUS_MessageThreadsList").load(susurl+"/inc/messages_list.php");
					ResetForm($("#sUS_MessagesNewForm"));
				}
				else
				{
					DDA(r);
				}
			},
			error: function(){
				DDA(ajaxerror);
			}
		});
		
		return false;
	});
	
	$("form#sUS_InstallerForm").submit(function(){
		$.ajax({
			type: "POST",
			url: susurl+"/installer/install.php",
			data: $(this).serialize(),
			success: function(r){
				if (r == "success")
				{
					DDA("sUS V1 has been successfully installed! Please delete the \"installer/\" folder then you may use sUS!");
				}
				else
				{
					DDA(r);
				}
			},
			error: function(){
				DDA(ajaxerror);
			}
		});
		
		return false;
	});
	
	$("form#sUS_AdminSiteSettingsForm").submit(function(){
		$.ajax({
			type: "POST",
			url: susurl+"/admin/inc/sitesettings.php",
			data: $(this).serialize(),
			success: function(r){
				DDA(r);
			},
			error: function(){
				DDA(ajaxerror);
			}
		});
		
		return false;
	});
	
	$("form#sUS_AdminMySQLForm").submit(function(){
		$.ajax({
			type: "POST",
			url: susurl+"/admin/inc/mysql.php",
			data: $(this).serialize(),
			success: function(r){
				DDA(r);
			},
			error: function(){
				DDA(ajaxerror);
			}
		});
		
		return false;
	});
	
	$("form#sUS_AdminAddUserForm").submit(function(){
		$.ajax({
			type: "POST",
			url: susurl+"/admin/inc/adduser.php",
			data: $(this).serialize(),
			success: function(r){
				DDA(r);
			},
			error: function(){
				DDA(ajaxerror);
			}
		});
		
		return false;
	});
	
	$("form#sUS_AdminEditUserForm").submit(function(){
		$.ajax({
			type: "POST",
			url: susurl+"/admin/inc/edituser.php",
			data: $(this).serialize(),
			success: function(r){
				DDA(r);
			},
			error: function(){
				DDA(ajaxerror);
			}
		});
		
		return false;
	});
	
	$("form#sUS_AdminAlertUserForm").submit(function(){
		$.ajax({
			type: "POST",
			url: susurl+"/admin/inc/alertuser.php",
			data: $(this).serialize(),
			success: function(r){
				if (r == "success")
				{
					$("form#sUS_AdminAlertUserForm").fadeOut("slow", function(){
						$("p#sUS_AlertUserText1").hide();
						$("div.span9").append("<div class=\"alert alert-success\"><strong>Success!</strong> Your alert has been successfully sent!</div>");
						ResetForm($(this));
					});
				}
				else
				{
					DDA(r);
				}
			},
			error: function(){
				DDA(ajaxerror);
			}
		});
		
		return false;
	});
	
	$("button#sUS_AdminAlertUserPreview").click(function(){
		$("h3#sUS_AlertUserPreviewH3").html($("input#sUS_AdminAlertUserTitle").val());
		$("p#sUS_AlertUserPreviewP").html($("textarea#sUS_AdminAlertUserMessage").val().replace(/\n\r?/g, '<br />') + "<br /><br />From " + $("button#sUS_AdminAlertUserPreview").attr("data-fromuser"));
		$("div#sUS_AlertUserPreviewDialog").modal('show');
	});
	
	$("button#sUS_ContactFormsMarkRead").click(function(){
		$.ajax({
			type: "POST",
			url: susurl+"/admin/inc/contact_mark_dealt_with.php",
			data: "ContactID=" + $("input#sUS_ContactFormsID").val(),
			success: function(r){
				if (r == "success")
				{
					window.location = susurl+"/admin/contactforms.php";
				}
				else
				{
					DDA(r);
				}
			},
			error: function(){
				DDA(ajaxerror);
			}
		});
	});
	
	$("button#sUS_ContactFormsDelete").click(function(){
		if (confirm("Are you sure that you want to delete this contact submission?")) {
			$.ajax({
				type: "POST",
				url: susurl+"/admin/inc/contact_delete.php",
				data: "ContactID=" + $("input#sUS_ContactFormsID").val(),
				success: function(r){
					if (r == "success")
					{
						window.location = susurl+"/admin/contactforms.php";
					}
					else
					{
						DDA(r);
					}
				},
				error: function(){
					DDA(ajaxerror);
				}
			});
		}
	});
	
	$("a#sUS_BigLoginButton").click(function(){
		$("input#sUS_LoginFormUsername").focus();
	});
	
	$("a#sUS_PoweredByTip").tooltip({'placement': 'left'});
	
	$("div#drop_down_bar").click(function(){
		$(this).hide();
	});
	
	$("input[type='text'], input[type='password'], input[type='email'], input[type='url'], input[type='tel']").each(function(i,a){
		$(a).attr("autocomplete", "off");
	});
});
	
function LogOut(name) {
	if (confirm("Are you sure you want to log out now, "+name+"?")) {
		window.location = susurl + "/logout.php";
	}
}

function DDA(w) {
	$("div#drop_down_bar").text(w).slideDown(350, function(){
		$(this).effect("bounce", { times: 3 }, 650, function(){
			$(this).delay(4000).slideUp("slow");
		});
	});
}

function ResetForm($form) {
	$form.find('input:text, input:password, input:file, select, textarea').val('');
	$form.find('input:checkbox, input:checkbox').removeAttr('checked').remoteAttr('selected');
	return true;
}