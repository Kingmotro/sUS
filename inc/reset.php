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
	$Email = $_POST["sUS_ResetFormEmail"];
	$Error = null;
	
	if ($Email)
	{
		if ($User->EmailExists($Email))
		{
			$Error = null;
		}
		else
		{
			$Error = "No account exists with this email address.";
		}
	}
	else
	{
		$Error = "Please provide your email address.";
	}
	
	if (is_null($Error)==true)
	{
		$Key = $Core->RandomString();
		$DB->Insert("PasswordReset", array("ResetKey"  => $Key,
										   "Email"     => $Email,
										   "TimeStamp" => time(),
										   "IPAddress" => $_SERVER["REMOTE_ADDR"]));
		
		//Generate and send email
		$subject = "Password Reset at {$Core->GetString("Title")}";
		
		$ResetNameQ = $DB->Query("SELECT * FROM `Users` WHERE `Email` = '{$Email}'");
		$ResetNameA = $DB->Arr($ResetNameQ);
		
		$message = "Hello {$ResetNameA["Username"]}!<br /><br />You are receiving this email because you have requested a password reset at {$Core->GetString("Title")}.<br /><br />To reset your password, click the link below:<br /><a href=\"{$Core->GetString("URL")}/reset_submit.php?k={$Key}\" target=\"_blank\">{$Core->GetString("URL")}/reset_submit.php?k={$Key}</a><br /><br />Best wishes,<br />{$Core->GetString("Title")} Administration Team.";
		
		$Core->Email($Email, $subject, $message);
		//Generate and send email
		echo "success";
	}
	else
	{
		echo $Error;
	}
}
ob_flush();
?>