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
	if (isset($_GET["ThreadID"])) {
		$ThreadID = (int) $_GET["ThreadID"];
		if ($Messages->Deleted($ThreadID)==false) {
			$ThreadQ = $DB->Query("SELECT * FROM `MessageThreads` WHERE (`ToID` = '{$User->ID}' OR `FromID` = '{$User->ID}') AND `ThreadID` = '{$ThreadID}'");
			if (intval($DB->Num($ThreadQ)) !== 0)
			{
				$ThreadA = $DB->Arr($ThreadQ); //May not be used, but it's here just in case. :)
				$FromID = ($ThreadA["ToID"] == $User->ID) ? $ThreadA["FromID"] : $ThreadA["ToID"];
				
				if ($ThreadA["ToID"] == $User->ID) {
					$DB->Query("UPDATE `MessageThreads` SET `IsRead` = '1' WHERE `ThreadID` = '{$ThreadID}'");
				}
				
				$MessagesQ = $DB->Query("SELECT * FROM `Messages` WHERE `ThreadID` = '{$ThreadID}' ORDER BY ABS(`MessageID`) DESC");
				if (intval($DB->Num($MessagesQ)) !== 0)
				{
					echo "<div class=\"pull-right\">
						<input type=\"hidden\" name=\"sUS_MessageThreadsID\" id=\"sUS_MessageThreadsID\" value=\"{$ThreadID}\" />
						<button type=\"button\" class=\"btn btn-danger btn-mini\" name=\"sUS_MessageThreadsDeleteConversation\" id=\"sUS_MessageThreadsDeleteConversation\"><i class=\"icon-trash icon-white\"></i> Delete Conversation</button>
						<a role=\"button\" data-toggle=\"modal\" href=\"#sUS_MessagesReplyDialog\" class=\"btn btn-success btn-mini\" name=\"sUS_MessageThreadsReply\" id=\"sUS_MessageThreadsReply\" style=\"outline: none;\"><i class=\"icon-pencil icon-white\"></i> Reply</a>
					</div>
					
					<div id=\"sUS_MessagesReplyDialog\" class=\"modal hide fade\" style=\"outline: none;\" tabindex=\"-1\" role=\"dialog\" aria-labelled=\"sUS_MessagesReplyLabel\" aria-hidden=\"true\">
						<div class=\"modal-header\">
							<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
							<h3 id=\"sUS_MessagesReplyLabel\">Reply to {$User->Get("Username", $FromID)}</h3>
						</div>
						<form method=\"post\" name=\"sUS_MessagesReplyForm\" id=\"sUS_MessagesReplyForm\" style=\"margin: 0;\">
							<input type=\"hidden\" name=\"sUS_MessagesReplyThreadID\" id=\"sUS_MessagesReplyThreadID\" value=\"{$ThreadID}\" />
							<div class=\"modal-body\">
								<div class=\"control-group\">
									<label for=\"sUS_MessagesReplyMessage\" class=\"control-label\">Message</label>
									<div class=\"controls\">
										<textarea id=\"sUS_MessagesReplyMessage\" name=\"sUS_MessagesReplyMessage\" style=\"height: 140px; width: 518px;\" placeholder=\"Enter a message to send&hellip;\"></textarea>
									</div>
								</div>
							</div>
							<div class=\"modal-footer\">
								<button type=\"button\" class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\"><i class=\"icon-remove\"></i> Close</button>
								<button type=\"submit\" class=\"btn btn-primary\" id=\"sUS_MessagesReplySubmit\" name=\"sUS_MessagesReplySubmit\"><i class=\"icon-ok icon-white\"></i> Send</button>
							</div>
						</form>
					</div>
					
					<div class=\"pull-left\">
						<h4>You and {$User->Get("Username", $FromID)}</h4>
					</div>
					<div class=\"clearfix\"></div>
					<hr />";
					
					while ($MessagesA = $DB->Arr($MessagesQ)) {
						?>
						<div class="media" style="display: block;">
							<a href="<?php echo $Core->GetString("URL"); ?>/profile/<?php echo $User->Get("Username", $MessagesA["FromID"]); ?>" class="pull-left">
								<img src="<?php echo $User->Get("Picture", $MessagesA["FromID"]); ?>" height="32" width="32" class="media-object" />
							</a>
							<div class="media-body">
								<h5 class="media-heading"><a href="<?php echo $Core->GetString("URL"); ?>/profile/<?php echo $User->Get("Username", $MessagesA["FromID"]); ?>"><?php echo $User->Get("Username", $MessagesA["FromID"]); ?></a></h5>
								<span style="font-size: 12px;"><?php echo $Core->Filter($MessagesA["Message"]); ?></span>
							</div>
						</div>
						<?php
					}
				}
				else
				{
					echo "We could not find any messages linked to this thread.";
				}
			}
			else
			{
				echo "We could not find this thread.";
			}
		}
	}
}

ob_flush();
?>