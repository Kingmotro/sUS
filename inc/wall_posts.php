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
include_once("global.php");

if ($User->LoggedIn) {
	echo "<a href=\"#sUS_WallPostDialog\" role=\"button\" class=\"btn btn-primary\" style=\"outline: none;\" data-toggle=\"modal\">Post to Wall</a>";
}

$WallPostUser = intval($_GET["UserID"]);

$WallPostQ = $DB->Query("SELECT * FROM `WallPosts` WHERE `ToID` = '{$WallPostUser}' ORDER BY ABS(`WallPostID`) DESC");
if (intval($DB->Num($WallPostQ)) > 0)
{
	while ($WallPostA = $DB->Arr($WallPostQ)) {
		?>
		<div class="media">
			<a class="pull-left" href="<?php echo $Core->GetString("URL"); ?>/profile/<?php echo $User->Get("Username", $WallPostA["FromID"]); ?>">
				<img class="media-object" src="<?php echo $User->Get("Picture", $WallPostA["FromID"]); ?>" height="64" width="64" alt="<?php echo $User->Get("Username", $WallPostA["FromID"]); ?>'s Profile Picture" />
			</a>
			<div class="media-body">
				<h4 class="media-heading"><a href="<?php echo $Core->GetString("URL"); ?>/profile/<?php echo $User->Get("Username", $WallPostA["FromID"]); ?>"><?php echo $User->Get("Username", $WallPostA["FromID"]); ?></a></h4>
				<?php echo $Core->Filter($WallPostA["Content"]); ?>
			</div>
		</div>
		<?php
	}
}
else
{
	echo "<p class=\"text-info\">{$User->Get("Username", $WallPostUser)} currently has no wall posts to display.</p>";
}
ob_flush();
?>