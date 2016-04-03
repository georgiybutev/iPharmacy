<?php

/*
 * Process Login
 * Check user supplied username and password against the database records.
 * Authenticate
 * Get user details from database and store them in the SESSION array.
 */

session_start();

// CSS highlight button

$page = "login";

include 'head.php';

include 'library/check_registration.php';

// Validate the username and password against the database

$validation = new Validation();
$checkUsername = $validation->checkUsername();
$checkPassword = $validation->checkPassword();

// Array containting both username and password correct authentication.

$correct = array();
$correct[0] = false;
$correct[1] = false;

?>

<!-- Display Process Login Form -->

<form name="login" action="FinaliseLogin" method="POST">
	<section>
		<table>
			<th><h2>Form</h2></th>
			<th><h2>User Details</h2></th>
			<th></th>
			<tr>
				<td><label for="username">Username: </label></td>
				<td><input type="text" id="username" name="username" maxlength="10" value="<? echo $_POST['username'] ?>" readonly="readonly" /></td>
				<td>
					<?
					// Check if the supplied username was correct
					// If so notify the user with green icon
					// Else notify the user with red icon
					if($checkUsername[0]) {

						$query = sprintf("select username from user where username='%s'",
							mysql_real_escape_string($_POST['username']));
						$result = mysql_query($query);
						
						if(mysql_affected_rows() == 0) {
							echo "<img src=\"media/incorrect.ico\" />";
							echo "<br/>";
							echo "No such username.";
						} else {
							echo "<img src=\"media/correct.ico\" />";
							$correct[0] = true;
						}
					} else {
						echo "<img src=\"media/incorrect.ico\" />";
						echo "<br/>";
						echo $checkUsername[1];
					}

					?>
				</td>
			</tr>
			<tr>
				<td><label for="password">Password: </label></td>
				<td><input type="password" id="password" name="password" maxlength="10" value="<? echo $_POST['password'] ?>" readonly="readonly" /></td>
				<td>
					<?
					// Check if the supplied password was correct
					// If so notify the user with green icon
					// Else notify the user with red icon
					if($checkPassword[0]) {

						$query = sprintf("select username, password from user where username='%s' and password=SHA2('%s', 224)", 
							mysql_real_escape_string($_POST['username']),
							mysql_real_escape_string($_POST['password']));
						$result = mysql_query($query);

						if (mysql_affected_rows() == 0) {
							echo "<img src=\"media/incorrect.ico\" />";
							echo "<br/>";
							echo "Password is incorrect.";
						} else {
							echo "<img src=\"media/correct.ico\" />";
							$correct[1] = true;
						}
					} else {
						echo "<img src=\"media/incorrect.ico\" />";
						echo "<br/>";
						echo $checkPassword[1];
					}

					?>
				</td>
			</tr>
			<tr>
				<td><label for="submit">Proceed: </label></td>
				<? 
				// Make sure that both supplied username and password were correct
				// If so the user can finalise the login
				// Else disbale the login button
				if($correct[0] && $correct[1]){
					$disable = "";
				} else {
					$disable = "disabled=\"disabled\"";
				}

				?>
				<td><input type="submit" id="submit" name="submit" value="Continue" <? echo $disable ?> /></td>
				<td>
					<?

					if($disable == ""){
						echo "<img src=\"media/success.ico\" />";
						$_SESSION['authenticated'] = true;
					} else {
						echo "<img src=\"media/fail.ico\" />";
					}

					?>
				</td>
			</tr>
		</table>
	</section>
</form>

<?

include 'tail.php';

?>