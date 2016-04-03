<?php

/*
 * View Existing Users in the Database and Remove
 * Admin Only Interface
 */

session_start();

// CSS highlight button

$page = "users";

include 'admin_header.php';

/*if(($_SESSION['authenticated'] == true) && ($_SESSION['privilege'] == 3)) {
} else {
	header("Location: Error.php");
	exit;
}*/

include 'library/database_operations.php';
$db = new databaseOperations;

// Check whether the form was submitted
// If so perform SQL delete row based on the id

if(isset($_POST['submitD'])) {
	$errorMessage = $db->deleteUser();
	echo $errorMessage;
}

// Retrieve all users from the database

$result = $db->selectAllUsers();

?>

<!-- Display HTML Form For Removing Users -->

<section>
	<table>
		<th>Personal Name: </th>
		<th>Username: </th>
		<th>Privilege: </th>
		<th>Avatar / Notes: </th>
		<th>Submit: </th>
		
		<?
		// Get DB result set
		while ($row = mysql_fetch_assoc($result)) {
			// Print Mr or Mrs based on the gender entry
			if($row['gender'] == "Male") {
				$gender = "Mr ";
			} else {
				$gender = "Mrs ";
			}
			// Print privilege title rather than digits
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
			// Select the appropriate privilege in the drop-down
			if($privilege == "Guest") {
				$privilegeForm = "<select id=\"privilegeU\" name=\"privilegeU\"><option value=\"1\" selected=\"selected\">Guest</option><option value=\"2\">User</option><option value=\"3\">Administrator</option></select>";
			} elseif ($privilege == "User") {
				$privilegeForm = "<select id=\"privilegeU\" name=\"privilegeU\"><option value=\"1\">Guest</option><option value=\"2\" selected=\"selected\">User</option><option value=\"3\">Administrator</option></select>";
			} elseif ($privilege == "Administrator") {
				$privilegeForm = "<select id=\"privilegeU\" name=\"privilegeU\"><option value=\"1\">Guest</option><option value=\"2\">User</option><option value=\"3\" selected=\"selected\">Administrator</option></select>";
			}
			// Build TD structure for all users
			echo "<tr>";
			echo "<form id=\"AdminRemoveUser\" name=\"AdminRemoveUser\" action=\"AdminRemoveUser\" method=\"POST\" enctype=\"multipart/form-data\">";
			echo "<input type=\"hidden\" id=\"user_id\" name=\"user_id\" value=\"" . $row['id'] . "\" />";
			echo "<td><a href=\"#\" title=\"" . $row['date'] . "\">" . $gender . $row['forname'] . " " . $row['surname'] . "</a></td>";
			echo "<td><input type=\"text\" id=\"usernameU\" name=\"usernameU\" value=\"" . $row['username'] . "\" size=\"9\" /></td>";
			echo "<td>" . $privilegeForm . "</td>";
			echo "<td><img title=\"" . $row['notes'] . "\" src=\"" . $row['avatar']. "\" width=\"100px\" height=\"100px\"></td>";
			echo "<td><input type=\"submit\" id=\"submitD\" name=\"submitD\" value=\"Delete\" title=\"" . $row['id'] . "\" /></td>";
			echo "</tr>";
			echo "</form>";
		}
		?>
	</table>
</section>

<?

include 'tail.php';

?>