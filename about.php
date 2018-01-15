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
define("CURRENT_PAGE", "ABOUT");
include_once("inc/global.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>About &middot; <?php echo $Core->GetString("Title"); ?></title>
	<?php include_once("inc/inc.head.php"); ?>
</head>

<body>
	<div id="drop_down_bar">&nbsp;</div>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="brand" href="<?php echo $Core->GetString("URL"); ?>/index.php"><?php echo $Core->GetString("Title"); ?></a>
				<div class="nav-collapse collapse">
					<?php include_once("inc/inc.navigation.php"); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span3">
				<div class="well">
					<?php include_once("inc/inc.sidebar.php"); ?>
				</div>
			</div>
			
			<div class="span9 well">
				<div class="page-header">
					<h1>About <small><?php echo $Core->GetString("Title"); ?></small></h1>
				</div>
				
				<p>
					<?php echo $Core->GetString("Title"); ?> is a simple usersystem developed in <abbr title="Object Oriented Programming">OOP</abbr> <abbr title="Hypertext PreProcessor">PHP</abbr> powered by <a href="http://www.mark-eriksson.com/projects/sUS" target="_blank">sUS</a>.
				</p>
				
				<p>
					This is free software and can be modified. Credits aren't required but are appreciated.
				</p>
				
				<p>
					This software also makes full use of the <a href="http://www.twitter.github.com/bootstrap/" target="_blank">Bootstrap</a> and <a href="http://www.jquery.com">jQuery</a> framework libraries, so credits to their developers.
				</p>
			</div>
		</div>

		<hr />

		<footer>
			<?php include_once("inc/inc.footer.php"); ?>
		</footer>
	</div>
	
	<?php include_once("inc/inc.scripts.php"); ?>
	<?php require_once(SUS_INCLUDES . "/useralerts.php"); ?>
</body>
</html>
<?php
ob_flush();
?>