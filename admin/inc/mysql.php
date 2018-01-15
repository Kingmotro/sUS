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

if (($_SERVER["REQUEST_METHOD"] == "POST") && ($User->Get("UserID") == "1")) {
	$Host  = $_POST["sUS_AdminMySQLHost"];
	$Name  = $_POST["sUS_AdminMySQLDBName"];
	$User  = $_POST["sUS_AdminMySQLUser"];
	$Pass  = $_POST["sUS_AdminMySQLPass"];
	$Error = null;
	
	if ($Host)
	{
		if ($Name)
		{
			if ($User)
			{
				if ($Pass)
				{
					if (($Connect = @mysql_connect($Host, $User, $Pass)))
					{
						if (@mysql_select_db($Name, $Connect))
						{
							$Error = null;
						}
						else
						{
							$Error = "We could not find your database.";
						}
					}
					else
					{
						$Error = "We could not connect to your database.";
					}
				}
				else
				{
					$Error = "Please enter a password.";
				}
			}
			else
			{
				$Error = "Please enter a username.";
			}
		}
		else
		{
			$Error = "Please enter the name of your database.";
		}
	}
	else
	{
		$Error = "Please enter the location of your database.";
	}
	
	if (is_null($Error)==true)
	{
		//Update inc/global.php
		$Global = @file("../../inc/global.php");
		$Global = str_replace($DBGlobal["Host"], $Host, $Global);
		$Global = str_replace($DBGlobal["Name"], $Name, $Global);
		$Global = str_replace($DBGlobal["User"], $User, $Global);
		$Global = str_replace($DBGlobal["Pass"], $Pass, $Global);
		@file_put_contents("../../inc/global.php", $Global);
		//Update inc/global.php
				
		echo "The MySQL connection settings have been successfully updated!";
	}
	else
	{
		echo $Error;
	}
}

ob_flush();
?>