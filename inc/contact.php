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
	$Name    = $_POST["sUS_ContactName"];
	$Email   = $_POST["sUS_ContactEmail"];
	$Subject = $_POST["sUS_ContactSubject"];
	$Message = $_POST["sUS_ContactMessage"];
	$IP      = $_SERVER["REMOTE_ADDR"];
	$Time    = time();
	$Error   = null;
	
	if ($Name)
	{
		if ($Email)
		{
			if ($User->ValidEmail($Email)==true)
			{
				if ($Subject)
				{
					if ($Message)
					{
						$Error = null;
					}
					else
					{
						$Error = "You must enter a message to send to us.";
					}
				}
				else
				{
					$Error = "Please tell us why you are contacting us.";
				}
			}
			else
			{
				$Error = "You must enter a valid email address.";
			}
		}
		else
		{
			$Error = "Please enter your email address or we can't contact you back.";
		}
	}
	else
	{
		$Error = "Please tell us your name so we know how to address you.";
	}
	
	if (is_null($Error)==true)
	{
		$DB->Insert("Contact", array("Name"      => $Name,
									 "Email"     => $Email,
									 "Subject"   => $Subject,
									 "Message"   => $Message,
									 "IPAddress" => $IP,
									 "TimeStamp" => $Time));
		echo "success";
	}
	else
	{
		echo $Error;
	}
}
ob_flush();
?>