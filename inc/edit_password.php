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
	$Current = $_POST["sUS_EditPasswordCurrent"];
	$New1    = $_POST["sUS_EditPasswordNew1"];
	$New2    = $_POST["sUS_EditPasswordNew2"];
	$Error   = null;
	
	if ($Current)
	{
		if ($New1)
		{
			if ($New2)
			{
				if ($Core->Hash($Current) == $User->Get("Password"))
				{
					if ($Core->Hash($New1) == $Core->Hash($New2))
					{
						if (($User->ValidPassword($New1)) && ($User->ValidPassword($New2)))
						{
							$Error = null;
						}
						else
						{
							$Error = "Your password is not valid. It must be between 7 and 30 characters long.";
						}
					}
					else
					{
						$Error = "The two new passwords you have entered do not match.";
					}
				}
				else
				{
					$Error = "The password you have entered does not match the one linked to this account.";
				}
			}
			else
			{
				$Error = "You must verify your new password.";
			}
		}
		else
		{
			$Error = "You must enter a new password.";
		}
	}
	else
	{
		$Error = "You must enter your current password.";
	}
	
	if (is_null($Error)==true)
	{
		$User->Update("Password", $Core->Hash($New1));
		//Generate and send email
		$subject = "Password Changed at {$Core->GetString("Title")}";
		
		$message = "Hello {$User->Name}!<br /><br />You are receiving this email because you have successfully changed your password at {$Core->GetString("Title")}!<br /><br />If you did not make this change, we recommend you <a href=\"{$Core->GetString("URL")}/contact.php\" target=\"_blank\">contact us</a>.<br /><br />Best wishes,<br />{$Core->GetString("Title")} Administration Team.";
		
		$Core->Email($User->Get("Email"), $subject, $message);
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