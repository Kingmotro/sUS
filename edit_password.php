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
	<title>Edit Password &middot; <?php echo $Core->GetString("Title"); ?></title>
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
			
			<div class="span9 well">
				<div class="page-header">
					<h1>Edit Password</h1>
				</div>
				
				<?php
				if ($User->LoggedIn) //User IS logged in.
				{
					?>
					<p id="sUS_EditPasswordText1">
						By using this form you are able to edit your password. If you do change your password, you may be asked to login again.
					</p>
					
					<form method="post" id="sUS_EditPasswordForm" name="sUS_EditPasswordForm" class="form-horizontal">
						<div class="control-group">
							<label for="sUS_EditPasswordCurrent" class="control-label">Current Password</label>
							<div class="controls">
								<input type="password" name="sUS_EditPasswordCurrent" id="sUS_EditPasswordCurrent" maxlength="30" placeholder="Enter your current password&hellip;" />
							</div>
						</div>
						
						<div class="control-group">
							<div class="pull-left">
								<label for="sUS_EditPasswordNew1" class="control-label">New Password</label>
								<div class="controls">
									<input type="password" name="sUS_EditPasswordNew1" id="sUS_EditPasswordNew1" maxlength="30" placeholder="Enter a new password&hellip;" />
								</div>
							</div>
							
							<div class="pull-left">
								<label for="sUS_EditPasswordNew2" class="control-label">Verify New Password</label>
								<div class="controls">
									<input type="password" name="sUS_EditPasswordNew2" id="sUS_EditPasswordNew2" maxlength="30" placeholder="Verify your new password&hellip;" />
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						
						<div class="form-actions">
							<button type="submit" name="sUS_EditPasswordSubmit" id="sUS_EditPasswordSubmit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Submit</button>
							<button type="reset" name="sUS_EditPasswordReset" id="sUS_EditPasswordReset" class="btn"><i class="icon-trash"></i> Reset</button>
						</div>
					</form>
					<?php
				}
				else //User is NOT logged in.
				{
					$Core->Alert("Oops!", "It appears you are not logged in and therefore cannot change your password.", "error");
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
</body>
</html>
<?php
ob_flush();
?>