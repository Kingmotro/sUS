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
define("CURRENT_PAGE", "ADMIN");
include_once("../inc/global.php");

if (isset($_GET["user"])) {
	$_User = $_GET["user"];
	if ($User->Exists($_User)) {
		$AlertName = $User->Get("Username", $_User);
		$AlertID   = $User->Get("UserID", $_User);
		$Title     = " - {$AlertName}";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin CP &middot; Alert User<?php echo $Title; ?> &middot; <?php echo $Core->GetString("Title"); ?></title>
	<?php include_once(SUS_INCLUDES . "/inc.head.php"); ?>
</head>

<body>
	<div class="modal hide fade" id="sUS_AlertUserPreviewDialog">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="sUS_AlertUserPreviewH3"></h3>
		</div>
		<div class="modal-body">
			<p id="sUS_AlertUserPreviewP">
				
			</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-primary" data-dismiss="modal"><i class="icon-ok icon-white"></i> OK!</a>
		</div>
	</div>
	<div id="drop_down_bar">&nbsp;</div>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="brand" href="<?php echo $Core->GetString("URL"); ?>/index.php"><?php echo $Core->GetString("Title"); ?></a>
				<div class="nav-collapse collapse">
					<?php include_once(SUS_INCLUDES . "/inc.navigation.php"); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span3">
				<div class="well sidebar-nav">
					<ul class="nav nav-list">
						<li class="nav-header">GENERAL</li>
						<li class=""><a href="index.php">Dashboard</a></li>
						<li class=""><a href="sitesettings.php">Site Settings</a></li>
						<li class=""><a href="contactforms.php">Contact Forms</a></li>
						<li class=""><a href="adminlogs.php">Admin Logs</a></li>
						<li class=""><a href="mysql.php">MySQL Connection Details</a></li>
						
						<li class="nav-header">USERS</li>
						<li class=""><a href="adduser.php">Add User</a></li>
						<li class=""><a href="edituser.php">Edit User</a></li>
						<li class=""><a href="deleteuser.php">Delete User</a></li>
						<li class=""><a href="banuser.php">Ban User</a></li>
						<li class=""><a href="unbanuser.php">Unban User</a></li>
						<li class="active"><a href="alertuser.php">Alert User</a></li>
						
						<li class="divider"></li>
						
						<li class=""><a href="#">Help</a></li>
					</ul>
				</div>
			</div>
			
			<div class="span9">
				<div class="page-header">
					<h1>Alert User<?php echo $Title; ?></h1>
				</div>
				
				<?php
				if ($User->LoggedIn && $User->Get("Rank") == "Administrator")
				{
					if ($AlertName)
					{
					?>
						<p class="lead" id="sUS_AlertUserText1">To send <?php echo $AlertName; ?> an alert, fill in the details below and click the 'Submit' button.</p>
						
						<form method="post" id="sUS_AdminAlertUserForm" name="sUS_AdminAlertUserForm" class="form-horizontal">
							<div class="control-group">
								<label for="sUS_AdminAlertUserTo" class="control-label">To</label>
								<div class="controls">
									<input type="text" name="sUS_AdminAlertUserTo" id="sUS_AdminAlertUserTo" maxlength="18" value="<?php echo $AlertName; ?>" readonly="yes" />
								</div>
							</div>
							<div class="control-group">
								<label for="sUS_AdminAlertUserTitle" class="control-label">Title</label>
								<div class="controls">
									<input type="text" name="sUS_AdminAlertUserTitle" id="sUS_AdminAlertUserTitle" maxlength="30" />
								</div>
							</div>
							<div class="control-group">
								<label for="sUS_AdminAlertUserMessage" class="control-label">Message</label>
								<div class="controls">
									<textarea name="sUS_AdminAlertUserMessage" id="sUS_AdminAlertUserMessage" style="height: 120px; width: 605px;" /></textarea>
								</div>
							</div>
							
							<div class="form-actions">
								<button type="submit" name="sUS_AdminAlertUserSubmit" id="sUS_AdminAlertUserSubmit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Submit</button>
								<button type="button" name="sUS_AdminAlertUserPreview" id="sUS_AdminAlertUserPreview" class="btn btn-info" data-fromuser="<?php echo $User->Name; ?>"><i class="icon-fullscreen icon-white"></i> Preview</button>
								<button type="reset" name="sUS_AdminAlertUserReset" id="sUS_AdminAlertUserReset" class="btn"><i class="icon-trash"></i> Reset</button>
							</div>
						</form>
					<?php
					}
					else
					{
						?>
						<p class="lead">You haven't selected a user to alert, select one from below.</p>
						
						<?php
						$MembersQ = $DB->Query("SELECT * FROM `Users` ORDER BY ABS(`Username`) ASC");
						if (intval($DB->Num($MembersQ)) > 0)
						{
							echo "<table class=\"table table-bordered table-striped\">
								<thead>
									<tr>
										<th>#</th>
										<th>Username</th>
										<th>Alert</th>
									</tr>
								</thead>
								<tbody>";
									while ($MembersA = @mysql_fetch_array($MembersQ)) {
										echo "<tr>
											<td>{$MembersA["UserID"]}</td>
											<td>{$MembersA["Username"]}</td>
											<td><a href=\"{$Core->GetString("URL")}/admin/alertuser.php?user={$MembersA["Username"]}\">Alert {$MembersA["Username"]}</a></td>
										</tr>";
									}
								echo "</tbody>
							</table>";
						}
						else //I don't know how this is possible because you have to be logged in to view this page, thus meaning that users DO exist but better safe than sorry.
						{
							echo "<p class=\"text-error\">There are no members to display</p>";
						}
					}
				}
				else
				{
					$Core->Alert("Oops!", "You do not have permission to view this page.", "error");
					echo "<div class=\"form-actions\">
						<a href=\"{$Core->GetString("URL")}/admin/\" class=\"btn btn-primary\">Admin CP</a>
					</div>";
				}
				?>
			</div>
		</div>
		
		<hr />

		<footer>
			<?php include_once(SUS_INCLUDES . "/inc.footer.php"); ?>
		</footer>
	</div>
	
	<?php include_once(SUS_INCLUDES . "/inc.scripts.php"); ?>
	<?php require_once(SUS_INCLUDES . "/useralerts.php"); ?>
</body>
</html>
<?php
ob_flush();
?>