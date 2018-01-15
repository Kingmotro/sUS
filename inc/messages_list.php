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
	if (intval($Messages->Amount) > 0)
	{
		$ThreadsQ = $DB->Query("SELECT * FROM `MessageThreads` WHERE (`ToID` = '{$User->ID}' OR `FromID` = '{$User->ID}') ORDER BY ABS(`LastMessageTime`) DESC");
		while ($ThreadsA = $DB->Arr($ThreadsQ)) {
			if ($Messages->Deleted($ThreadsA["ThreadID"])==false) {
				$FromID = ($ThreadsA["ToID"] == $User->ID) ? $ThreadsA["FromID"] : $ThreadsA["ToID"];
				?>
				<div class="media sUS_MessageThreadsListItem" style="margin: 0;" data-threadid="<?php echo $ThreadsA["ThreadID"]; ?>">
					<div class="pull-left">
						<img src="<?php echo $User->Get("Picture", $FromID); ?>" height="50" width="50" class="media-object" />
					</div>
					<div class="media-body">
						<h4 class="media-heading"><?php echo $User->Get("Username", $FromID); ?></h4>
						<?php
						//This snippet of code will get the latest message from the thread to display under the username.
						$LatestMessageQ = $DB->Query("SELECT * FROM `Messages` WHERE `ThreadID` = '{$ThreadsA["ThreadID"]}' ORDER BY ABS(`MessageID`) DESC LIMIT 1");
						if (intval($DB->Num($LatestMessageQ)) > 0)
						{
							$LatestMessageA = $DB->Arr($LatestMessageQ);
							echo $Core->Cut($LatestMessageA["Message"], 0, 50);
						}
						else
						{
							echo "We cannot find a message related to this thread.";
						}
						//This snippet of code will get the latest message from the thread to display under the username.
						?>
					</div>
				</div>
				<?php
			}
		}
	}
	else
	{
		echo "You have no messages to display.";
	}
	echo $Amount;
}

ob_flush();
?>