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

if ($User->LoggedIn)
{
?>
	<div class="media">
		<a href="<?php echo $Core->GetString("URL"); ?>/profile/<?php echo $User->Name; ?>" class="pull-left">
			<img src="<?php echo $User->Get("Picture"); ?>" height="64" width="64" class="media-object" />
		</a>
		<div class="media-body">
			<h4 class="media-heading"><a href="<?php echo $Core->GetString("URL"); ?>/profile/<?php echo $User->Name; ?>"><?php echo $User->Name; ?></a></h4>
			<small>
				Page Visits: <?php echo ($User->Get("PageVisits")+1); ?><br />
				Wall Posts: <?php echo intval($DB->Num($DB->Query("SELECT * FROM `WallPosts` WHERE `ToID` = '{$User->ID}'"))); ?><br />
				<?php if ($User->Get("LastVisit") !== "0") { echo "Last Visit: <abbr title=\"" . date("l, jS F, Y - g:i a", $User->Get("LastVisit")) . "\">{$Core->DateAgo($User->Get("LastVisit"))}</abbr>"; } ?>
			</small>
		</div>
	</div>
<?php
}else{
?>
	<h3 style="margin-top: 0;">Log in</h3>
	<form method="post" id="sUS_LoginForm" name="sUS_LoginForm">
		<div class="control-group">
			<label for="sUS_LoginFormUsername" class="control-label">Username</label>
			<div class="controls">
				<input type="text" name="sUS_LoginFormUsername" id="sUS_LoginFormUsername" maxlength="18" placeholder="Enter your username&hellip;" />
			</div>
		</div>
		
		<div class="control-group">
			<label for="sUS_LoginFormPassword" class="control-label">Password</label>
			<div class="controls">
				<input type="password" name="sUS_LoginFormPassword" id="sUS_LoginFormPassword" maxlength="30" placeholder="Enter your password&hellip;" />
			</div>
		</div>
		
		<div class="control-group">
			<input type="submit" name="sUS_LoginFormSubmit" id="sUS_LoginFormSubmit" value="Login" class="btn btn-primary" />
			<a href="<?php echo $Core->GetString("URL"); ?>/register.php" name="sUS_LoginFormRegister" id="sUS_LoginFormRegister" class="btn btn-success">Register</a>
			<a href="<?php echo $Core->GetString("URL"); ?>/reset.php" name="sUS_LoginFormReset" id="sUS_LoginFormReset" class="btn btn-danger">Reset</a>
		</div>
	</form>
	
<?php
}
?>