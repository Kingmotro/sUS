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
	$Title     = $_POST["sUS_AdminSiteSettingsTitle"];
	$URL       = $_POST["sUS_AdminSiteSettingsURL"];
	$Copyright = $_POST["sUS_AdminSiteSettingsCopyright"];
	$Email     = $_POST["sUS_AdminSiteSettingsEmail"];
	$Error     = null;
	
	if ($Title)
	{
		if ($URL)
		{
			if ($Copyright)
			{
				if ($Email && $User->ValidEmail($Email))
				{
					$Error = null;
				}
				else
				{
					$Error = "Please enter a valid email address.";
				}
			}
			else
			{
				$Copyright = "&copy; sUS " . date("Y");
			}
		}
		else
		{
			$Error = "Please enter a site URL.";
		}
	}
	else
	{
		$Error = "Please enter a site title.";
	}
	
	if (is_null($Error)==true)
	{
		//Update js/funcs.js
		$Funcs = @file("../../js/funcs.js");
		$Funcs = str_replace($Core->GetString("URL"), $URL, $Funcs);
		@file_put_contents("../../js/funcs.js", $Funcs);
		//Update js/funcs.js
		
		$DB->Query("UPDATE `System` SET `Title` = '{$Title}', `URL` = '{$URL}', `Copyright` = '{$Copyright}', `Email` = '{$Email}'");
		
		echo "The general site settings have been successfully updated!";
	}
	else
	{
		echo $Error;
	}
}

ob_flush();
?>