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
	$Current = $_POST["sUS_EditEmailCurrent"];
	$New1    = $_POST["sUS_EditEmailNew1"];
	$New2    = $_POST["sUS_EditEmailNew2"];
	$Error   = null;
	
	if ($Current)
	{
		if ($New1)
		{
			if ($New2)
			{
				if ($Current == $User->Get("Email"))
				{
					if ($New1 == $New2)
					{
						if (($User->ValidEmail($New1)) && ($User->ValidEmail($New2)))
						{
							$Error = null;
						}
						else
						{
							$Error = "Your email address is not valid. It must contain a '@' and '.'";
						}
					}
					else
					{
						$Error = "The two new email addresses you have entered do not match.";
					}
				}
				else
				{
					$Error = "The email address you have entered does not match the one linked to this account.";
				}
			}
			else
			{
				$Error = "You must verify your new email address.";
			}
		}
		else
		{
			$Error = "You must enter a new email address.";
		}
	}
	else
	{
		$Error = "You must enter your current email address.";
	}
	
	if (is_null($Error)==true)
	{
		$User->Update("Email", $New1);
		echo "success";
	}
	else
	{
		echo $Error;
	}
}
ob_flush();
?>