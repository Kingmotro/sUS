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

if (isset($_GET["id"]))
{
	$ContactID = $_GET["id"];
	$ContactQ  = $DB->Query("SELECT * FROM `Contact` WHERE `ContactID` = '{$ContactID}'");
	if (intval($DB->Num($ContactQ)) > 0)
	{
		$ContactA = $DB->Arr($ContactQ);
		$Title = $ContactA["Subject"];
	}
	else
	{
		$Title = "Contact Forms";
	}
}
else
{
	$Title = "Contact Forms";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin CP &middot; <?php echo $Title; ?> &middot; <?php echo $Core->GetString("Title"); ?></title>
	<?php include_once(SUS_INCLUDES . "/inc.head.php"); ?>
</head>

<body>
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
						<li class="active"><a href="contactforms.php">Contact Forms</a></li>
						<li class=""><a href="adminlogs.php">Admin Logs</a></li>
						<li class=""><a href="mysql.php">MySQL Connection Details</a></li>
						
						<li class="nav-header">USERS</li>
						<li class=""><a href="adduser.php">Add User</a></li>
						<li class=""><a href="edituser.php">Edit User</a></li>
						<li class=""><a href="deleteuser.php">Delete User</a></li>
						<li class=""><a href="banuser.php">Ban User</a></li>
						<li class=""><a href="unbanuser.php">Unban User</a></li>
						<li class=""><a href="alertuser.php">Alert User</a></li>
						
						<li class="divider"></li>
						
						<li class=""><a href="#">Help</a></li>
					</ul>
				</div>
			</div>
			
			<div class="span9">
				<div class="page-header">
					<h1><?php echo $Title; ?></h1>
				</div>
				
				<?php
				if ($User->LoggedIn && $User->Get("Rank") == "Administrator")
				{
					if ($ContactID)
					{
						?>
						<table class="table">
							<tbody>
								<tr>
									<td><strong>Name:</strong> <?php echo $ContactA["Name"]; ?></td>
									<td><strong>Email:</strong> <a href="mailto:<?php echo $ContactA["Email"]; ?>"><?php echo $ContactA["Email"]; ?></a></td>
								</tr>
								<tr>
									<td><strong>IP Address:</strong> <?php echo $ContactA["IPAddress"]; ?></td>
									<td><strong>Date Sent:</strong> <?php echo date("l, jS F, Y - g:i a", $ContactA["TimeStamp"]); ?></td>
								</tr>
								<tr>
									<td colspan="2">
										<strong>Message:</strong><br />
										<?php echo nl2br(htmlspecialchars($ContactA["Message"])); ?>
									</td>
								</tr>
							</tbody>
						</table>
						
						<div class="form-actions">
							<form method="post" style="margin: 0;" id="sUS_ContactFormsForm" name="sUS_ContactFormsForm">
								<input type="hidden" id="sUS_ContactFormsID" name="sUS_ContactFormsID" value="<?php echo $ContactID; ?>" />
								<button type="button" id="sUS_ContactFormsMarkRead" name="sUS_ContactFormsMarkRead" class="btn btn-success"><i class="icon-ok icon-white"></i> Dealt With</button>
								<button type="button" id="sUS_ContactFormsDelete" name="sUS_ContactFormsDelete" class="btn btn-danger"><i class="icon-trash icon-white"></i> Delete</button>
							</form>
						</div>
						<?php
					}
					else
					{
						?>
						<p class="lead">You haven't selected a contact submission to view, select one from below.</p>
						
						<?php
						$ContactListQ = $DB->Query("SELECT * FROM `Contact` ORDER BY ABS(`DealtWith`) ASC, ABS(`ContactID`) ASC");
						if (intval($DB->Num($ContactListQ)) > 0)
						{
							echo "<table class=\"table table-bordered\">
								<thead>
									<tr>
										<th>Subject</th>
										<th>From</th>
										<th>Read</th>
									</tr>
								</thead>
								<tbody>";
									while ($ContactListA = @mysql_fetch_array($ContactListQ)) {
										$ContactClass = ($ContactListA["DealtWith"]=="1") ? "success" : "error";
										echo "<tr class=\"{$ContactClass}\">
											<td>" . htmlspecialchars($ContactListA["Subject"]) . "</td>
											<td><a href=\"mailto:" . $ContactListA["Email"] . "\">{$ContactListA["Name"]}</a></td>
											<td><a href=\"{$Core->GetString("URL")}/admin/contactforms.php?id={$ContactListA["ContactID"]}\">Read</a></td>
										</tr>";
									}
								echo "</tbody>
							</table>";
						}
						else //I don't know how this is possible because you have to be logged in to view this page, thus meaning that users DO exist but better safe than sorry.
						{
							echo "<p class=\"text-error\">There are no contact submissions to display</p>";
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