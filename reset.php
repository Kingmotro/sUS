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
define("CURRENT_PAGE", "RESET_PW");
include_once("inc/global.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Reset Password &middot; <?php echo $Core->GetString("Title"); ?></title>
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
				<?php
				if ($User->LoggedIn) //User is NOT logged in.
				{
					$Core->Alert("Oops!", "It appears you are already logged in and therefore cannot reset your password.", "error");
					echo "<div class=\"form-actions\">
						<a href=\"{$Core->GetString("URL")}/index.php\" class=\"btn btn-primary\">Return Home</a>
					</div>";
				}
				else //User IS logged in.
				{
				?>
					<div class="page-header">
						<h1>Reset Password</h1>
					</div>
					
					<p id="sUS_ForgotText1">
						If you have forgotten your password, simply enter the email address that is linked to your account and we will send you instructions on how to reset your password.
					</p>
					
					<form method="post" id="sUS_ResetForm" name="sUS_ResetForm" class="form-horizontal">
						<div class="control-group">
							<label for="sUS_ResetFormEmail" class="control-label">Email</label>
							<div class="controls">
								<input type="text" name="sUS_ResetFormEmail" id="sUS_ResetFormEmail" maxlength="150" placeholder="Enter your email address&hellip;" />
							</div>
						</div>
						
						<div class="form-actions">
							<button type="submit" name="sUS_ResetFormSubmit" id="sUS_ResetFormSubmit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Submit</button>
							<button type="reset" name="sUS_ResetFormReset" id="sUS_ResetFormReset" class="btn"><i class="icon-trash"></i> Reset</button>
						</div>
					</form>
				<?php
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