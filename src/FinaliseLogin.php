<?php

/*
 * Finalise Login
 * Redirect user to user home page  ||
 * Redirect user to admin home page ||
 * Redirect user to error page
 */

session_start();

// CSS highlight button

$page = 'login';

include 'head.php';

// Check whether the use has been authenticated
// Get his/her name else display error

if($_SESSION['authenticated']) {
	$query = sprintf("select * from user where username='%s'", 
		mysql_real_escape_string($_POST['username']));
	$result = mysql_query($query);
	if(!$result) {
		$errorMessage = mysql_error();
	} else {
		// Process SQL result set
		// Assign the user's data from the database to the SESSION array
		while($row = mysql_fetch_array($result)) {
			$_SESSION['user_id'] = $row['id'];
			$_SESSION['meta_id'] = $row['id'];
			$_SESSION['user_occupation'] = $row['occupation'];
			$_SESSION['user_role'] = $row['role'];
			$_SESSION['forename'] = $row['forname'];
			$_SESSION['surname'] = $row['surname'];
			$_SESSION['username'] = $row['username'];
			$_SESSION['gender'] = $row['gender'];
			$_SESSION['date'] = $row['date'];
			$_SESSION['pin'] = $row['pin'];
			$_SESSION['privilege'] = $row['privilege'];
		}
		// Assign the appropriate SESSION privilege
		// 1 = Guest => only front page
		// 2 = User => manage products
		// 3 = Admin => manage products and users
		if($_SESSION['privilege'] = 1) {
			$url = "index.php";
		} elseif ($_SESSION['privilege'] = 2) {
			$url = "Home/" . $_SESSION['forename'] . $_SESSION['surname'] . "/Interface";
		} elseif ($_SESSION['privilege'] = 3) {
			$url = "Admin";
		}
		
	}
} else {
	// On MySQL failure redirect user
	header("Location: Error.php");
	exit;
}

?>

<script type="text/javascript">
// Redirect the user to administrator or user interface
function redirect(url) {
	window.location = url;
}
</script>

<!-- Notify User Of Success Login -->

<section>
	<table>
		<tr>
			<td>
				<img src="media/success.ico">
			</td>
			<td>
				Welcome 
				<? 
				// Welcome the user by his/her name and Mr/Mrs based on gender
				if($_SESSION['gender'] == "Male"){
					echo " Mr " . $_SESSION['surname'] . "!";
				} 
				if($_SESSION['gender'] == "Female") {
					echo " Mrs " . $_SESSION['surname'] . "!";
				}
				?>
			</td>
			<td>
				<!-- Redirect To Either Admin Or User Interface -->
				<form name="redirect" action="<? echo $url ?>" method="POST">
					<input type="submit" id="submit" name="submit" value="Proceed" />
				</form>
			</td>
		</tr>
	</table>
</section>

<?

include 'tail.php';

?>