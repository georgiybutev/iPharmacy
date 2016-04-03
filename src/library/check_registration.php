<?php

/*
 * Check registration forms validity.
 * Forname, Surname, Username, Password, Repeat-Password
 */

class Validation {
		
	function __construct() {
		$correct = "false";
		$response = array();
		$response[0] = $correct;
	}

	// Check whether the user supplied forename string matches the criteria
	function checkForname(){
		// The text field should not be empty
		if(!empty($_POST['forname'])){
			// The forename string should NOT be less than 3 characters long
			if (strlen($_POST['forname']) < 3) {
				$message = "Forname is less than 3 characters long.";
				$response[1] = $message;
			}
			// The forename string should be more than 1 character long
			if (str_word_count($_POST['forname']) > 1) {
				$message = "Forname should not have any white spaces.";
				$response[1] = $message;
			}
			// The forname string should not contain numbers
			if (preg_match('/[0-9]/', $_POST['forname'])) {
				$message = "Forname should not contain numbers.";
				$response[1] = $message;
			}
			// The forname string should contain uppercase letters
			if (!preg_match('/[A-Z]/', $_POST['forname'])) {
				$message = "Forname should contain uppercase letters.";
				$response[1] = $message;
			}
			if (empty($message)) {
				// Trim string whitespace
				$forname = trim($_POST['forname']);
				// Forename in uppercase
				$forname = ucfirst($forname);
				$correct = true;
				$response[0] = $correct;
				$response[2] = $forname;
			}

			return $response;

		} else {

			return $response;

		}
	}
	
	// Check whether the user supplied surname string matches the criteria
	function checkSurname(){
		// The text field should not be empty
		if(!empty($_POST['surname'])){
			// The surname string is less than 3 characters long
			if (strlen($_POST['surname']) < 3) {
				$message = "Surname is less than 3 characters long.";
				$response[1] = $message;
			}
			// The surname string should not have any white spaces
			if (str_word_count($_POST['surname']) > 1) {
				$message = "Surname should not have any white spaces.";
				$response[1] = $message;
			}
			// The surname string should not contain numbers
			if (preg_match('/[0-9]/', $_POST['surname'])) {
				$message = "Surname should not contain numbers.";
				$response[1] = $message;
			}
			// The surname string should contain uppercase letters
			if (!preg_match('/[A-Z]/', $_POST['surname'])) {
				$message = "Surname should contain uppercase letters.";
				$response[1] = $message;
			}
			if (empty($message)) {
				// Trim string whitespace
				$surname = trim($_POST['surname']);
				// The surname in uppercase
				$surname = ucfirst($surname);
				$correct = true;
				$response[0] = $correct;
				$response[2] = $surname;
			}

			return $response;

		} else {

			return $response;

		}
	}

	// Check whether the user supplied username string matches the criteria
	function checkUsername(){
		// The text field should not be empty
		if(!empty($_POST['username'])){
			// The username string is less than 6 characters long
			if (strlen($_POST['username']) < 6) {
				$message = "Username is less than 6 characters long.";
				$response[1] = $message;
			}
			// The username string should not have any white spaces
			if (str_word_count($_POST['username']) > 1) {
				$message = "Username should not have any white spaces.";
				$response[1] = $message;
			}
			/*if (preg_match('/[0-9]/', $_POST['username'])) {
				$message = "Username should not contain numbers.";
				$response[1] = $message;
			}
			if (!preg_match('/[A-Z]/', $_POST['username'])) {
				$message = "Username should contain uppercase letters.";
				$response[1] = $message;
			}*/
			if (empty($message)) {
				// Trim string whitespace
				$username = trim($_POST['username']);
				/*$username = ucfirst($username);*/
				$correct = true;
				$response[0] = $correct;
				$response[2] = $username;
			}

			return $response;

		} else {

			return $response;

		}
	}

	// Check whether the user supplied password string matches the criteria
	function checkPassword(){
		// The text field should not be empty
		if(!empty($_POST['password'])) {
			// The password string is less than 6 characters long
			if (strlen($_POST['password']) < 6) {
				$message = "Password is less than 6 characters long.";
				$response[1] = $message;
			}
			// The password string should not have any white spaces
			if (str_word_count($_POST['password']) > 1) {
				$message = "Password should not have any white spaces.";
				$response[1] = $message;
			}
			// The password string should contain numbers
			if (!preg_match('/[0-9]/', $_POST['password'])) {
				$message = "Password should contain numbers.";
				$response[1] = $message;
			}
			// The password string should contain uppercase letters
			if (!preg_match('/[A-Z]/', $_POST['password'])) {
				$message = "Password should contain uppercase letters.";
				$response[1] = $message;
			}
			if (empty($message)) {
				// Trim string whitespace
				$password = trim($_POST['password']);
				$correct = true;
				$response[0] = $correct;
				$response[2] = $password;
			}

			return $response;

		} else {

			return $response;

		}
	}

	// Check whether the user supplied password string matches the criteria
	function checkRepeatPassword(){
		// The text field should not be empty
		if(!empty($_POST['repeat-password'])) {
			// Compare the two user supplied strings
			// They should match, which means = 0
			if(strcmp($_POST['password'], $_POST['repeat-password']) != 0){
				$message = "Both password entries should match.";
				$response[1] = $message;
			}
			if(empty($message)) {
				$correct = true;
				$response[0] = $correct;
				$response[2] = $_POST['repeat-password'];
			}

			return $response;

		} else {

			return $response;

		}
	}

	// Check whether all user supplied strings match the criteria - marked as correct
	function checkAll(
						$checkForname, 
						$checkSurname, 
						$checkUsername, 
						$checkPassword, 
						$checkRepeatPassword){
		if(
						$checkForname[0] && 
						$checkSurname[0] && 
						$checkUsername[0] && 
						$checkPassword[0] && 
						$checkRepeatPassword[0]) {

			// The finalise button will be enabled.
			return "";

		} else {

			// The finalise button will be disabled.
			return "disabled=\"disabled\"";
		}
	}
}

?>