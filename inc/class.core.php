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

class sUS_Core {
	/**
	 * This function will filter any string, remove bad tags and replace line breaks with <br /> for HTML purposes.
	 * @param  $string  string  The string to be filtered.
	 * @return  string  The filtered string.
	 */
	public function Filter($string) {
		return nl2br(htmlspecialchars($string, ENT_QUOTES | ENT_HTML5));
	}
	
	/**
	 * This function will use a string to return a value from the System table in the database associated with that string.
	 * @param  $string  string  The string to find in the database.
	 * @param  $filter  bool  If true the function will use the Filter function in the Core (current) class to filter the returned string.
	 * @return  $DBString  string  The value found in the database.
	 * @global  $DB  class  Import the DB class to be able to gain access to the database.
	 */
	public function GetString($string, $filter=false) {
		global $DB;
		
		$string = trim($DB->Clean($string));
		$System = $DB->Arr($DB->Query("SELECT * FROM `System`"));
		
		$DBString = ($filter==true) ? $this->Filter($System[$string]) : $System[$string];
		
		return $DBString;
	}
	
	/**
	 * This function will display an alert to the user. You can chose between: [info, success, error, alert (default)].
	 * @param  $title  string  This will be displayed in bold text, for example: "Warning!", "Success!" etc.
	 * @param  $message  string  This will be the message that is displayed in the alert.
	 * @param  $type  string  This will be the type of alert: [info, success, error, alert (default)].
	 * @param  $showbutton  bool  If true a button will be displayed to allow the user to close the alert.
	 * @param  $block  bool  If true the padding top and padding bottom will be increased on the alert box.
	 * @echo  $Alert  string  The full HTML alert to be returned to the user.
	 */
	public function Alert($title="", $message, $type, $showbutton=false, $block=false) {
		$TypeArray = array("info", "success", "error", "alert");
		if (!in_array($type, $TypeArray)) $type = "alert";
		
		$AlertClass = ' alert-' . $type .  (($block==true) ? ' alert-block' : '');
		
		$Alert = '<div class="alert alert-' . $AlertClass . '">';
			if ($showbutton==true) $Alert .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
			if (!empty($title)) $Alert .= '<strong>' . $title . '</strong> ';
			$Alert .= $message . '
		</div>';
		
		echo $Alert;
	}
	
	/**
	 * This function will dynamically write the code for a navigation item, this is necessary because 'class="active"' must be added to the current page link.
	 * @param  $id  string  The ID of the navigation item.
	 * @param  $name  string  The name of the page to display as the link.
	 * @param  $url  string  The location of the page.
	 * @param  $activepage  string  The ID of the current page, this will be used for the '$id' parameter.
	 * @param  $dropdown  bool  This parameter will determine whether the link has a dropdown menu.
	 * @param  $dropdown_pages  array  If '$dropdown' is set to true, these are the pages that will be displayed in the drop down menu..
	 */
	public function NavItem($id, $name, $url, $activepage='', $dropdown=false, $dropdown_pages=array()) {
		$class = ($activepage == $id) ? "active" : "";
		
		$NavItem = "<li class=\"{$class}";
		if ($dropdown==true) { $NavItem .= " dropdown"; }
		$NavItem .= "\"><a href=\"";
		if ($dropdown==true) { $NavItem .= "#\""; } else { $NavItem .= "{$this->GetString("URL")}/{$url}\""; }
		if ($dropdown==true) { $NavItem .= " class=\"dropdown-toggle\" data-toggle=\"dropdown\""; }
		$NavItem .= ">{$name}";
		if ($dropdown==true) { $NavItem .= " <b class=\"caret\"></b>"; }
		$NavItem .= "</a>";
		
		if (($dropdown==true) && (count($dropdown_pages) > 0)) {
			$NavItem .= "<ul class=\"dropdown-menu\">";
				foreach ($dropdown_pages as $dropdown_pages_name => $dropdown_pages_url) {
					if ($dropdown_pages_name == "NAV_DIVIDER")
					{
						$NavItem .= "<li class=\"divider\"></li>";
					}
					else
					{
						$NavItem .= "<li><a tabindex=\"-1\" href=\"{$this->GetString("URL")}/{$dropdown_pages_url}\">{$dropdown_pages_name}</a></li>";
					}
				}
			$NavItem .= "</ul>";
		}
		
		$NavItem .= "</li>";
		
		echo $NavItem;
	}
	
	/**
	 * This function will generate a random string.
	 * @param  $length  int  The length of the string to generate
	 * @return  $Key  string  The generated random string.
	 */
	public function RandomString($length=10, $md5=true) {
		$Characters = array_merge(range(a,z), range(A,Z), range(0,9));
		
		if ((intval($length) < 10) || (intval($length) > 31)) $length = mt_rand(10, 15);
		
		$Key = '';
		
		for ($i=0; $i<=$length; $i++) {
			$Key .= $Characters[mt_rand(0, count($Characters))];
		}
		
		if ($md5==true) {
			$Key = ($Key) . md5(microtime(true));
			
			$MD5Times = mt_rand(1,4);
			for ($i=0; $i<=$MD5Times; $i++) {
				$Key = md5($Key);
			}
		}
		
		$Key = substr($Key, 0, $length);
		
		return $Key;
	}
	
