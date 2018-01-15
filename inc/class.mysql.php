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

class sUS_MySQL {
	private $connection;
	
	/**
	 * This function connects to the database.
	 */
	public function __construct() {
		global $DBGlobal;
		$this->connection = mysql_connect($DBGlobal["Host"], $DBGlobal["User"], $DBGlobal["Pass"]) or die("sUS cannot connect to {$DBGlobal["User"]}:{$DBGlobal["Pass"]}@{$DBGlobal["Host"]}");
		mysql_select_db($DBGlobal["Name"], $this->connection) or die("sUS cannot initiate a link between the MySQL database and the user.");
	}
	
	/**
	 * This function will perform an MySQL query and return the result.
	 * @param  $query  string  The query to perform.
	 * @return  $mysqlResult  resource  The result of the query or an MySQL error string.
	 */
	public function Query($query) {
		$mysqlResult = mysql_query($query);
		if (!$mysqlResult) {
			die(mysql_error());
		}
		
		return $mysqlResult;
	}
	
	/**
	 * This function will return how many rows exist.
	 * @param  $query  resource  This will contain the query that will be used to find out how many rows exist.
	 * @return  $mysqlResult  int  How many rows exist.
	 */
	public function Num($query) {
		return @mysql_num_rows($query);
	}
	
	/**
	 * This function will return an array of data from a table in the database.
	 * @param  $query  resource  This will contain the query that will be used to return an array of data.
	 * @return  $mysqlResult  array  The array of data to be returned or an MySQL error string.
	 */
	public function Arr($query) {
		$mysqlResult = mysql_fetch_array($query);
		if (!$mysqlResult) {
			die(mysql_error());
		}
		
		return array_map("stripslashes", $mysqlResult);
	}
	
	/**
	 * This function will sanitize any data that will be inserted into the database to prevent SQL injections.
	 * @param  $query  string  The string to be cleaned.
	 * @return  string  The string that has been cleaned.
	 */
	public function Clean($query) {
		return mysql_real_escape_string($query);
	}
	
	/**
	 * This function will insert an array of data into a table quickly without having to write a huge mysql_query code.
	 * @param  $table  string  The table to insert the data into.
	 * @param  $data  array  The array of data to insert into the table.
	 */
	public function Insert($table, $data) {
		$Fields = array_keys($data);
		$Values = array_map("mysql_real_escape_string", array_values($data));
		@mysql_query("INSERT INTO `{$table}` (`" . implode("`, `", $Fields) . "`) VALUES ('" . implode("', '", $Values) . "')");
	}
	
	/**
	 * This function will close the connection to the MySQL database.
	 */
	public function __destruct() {
		@mysql_close($this->connection);
	}
}

$DB = new sUS_MySQL();
?>