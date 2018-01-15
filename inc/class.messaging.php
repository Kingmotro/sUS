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

class sUS_Messaging {
	public $Unread = 0;
	public $Amount = 0;

	/**
	 * This function will initialise the messaging class, setting $Unread to how many unread messages a user has, and setting $Amount to how many messages a user has in total.
	 * @global  $DB  class  Import the DB class to be able to gain access to the database.
	 * @global  $User  class  Import the User class to be able to get information from a user.
	 */
	public function __construct(){
		global $DB, $User;
		
		if ($User->LoggedIn) {
			$this->Unread = intval($DB->Num($DB->Query("SELECT * FROM `MessageThreads` WHERE `ToID` = '{$User->ID}' AND `IsRead` = '0'")));
			
			$AllMessagesQ = $DB->Query("SELECT * FROM `MessageThreads` WHERE `ToID` = '{$User->ID}' OR `FromID` = '{$User->ID}'");
			if (intval($DB->Num($AllMessagesQ)) !== 0) {
				while ($AllMessagesA = mysql_fetch_array($AllMessagesQ)) {
					if (!$this->Deleted($AllMessagesA["ThreadID"])) {
						$this->Amount++;
					}
				}
			}
			
			//$this->Amount = intval($DB->Num($DB->Query("SELECT * FROM `MessageThreads` WHERE `ToID` = '{$User->ID}' OR `FromID` = '{$User->ID}'")));
		}
	}
	
	/**
	 * This function will delete a thread along with all of it's messages.
	 * @param  $threadid  int  The ID of the thread to delete.
	 * @global  $DB  class  Import the DB class to be able to gain access to the database.
	 * @global  $User  class  Import the User class to be able to get information from a user.
	 */
	public function Delete($threadid) {
		global $DB, $User;
		
		$ThreadQ = $DB->Query("SELECT * FROM `MessageThreads` WHERE `ThreadID` = '{$threadid}'");
		if (intval($DB->Num($ThreadQ)) > 0) {
			$ThreadA = $DB->Arr($ThreadQ);
			if ($this->Deleted($threadid))
			{
				return false;
			}
			else
			{
				$DeletedCurrent = $ThreadA["Deleted"];
				$Deleted = $DeletedCurrent . $User->ID . ";";
				$DB->Query("UPDATE `MessageThreads` SET `Deleted` = '{$Deleted}' WHERE `ThreadID` = '{$threadid}'");
				return true;
			}
		}
		return false;
	}
	
	/**
	 * This function will determine who has deleted a conversation between 2 people.
	 * @param  $threadid  int  The ID of the thread to see who has deleted it.
	 * @global  $DB  class  Import the DB class to be able to gain access to the database.
	 * @global  $User  class  Import the User class to be able to get information from a user.
	 */
	public function Deleted($threadid) {
		global $DB, $User;
		
		$ThreadQ = $DB->Query("SELECT * FROM `MessageThreads` WHERE `ThreadID` = '{$threadid}'");
		if (intval($DB->Num($ThreadQ)) > 0) {
			$ThreadA = $DB->Arr($ThreadQ);
			$Deleted = $ThreadA["Deleted"];
			if (strlen($Deleted) == 0)
			{
				return false;
			}
			else
			{
				$WhoDeleted = explode(";", $Deleted);
				
				if (in_array($User->ID, $WhoDeleted)) {
					return true;
				}
			}
		}
	}
	
	/**
	 * This function will compose a threaded conversation between two members.
	 * @param  $to  int  First person who the thread is between.
	 * @param  $from  int  Second person who the thread is between.
	 * @global  $DB  class  Import the DB class to be able to gain access to the database.
	 * @global  $User  class  Import the User class to be able to get information from a user.
	 */
	public function ComposeThread($to, $from) {
		global $DB, $User;
		
		if ($User->LoggedIn) {
			$ThreadQ = $DB->Query("SELECT * FROM `MessageThreads` WHERE (`ToID` = '{$to}' AND `FromID` = '{$from}') OR (`ToID` = '{$from}' AND `FromID` = '{$to}')");
			
			if (intval($DB->Num($ThreadQ)) == 0)
			{
				$TimeStamp = time();
				$DB->Insert("MessageThreads", array("TimeStamp"       => $TimeStamp,
													"LastMessageTime" => $TimeStamp,
													"ToID"            => $to,
													"FromID"          => $from));
			}
		}
	}
	
	/**
	 * This function will create a message between two users and link it to a specific thread.
	 * @param  $threadid  int  The thread ID to append the message to.
	 * @param  $to  int  The person to send the message to.
	 * @param  $from  int  The person who is sending the message
	 * @param  $message  string  The message to send to '$to'.
	 * @global  $DB  class  Import the DB class to be able to gain access to the database.
	 * @global  $User  class  Import the User class to be able to get information from a user.
	 */
	public function CreateMessage($threadid, $to, $from, $message) {
		global $DB, $User;
		
		if ($User->LoggedIn) {
			$DB->Insert("Messages", array("ThreadID"  => $threadid,
										  "ToID"      => $to,
										  "FromID"    => $from,
										  "TimeStamp" => time(),
										  "Message"   => $message));
			$DB->Query("UPDATE `MessageThreads` SET `Deleted` = '' WHERE `ThreadID` = '{$threadid}'");
		}
	}
}

$Messages = new sUS_Messaging();
?>