	/**
	 * This function will send out a fully HTML email to someone.
	 * @param  $to  string  The email address to send the email to.
	 * @param  $subject  string  The subject of the email address.
	 * @param  $message  string  The body of the email message.
	 */
	public function Email($to, $subject, $message) {
		$headers = "From: {$this->GetString("Title")} <no-reply@{$_SERVER["SERVER_NAME"]}>" . "\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1" . "\r\n";
		
		@mail($to, $subject, $message, $headers);
	}
	
	/**
	 * This function will give an accurate guess as to how long ago something was, eg "4 minutes", "5 days", "3 hours".
	 * @param  $datestr  string/int  The date to determine how long ago it was.
	 * @param  $afterstr  string  A string to appear after the estimated length of time, eg "4 minutes ago".
	 */
	function DateAgo($datestr, $afterstr="ago") {
		$difference = (is_numeric($datestr)) ? time() - $datestr : time() - strtotime(str_replace("-", "/", $datestr));
		
		if ((int) $difference > 29030400)
		{
			$ago = round($difference / 29030400, 0);
			$unit = "year";
		}
		elseif ((int) $difference > 2419200)
		{
			$ago = round($difference / 2419200, 0);
			$unit = "month";
		}
		elseif ((int) $difference > 604800)
		{
			$ago = round($difference / 604800, 0);
			$unit = "week";
		}
		elseif ((int) $difference > 86400)
		{
			$ago = round($difference / 86400, 0);
			$unit = "day";
		}
		elseif ((int) $difference > 3600)
		{
			$ago = round($difference / 3600, 0);
			$unit = "hour";
		}
		elseif ((int) $difference > 60)
		{
			$ago = round($difference / 60, 0);
			$unit = "minute";
		}
		else
		{
			$ago = round($difference / 60, 0);
			$unit = "second";
		}
		
		if (($ago == 0) && ($unit == "second")) { $ago = 2; $unit = "second"; }
		
		if (($ago <= 0) || ($ago > 1)) $unit .= "s";
		
		return ($afterstr) ? $ago . " " . $unit . " " . $afterstr : $ago . " " . $unit;
	}
	
	/**
	 * This function will give a shortened version of DateAgo, eg "4m", "5d", "3h".
	 * @param  $datestr  string/int  The date to determine how long ago it was.
	 * @param  $afterstr  string  A string to appear after the estimated length of time, eg "4m ago".
	 */
	function DateAgoSmall($datestr, $afterstr="ago") {
		$difference = (is_numeric($datestr)) ? time() - $datestr : time() - strtotime(str_replace("-", "/", $datestr));
		
		if ((int) $difference > 29030400)
		{
			$ago = round($difference / 29030400, 0);
			$unit = "y";
		}
		elseif ((int) $difference > 2419200)
		{
			$ago = round($difference / 2419200, 0);
			$unit = "m";
		}
		elseif ((int) $difference > 604800)
		{
			$ago = round($difference / 604800, 0);
			$unit = "w";
		}
		elseif ((int) $difference > 86400)
		{
			$ago = round($difference / 86400, 0);
			$unit = "d";
		}
		elseif ((int) $difference > 3600)
		{
			$ago = round($difference / 3600, 0);
			$unit = "h";
		}
		elseif ((int) $difference > 60)
		{
			$ago = round($difference / 60, 0);
			$unit = "m";
		}
		else
		{
			$ago = round($difference / 60, 0);
			$unit = "s";
		}
		
		if (($ago == 0) && ($unit == "s")) { $ago = 2; $unit = "s"; }
		
		return ($afterstr) ? $ago . "" . $unit . " " . $afterstr : $ago . "" . $unit;
	}
	
	/**
	 * This function will cut a string and append "..." onto it if necessary.
	 * @param  $string  string  The string to cut.
	 * @param  $start  int  The position to start at.
	 * @param  $end  int The position to end cutting at.
	 * @param  $after  string  The string to put after the cutting, eg: "...".
	 * @return  $CutString  string  The full string after it has been cut.
	 */
	public function Cut($string, $start, $end, $after="&hellip;") {
		$CutString = substr($string, $start, $end);
		
		if ($end < strlen($string)) $CutString .= $after;
		
		return $CutString;
	}
	
	/**
	 * This function will remove a folder, rmdir() does this but will only remove the folder if it is empty, this will search for files, delete them, then delete the folder.
	 * @param  $folder  dir  The folder/directory to remove.
	 */
	public function DestroyFolder($folder) {
		if (is_dir($folder) == true) {
			$Files = scandir($folder);
			foreach ($Files as $File) {
				$CurrentFile = $folder . "/" . $File;
				if (filetype($CurrentFile) == "dir")
				{
					$this->DestroyFolder($CurrentFile);
				}
				else
				{
					unlink($CurrentFile);
				}
			}
			
			rmdir($folder);
			return true;
		}
		return false;
	}
	
	/**
	 * This function will encrypt a password with the hash the user provided at installation.
	 * @param  $string  string  The string to encrypt.
	 * @return  $Hash  string  The encrypted version of the string the user passed through.
	 * @global  $SiteSettings  array  Globalise the $SiteSettings array.
	 */
	public function Hash($string) {
		global $SiteSettings;
		
		$Hash = $SiteSettings["Hash"];
		$Hash = md5(sha1(md5(substr(md5(base64_encode(hash("sha512", $Hash . $string))), 0, 20))));
		$Hash = substr($Hash, 0, 20);
		
		return $Hash;
	}
}

$Core = new sUS_Core();
?>