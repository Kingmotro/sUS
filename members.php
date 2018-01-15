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
define("CURRENT_PAGE", "MEMBERS");
include_once("inc/global.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Members &middot; <?php echo $Core->GetString("Title"); ?></title>
	<?php include_once("inc/inc.head.php"); ?>
</head>

<body>
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

	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span3">
				<div class="well">
					<?php include_once("inc/inc.sidebar.php"); ?>
				</div>
			</div>
			
			<div class="span9 well">
				<div class="page-header">
					<h1>Members <small>(<?php echo intval($DB->Num($DB->Query("SELECT * FROM `Users`"))); ?>)</small></h1>
				</div>
				
				<?php
				$MembersQ = $DB->Query("SELECT * FROM `Users` ORDER BY ABS (`Username`) ASC");
				if (intval($DB->Num($MembersQ)) > 0)
				{
					echo "<div class=\"row-fluid\">";
						while ($MembersA = @mysql_fetch_array($MembersQ)) {
							echo "<div class=\"span3 thumbnail\" style=\"margin: 17px 17px 0 0;\">
								<center><a href=\"{$Core->GetString("URL")}/profile/{$MembersA["Username"]}\"><img src=\"{$MembersA["Picture"]}\" height=\"64\" width=\"64\" alt=\"{$MembersA["Username"]}'s Profile Picture\" /></a></center>
								<center><a href=\"{$Core->GetString("URL")}/profile/{$MembersA["Username"]}\" style=\"color:inherit;\"><h3>{$MembersA["Username"]}</h3></a></center>
								<p style=\"margin:0;\">
									<a href=\"javascript:void(0);\" class=\"btn btn-success btn-block message_user"; if (!$User->LoggedIn) { echo " btn-disabled\" disabled=\"disabled"; } echo "\" data-user=\"{$MembersA["Username"]}\"><i class=\"icon-pencil icon-white\"></i> Send Message</a>";
									if ($User->Get("Rank") == "Administrator") {
										echo "<div class=\"btn-group\" style=\"margin: 4px 0 0 0;\">
											<a class=\"btn btn-info btn-block dropdown-toggle\" data-toggle=\"dropdown\" href=\"javascript:void(0);\">
												<i class=\"icon-user icon-white\"></i> Administrator
												<span class=\"caret\"></span>
											</a>
											<ul class=\"dropdown-menu\">
												<li><a href=\"{$Core->GetString("URL")}/admin/edituser.php?user={$MembersA["Username"]}\"><i class=\"icon-wrench\"></i> Edit User</a></li>
												<li><a href=\"{$Core->GetString("URL")}/admin/banuser.php?user={$MembersA["Username"]}\"><i class=\"icon-lock\"></i> Ban User</a></li>
												<li><a href=\"{$Core->GetString("URL")}/admin/deleteuser.php?user={$MembersA["Username"]}\"><i class=\"icon-trash\"></i> Delete User</a></li>
											</ul>
										</div>";
									}
									echo "
								</p>
							</div>";
						}
					echo "</div>";
				}
				else
				{
					$Core->Alert("Oops!", "There are no members to display here!", "alert");
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
	<?php if ($User->LoggedIn) { ?>
		<script type="text/javascript">
		$(function(){
			$("a.message_user").click(function(){
				$("input#sUS_MessagesNewTo").val($(this).attr("data-user"));
				$("div#sUS_MessagesNewDialog").modal('show');
			});
		});
		</script>
	<?php } ?>
</body>
</html>
<?php
ob_flush();
?>