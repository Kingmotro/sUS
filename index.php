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
define("CURRENT_PAGE", "HOME");
include_once("inc/global.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Home &middot; <?php echo $Core->GetString("Title"); ?></title>
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

	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span3">
				<div class="well">
					<?php include_once("inc/inc.sidebar.php"); ?>
				</div>
			</div>
			
			<div class="span9">
				<div class="hero-unit">
					<?php
					if (!$User->LoggedIn) //User is NOT logged in.
					{
					?>
						<h1>Hello there!</h1>
						<p>Welcome to <?php echo $Core->GetString("Title"); ?>! It appears you are not logged in, please choose an option from below.</p>
						<p>
							<a class="btn btn-primary btn-large" id="sUS_BigLoginButton"><i class="icon-user icon-white"></i> Login</a>
							<a class="btn btn-success btn-large" href="<?php echo $Core->GetString("URL"); ?>/register.php"><i class="icon-plus icon-white"></i> Register</a>
							<a class="btn btn-danger btn-large" href="<?php echo $Core->GetString("URL"); ?>/reset.php"><i class="icon-lock icon-white"></i> Reset Password</a>
						</p>
					<?php
					}
					else //User IS logged in.
					{
					?>
						<h1>Hi <?php echo $User->Name; ?>!</h1>
						<p>
							Welcome to <?php echo $Core->GetString("Title"); ?>! We hope you enjoy your stay!
						</p>
					<?php
					}
					?>
				</div>
			</div>
		</div>

		<hr />

		<footer>
			<?php include_once("inc/inc.footer.php"); ?>
		</footer>
	</div>
	
	<?php include_once("inc/inc.scripts.php"); ?>
	<?php require_once(SUS_INCLUDES . "/useralerts.php"); ?>
</body>
</html>
<?php
ob_flush();
?>