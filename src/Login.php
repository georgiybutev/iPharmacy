<?php

/*
 * Login
 * Username and Password form.
 * 
 */

session_start();

// CSS highlight button

$page = "login";

include 'head.php';

// Check whether the SESSION array was created
// Set the trial and error counter to 0
if(!isset($_SESSION['trial_error'])){
	$_SESSION['trial_error'] = 0;
}

$disabled = "";
$message = "";

?>

<!-- Load The Quick Login Utility -->

<script type="text/javascript" src="library/quick_login.js"></script>

<!-- Display Login Form -->

<form name="login" action="ProcessLogin" method="POST">
	<section>
		<table>
			<th><h2>Form</h2></th>
			<th><h2>User Details</h2></th>
			<th></th>
			<tr>
				<td><label for="username">Username: </label></td>
				<td><input type="text" id="username" name="username" maxlength="10" /></td>
				<td><img src="media/incorrect.ico" /></td>
			</tr>
			<tr>
				<td><label for="password">Password: </label></td>
				<td><input type="password" id="password" name="password" maxlength="10" autocomplete="off" /></td>
				<td><img src="media/incorrect.ico" /></td>
			</tr>
			<tr>
				<td><label for="submit">Proceed: </label></td>
				<td><input type="submit" id="submit" name="submit" value="Continue" /></td>
				<td><img src="media/fail.ico" /></td>
			</tr>
		</table>
	</section>
</form>

<?

// If the user has tried to login and failed 3 times
// Disable the login button
// Notify the user
// Record the time and set it in the SESSION array
// The user will not be able to quick login
// Release the lock after 10 minutes

if($_SESSION['trial_error'] >= 3) {
	$disabled = "disabled=\"disabled\"";
	$message = "Try again after 10 minutes to Quick Login.";
	$message .= " Recorded at " . date('i') . ".";
	if((date("i") - $_SESSION['trial_error_lock'] >= 10) || 
		($_SESSION['trial_error_lock'] - date("i") >= 10)) {
			$_SESSION['trial_error'] = 0;
	} else {
		$_SESSION['trial_error_lock'] = date("i");
	}
}

?>

<!-- Display The Quick Login Form -->

<form name="quick_login" action="QuickLogin" method="POST">
	<section>
		<table>
			<th></th>
			<th><h2>Quick Login</h2></th>
			<th></th>
			<tr>
				<td>
					<input type="button" name="one" id="one" value="1" onclick="getDigit(this.value)" />
				</td>
				<td>
					<input type="button" name="two" id="two" value="2" onclick="getDigit(this.value)" />
				</td>
				<td>
					<input type="button" name="three" id="three" value="3" onclick="getDigit(this.value)" />
				</td>
			</tr>
			<tr>
				<td>
					<input type="button" name="four" id="four" value="4" onclick="getDigit(this.value)" />
				</td>
				<td>
					<input type="button" name="five" id="five" value="5" onclick="getDigit(this.value)" />
				</td>
				<td>
					<input type="button" name="six" id="six" value="6" onclick="getDigit(this.value)" />
				</td>
			</tr>
			<tr>
				<td>
					<input type="button" name="seven" id="seven" value="7" onclick="getDigit(this.value)" />
				</td>
				<td>
					<input type="button" name="eight" id="eight" value="8" onclick="getDigit(this.value)" />
				</td>
				<td>
					<input type="button" name="nine" id="nine" value="9" onclick="getDigit(this.value)" />
				</td>
			</tr>
			<tr>
				<td>
					<input type="button" name="reset" id="reset" value="Reset" onclick="reseto()" />
				</td>
				<td>
					<input type="button" name="zero" id="zero" value="0" onclick="getDigit(this.value)" />
				</td>
				<td>
					<input type="submit" name="submit" id="ten" value="&rArr;" <? echo $disabled ?> />
				</td>
			</tr>
		</table>
	</section>
</form>

<!-- Display Error Or Lock Restriction Message -->

<p><? echo $message ?></p>

<?

include 'tail.php';

?>