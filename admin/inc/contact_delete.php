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
	$ContactID = (int) $_POST["ContactID"];
	$Error     = null;
	
	if ($ContactID)
	{
		$ContactQ = $DB->Query("SELECT * FROM `Contact` WHERE `ContactID` = '{$ContactID}'");
		if (intval($DB->Num($ContactQ)) > 0)
		{
			$Error = null;
		}
		else
		{
			$Error = "This contact submission no longer exists.";
		}
	}
	else
	{
		$Error = "You must specify a contact submission to delete.";
	}
	
	if (is_null($Error)==true)
	{
		$DB->Query("DELETE FROM `Contact` WHERE `ContactID` = '{$ContactID}'");
		echo "success";
	}
	else
	{
		echo $Error;
	}
}

ob_flush();
?>