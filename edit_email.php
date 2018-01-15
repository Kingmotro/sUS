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
	<title>Edit Email &middot; <?php echo $Core->GetString("Title"); ?></title>
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
					<h1>Edit Email</h1>
				</div>
				
				<?php
				if ($User->LoggedIn) //User IS logged in.
				{
					?>
					<p id="sUS_EditEmailText1">
						To edit your email address, simply fill in this form. All emails that are usually sent from this website will be sent to this email address instead.
					</p>
					
					<form method="post" id="sUS_EditEmailForm" name="sUS_EditEmailForm" class="form-horizontal">
						<div class="control-group">
							<label for="sUS_EditEmailCurrent" class="control-label">Current Email</label>
							<div class="controls">
								<input type="text" name="sUS_EditEmailCurrent" id="sUS_EditPasswordCurrent" maxlength="150" placeholder="Enter your current email address&hellip;" />
							</div>
						</div>
						
						<div class="control-group">
							<div class="pull-left">
								<label for="sUS_EditEmailNew1" class="control-label">New Email</label>
								<div class="controls">
									<input type="text" name="sUS_EditEmailNew1" id="sUS_EditEmailNew1" maxlength="30" placeholder="Enter a new email address&hellip;" />
								</div>
							</div>
							
							<div class="pull-left">
								<label for="sUS_EditEmailNew2" class="control-label">Verify New Email</label>
								<div class="controls">
									<input type="text" name="sUS_EditEmailNew2" id="sUS_EditEmailNew2" maxlength="30" placeholder="Verify your new email address&hellip;" />
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						
						<div class="form-actions">
							<button type="submit" name="sUS_EditEmailSubmit" id="sUS_EditEmailSubmit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Submit</button>
							<button type="reset" name="sUS_EditEmailReset" id="sUS_EditEmailReset" class="btn"><i class="icon-trash"></i> Reset</button>
						</div>
					</form>
					<?php
				}
				else //User is NOT logged in.
				{
					$Core->Alert("Oops!", "It appears you are not logged in and therefore cannot change your email address.", "error");
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