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
	$Gender       = $_POST["sUS_EditProfileGender"];
	$DOB["Date"]  = $_POST["sUS_EditProfileDate"];
	$DOB["Month"] = $_POST["sUS_EditProfileMonth"];
	$DOB["Year"]  = $_POST["sUS_EditProfileYear"];
	$Location     = $_POST["sUS_EditProfileLocation"];
	$Music        = $_POST["sUS_EditProfileMusic"];
	$Movies       = $_POST["sUS_EditProfileMovies"];
	$Website      = $_POST["sUS_EditProfileWebsite"];
	$Facebook     = $_POST["sUS_EditProfileFacebook"];
	$Twitter      = $_POST["sUS_EditProfileTwitter"];
	$Xbox         = $_POST["sUS_EditProfileXbox"];
	$PS3          = $_POST["sUS_EditProfilePS3"];
	$Error        = null;
	
	if ($Gender)
	{
		if ($DOB["Date"] && $DOB["Month"] && $DOB["Year"])
		{
			$Error = null;
		}
		else //Not even sure if this would be possible since they're select boxes, but hey, how knows?!
		{
			$Error = "Please provide your date of birth.";
		}
	}
	else //Not even sure if this would be possible since they're select boxes, but hey, how knows?!
	{
		$Error = "Please tell us your gender.";
	}
	
	if (is_null($Error)==true) //I don't even know if there can be an error with this, but whatever...
	{
		$DOB["Unix"] = mktime(0, 0, 0, $DOB["Month"], $DOB["Date"], $DOB["Year"]);
		$User->Update("Sex", $Gender);
		$User->Update("BirthDate", $DOB["Unix"]);
		$User->Update("Location", $Location);
		$User->Update("Music", $Music);
		$User->Update("Movies", $Movies);
		$User->Update("Website", (str_replace("http://", "", str_replace("www.", "", $Website))));
		$User->Update("Facebook", $Facebook);
		$User->Update("Twitter", $Twitter);
		$User->Update("Xbox", $Xbox);
		$User->Update("PS3", $PS3);
		echo "success";
	}
	else
	{
		echo $Error;
	}
}
ob_flush();
?>