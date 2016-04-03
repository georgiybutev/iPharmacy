<?php

/*
 * Check reCaptcha
 * Success - the user has entered the verification code correctly.
 * Fail - the user has mistyped the verification code.
 */

class Verification {

	function __construct() {
		// Success or Failure message
		$message = "";
		define("path", "library/recaptchalib.php");
	}
	
	// Check the Google captcha correctness using the private key
	function check($private){

		require_once(path);

		// Google requires the private key, server address, captcha code, and user input
		$response = recaptcha_check_answer(
					$private,
					$_SERVER["REMOTE_ADDR"],
					$_POST["recaptcha_challenge_field"],
					$_POST["recaptcha_response_field"]);

		if(!$response->is_valid){
			// Fail
			$message = $response->error;
		} else {
			// Success
			$message = "success";
		}

		return $message;
	}
}

?>