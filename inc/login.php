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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$Username = $_POST["sUS_LoginFormUsername"];
	$Password = $_POST["sUS_LoginFormPassword"];
	$Error    = null;

	if ($Username)
	{
		if ($Password)
		{
			if (!$User->IsBanned($Username))
			{
				if ($User->Exists($Username))
				{
					if ($Core->Hash($Password) == $User->Get("Password", $Username))
					{
						$Error = null;
					}
					else
					{
						$Error = "The password you entered was incorrect.";
					}
				}
				else
				{
					$Error = "The user \"{$Username}\" does not exist.";
				}
			}
			else
			{
				$Error = "Sorry, it would appear that your account has been banned!";
			}
		}
		else
		{
			$Error = "Please enter your password.";
		}
	}
	else
	{
		$Error = "Please enter your username.";
	}
	
	if (is_null($Error)==true)
	{
		$User->Name     = $User->Get("Username", $Username);
		$User->ID       = $User->Get("UserID", $Username);
		$User->LoggedIn = true;
		$User->Update("LastIP", $_SERVER["REMOTE_ADDR"]);
		$User->Update("LastVisit", time());
		setcookie("sUS_UserID", $User->ID, (time() + 60 * 60 * 24 * 5), '/', (str_replace("www.", "", $_SERVER["SERVER_NAME"])));
		setcookie("sUS_Security", md5($_SERVER["REMOTE_ADDR"]), (time() + 60 * 60 * 24 * 5), '/', (str_replace("www.", "", $_SERVER["SERVER_NAME"])));
		setcookie("sUS_Password", md5($Core->Hash($Password)), (time() + 60 * 60 * 24 * 5), '/', (str_replace("www.", "", $_SERVER["SERVER_NAME"])));
		echo "success";
	}
	else
	{
		echo $Error;
	}
}
ob_flush();
?>