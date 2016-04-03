<?php

/*
 * View Existing Users in the Database and Update
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
// If so perform SQL update user row based on the id
// Else display error message

if(isset($_POST['submitU'])) {
	$errorMessage = $db->updateUser();
	echo $errorMessage;
}

// Retrieve all users from the database

$result = $db->selectAllUsers();

?>

<!-- Display HTML Form For Update User -->

<section>
	<table>
		<th>Personal Name: </th>
		<th>Username: </th>
		<th>Password: </th>
		<th>Pin: </th>
		<th>Privilege: </th>
		
		<?
		// Process SQL result set
		while ($row = mysql_fetch_assoc($result)) {
			// Print Mr or Mrs based on gender		
			if($row['gender'] == "Male") {
				$gender = "Mr ";
			} else {
				$gender = "Mrs ";
			}
			// Print privilege full title rather than digit
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
			// Make proper select-option based on privilege
			if($privilege == "Guest") {
				$privilegeForm = "<select id=\"privilegeU\" name=\"privilegeU\"><option value=\"1\" selected=\"selected\">Guest</option><option value=\"2\">User</option><option value=\"3\">Administrator</option></select>";
			} elseif ($privilege == "User") {
				$privilegeForm = "<select id=\"privilegeU\" name=\"privilegeU\"><option value=\"1\">Guest</option><option value=\"2\" selected=\"selected\">User</option><option value=\"3\">Administrator</option></select>";
			} elseif ($privilege == "Administrator") {
				$privilegeForm = "<select id=\"privilegeU\" name=\"privilegeU\"><option value=\"1\">Guest</option><option value=\"2\">User</option><option value=\"3\" selected=\"selected\">Administrator</option></select>";
			}
			// Build TD structure for all users in the database
			echo "<tr>";
			echo "<form id=\"AdminUpdateUser\" name=\"AdminUpdateUser\" action=\"AdminUpdateUser\" method=\"POST\" enctype=\"multipart/form-data\">";
			echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"1048576\"/>";
			echo "<input type=\"hidden\" id=\"user_id\" name=\"user_id\" value=\"" . $row['id'] . "\" />";
			echo "<input type=\"hidden\" id=\"backupAvatar\" name=\"backupAvatar\" value=\"" . $row['avatar'] . "\" />";
			echo "<td><a href=\"#\" title=\"" . $row['date'] . "\">" . $gender . $row['forname'] . " " . $row['surname'] . "</a></td>";
			echo "<td><input type=\"text\" id=\"usernameU\" name=\"usernameU\" value=\"" . $row['username'] . "\" size=\"9\" /></td>";
			echo "<td><input type=\"text\" id=\"passwordU\" name=\"passwordU\" size=\"9\"></td>"; 
			echo "<td>" . $row['pin'] . "</td>";
			echo "<td>" . $privilegeForm . "</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td><img src=\"" . $row['avatar']. "\" width=\"100px\" height=\"100px\"></td>";
			echo "<td>" . $row['occupation'] . "</td>";
			echo "<td>" . $row['role'] . "</td>";
			echo "<td><input type=\"file\" size=\"1\" id=\"avatar\" name=\"avatar\" /></td>";
			echo "<td><input type=\"submit\" id=\"submitU\" name=\"submitU\" value=\"Update\" /></td>";
			echo "</tr>";
			echo "<tr><td><textarea id=\"notes\" name=\"notes\" cols=\"20\" rows=\"5\">" . $row['notes'] . "</textarea></td></tr>";
			echo "</form>";
		}
		?>
	</table>
</section>

<?

include 'tail.php';

?>