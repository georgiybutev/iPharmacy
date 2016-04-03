<?php

/*
 * Messages Interface
 * Mailbox, Receive, and Send
 * User can Attach Files - Images, PDF, and Doc.
 * Only for Registered Users
 * User Only Interface
 */

session_start();

// CSS highligh button

$page = "reports";
$path = "../../";

include '../../user_header.php';

/*if(($_SESSION['authenticated'] == true) && ($_SESSION['privilege'] == 2)) {
} else {
	header("Location: Error.php");
	exit;
}*/


// Check whether the form was submitted
// If so generate the PDF document
if(isset($_POST['submit'])) {
	include 'GeneratePDF.php';
	$generate = new GeneratePDF();
	$generate->document();
}

?>

<section>

	<!-- Display Selection For Report -->

	<form method="POST" action="Report">
		<table>
			<tr>
				<td>Create CMS Report: </td>
				<td>
					<select id="type" name="type">
						<option value="info">MySQL Statistics</option>
						<option value="messages">Messages</option>
						<option value="products">Medical Products</option>
						<option value="users">Users</option>
					</select>
				</td>
				<td><input type="submit" id="submit" name="submit" value="Generate Report" /></td>
			</tr>
			<!-- Personal Comment Text Area -->
			<tr>
				<td colspan="3">
					<br/>
					<textarea id="comment" name="comment" cols="75" rows="10">Submit personal comment ...</textarea>
					<br/>
				</td>
			</tr>
		</table>
	</form>
</section>

<?

include '../../tail.php';

?>