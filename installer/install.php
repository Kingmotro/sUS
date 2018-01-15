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

include("../inc/class.core.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//MySQL
	$MySQL["Host"] = ($_POST["sUS_InstallerMySQLHost"]);
	$MySQL["User"] = ($_POST["sUS_InstallerMySQLUsername"]);
	$MySQL["Pass"] = ($_POST["sUS_InstallerMySQLPassword"]);
	$MySQL["Name"] = ($_POST["sUS_InstallerMySQLDBName"]);
	//MySQL

	//Admin
	$Admin["Username"] = ($_POST["sUS_InstallerAdminUsername"]);
	$Admin["Password"] = ($_POST["sUS_InstallerAdminPassword"]);
	$Admin["Email"]    = ($_POST["sUS_InstallerAdminEmail"]);
	$Admin["Gender"]   = ($_POST["sUS_InstallerAdminSex"]);
	$Admin["Date"]     = ($_POST["sUS_InstallerAdminDate"]);
	$Admin["Month"]    = ($_POST["sUS_InstallerAdminMonth"]);
	$Admin["Year"]     = ($_POST["sUS_InstallerAdminYear"]);
	$Admin["JoinDate"] = time();
	//Admin

	//Settings
	$Settings["Title"]     = ($_POST["sUS_InstallerSettingsTitle"]);
	$Settings["URL"]       = ($_POST["sUS_InstallerSettingsURL"]);
	$Settings["Copyright"] = ($_POST["sUS_InstallerSettingsCopyright"]);
	$Settings["Email"]     = ($_POST["sUS_InstallerSettingsEmail"]);
	$Settings["Hash"]      = ($_POST["sUS_InstallerSettingsHash"]);
	//Settings

	$Error = null;
	
	if ($MySQL["Host"])
	{
		if ($MySQL["User"])
		{
			if ($MySQL["Pass"])
			{
				if ($MySQL["Name"])
				{
					$MySQL["Connect"] = @mysql_connect($MySQL["Host"], $MySQL["User"], $MySQL["Pass"]);
					if ($MySQL["Connect"])
					{
						$MySQL["Link"] = @mysql_select_db($MySQL["Name"], $MySQL["Connect"]);
						if ($MySQL["Link"])
						{
							if ($Admin["Username"])
							{
								if (ctype_alnum($Admin["Username"]))
								{
									if (($Admin["Password"]) && (strlen($Admin["Password"]) >= 7))
									{
										if ($Admin["Email"] && filter_var($Admin["Email"], FILTER_VALIDATE_EMAIL))
										{
											if ($Settings["Title"])
											{
												if ($Settings["URL"])
												{
													if ($Settings["Copyright"])
													{
														if ($Settings["Email"] && filter_var($Settings["Email"], FILTER_VALIDATE_EMAIL))
														{
															if ($Settings["Hash"])
															{
																$Error = null;
															}
															else
															{
																$Error = "Please enter a random hash to use for passwords.";
															}
														}
														else
														{
															$Error = "You must enter a valid email address for the site configuration.";
														}
													}
													else
													{
														$Settings["Copyright"] = "&copy; sUS " . date("Y");
													}
												}
												else
												{
													$Error = "Please enter a URL for your site.";
												}
											}
											else
											{
												$Error = "Please enter a title for your site.";
											}
										}
										else
										{
											$Error = "You must enter a valid email address for your administrator account.";
										}
									}
									else
									{
										$Error = "Your password must be equal to or more than 7 characters.";
									}
								}
								else
								{
									$Error = "Your administrator username can only consist of numbers and letters.";
								}
							}
							else
							{
								$Error = "You must enter a username for your administrator account.";
							}
						}
						else
						{
							$Error = "An error occurred whilst connect to your MySQL database.";
						}
					}
					else
					{
						$Error = "The MySQL server configuration details you provided were invalid.";
					}
				}
				else
				{
					$Error = "Please provide the name of your database.";
				}
			}
			else
			{
				$Error = "Please enter the password to your MySQL account.";
			}
		}
		else
		{
			$Error = "Please enter the username of your MySQL account.";
		}
	}
	else
	{
		$Error = "Please enter the host of your MySQL database.";
	}
	
	if (!is_writable("../inc/global.php")) { //If this file is not writable, we will not be able to store the MySQL details.
		//chmod("../inc/global.php", 0777);
		$Error = "Your 'inc/global.php' is not writable, please change the permissions to '777'.";
	}
	
	if (!is_writable("../img/avatars")) { //If this directory is not writable, people will not be able to upload their own avatars.
		$Error = "Your 'img/avatars/' directory is not writable, please change the permissions to '777'.";
	}
	
	if (!is_writable("../js/funcs.js")) { //If this file is not writable, the string 'sUS_JSURL' won't be replaced with the URL the user provides in the 'Settings' tab.
		$Error = "Your 'js/funcs.js' file is not writable, please change the permissions to '777'.";
	}

	if (is_null($Error)==true)
	{
		$ConfigFile = @file_get_contents("global.php");
		$ConfigFile = str_replace("sUS_DBHost", $MySQL["Host"], $ConfigFile);
		$ConfigFile = str_replace("sUS_DBUser", $MySQL["User"], $ConfigFile);
		$ConfigFile = str_replace("sUS_DBPass", $MySQL["Pass"], $ConfigFile);
		$ConfigFile = str_replace("sUS_DBName", $MySQL["Name"], $ConfigFile);
		$ConfigFile = str_replace("sUS_SettingsHash", $Settings["Hash"], $ConfigFile);
		@file_put_contents("../inc/global.php", $ConfigFile);
		
		$JSFile = @file_get_contents("../js/funcs.js");
		$JSFile = str_replace("sUS_JSURL", $Settings["URL"], $JSFile);
		@file_put_contents("../js/funcs.js", $JSFile);
		
		$sUS_MySQL = @file("sUS_MySQL.sql");
		
		foreach ($sUS_MySQL as $SQL_Line) {
			@mysql_query(trim($SQL_Line));
		}
		
		$Admin["UnixBirth"] = mktime(0, 0, 0, $Admin["Month"], $Admin["Date"], $Admin["Year"]);
		$Admin["Password"]  = $Core->Hash($Admin["Password"]);
		
		@mysql_query("INSERT INTO `Users` (`Username`, `Password`, `Email`, `JoinDate`, `RegIP`, `Sex`, `BirthDate`, `Rank`, `Picture`) VALUES ('{$Admin["Username"]}', '{$Admin["Password"]}', '{$Admin["Email"]}', '{$Admin["JoinDate"]}', '{$_SERVER["REMOTE_ADDR"]}', '{$Admin["Gender"]}', '{$Admin["UnixBirth"]}', 'Administrator', '{$Settings["URL"]}/img/avatars/default_{$Admin["Gender"]}.png')");
		@mysql_query("INSERT INTO `System` (`Title`, `Copyright`, `URL`, `Email`) VALUES ('{$Settings["Title"]}', '{$Settings["Copyright"]}', '{$Settings["URL"]}', '{$Settings["Email"]}')");
		
		echo "success";
	}
	else
	{
		echo $Error;
	}
}
?>