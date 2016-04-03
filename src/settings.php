<?php

/*
 * System Settings
 * DB, Facebook, reCaptcha
 */

class Settings {
	
	/* MySQL Database */
		
	function connectToDatabase(){
		// Database connection properties
		$connection = array(
							"hostname" => "localhost:3306",
							"username" => "root",
							"password" => "toor");
		// Connect to database
		$connect = mysql_connect(
							$connection["hostname"],
							$connection["username"],
							$connection["password"]);
		// Notify on failure to establish a connection to the database
		if(!$connect){
			die('Could not connect to the MySQL Server: ' . mysql_error());
		}
		// Set UTF-8 character set as default
		mysql_set_charset('utf8', $connect);
		// Select the default Medical CMS database table
		$selectDatabase = mysql_select_db("medical");
		// Nofity on failure to select the table from the database
		if(!$selectDatabase){
			die('Could not select the database: ' . mysql_error());
		}
	}

	/* Facebook API Authentication */

	function authenticate(){

		include 'library/facebook.php';
		// Facebook API connection properties
		$config = array(
						"appId" => "appid",
						"secret" => "secret",
						"fileUpload" => false);
		// Create Facebook API object and set states
		$facebook = new Facebook($config);
		// Get curretnly logged in user
		$userID = $facebook->getUser();
		// Get his / her URL
		$url = $facebook->getLoginUrl();
		$data = array(
						"userID" => $userID,
						"url" => $url);
		return $data;
	}

	/* Google reCaptcha */

	function getPublicKey() {
		// Used only to display the recaptcha widget
		$public = "6Lf1PdMSAAAAAHQp1vaZDg1sc_5L_K3q16EiwQgZ";

		return $public;
	}

	function getPrivateKey() {
		// Used only to verify the user submitted key
		$private = "6Lf1PdMSAAAAAPL5HsTLRL06o4iz_AnhAtE_fvHx";

		return $private;
	}

	function setRootPath() {
		// Print the working directory of the script
		exec('pwd', $path);
		// Set the result in the info database table
		$query = sprintf("update info set path='%s' where id=1", $path[0]);
		$result = mysql_query($query);
	}

	function getRootPath() {
		// Get the working directory of the script from the info database table
		$query = "select * from info where id=1";
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		$path = $row['path'];
		
		return $path;
	}

}

?>