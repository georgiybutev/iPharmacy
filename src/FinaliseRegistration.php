<?php

/*
 * Finalise Registration
 * Get all POST array form values using SESSION array.
 * Insert new user into the database using database class.
 * Clear SESSION user data variables.
 */

session_start();

// CSS highlight button

$page = "register";

include 'head.php';

// Assign the SESSION array to local array for processing

$form = array();
$form[0] = $_SESSION['occupation'];
$form[1] = $_SESSION['role'];
$form[2] = $_SESSION['forname'];
$form[3] = $_SESSION['surname'];
$form[4] = $_SESSION['username'];
$form[5] = $_SESSION['password'];
$form[6] = $_SESSION['repeat-password'];
$form[7] = $_SESSION['gender'];
// Used for the SQL query
// The date format is day of week, Month, Year, time
$form[8] = date("l jS \of F Y \@ GA e");
// Perform SQL insert row into the users' table
include 'library/database_operations.php';
$db = new databaseOperations();
$errorMessage = $db->insertIntoUserTable($form);
// Create user directory structure similar to Linux
include 'library/system_operations.php';
$sys = new systemOperations();
$errorMessage = $sys->createNewUser($form[2], $form[3]);

?>

<!-- Display Success To Add New User -->

<section>
	<table>
		<th></th>
		<th></th>
		<th>Password: </th>
		<tr>
			<td><img src="media/success.ico"/></td>
			<td>Welcome <? echo $_SESSION['forname'] ?>!</td>
			<td><? echo $_SESSION['password'] ?></td>
		</tr>
	</table>
</section>
<?

// Display any error messages

echo $errorMessage;

// Erase all SESSION variables

session_unset();
session_destroy();

include 'tail.php';

?>