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
include_once("inc/global.php");

setcookie("sUS_UserID", "", (time() - 60 * 60 * 24 * 5), '/', (str_replace("www.", "", $_SERVER["SERVER_NAME"])));
setcookie("sUS_Security", "", (time() - 60 * 60 * 24 * 5), '/', (str_replace("www.", "", $_SERVER["SERVER_NAME"])));
setcookie("sUS_Password", "", (time() - 60 * 60 * 24 * 5), '/', (str_replace("www.", "", $_SERVER["SERVER_NAME"])));
header("Location: {$Core->GetString("URL")}/index.php");
ob_flush();
?>