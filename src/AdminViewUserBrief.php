<?php

/*
 * View Existing Users in the Database
 * Search for Existing Users in the Database
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

// Select all users from the database

include 'library/database_operations.php';
$db = new databaseOperations;
$result = $db->selectAllUsers();

?>

<script type="text/javascript">
// Display response from ajaxSearchUsers based on forname input
function searchAllUsers(search) {
	var xmlhttp;

	xmlhttp=new XMLHttpRequest();

	xmlhttp.onreadystatechange=function() {
		// If DONE and OK
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			// Clear division
			document.getElementById("search").innerHTML= "";
			// Populate division
			document.getElementById("search").innerHTML=xmlhttp.responseText;
		}
	}

	xmlhttp.open("GET","ajaxSearchUsers.php?forename="+search,true);
	xmlhttp.send();
}

// Sort the results by type and limit
// Display the response from ajaxSearchUsersSort
function sort() {
	var xmlhttp;
	var type = document.getElementById("type").value;
	var limit = document.getElementById("limit").value;
	
	xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange=function() {
		// If DONE and OK
		if(xmlhttp.readyState===4 && xmlhttp.status==200) {
			// Clear division
			document.getElementById("search").innerHTML= "";
			// Populate division
			document.getElementById("search").innerHTML=xmlhttp.responseText;
		}
	}

	xmlhttp.open("GET", "ajaxSearchUsersSort.php?type="+type+"&limit="+limit,true);
	xmlhttp.send();
}
</script>

<!-- Display HTML Form For Viewing and Searching Users -->

<section>

	<form>
		<br/>Search for users in the database: <input type="text" id="searchField" onkeyup="searchAllUsers(this.value)" />
	</form>

	<div id="search">
		<table>
			<th>Personal Name: </th>
			<th>Username: </th>
			<th>Privilege: </th>
			<th>Occupation: </th>
			<th>Role: </th>
			<th>Image ID: </th>
			<?
				// Process MySQL result set
				while ($row = mysql_fetch_assoc($result)) {
					// Print Mr or Mrs based on gender
					if($row['gender'] == "Male") {
						$gender = "Mr ";
					} else {
						$gender = "Mrs ";
					}
					// Print full privilege title rather than digit
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
					// Build TD Structure
					// Restrict avatar's size
					echo "<tr>";
					echo "<td>" . $gender . $row['forname'] . " " . $row['surname'] . "</td>";
					echo "<td>" . $row['username'] . "</td>";
					echo "<td>" . $privilege . "</td>";
					echo "<td>" . $row['occupation'] . "</td>";
					echo "<td>" . $row['role'] . "</td>";
					echo "<td><img src=\"" . $row['avatar']. "\" width=\"100px\" height=\"100px\"></td>";
					echo "</tr>";
				}
				?>
		</table></div>

		<!-- Display HTML Form To Sort Users By Criterion -->
		
		<form>
			<p>
				Sort the results by type and range:  
				<select id="type" name="type">
					<option value="forname">Forename</option>
					<option value="surname">Surname</option>
					<option value="username">Username</option>
					<option value="occupation">Occupation</option>
					<option value="role">Role</option>
					<option value="date">Date</option>
				</select>
				<select id="limit" name="limit">
					<option value="1">1</option>
					<option value="5">5</option>
					<option value="25">25</option>
					<option value="50">50</option>
					<option value="100">100</option>
				</select>
				<input type="button" id="sortButton" name="sortButton" value="Sort" onclick="sort()" />
			</p>
		</form>
</section>

<?

include 'tail.php';

?>