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

if (($_SERVER["REQUEST_METHOD"] == "POST") && ($User->LoggedIn == true)) {
	$To        = $_POST["sUS_MessagesNewTo"];
	$Message   = $_POST["sUS_MessagesNewMessage"];
	$TimeStamp = time();
	$Error     = null;
	
	if ($To)
	{
		if ($User->Exists($To))
		{
			$ToID = $User->Get("UserID", $To);
			if ($Message)
			{
				$Error = null;
			}
			else
			{
				$Error = "Please enter a message to send to {$User->Get("Username", $ToID)}.";
			}
		}
		else
		{
			$Error = "The user \"{$To}\" does not exist.";
		}
	}
	else
	{
		$Error = "Please choose a user to send the message to.";
	}
	
	if (is_null($Error)==true)
	{
		$ThreadQ = $DB->Query("SELECT * FROM `MessageThreads` WHERE (`ToID` = '{$User->ID}' AND `FromID` = '{$ToID}') OR (`ToID` = '{$ToID}' AND `FromID` = '{$User->ID}')");
		$CreateNewThread = (intval($DB->Num($ThreadQ)) == 0) ? true : false;
		
		if ($CreateNewThread==true)
		{
			$Messages->ComposeThread($ToID, $User->ID); //Create the thread
			
			//Get new thread details.
			$NewThreadQ  = $DB->Query("SELECT * FROM `MessageThreads` ORDER BY ABS(`ThreadID`) DESC LIMIT 1");
			$NewThreadA  = $DB->Arr($NewThreadQ);
			$NewThreadID = $NewThreadA["ThreadID"];
			//Get new thread details.
			
			$Messages->CreateMessage($NewThreadID, $ToID, $User->ID, $Message); //Insert the message into the database and link to newly created thread ID.
		}
		else
		{
			$ThreadA = $DB->Arr($ThreadQ);
			
			if ($ToID !== $User->ID) $DB->Query("UPDATE `MessageThreads` SET `IsRead` = '0' WHERE `ThreadID` = '{$ThreadA["ThreadID"]}'");
			
			$Messages->CreateMessage($ThreadA["ThreadID"], $ToID, $User->ID, $Message); //Insert the message into the database and link to newly created thread ID.
			
			$DB->Query("UPDATE `MessageThreads` SET `LastMessageTime` = '{$TimeStamp}' WHERE `ThreadID` = '{$ThreadA["ThreadID"]}'");
		}
		echo "success";
	}
	else
	{
		echo $Error;
	}
}

ob_flush();
?>