<?php

/*
 * Quick Login
 * Check whether the PIN code associated with the user is correct.
 * Redirect to user home page or back to login page.
 * If three incorrect PIN codes are supplied the user is blocked for time.
 */

session_start();

// CSS highlight button

$page = "login";

include 'head.php';

// Check whether the form was submitted
// If so increment the number of login trial and error
// Check with the database whether the quick login key is correct
// If there was a match associate all user columns to the SESSION array
// The trial and error count will be nulled
// If NO match was found the user is notified

if(isset($_POST['submit'])) {
	$_SESSION['trial_error'] += 1;
	$query = sprintf("select * from user where pin='%s'",
		mysql_real_escape_string($_POST['submit']));
	$result = mysql_query($query);
	if(!$result) {
		// Display MySQL error
		$errorMessage = mysql_error();
	} else {
		if(mysql_affected_rows() == 0) {
			$errorMessage = "No match was found!";
		} else {
			// Process SQL result set
			while ($row = mysql_fetch_array($result)) {
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
				// The user URL is different from the admin's
				$url = "Home/" . $_SESSION['forename'] . $_SESSION['surname'] . "/Interface";
				// Destroy trial and error values
				unset($_SESSION['trial_error']);
				unset($_SESSION['trial_error_lock']);
			}
		}
	}
} 

?>

<section>
	<!-- Notify The User On Success Or Failure -->
	<table>
		<tr>
			<td>
				<? 
				if(isset($url)) {
					echo "<img src=\"media/success.ico\">";
				} else {
					echo "<img src=\"media/fail.ico\">";
				}
				?>
			</td>
			<!-- Welcome The User By His / Her Gender and Full Name-->
			<td>
				<?
				// Only display if a match was found in the database for quick login key
				if(isset($url)) {
					if($_SESSION['gender'] == "Male"){
						echo "Welcome  Mr " . $_SESSION['surname'] . "!";
					} 
					if($_SESSION['gender'] == "Female") {
						echo "Welcome  Mrs " . $_SESSION['surname'] . "!";
					}
				} else {
					echo $errorMessage;
				}
				?>
			</td>
			<!-- The User Can Only Login If The Quick Login Key Was Correct -->
			<td>
				<form name="redirect" action="<? echo $url ?>" method="POST">
					<input type="submit" id="submit" name="submit" value="Proceed" <? if(!isset($url)) {echo "disabled=\"disabled\"";} ?> />
				</form>
			</td>
		</tr>
	</table>
</section>

<?

include 'tail.php';

?>