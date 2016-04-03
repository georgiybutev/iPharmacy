<?php
/*
 * Users
 * Manage Users
 * View, Search, Add, Update, Remove Users Information
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

?>

<!-- Display Navigation Links -->

<section>
	<table>
		<td><a class="admin_users" href="AdminViewUserBrief">View<br/><img src="media/view.ico"></a></td>
		<td><a class="admin_users" href="AdminAddUser">Add New<br/><img src="media/add.ico"></a></td>
		<td><a class="admin_users" href="AdminUpdateUser">Update<br/><img src="media/update.ico"></a></td>
		<td><a class="admin_users" href="AdminRemoveUser">Remove<br/><img src="media/remove.ico"></a></td>
	</table>
</section>

<?

include 'tail.php';

?>