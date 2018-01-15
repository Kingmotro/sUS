<?php
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

ob_start();
define("CURRENT_PAGE", "ME");
include_once("inc/global.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Messages &middot; <?php echo $Core->GetString("Title"); ?></title>
	<?php include_once("inc/inc.head.php"); ?>
</head>

<body>
	<div id="drop_down_bar">&nbsp;</div>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="brand" href="<?php echo $Core->GetString("URL"); ?>/index.php"><?php echo $Core->GetString("Title"); ?></a>
				<div class="nav-collapse collapse">
					<?php include_once("inc/inc.navigation.php"); ?>
				</div>
			</div>
		</div>
	</div>
	
	<div id="sUS_MessagesNewDialog" class="modal hide fade" style="outline: none;" tabindex="-1" role="dialog" aria-labelledby="sUS_MessagesNewLabel" aria-hidden="false">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="sUS_MessagesNewLabel">New Message</h3>
		</div>
		<form method="post" name="sUS_MessagesNewForm" id="sUS_MessagesNewForm" style="margin: 0;">
			<div class="modal-body">
				<div class="control-group">
					<label for="sUS_MessagesNewTo" class="control-label">To</label>
					<div class="controls">
						<input type="text" data-provide="typeahead" name="sUS_MessagesNewTo" id="sUS_MessagesNewTo" placeholder="Who should this go to?" />
					</div>
				</div>
				
				<div class="control-group">
					<label for="sUS_MessagesNewMessage" class="control-label">Message</label>
					<div class="controls">
						<textarea id="sUS_MessagesNewMessage" name="sUS_MessagesNewMessage" style="height: 140px; width: 518px;" placeholder="Enter a message to send&hellip;"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
				<button type="submit" class="btn btn-primary" id="sUS_MessagesNewSubmit" name="sUS_MessagesNewSubmit"><i class="icon-ok icon-white"></i> Send</button>
			</div>
		</form>
	</div>
	
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span3">
				<div class="well">
					<?php include_once("inc/inc.sidebar.php"); ?>
				</div>
			</div>
			
			<div class="span9 well">
				<div class="page-header">
					<h1>Messages</h1>
				</div>
				
				<?php
				if ($User->LoggedIn) //User IS logged in.
				{
					?>
					<div id="sUS_MessageActions" class="well well-small">
						<div class="pull-right">
							<a href="#sUS_MessagesNewDialog" role="button" style="outline: none;" data-toggle="modal" class="btn btn-primary"><i class="icon-pencil icon-white"></i> New Message</a>
						</div>
						<div class="clearfix"></div>
					</div>
					<hr />
					<?php
					if ($Messages->Amount > 0)
					{
					?>
						<div id="sUS_MessageThreads">
							<div id="sUS_MessageThreadsList" class="well span4">
								
							</div>
							<div id="sUS_MessageThreadsContent" class="well span8">
								<p class="text-info">
									Select a thread on the left hand side to view its messages.
								</p>
							</div>
						</div>
					<?php
					}
					else
					{
						echo "<p class=\"text-error\">You have no messages to display!</p>";
					}
				}
				else //User is NOT logged in.
				{
					$Core->Alert("Oops!", "It appears you are not logged in and therefore cannot view your messages.", "error");
					echo "<div class=\"form-actions\">
						<a href=\"{$Core->GetString("URL")}/index.php\" class=\"btn btn-primary\">Return Home</a>
					</div>";
				}
				?>
			</div>
		</div>

		<hr />

		<footer>
			<?php include_once("inc/inc.footer.php"); ?>
		</footer>
	</div>
	
	<?php include_once("inc/inc.scripts.php"); ?>
	<?php require_once(SUS_INCLUDES . "/useralerts.php"); ?>
	
	<script type="text/javascript">
	

	
	<?php
	$AllUsersQ = $DB->Query("SELECT * FROM `Users`");
	if (intval($DB->Num($AllUsersQ)) > 0)
	{
		$AllUsers = array();
		while ($AllUsersA = mysql_fetch_array($AllUsersQ)) {
			$AllUsers[] = $AllUsersA["Username"];
		}
		$Users_JS = json_encode($AllUsers);
		
		echo "var allUsers = " . $Users_JS . ";\n";
	}
	?>
	
	$(function(){
		$("#sUS_MessagesNewTo").typeahead({source: allUsers});
		
		$("div#sUS_MessageThreadsList").load("<?php echo $Core->GetString("URL"); ?>/inc/messages_list.php").delegate("div.sUS_MessageThreadsListItem", "click", function(){
			$("div#sUS_MessageThreadsContent").load("<?php echo $Core->GetString("URL"); ?>/inc/messages_content.php?ThreadID=" + $(this).attr("data-threadid")).delegate("button#sUS_MessageThreadsDeleteConversation", "click", function(){
				$.ajax({
					type: "POST",
					url: "<?php echo $Core->GetString("URL"); ?>/inc/messages_delete_conversation.php",
					data: "ThreadID=" + $("input#sUS_MessageThreadsID").val(),
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
			}).delegate("a#sUS_MessageThreadsReply", "click", function(){
				$("form#sUS_MessagesReplyForm").on("submit", function(){
					$.ajax({
						type: "POST",
						url: susurl+"/inc/replymessage.php",
						data: $(this).serialize(),
						success: function(r){
							if (r == "success")
							{
								$("div#sUS_MessagesReplyDialog").modal('hide');
								$("div#sUS_MessageThreadsList").load(susurl+"/inc/messages_list.php");
								$("div#sUS_MessageThreadsContent").load(susurl+"/inc/messages_content.php?ThreadID=" + ($("input#sUS_MessagesReplyThreadID").val()));
								ResetForm($("#sUS_MessagesReplyForm"))
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
			});
			$("div.sUS_MessageThreadsListItem").removeClass("active");
			$(this).addClass("active");
		});
	});
	</script>
</body>
</html>
<?php
ob_flush();
?>