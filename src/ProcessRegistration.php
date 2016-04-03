<?php

/*
 * Process Registration
 * Check whether captcha code is correct using private key.
 * Get all POST variables and display them to the user.
 * Check whether the form was filled correctly by the user.
 */

session_start();

// CSS highlight button

$page = "register";

include 'head.php';

// Use Google's image verification tool

$private = $settings->getPrivateKey();

include 'library/check_recaptcha.php';

// Sign to Google's image verification tool

$verification = new Verification();
$checkVerification = $verification->check($private);

include 'library/check_registration.php';

// Validate user input against CMS criteria

$validation = new Validation();
$checkForname = $validation->checkForname();
$checkSurname = $validation->checkSurname();
$checkUsername = $validation->checkUsername();
$checkPassword = $validation->checkPassword();
$checkRepeatPassword = $validation->checkRepeatPassword();

$finalise = $validation->checkAll(
									$checkForname,
									$checkSurname,
									$checkUsername,
									$checkPassword,
									$checkRepeatPassword);

$_SESSION['occupation'] = $_POST['occupation'];
$_SESSION['role'] = $_POST['role'];
$_SESSION['forname'] = $_POST['forname'];
$_SESSION['surname'] = $_POST['surname'];
$_SESSION['username'] = $_POST['username'];
$_SESSION['password'] = $_POST['password'];
$_SESSION['repeat-password'] = $_POST['repeat-password'];
$_SESSION['gender'] = $_POST['gender'];
$_SESSION['date'] = $_POST['date'];

?>

<!-- Display HTML Form For Registration Of New Users -->

<form name="registration" action="FinaliseRegistration" method="POST">
	<section>
		<!-- Build Table Structure From User Form Submit -->
		<table>
			<th><h2>Form</h2></th>
			<th><h2>User Details</h2></th>
			<th><h2>Verification</h2></th>
			<tr>
				<td>Occupation: </td>
				<td>
					<select id="occupation" name="occupation" >
						<!-- Medical Occupation String In Uppercase -->
						<option value="<? echo ucfirst($_POST['occupation']) ?>" disabled="disabled"><? echo ucfirst($_POST['occupation']) ?></option>
					</select>
				</td>
				<td><img src="media/correct.ico" /></td>
			</tr>
			<tr>
				<td>Role: </td>
				<td>
					<select id="role" name="role">
						<!-- Medical Role String In Uppercase -->
						<option value="<? echo ucfirst($_POST['role']) ?>" disabled="disabled"><? echo ucfirst($_POST['role']) ?></option>
					</select>
				</td>
				<td><img src="media/correct.ico" /></td>
			</tr>
			<tr>
				<!-- Get Forename From POST -->
				<td>Forename: </td>
				<td>
					<input type="text" id="forname" name="forname" value="<? echo $_POST['forname'] ?>" disabled="disabled"/>
				</td>
				<td>
					<?
					// Notify if the forename string matches the criteria
					// Success / Failure
					if($checkForname[0]) { 
						echo "<img src=\"media/correct.ico\" />";
					} else {
						echo "<img src=\"media/incorrect.ico\" />";
						echo "<br/>";
						echo $checkForname[1];
					}

					?>
				</td>
			</tr>
			<tr>
				<!-- Get Forename From POST -->
				<td>Surname: </td>
				<td>
					<input type=""text id="surname" name="surname" value="<? echo $_POST['surname'] ?>" disabled="disabled" />
				</td>
				<td>
					<? 
					// Notify if the surname string matches the criteria
					// Success / Failure
					if($checkSurname[0]) { 
						echo "<img src=\"media/correct.ico\" />";
					} else {
						echo "<img src=\"media/incorrect.ico\" />";
						echo "<br/>";
						echo $checkSurname[1];
					}

					?>
				</td>
			</tr>
			<tr>
				<!-- Get Username From POST -->
				<td>Username: </td>
				<td>
					<input type="text" id="username" name="username" value="<? echo $_POST['username'] ?>" disabled="disabled" />
				</td>
				<td>
					<?
					// Notify if the username string matches the criteria
					// Success / Failure
					if($checkUsername[0]) {
						echo "<img src=\"media/correct.ico\" />";
					} else {
						echo "<img src=\"media/incorrect.ico\" />";
						echo "<br/>";
						echo $checkUsername[1];
					}

					?>
				</td>
			</tr>
			<tr>
				<!-- Get Password From POST -->
				<td>Password: </td>
				<td>
					<input type="password" id="password" name="password" value="<? echo $_POST['password'] ?>" disabled="disabled" />
				</td>
				<td>
					<?
					// Notify if the password string matches the criteria
					// Success / Failure
					if($checkPassword[0]) {
						echo "<img src=\"media/correct.ico\" />";
					} else {
						echo "<img src=\"media/incorrect.ico\" />";
						echo "<br/>";
						echo $checkPassword[1];
					}

					?>
				</td>
			</tr>
			<tr>
				<!-- Get Repeat Password From POST -->
				<td>Repeat Password: </td>
				<td>
					<input type="password" id="repeat-password" name="repeat-password" value="<? echo $_POST['repeat-password'] ?>" disabled="disabled" />
				</td>
				<td>
					<?
					// Notify if the repeat password string matches the criteria
					// Success / Failure
					if($checkRepeatPassword[0]) {
						echo "<img src=\"media/correct.ico\" />";
					} else {
						echo "<img src=\"media/incorrect.ico\" />";
						echo "<br/>";
						echo $checkRepeatPassword[1];
					}

					?>
				</td>
			</tr>
			<tr>
				<!-- Get Gender From POST -->
				<td>Gender: </td>
				<td>
					<select id="gender">
						<option value="<? echo $_POST['gender'] ?>" disabled="disabled"><? echo $_POST['gender'] ?></option>
					</select>
				</td>
				<!-- Gender String Is Always Correct -->
				<td><img src="media/correct.ico" /></td>
			</tr>
			<tr>
				<!-- Get Captcha Code From POST -->
				<td>Captcha: </td>
				<td>
					<input type="password" id="captcha" name="captcha" value="123456" disabled="disabled" />
				</td>
				<td>
					<? 
					// Verify Google Captcha
					// Notify on success or failure
					if(strcmp($checkVerification, "success") == 0) {
						echo "<img src=\"media/correct.ico\" />";
					} else {
						echo "<img src=\"media/incorrect.ico\" />";
						echo "<br/>";
						echo $checkVerification;
					}

					?>
				</td>
			</tr>
			<tr>
				<!-- Finalise Registration Form Button -->
				<td>Proceed: </td>
				<td><input type="submit" id="submit" name="submit" value="Finalise" <? echo $finalise ?> /></td>
				<td>
					<?
					// If the user input matches the criteria and Google captcha is correct
					// If no the user has to correct the mistakes
					if(($finalise == "") && ($checkVerification == "success")) {
						echo "You can finalise your registration";
					} else {
						echo "You have to correct your mistakes.";
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