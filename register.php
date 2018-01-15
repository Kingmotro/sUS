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
define("CURRENT_PAGE", "REGISTER");
include_once("inc/global.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register &middot; <?php echo $Core->GetString("Title"); ?></title>
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
					$Core->Alert("Oops!", "It appears you are already logged in and therefore cannot register.", "error");
					echo "<div class=\"form-actions\">
						<a href=\"{$Core->GetString("URL")}/index.php\" class=\"btn btn-primary\">Return Home</a>
					</div>";
				}
				else //User IS logged in.
				{
				?>
					<div class="page-header">
						<h1>Register <small>to <?php echo $Core->GetString("Title"); ?>.</small></h1>
					</div>
					
					<form method="post" id="sUS_RegisterForm" name="sUS_RegisterForm" class="form-horizontal">
						<div class="control-group">
							<label for="sUS_RegisterFormUsername" class="control-label">Username</label>
							<div class="controls">
								<input type="text" name="sUS_RegisterFormUsername" id="sUS_RegisterFormUsername" maxlength="18" placeholder="Choose a username" />
							</div>
						</div>
						
						<div class="control-group">
							<div class="pull-left">
								<label for="sUS_RegisterFormPassword1" class="control-label">Password</label>
								<div class="controls">
									<input type="password" name="sUS_RegisterFormPassword1" id="sUS_RegisterFormPassword1" maxlength="30" placeholder="Enter a password" />
								</div>
							</div>
							
							<div class="pull-left">
								<label for="sUS_RegisterFormPassword2" class="control-label">Verify Password</label>
								<div class="controls">
									<input type="password" name="sUS_RegisterFormPassword2" id="sUS_RegisterFormPassword2" maxlength="30" placeholder="Verify your password" />
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						
						<div class="control-group">
							<label for="sUS_RegisterFormEmail" class="control-label">Email</label>
							<div class="controls">
								<input type="text" name="sUS_RegisterFormEmail" id="sUS_RegisterFormEmail" maxlength="150" placeholder="Enter your email address" />
							</div>
						</div>
						
						<div class="control-group">
							<label for="sUS_RegisterFormSex" class="control-label">Sex</label>
							<div class="controls">
								<select name="sUS_RegisterFormSex" id="sUS_RegisterFormSex">
									<option>Male</option>
									<option>Female</option>
								</select>
							</div>
						</div>
						
						<div class="control-group">
							<label for="sUS_RegisterFormDate" class="control-label">Date of Birth</label>
							<div class="controls">
								<select name="sUS_RegisterFormDate" id="sUS_RegisterFormDate">
									<?php
										for ($i=1; $i<=31; $i++) {
											echo "<option>{$i}</option>";
										}
									?>
								</select>
								
								<select name="sUS_RegisterFormMonth" id="sUS_RegisterFormMonth">
									<?php
										$Months = array("1" => "January", "2" => "February", "3" => "March", "4" => "April", "5" => "May", "6" => "June", "7" => "July", "8" => "August", "9" => "September", "10" => "October", "11" => "November", "12" => "December");
										foreach ($Months as $MonthID => $MonthName) {
											echo "<option value=\"{$MonthID}\">{$MonthName}</option>";
										}
									?>
								</select>
								
								<select name="sUS_RegisterFormYear" id="sUS_RegisterFormYear">
									<?php
										for ($i=1950; $i<=(date("Y")-5); $i++) {
											echo "<option>{$i}</option>";
										}
									?>
								</select>
							</div>
						</div>
						
						<div class="form-actions">
							<button type="submit" name="sUS_RegisterFormSubmit" id="sUS_RegisterFormSubmit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Register</button>
							<button type="reset" name="sUS_RegisterFormReset" id="sUS_RegisterFormReset" class="btn"><i class="icon-trash"></i> Reset</button>
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