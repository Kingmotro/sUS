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
	$ThreadID = (int) $_POST["sUS_MessagesReplyThreadID"];
	$Message = $_POST["sUS_MessagesReplyMessage"];
	$Error = null;
	
	if ($ThreadID)
	{
		if ($Message)
		{
			$ThreadQ = $DB->Query("SELECT * FROM `MessageThreads` WHERE `ThreadID` = '{$ThreadID}'");
			if (intval($DB->Num($ThreadQ)) > 0)
			{
				$ThreadA = $DB->Arr($ThreadQ);
				if (($ThreadA["ToID"] == $User->ID) XOR ($ThreadA["FromID"] == $User->ID))
				{
					$Error = null;
				}
				else
				{
					$Error = "You are not a part of this conversation.";
				}
			}
			else
			{
				$Error = "This thread does not exist.";
			}
		}
		else
		{
			$Error = "You must enter a message.";
		}
	}
	else
	{
		$Error = "Invalid thread ID specified.";
	}
	
	if (is_null($Error)==true)
	{
		if ($ThreadA["ToID"] == $User->ID) {
			$NewToID = (($ThreadA["FromID"] == $User->ID) ? $ThreadA["ToID"] : $ThreadA["FromID"]);
			$DB->Query("UPDATE `MessageThreads` SET `IsRead` = '0', `FromID` = '{$User->ID}', `ToID` = '{$NewToID}' WHERE `ThreadID` = '{$ThreadID}'");
		}
		
		$Messages->CreateMessage($ThreadID, (($ThreadA["ToID"] == $User->ID) ? $ThreadA["FromID"] : $ThreadA["ToID"]), $User->ID, $Message);
		
		echo "success";
	}
	else
	{
		echo $Error;
	}
}

ob_flush();
?>