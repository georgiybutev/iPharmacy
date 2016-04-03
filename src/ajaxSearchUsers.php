<?php

/*
 * Search User by Forename in the Database
 * Admin Only Interface
 * AJAX Enabled
 */

// Get forename keyword to search user in the database
$forename = $_GET['forename'];

include 'settings.php';
$settings = new Settings();
$settings->connectToDatabase();

// Perform SQL select row based on matching forename

include 'library/database_operations.php';
$db = new databaseOperations;
$result = $db->searchAllUsers($forename);

// Process SQL result set

while ($row = mysql_fetch_assoc($result)) {
	// Print Mr or Mrs based on gender
	if($row['gender'] == "Male") {
		$gender = "Mr ";
	} else {
		$gender = "Mrs ";
	}
	// Print full privilege title rather than digit
	// If no entry was found, print Unknown
	switch ($row['privilege']) {
		case 1:
			$privilege = "Guest";
			break;
		case 2:
			$privilege = "User";
			break;
		case 3:
			$privilege = "Administrator";
			break;
		default:
			$privilege = "Unknown";
			break;
	}
	// Build TD structure
	// Restrict avatar's size
	echo "<table>";
	echo "<th>Personal Name: </th>";
	echo "<th>Username: </th>";
	echo "<th>Privilege: </th>";
	echo "<th>Occupation: </th>";
	echo "<th>Role: </th>";
	echo "<th>Image ID: </th>";
	echo "<tr>";
	echo "<td>" . $gender . $row['forname'] . " " . $row['surname'] . "</td>";
	echo "<td>" . $row['username'] . "</td>";
	echo "<td>" . $privilege . "</td>";
	echo "<td>" . $row['occupation'] . "</td>";
	echo "<td>" . $row['role'] . "</td>";
	echo "<td><img src=\"" . $row['avatar']. "\" width=\"100px\" height=\"100px\"></td>";
	echo "</tr>";
	echo "</table>";
}

?>