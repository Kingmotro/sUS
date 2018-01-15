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
	$UserEdit     = $_POST["sUS_AdminEditUserUserID"];
	$Username     = $_POST["sUS_AdminEditUserUsername"];
	$Password     = $_POST["sUS_AdminEditUserPassword"];
	$Email        = $_POST["sUS_AdminEditUserEmail"];
	$Rank         = $_POST["sUS_AdminEditUserRank"];
	$Banned       = $_POST["sUS_AdminEditUserBanned"];
	$Gender       = $_POST["sUS_AdminEditUserGender"];
	$DOB["Date"]  = $_POST["sUS_AdminEditUserDate"];
	$DOB["Month"] = $_POST["sUS_AdminEditUserMonth"];
	$DOB["Year"]  = $_POST["sUS_AdminEditUserYear"];
	$Location     = $_POST["sUS_AdminEditUserLocation"];
	$Music        = $_POST["sUS_AdminEditUserMusic"];
	$Movies       = $_POST["sUS_AdminEditUserMovies"];
	$Website      = $_POST["sUS_AdminEditUserWebsite"];
	$Facebook     = $_POST["sUS_AdminEditUserFacebook"];
	$Twitter      = $_POST["sUS_AdminEditUserTwitter"];
	$Xbox         = $_POST["sUS_AdminEditUserXbox"];
	$PS3          = $_POST["sUS_AdminEditUserPS3"];
	$Error        = null;
	
	if ($Username)
	{
		if (ctype_alnum($Username))
		{
			if (($Username == $User->Get("Username", $UserEdit)) XOR !$User->Exists($Username))
			{
				if (($Email == $User->Get("Email", $UserEdit)) XOR !$User->EmailExists($Email))
				{
					if ($User->ValidEmail($Email))
					{
						if (!$Password)
						{
							$Error = null;
						}
						else
						{
							if ($User->ValidPassword($Password))
							{
								$Error = null;
							}
							else
							{
								$Error = "The password must be equal to or more than 7 characters.";
							}
						}
					}
					else
					{
						$Error = "The email address must consist of an '@' and a '.' character";
					}
				}
				else
				{
					$Error = "Someone has already taken the email address \"{$Email}\".";
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
		$Error = "Please provide a username.";
	}
	
	if (is_null($Error)==true)
	{
		$Unix = mktime(0, 0, 0, $DOB["Month"], $DOB["Date"], $DOB["Year"]);
		
		$User->Update("Username", $Username, $UserEdit);
		if ($Password) { $User->Update("Password", $Core->Hash($Password), $UserEdit); }
		$User->Update("Email", $Email, $UserEdit);
		$User->Update("Rank", $Rank, $UserEdit);
		$User->Update("Banned", $Banned, $UserEdit);
		$User->Update("Sex", $Gender, $UserEdit);
		$User->Update("BirthDate", $Unix, $UserEdit);
		$User->Update("Location", $Location, $UserEdit);
		$User->Update("Music", $Music, $UserEdit);
		$User->Update("Movies", $Movies, $UserEdit);
		$User->Update("Website", (str_replace("http://", "", str_replace("www.", "", $Website))), $UserEdit);
		$User->Update("Facebook", $Facebook, $UserEdit);
		$User->Update("Twitter", $Twitter, $UserEdit);
		$User->Update("Xbox", $Xbox, $UserEdit);
		$User->Update("PS3", $PS3, $UserEdit);
		
		echo "{$Username}'s information has been successfully updated!";
	}
	else
	{
		echo $Error;
	}
}
ob_flush();
?>