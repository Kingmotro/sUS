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
define("CURRENT_PAGE", "CONTACT");
include_once("inc/global.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Contact &middot; <?php echo $Core->GetString("Title"); ?></title>
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
					<h1>Contact</h1>
				</div>
				
				<p id="sUS_ContactText1">
					If you've got something you want to say to us, simply fill in this form below and we shall try to respond within 48 hours.
				</p>
				
				<form method="post" id="sUS_ContactForm" name="sUS_ContactForm" class="form-horizontal">
					<div class="control-group">
						<div class="pull-left">
							<label for="sUS_ContactName" class="control-label">Your name</label>
							<div class="controls">
								<input type="text" name="sUS_ContactName" id="sUS_ContactName" maxlength="75" placeholder="Please tell us your name"<?php if ($User->LoggedIn) { echo " value=\"{$User->Name}\" readonly=\"readonly\""; } ?> />
							</div>
						</div>
						
						<div class="pull-left">
							<label for="sUS_ContactEmail" class="control-label">Your email</label>
							<div class="controls">
								<input type="text" name="sUS_ContactEmail" id="sUS_ContactEmail" maxlength="150" placeholder="What is your email address?"<?php if ($User->LoggedIn) { echo " value=\"{$User->Get("Email")}\" readonly=\"readonly\""; } ?> />
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
						
					<div class="control-group">
						<label for="sUS_ContactSubject" class="control-label">Subject</label>
						<div class="controls">
							<input type="text" name="sUS_ContactSubject" id="sUS_ContactSubject" maxlength="75" style="width: 605px;" placeholder="Why are you contacting us?" />
						</div>
					</div>
					
					<div class="control-group">
						<label for="sUS_ContactMessage" class="control-label">Message</label>
						<div class="controls">
							<textarea name="sUS_ContactMessage" id="sUS_ContactMessage" style="height: 120px; width: 605px;" placeholder="What would you like to say to us?"></textarea>
						</div>
					</div>
					
					<div class="form-actions">
						<button type="submit" name="sUS_EditEmailSubmit" id="sUS_EditEmailSubmit" class="btn btn-primary"><i class="icon-ok icon-white"></i> Submit</button>
						<button type="reset" name="sUS_EditEmailReset" id="sUS_EditEmailReset" class="btn"><i class="icon-trash"></i> Reset</button>
					</div>
				</form>
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