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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin CP &middot; Site Settings &middot; <?php echo $Core->GetString("Title"); ?></title>
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
						<li class="active"><a href="sitesettings.php">Site Settings</a></li>
						<li class=""><a href="contactforms.php">Contact Forms</a></li>
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
					<h1>Site Settings</h1>
				</div>
				
				<?php
				if ($User->LoggedIn && $User->Get("Rank") == "Administrator")
				{
				?>
					<p class="lead">To edit the general settings of <?php echo $Core->GetString("Title"); ?>, edit the details below.</p>
					
					<form method="post" id="sUS_AdminSiteSettingsForm" name="sUS_AdminSiteSettingsForm" class="form-horizontal">
						<div class="control-group">
							<label for="sUS_AdminSiteSettingsTitle" class="control-label">Title</label>
							<div class="controls">
								<input type="text" name="sUS_AdminSiteSettingsTitle" id="sUS_AdminSiteSettingsTitle" value="<?php echo $Core->GetString("Title"); ?>" maxlength="65" class="input-xxlarge" />
							</div>
						</div>
						<div class="control-group">
							<label for="sUS_AdminSiteSettingsURL" class="control-label">URL</label>
							<div class="controls">
								<input type="text" name="sUS_AdminSiteSettingsURL" id="sUS_AdminSiteSettingsURL" value="<?php echo $Core->GetString("URL"); ?>" maxlength="75" class="input-xxlarge" /><span class="help-inline">no trailing slash (/)</span>
							</div>
						</div>
						<div class="control-group">
							<label for="sUS_AdminSiteSettingsCopyright" class="control-label">Copyright</label>
							<div class="controls">
								<input type="text" name="sUS_AdminSiteSettingsCopyright" id="sUS_AdminSiteSettingsCopyright" value="<?php echo htmlspecialchars($Core->GetString("Copyright")); ?>" maxlength="75" class="input-xxlarge" />
							</div>
						</div>
						<div class="control-group">
							<label for="sUS_AdminSiteSettingsEmail" class="control-label">Email</label>
							<div class="controls">
								<input type="text" name="sUS_AdminSiteSettingsEmail" id="sUS_AdminSiteSettingsEmail" value="<?php echo $Core->GetString("Email"); ?>" maxlength="150" class="input-xxlarge" />
							</div>
						</div>
						
						<div class="form-actions">
							<button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Submit</button>
							<button type="reset" class="btn"><i class="icon-trash"></i> Reset</button>
						</div>
					</form>
				</div>
			<?php
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