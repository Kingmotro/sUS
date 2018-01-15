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

define("SUS_INCLUDES", dirname(__FILE__));

//MySQL Database details.
$DBGlobal["Host"] = "sUS_DBHost";
$DBGlobal["Name"] = "sUS_DBName";
$DBGlobal["User"] = "sUS_DBUser";
$DBGlobal["Pass"] = "sUS_DBPass";
//MySQL Database details.

//Site Settings.
$SiteSettings["Hash"]    = "sUS_SettingsHash";
$SiteSettings["Version"] = "1.0.0";
//Site Settings.

date_default_timezone_set("Europe/London");

require_once(SUS_INCLUDES . "/class.mysql.php");
require_once(SUS_INCLUDES . "/class.core.php");
require_once(SUS_INCLUDES . "/class.user.php");
require_once(SUS_INCLUDES . "/class.messaging.php");

foreach ($_POST as $k => $v) {
	return $DB->Clean($_POST[$k]);
}
foreach ($_GET as $k => $v) {
	return $DB->Clean($_GET[$k]);
}

if (file_exists("installer/")) {
	die("Please delete <code>installer/</code>");
}

ob_flush();
?>