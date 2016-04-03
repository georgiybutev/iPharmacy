<?php

/*
 * Register
 * Load medical occupations and roles.
 * Display registration form.
 * Prevent spam and bots using reCaptcha.
 */

$page = "register";

// CSS highlight button

include 'head.php';

// Use Google's image verification tool

$public = $settings->getPublicKey();

require_once('library/recaptchalib.php');

?>

<!-- Load Medical Occupations / Roles List Library -->
<script type="text/javascript" src="library/occupation.js"></script>

<!-- Display HTML Form For Registration Of New Users -->

<form name="registration" action="ProcessRegistration" method="POST">
	<section>
		<table>
			<th><h2>Form</h2></th>
			<th><h2>User Details</h2></th>
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
				<td><label for="forname">Forename: </label></td>
				<td><input type="text" name="forname" id="forname" maxlength="10" size="10" value="Georgi" /></td>
			</tr>
			<tr>
				<td><label for="surname">Surname: </label></td>
				<td><input type="text" name="surname" id="surname" maxlength="10" size="10" value="Butev" /></td>
			</tr>
			<tr>
				<td><label for="username">Username: </label></td>
				<td><input type="text" name="username" id="username" maxlength="10" size="10" value="butevg" /></td>
			</tr>
			<tr>
				<td><label for="password">Password: </label></td>
				<td><input type="password" name="password" id="password" maxlength="10" size="11" value="123456" autocomplete="off" /></td>
			</tr>
			<tr>
				<td><label for="repeat-password">Repeat Password: </label></td>
				<td><input type="password" name="repeat-password" id="repeat-password" maxlength="10" size="11" value="123456" autocomplete="off" /></td>
			</tr>
			<tr>
				<td><label for="gender">Gender: </label></td>
				<td>
					<select name="gender" id="gender">
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
				</td>
			</tr>
			<tr>
			</tr>
			<tr>
				<td>Proceed: </td>
				<td><input type="submit" value="Continue" name="submit" id="submit" /></td>
			</tr>
		</table>
		<!-- Display Google's Captcha Widget -->
		<? echo recaptcha_get_html($public) ?>
	</section>
</form>

<? 

include 'tail.php';

?>