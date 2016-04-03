<?php

/*
 * Work with the server's file system.
 * Create, Insert, Update, Delete user directories.
 * Direct access to the terminal via system().
 */

class systemOperations {

	// Create user directory structure using his/her forename and surname
	function createNewUser($forename, $surname) {
		$path = $forename . $surname;
		// All users are placed in the Home/ directory
		chdir("Home");
		// Create directory for example GeorgiButev
		mkdir($path);
		// Change directory to GeorgiButev
		chdir($path);
		// Create two necessary user directories
		mkdir("Images");
		mkdir("Reports");
		// Change their mode so files can be created
		chmod("Images", 0777);
		chmod("Reports", 0777);
	}

	// Only registered and authenticated users have a Home/ directory
	function createPrivilegedUser($forename, $surname) {
		$path = $forename . $surname;
		system("cp Products.php Home/" . $path . "/");
	}

	// Admin scripts are placed in the base path of the Medical CMS
	function createNewAdmin($forename, $surname) {
		$path = $forename . $surname;
		system("cp Admin.php Home/" . $path . "/");
	}

	// Get the working path or base path
	function getPath() {
		exec('find / -name project 2>/dev/null', $path);
		return $path[0];
	}

}

?>