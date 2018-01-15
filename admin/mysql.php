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
	<title>Admin CP &middot; MySQL Connection Details &middot; <?php echo $Core->GetString("Title"); ?></title>
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
						<li class="active"><a href="mysql.php">MySQL Connection Details</a></li>
						
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
					<h1>MySQL Connection Details</h1>
				</div>
				
				<?php
				if ($User->LoggedIn && $User->Get("UserID") == "1")
				{
				?>
					<p class="lead">Please make sure you enter these details correctly or you risk ruining your website. If you do enter these details incorretly, you can change them in 'inc/global.php'.</p>
					
					<form method="post" id="sUS_AdminMySQLForm" name="sUS_AdminMySQLForm" class="form-horizontal">
						<div class="control-group">
							<label for="sUS_AdminMySQLHost" class="control-label">Host</label>
							<div class="controls">
								<input type="text" name="sUS_AdminMySQLHost" id="sUS_AdminMySQLHost" value="<?php echo $DBGlobal["Host"]; ?>" maxlength="45" class="input-xxlarge" />
							</div>
						</div>
						<div class="control-group">
							<label for="sUS_AdminMySQLDBName" class="control-label">Database name</label>
							<div class="controls">
								<input type="text" name="sUS_AdminMySQLDBName" id="sUS_AdminMySQLDBName" value="" maxlength="45" class="input-xxlarge" />
							</div>
						</div>
						<div class="control-group">
							<label for="sUS_AdminMySQLUser" class="control-label">Username</label>
							<div class="controls">
								<input type="text" name="sUS_AdminMySQLUser" id="sUS_AdminMySQLUser" value="" maxlength="45" class="input-xxlarge" />
							</div>
						</div>
						<div class="control-group">
							<label for="sUS_AdminMySQLPass" class="control-label">Password</label>
							<div class="controls">
								<input type="password" name="sUS_AdminMySQLPass" id="sUS_AdminMySQLPass" value="" maxlength="70" class="input-xxlarge" />
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