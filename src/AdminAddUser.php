<?php

/*
 * Add New User to the CMS
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

// Check whether the form was submitted
// If so perform SQL query to add entry
// On success / failure notify the user

if (isset($_POST['submit'])) {
	include 'library/database_operations.php';
	$db = new databaseOperations;
	$errorMessage = $db->addNewUser();
	include 'library/system_operations.php';
	$sys = new systemOperations();
	$sys->createNewUser($_POST['forname'], $_POST['surname']);

	echo $errorMessage;
	/*if ($errorMessage == "") {
		echo "The user was successfully added to the database.";
	} else {
		echo "There was an error. Please try again.";
		//echo mysql_error();
	}*/

}

?>

<!-- Load JS Occupation List -->

<script type="text/javascript" src="library/admin_add_user_occupation.js"></script>

<!-- Load JS Occupation List -->

<script type="text/javascript" src="library/admin_add_user.js"></script>

<!-- Display HTML Form to Add New User -->

<section>
	<form id="AdminAddUser" name="AdminAddUser" action="AdminAddUser" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="MAX_FILE_SIZE" value="1048576"/>
		<table>
			<th>Form: </th>
			<th>Contents: </th>
			<tr>
				<td><label for="forname">Forename: </label></td>
				<td><input type="text" id="forname" name="forname" value="Georgi" onblur="checkIfEmpty(this)"></td>
			</tr>
			<tr>
				<td><label for="surname">Surname: </label></td>
				<td><input type="text" id="surname" name="surname" value="Butev" onblur="checkIfEmpty(this)"></td>
			</tr>
			<tr>
				<td><label for="username">Username: </label></td>
				<td><input type="text" id="username" name="username" value="username" onfocus="generateUsername()" ></td>
			</tr>
			<tr>
				<td><label for="password">Password: </label></td>
				<td><input type="text" id="password" name="password" value="password" onfocus="generatePassword()" ></td>
			</tr>
			<tr>
				<td><label for="pin">PIN Code:</label></td>
				<td><input type="text" id="pin" name="pin" value="1234" onfocus="generatePin()" /></td>
			</tr>
			<tr>
				<td><label for="privilege">Privilege: </label></td>
				<td>
					<select id="privilege" name="privilege">
						<option value="1">Guest</option>
						<option selected="selected" value="2">User</option>
						<option value="3">Administrator</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="gender">Gender: </label></td>
				<td>
					<select id="gender" name="gender">
						<option value="Male">Male</option>
						<option selected="selected" value="Female">Female</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="occupation">Occupation: </label></td>
				<td>
					<select id="occupation" name="occupation" onchange="getRole(this.value)">
						<option value="blank">Select One: </option>
						<option value="allied">Allied Health Professional</option>
						<option value="ambulance">Ambulance</option>
						<option value="dental">Dental</option>
						<option value="doctor">Doctor</option>
						<option value="Healthcare Science">Healthcare Science</option>
						<option value="Health Informatics">Health Informatics</option>
						<option value="management">Management</option>
						<option value="Midwifery">Midwifery</option>
						<option value="nursing">Nursing</option>
						<option value="pharmacy">Pharmacy</option>
						<option value="psychological">Psychological Therapies</option>
						<option value="other">Other</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Role: </td>
				<td>
					<select name="role" id="role">
						<option value="blank">Select One: </option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="cover">User Picture ID: </label></td>
				<td><input type="file" id="avatar" name="avatar" /></td>
			</tr>
			<tr>
				<td><label for="notes">Notes: </label></td>
				<td><textarea id="notes" name="notes" rows="10" cols="40" onblur="checkIfEmpty(this)"></textarea></td>
			</tr>
			<tr>
				<td><label for="submit">Proceed: </label></td>
				<td><input type="submit" id="submit" name="submit" value="Continue" /></td>
			</tr>
		</table>
	</form>
</section>

<?

include 'tail.php';

?>