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
	<title>Admin CP &middot; Dashboard &middot; <?php echo $Core->GetString("Title"); ?></title>
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
						<li class="active"><a href="index.php">Dashboard</a></li>
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
						<li class=""><a href="alertuser.php">Alert User</a></li>
						
						<li class="divider"></li>
						
						<li class=""><a href="#">Help</a></li>
					</ul>
				</div>
			</div>
			
			<div class="span9">
				<div class="page-header">
					<h1>Dashboard</h1>
				</div>
				
				<?php
				if ($User->LoggedIn && $User->Get("Rank") == "Administrator")
				{
				?>
					<p class="lead">Hello <?php echo $User->Name; ?>! Welcome to the Admin CP.</p>
					
					<div class="span3 well well-small" style="margin-left: 0px;">
							<?php
							$UpdateData    = explode("\n", file_get_contents("http://mark-eriksson.com/work/projects/sUS/version.txt"));
							$UpdateVersion = $UpdateData[0];
							$UpdateLink    = $UpdateData[1];
							if ($SiteSettings["Version"] !== $UpdateVersion)
							{
								echo "A new version of sUS is available.<br /><br /><a href=\"{$UpdateLink}\" target=\"_blank\" class=\"btn btn-block btn-primary\">Get v{$UpdateVersion} Now!</a>";
							}
							else
							{
								echo "The version of sUS you are running (v{$UpdateVersion}) is up-to-date.";
							}
							?>
					</div>
					
					<div class="span3 well well-small">
							Here are a few statistics of <?php echo $Core->GetString("Title"); ?>.<br /><br />
							<span style="font-size: 32px;"><?php echo intval($DB->Num($DB->Query("SELECT * FROM `Users`"))); ?></span> <span class="muted">users</span><br />
							<span style="font-size: 32px;"><?php echo intval($DB->Num($DB->Query("SELECT * FROM `Users` WHERE `Banned` = '1'"))); ?></span> <span class="muted">banned users</span><br />
							<span style="font-size: 32px;"><?php echo intval($DB->Num($DB->Query("SELECT * FROM `WallPosts`"))); ?></span> <span class="muted">wall posts</span><br />
							<span style="font-size: 32px;"><?php echo intval($DB->Num($DB->Query("SELECT * FROM `Contact`"))); ?></span> <span class="muted">contact forms</span>
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