<?php

/*
 * Check whether SQL Operation was Successful or Fail
 * MySQL returns 0 on fail.
 * MySQL return > 1 on success.
 * No Debug is used to prevent mysql_error() debugging
 */

class ExecutionSuccess {
	
	function __construct() {
		// Return value for success - true or false
		$success = "";
		$errorNumber = mysql_errno();
		$errorMessage = mysql_error();
	}

	// Check whether the database operation was successful by counting the number of affected rows
	// 1 means success and 0 means failure
	// On failure notify the user by printing the MySQL server debug information
	function executionSuccess() {

		$affected = mysql_affected_rows();

		if($affected == 1) {
			$success = "Success";
		} else if($affected == 0) {
			$success = mysql_error();
		} else {
			$success = "Exception";
		}

		return $success;

	}
	// Check whether the database operation was successful by counting the number of affected rows
	// 1 means success and 0 means failure
	// On failure notify the user by printing a string - NOT MySQL response
	function executionSuccessNoDebug() {

		$affected = mysql_affected_rows();

		if($affected == 1) {
			$success = "Success";
		} else if($affected == 0) {
			$success = "Fail";
		} else {
			$success = "Exception";
		}

		return $success;

	}

	function getErrorNumber() {
		return $errorNumber;
	}

	function getErrorMessage() {
		return $errorMessage;
	}
}

?>