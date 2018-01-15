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

class sUS_UserManager {
	public $Name;
	public $ID;
	public $LoggedIn = false;
	public $Blocked = array("Names" => array("m0nsta", "monsta"),
							"Parts" => array("staff", "mod")); //Ensure every value in these arrays are in lowercase format.
	
	/**
	 * This function will initialise the user manager class and will determine if a user is logged in.
	 * @global  $DB  class  Import the DB class to be able to gain access to the database.
	 */
	public function __construct() {
		global $DB;
		
		$UserLoginQ = $DB->Query("SELECT * FROM `Users` WHERE `UserID` = '" . $DB->Clean($_COOKIE["sUS_UserID"]) . "'");
		if (intval($DB->Num($UserLoginQ)) > 0) {
			$UserLoginA = $DB->Arr($UserLoginQ);
			if ($_COOKIE["sUS_UserID"] == $UserLoginA["UserID"]) {
				if ($_COOKIE["sUS_Security"] == md5($UserLoginA["LastIP"])) {
					if ($_COOKIE["sUS_Password"] == md5($UserLoginA["Password"])) {
						$this->ID       = (int) $UserLoginA["UserID"];
						$this->Name     = $UserLoginA["Username"];
						$this->LoggedIn = true;
					}
				}
			}
		}
	}
	
	/**
	 * This function will check whether a user exists based on their username of user ID.
	 * @param  $who  string/int  The user to check.
	 * @return  $Exists  bool  If true the user exists, if false the user doesn't exist.
	 * @global  $DB  class  Import the DB class to be able to gain access to the database.
	 */
	public function Exists($who) {
		global $DB;
		
		$who = trim($who);
		
		$SQLString   = ((is_numeric($who)==true) ? "`UserID` = '{$who}'" : "`Username` = '{$who}'");
		$UserExistsQ = $DB->Query("SELECT * FROM `Users` WHERE {$SQLString} LIMIT 1");
		$Exists      = (intval($DB->Num($UserExistsQ)==1)) ? true : false;
		
		return $Exists;
	}
	
	/**
	 * This function will check if an email address is already in use.
	 * @param  $email  string  The email to check.
	 * @global  $DB  class  Import the DB class to be able to gain access to the database.
	 */
	public function EmailExists($email) {
		global $DB;
		
		$EmailExistsQ = $DB->Query("SELECT * FROM `Users` WHERE `Email` = '{$email}'");
		return ((intval($DB->Num($EmailExistsQ)) > 0) ? true : false);
	}
	
	/**
	 * This function will return data associated with a user.
	 * @param  $field  string  The field to search within and return.
	 * @param  $who  string/int  The user to get the data from.
	 * @global  $DB  class  Import the DB class to be able to gain access to the database.
	 */
	public function Get($field, $who="") {
		global $DB;
		
		$field = trim($DB->Clean($field));
		
		if (!$who) {
			if ($this->ID) {
				$who = $this->ID;
			}
		}
		
		$who = trim($who);
		
		if ($this->Exists($who)) {
			$SQLString = (is_numeric($who)==true) ? "`UserID` = '{$who}'" : "`Username` = '{$who}'";
			$UserGetQ = $DB->Query("SELECT * FROM `Users` WHERE {$SQLString} LIMIT 1");
			$UserGetA = $DB->Arr($UserGetQ);
			
			return $UserGetA[$field];
		}
	}
	
	/**
	 * This function will check if a user is banned or not.
	 * @param  $who  string/int  The user to check.
	 */
	public function IsBanned($who) {
		if ($this->Exists($who)) {
			return (($this->Get("Banned", $who)=="1") ? true : false);
		}
	}
	
	/**
	 * This function will update a users information.
	 * @param  $field  string  The field to update.
	 * @param  $value  string/int  The new value to update the field to.
	 * @param  $who  string/int  The user to update.
	 * @global  $DB  class  Import the DB class to be able to gain access to the database.
	 */
	public function Update($field, $value, $who="") {
		global $DB;
		
		$field = trim($DB->Clean($field));
		$value = trim($DB->Clean($value));
		
		if (!$who) {
			if ($this->ID) {
				$who = $this->ID;
			}
		}
		
		$who = trim($who);
		
		if ($this->Exists($who)) {
			$SQLString = (is_numeric($who)==true) ? "`UserID` = '{$who}'" : "`Username` = '{$who}'";
			$DB->Query("UPDATE `Users` SET `{$field}` = '{$value}' WHERE {$SQLString}");
			return true;
		}
	}
	
	/**
	 * This function will check if a user has entered a valid email address.
	 * @param  $email  string  The email to check.
	 */
	public function ValidEmail($email) {
		return (((filter_var($email, FILTER_VALIDATE_EMAIL)==true) && (strlen($email) < 150)) ? true : false);
	}
	
	/**
	 * This function will check if a user has entered a valid password.
	 * @param  $password  string  The password to check.
	 */
	public function ValidPassword($password) {
		return (((strlen($password) >= 7) && (strlen($password) <= 30)) ? true : false);
	}
	
	/**
	 * This function will create a new user.
	 * @param  $username  string  The username of the new user.
	 * @param  $password  string  The password of the new user.
	 * @param  $email  string  The username of the new user.
	 * @param  $sex  string  The sex/gender of the new user.
	 * @param  $dob  int  The UNIX timestamp to represent when the user was born.
	 * @param  $picture  string  The profile picture of the user.
	 * @param  $ip  string  The IP Address of the new user.
	 * @param  $joindate  int  The UNIX timestamp to represent when the user was created.
	 * @global  $DB  class  Import the DB class to be able to gain access to the database.
	 */
	public function Create($username, $password, $email, $sex, $dob, $picture, $ip, $joindate) {
		global $DB;
		
		$DB->Insert("Users", array("Username"  => $username,
								   "Password"  => $password,
								   "Email"     => $email,
								   "Sex"       => $sex,
								   "BirthDate" => $dob,
								   "Picture"   => $picture,
								   "RegIP"     => $ip,
								   "JoinDate"  => $joindate));
	}
	
	/**
	 * This function will check if a name is blocked or contains blocked parts.
	 * @param  $name  string  The name to check.
	 */
	public function NameBlocked($name) {
		return ((in_array(strtolower($name), $Blocked["Names"]) || in_array(strtolower($name), $Blocked["Parts"])) ? true : false);
	}
}

$User = new sUS_UserManager();
?>