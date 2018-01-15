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
	$Username = $_POST["sUS_AdminAddUserUsername"];
	$Password = $_POST["sUS_AdminAddUserPassword"];
	$Email    = $_POST["sUS_AdminAddUserEmail"];
	$Gender   = $_POST["sUS_AdminAddUserGender"];
	$Rank     = $_POST["sUS_AdminAddUserRank"];
	$Date     = $_POST["sUS_AdminAddUserDate"];
	$Month    = $_POST["sUS_AdminAddUserMonth"];
	$Year     = $_POST["sUS_AdminAddUserYear"];
	$IP       = $_SERVER["REMOTE_ADDR"];
	$JoinDate = time();
	$Error    = null;
	
	if ($Username)
	{
		if (ctype_alnum($Username))
		{
			if (!$User->Exists($Username))
			{
				if ($Password && $User->ValidPassword($Password))
				{
					if ($Email)
					{
						if ($User->ValidEmail($Email))
						{
							if (!$User->EmailExists($Email))
							{
								if ($Gender)
								{
									if ($Rank)
									{
										if ($Date && $Month && $Year)
										{
											$Error    = null;
											$Unix     = mktime(0, 0, 0, $Month, $Date, $Year);
											$Password = $Core->Hash($Password);
											$Picture  = $Core->GetString("URL") . "/img/avatars/default_{$Gender}.png";
										}
										else
										{
											$Error = "Please provide the date of birth of the new user.";
										}
									}
									else
									{
										$Error = "Please provide the rank of the new user.";
									}
								}
								else
								{
									$Error = "Please provide the gender of the new user.";
								}
							}
							else
							{
								$Error = "Someone has already used the email address \"{$Email}\".";
							}
						}
						else
						{
							$Error = "The email address must contain the '@' and '.' characters.";
						}
					}
					else
					{
						$Error = "Please enter an email address.";
					}
				}
				else
				{
					$Error = "The password must be equal to or more than 7 characters.";
				}
			}
			else
			{
				$Error = "Someone has already taken the username \"{$Username}\".";
			}
		}
		else
		{
			$Error = "The username can only contain letters and numbers.";
		}
	}
	else
	{
		$Error = "Please provide a username for the new user.";
	}
	
	if (is_null($Error)==true)
	{
		$DB->Query("INSERT INTO `Users` (`Username`, `Password`, `Email`, `Picture`, `JoinDate`, `RegIP`, `Sex`, `Rank`, `BirthDate`) VALUES ('{$Username}', '{$Password}', '{$Email}', '{$Picture}', '{$JoinDate}', '{$IP}', '{$Gender}', '{$Rank}', '{$Unix}')");
		echo "The user \"{$Username}\" has been successfully added!";
	}
	else
	{
		echo $Error;
	}
}
ob_flush();
?>