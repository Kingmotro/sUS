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
		$UnbanName = $User->Get("Username", $_User);
		$UnbanID   = $User->Get("UserID", $_User);
		$Title   = " - {$UnbanName}";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin CP &middot; Unban User<?php echo $Title; ?> &middot; <?php echo $Core->GetString("Title"); ?></title>
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
						<li class=""><a href="contactforms.php">Contact Forms</a></li>
						<li class=""><a href="adminlogs.php">Admin Logs</a></li>
						<li class=""><a href="mysql.php">MySQL Connection Details</a></li>
						
						<li class="nav-header">USERS</li>
						<li class=""><a href="adduser.php">Add User</a></li>
						<li class=""><a href="edituser.php">Edit User</a></li>
						<li class=""><a href="deleteuser.php">Delete User</a></li>
						<li class=""><a href="banuser.php">Ban User</a></li>
						<li class="active"><a href="unbanuser.php">Unban User</a></li>
						<li class=""><a href="alertuser.php">Alert User</a></li>
						
						<li class="divider"></li>
						
						<li class=""><a href="#">Help</a></li>
					</ul>
				</div>
			</div>
			
			<div class="span9">
				<div class="page-header">
					<h1>Unban User<?php echo $Title; ?></h1>
				</div>
				
				<?php
				if ($User->LoggedIn && $User->Get("Rank") == "Administrator")
				{
					if ($UnbanName)
					{
						if (isset($_POST["sUS_AdminBanUserBan"]))
						{
							$UserQ = $DB->Query("SELECT * FROM `Users` WHERE `UserID` = '{$UnbanID}'");
							if (intval($DB->Num($UserQ)) > 0)
							{
								$User->Update("Banned", "0", $UnbanID);
								$Core->Alert("Success!", "The user \"{$UnbanName}\" has been successfully unbanned.", "success");
							}
							else //Could have been deleted by another administrator in the mean time.
							{
								echo "<p class=\"text-error\">This user no longer exists!</p>";
							}
						}
						else
						{
						?>
							<p class="lead">To grant <?php echo $UnbanName; ?> access to <?php echo $Core->GetString("Title"); ?> again, click the 'Unban' button below.</p>
							
							<form method="post" id="sUS_AdminUnbanUserForm" name="sUS_AdminUnbanUserForm" class="form-horizontal">
								<p>Are you sure that you want to ban <?php echo $UnbanName; ?>?</p>
								
								<button type="submit" name="sUS_AdminBanUserBan" id="sUS_AdminUnbanUserUnban" class="btn btn-danger"><i class="icon-ok-sign icon-white"></i> Unban</button>
								<a href="<?php echo $_SERVER["HTTP_REFERER"]; ?>" class="btn btn-success"><i class="icon-chevron-left icon-white"></i> Back</a>
							</form>
						<?php
						}
					}
					else
					{
						?>
						<p class="lead">You haven't selected a user to unban, select one from below.</p>
						
						<?php
						$MembersQ = $DB->Query("SELECT * FROM `Users` WHERE `Banned` = '1' ORDER BY ABS(`Username`) ASC");
						if (intval($DB->Num($MembersQ)) > 0)
						{
							echo "<table class=\"table table-bordered table-striped\">
								<thead>
									<tr>
										<th>#</th>
										<th>Username</th>
										<th>Unban</th>
									</tr>
								</thead>
								<tbody>";
									while ($MembersA = @mysql_fetch_array($MembersQ)) {
										echo "<tr>
											<td>{$MembersA["UserID"]}</td>
											<td>{$MembersA["Username"]}</td>
											<td><a href=\"{$Core->GetString("URL")}/admin/unbanuser.php?user={$MembersA["Username"]}\">Unban {$MembersA["Username"]}</a></td>
										</tr>";
									}
								echo "</tbody>
							</table>";
						}
						else
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