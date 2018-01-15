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
	$Email     = $_POST["sUS_ResetKeyFormEmail"];
	$Password1 = $_POST["sUS_ResetKeyFormPassword1"];
	$Password2 = $_POST["sUS_ResetKeyFormPassword2"];
	$Key       = $_POST["sUS_ResetKeyFormKey"];
	$Error     = null;
	
	if ($Email)
	{
		if ($Password1)
		{
			if ($Password2)
			{
				if (($User->ValidPassword($Password1)) && ($User->ValidPassword($Password2)))
				{
					if ($Key)
					{
						$KeyCheckQ = $DB->Query("SELECT * FROM `PasswordReset` WHERE `ResetKey` = '{$Key}'");
						if (intval($DB->Num($KeyCheckQ)) > 0 )
						{
							$KeyCheckA = $DB->Arr($KeyCheckQ);
							if ($Email == $KeyCheckA["Email"])
							{
								if (md5($Password1) == md5($Password2))
								{
									$Error = null;
								}
								else
								{
									$Error = "The two passwords you have entered do not match.";
								}
							}
							else
							{
								$Error = "You have entered an invalid email address.";
							}
						}
						else
						{
							$Error = "It appears you have not requested a password reset.";
						}
					}
					else
					{
						$Error = "An error occurred whilst trying to reset your password.";
					}
				}
				else
				{
					$Error = "Your new password is not valid. It must be between 7 and 30 characters long.";
				}
			}
			else
			{
				$Error = "Please verify your new password.";
			}
		}
		else
		{
			$Error = "Please enter a new password.";
		}
	}
	else
	{
		$Error = "Please enter your email address.";
	}
	
	if (is_null($Error)==true)
	{
		$PasswordHash = $Core->Hash($Password1);
		$DB->Query("UPDATE `Users` SET `Password` = '{$PasswordHash}' WHERE `Email` = '{$Email}'");
		$DB->Query("DELETE FROM `PasswordReset` WHERE `ResetKey` = '{$Key}'"); //Delete the key from the PasswordReset database so no one else can change the password.
		
		//Generate and send email
		$subject = "Password Changed at {$Core->GetString("Title")}";
		
		$ResetNameQ = $DB->Query("SELECT * FROM `Users` WHERE `Email` = '{$Email}'");
		$ResetNameA = $DB->Arr($ResetNameQ);
		
		$message = "Hello {$ResetNameA["Username"]}!<br /><br />You are receiving this email because you have successfully reset your password at {$Core->GetString("Title")}!<br /><br />If you did not make this change, we recommend you <a href=\"{$Core->GetString("URL")}/contact.php\" target=\"_blank\">contact us</a>.<br /><br />Best wishes,<br />{$Core->GetString("Title")} Administration Team.";
		
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