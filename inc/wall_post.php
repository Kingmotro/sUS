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
	$To      = $_POST["sUS_WallPostTo"];
	$From    = $User->ID;
	$Time    = time();
	$IP      = $_SERVER["REMOTE_ADDR"];
	$Message = $_POST["sUS_WallPostMessage"];
	$Error   = null;
	
	if ($To)
	{
		if ($From)
		{
			if ($Message)
			{
				$Error = null;
			}
			else
			{
				$Error = "You must enter a message to post to {$User->Get("Username", $To)}'s wall.";
			}
		}
		else
		{
			$Error = "An error occurred whilst trying to post to {$User->Get("Username", $To)}'s wall.";
		}
	}
	else
	{
		$Error = "An error occurred whilst trying to post to {$User->Get("Username", $To)}'s wall.";
	}
	
	if (is_null($Error)==true)
	{
		$DB->Insert("WallPosts", array("ToID"      => $To,
									   "FromID"    => $From,
									   "TimeStamp" => $Time,
									   "IPAddress" => $IP,
									   "Content"   => $Message));
		echo "success_{$To}";
	}
	else
	{
		echo $Error;
	}
}
ob_flush();
?>