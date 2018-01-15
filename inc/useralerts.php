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

if ($User->LoggedIn) {
	$AlertsQ = $DB->Query("SELECT * FROM `UserAlerts` WHERE `ToID` = '{$User->ID}' AND `Displayed` = '0'");
	if (intval($DB->Num($AlertsQ)) > 0) {
		while ($AlertsA = mysql_fetch_array($AlertsQ)) {
			?>
			<div class="modal hide fade" id="sUS_UserAlert<?php echo $AlertsA["AlertID"]; ?>">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3><?php echo htmlspecialchars($AlertsA["Title"]); ?></h3>
				</div>
				<div class="modal-body">
					<p>
						<?php echo nl2br(htmlspecialchars($AlertsA["Message"])); ?>
						
						<br /><br />
						From <a href="<?php echo $Core->GetString("URL"); ?>/profile/<?php echo $User->Get("Username", $AlertsA["FromID"]); ?>"><?php echo $User->Get("Username", $AlertsA["FromID"]); ?></a>
					</p>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-primary" data-dismiss="modal"><i class="icon-ok icon-white"></i> OK!</a>
				</div>
			</div>
			<script type="text/javascript">
			$(function(){
				$("div#sUS_UserAlert<?php echo $AlertsA["AlertID"]; ?>").modal();
			});
			</script>
			<?php
			
			$DB->Query("UPDATE `UserAlerts` SET `Displayed` = '1' WHERE `AlertID` = '{$AlertsA["AlertID"]}'");
		}
	}
}

ob_flush();
?>