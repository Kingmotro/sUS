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
include_once("../../inc/global.php");

if (($_SERVER["REQUEST_METHOD"] == "POST") && ($User->Get("Rank") == "Administrator")) {
	$To      = $_POST["sUS_AdminAlertUserTo"];
	$Title   = $_POST["sUS_AdminAlertUserTitle"];
	$Message = $_POST["sUS_AdminAlertUserMessage"];
	$Error   = null;
	
	if ($To)
	{
		if ($User->Exists($To))
		{
			if ($Title)
			{
				if ($Message)
				{
					$Error  = null;
					$ToName = $User->Get("Username", $To);
					$ToID   = $User->Get("UserID", $To);
				}
				else
				{
					$Error = "Please enter a message to be shown to {$To}.";
				}
			}
			else
			{
				$Error = "Please enter a title for the alert.";
			}
		}
		else
		{
			$Error = "The user \"{$To}\" does not exist.";
		}
	}
	else
	{
		$Error = "You must select a user to send this alert to.";
	}
	
	if (is_null($Error)==true)
	{
		$DB->Insert("UserAlerts", array("ToID"      => $ToID,
										"FromID"    => $User->ID,
										"Title"     => $Title,
										"Message"   => $Message,
										"IPAddress" => $_SERVER["REMOTE_ADDR"],
										"TimeStamp" => time()));
				
		echo "success";
	}
	else
	{
		echo $Error;
	}
}

ob_flush();
?>