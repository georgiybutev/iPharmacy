<?php
/*
 * Logout
 * Unset SESSION Variables
 * Destroy Current Administrator SESSION
 */

// PHP SESSION

session_start();

// CSS highlight pressed button

$page = "logout";

include 'admin_header.php';

// Completely erase all SESSION array variables

session_unset();
session_destroy();

?>

<section>
	<table>
		<tr>
			<?
			// If the user is logged on
			// Say goodbye using his / her name
			if (isset($_SESSION['forename'])) {
				echo "<td>The followind user was successfully logged out - </td>";
				echo "<td>" . $_SESSION['forename'] . " " . $_SESSION['surname'] . "</td>";
				echo "<td><img src=\"media/success.ico\"></td>";
			// If the visitor has NOT logged in
			} else {
				echo "<td>You have to login first!</td>";
				echo "<td>Anonymous</td>";
				echo "<td><img src=\"media/fail.ico\"></td>";
			}
			?>
		</tr>
	</table>
</section>

<?

include 'tail.php';

?>