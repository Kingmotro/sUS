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
	$Username     = $_POST["sUS_RegisterFormUsername"];
	$Password1    = $_POST["sUS_RegisterFormPassword1"];
	$Password2    = $_POST["sUS_RegisterFormPassword2"];
	$Email        = $_POST["sUS_RegisterFormEmail"];
	$Sex          = $_POST["sUS_RegisterFormSex"];
	$DOB["Date"]  = $_POST["sUS_RegisterFormDate"];
	$DOB["Month"] = $_POST["sUS_RegisterFormMonth"];
	$DOB["Year"]  = $_POST["sUS_RegisterFormYear"];
	$Error        = null;
	
	if ($Username)
	{
		if (ctype_alnum($Username) || $User->NameBlocked($Username))
		{
			if ($Password1)
			{
				if ($Password2)
				{
					if ($Core->Hash($Password1) == $Core->Hash($Password2))
					{
						if ($Email)
						{
							if ($User->ValidEmail($Email))
							{
								if ($User->ValidPassword($Password1) && $User->ValidPassword($Password2))
								{
									if (!$User->Exists($Username))
									{
										if (!$User->EmailExists($Email))
										{
											$Error = null; //EVERYTHING HAS PASSED, WOO.
										}
										else
										{
											$Error = "Somebody has already used that email address.";
										}
									}
									else
									{
										$Error = "Somebody has already used the username \"{$Username}\".";
									}
								}
								else
								{
									$Error = "Your password is not valid. It must be between 7 and 30 characters long.";
								}
							}
							else
							{
								$Error = "Your email address is not valid. It must contain a '@' and '.'";
							}
						}
						else
						{
							$Error = "You must enter your email address.";
						}
					}
					else
					{
						$Error = "The two passwords you entered do not match.";
					}
				}
				else
				{
					$Error = "You must verify your password.";
				}
			}
			else
			{
				$Error = "You must enter a password.";
			}
		}
		else
		{
			$Error = "Your username can only consist of letters and numbers.";
		}
	}
	else
	{
		$Error = "You must enter a username.";
	}
	
	if (is_null($Error)==true)
	{
		$DOB["Unix"] = mktime(0, 0, 0, $DOB["Month"], $DOB["Date"], $DOB["Year"]);
		
		$Picture = $Core->GetString("URL") . "/img/avatars/default_{$Sex}.png";
		
		$User->Create($Username, $Core->Hash($Password1), $Email, $Sex, $DOB["Unix"], $Picture, $_SERVER["REMOTE_ADDR"], time());
		echo "success";
	}
	else
	{
		echo $Error;
	}
}
ob_flush();
?>