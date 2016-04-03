<?php 

/*
 * Display Results in an HTML Table
 * Mark Message as Reviewed (DB)
 * Remove Message from the DB
 * Search for Messages in the DB by Keyword
 * Send Message to User in the DB with Subject, Contents, File
 * Allow for JavaScript Result Sorting
 * User Only Interface
 * AJAX Enabled
 */

// Get AJAX variables
$getAction = $_GET['action'];
$getSort = $_GET['sort'];
$getMessageId = $_GET['messageId'];
$getKeyword = $_GET['keyword'];

// Connect to the database
include '../../settings.php';
$settings = new Settings();
$settings->connectToDatabase();

// Create database object to be used by all following methods
include '../../library/database_operations.php';
$db = new databaseOperations;

if ($getAction == "showMessages") {
	
	// Based on the supplied form variables
	// Translate to valid SQL
	switch ($getSort) {
		case 'nosort':
			$sort = "";
			break;
		case 'sender':
			$sort = " order by sender";
			break;
		case 'receiver':
			$sort = " order by receiver";
			break;
		case 'date':
			$sort = " order by date desc";
			break;
		case 'reviewed':
			$sort = " order by reviewed";
			break;
		default:
			$sort = "";
			break;
	}

	// Query for all messages in the database table
	$result = $db->viewAllMessages($sort);

	// Process MySQL result set
	// Build TD structure
	while ($row = mysql_fetch_assoc($result)) {
		echo "<table>";
			echo "<th class=\"messages\"><a href=\"#\" title=\"Sort by Sender\" onclick=\"view('sender')\">from</a></th>";
			echo "<th class=\"messages\"><a href=\"#\" title=\"Sort by Receiver\" onclick=\"view('receiver')\">to</a></th>";
			echo "<th class=\"messages\">subject</th>";
			echo "<th class=\"messages\"><a href=\"#\" title=\"Sort by Date\" onclick=\"view('date')\">date</a></th>";
			echo "<th class=\"messages\">file</th>";
			echo "<th class=\"messages\"><a href=\"#\" title=\"Sort by Reviewed\" onclick=\"view('reviewed')\">reviewed</a></th>";
			echo "<tr>";
				echo "<td>" . $row['sender'] . "</td>";
				echo "<td>" . $row['receiver'] . "</td>";
				echo "<td>" . $row['subject'] . "</td>";
				echo "<td>" . $row['date'] . "</td>";
				echo "<td><a href=\"" . $row['file'] . "\">link</a></td>";
				// If message is reviewed, display green icon
				// Otherwise notify the user
				if($row['reviewed'] == "n") {
					echo "<td id=\"reviewed\">Not Yet</td>";
					echo "<input type=\"button\" id=\"" . $row['id'] . "\" name=\"markAsReviewed\" title=\"" . $row['id'] . "\" value=\"Mark as Reviewed\" onclick=\"markAsReviewed(this.title)\" />";
				} else if ($row['reviewed'] == "y") {
					echo "<td><img src=\"../../media/success.ico\" /></td>";
				} else {
					echo "";
				}
			echo "</tr>";
			echo "<th class=\"messages\" colspan=\"6\">message</th>";
			echo "<tr>";
				echo "<td colspan=\"6\">" . $row['message'] . "</td>";
			echo "</tr>";
		echo "</table>";
	}
} else if ($getAction == "markAsReviewed") {

	// Mark a message in the database table as reviewed by setting the field to - y
	$result = $db->markMessageAsRead($getMessageId);

} else if ($getAction == "removeMessage") {

	// Based on the supplied form variables
	// Translate to valid SQL
	switch ($getSort) {
		case 'nosort':
			$sort = "";
			break;
		case 'sender':
			$sort = " order by sender";
			break;
		case 'receiver':
			$sort = " order by receiver";
			break;
		case 'date':
			$sort = " order by date desc";
			break;
		case 'reviewed':
			$sort = " order by reviewed";
			break;
		default:
			$sort = "";
			break;
	}
	
	// Query for all messages in the database table
	$result = $db->viewAllMessages($sort);

	// Process SQL result set
	// Build TD structure
	while ($row = mysql_fetch_assoc($result)) {
		echo "<table>";
			echo "<th class=\"messages\"><a href=\"#\" title=\"Sort by Sender\" onclick=\"remove('sender')\">from</a></th>";
			echo "<th class=\"messages\"><a href=\"#\" title=\"Sort by Receiver\" onclick=\"remove('receiver')\">to</a></th>";
			echo "<th class=\"messages\">subject</th>";
			echo "<th class=\"messages\"><a href=\"#\" title=\"Sort by Date\" onclick=\"remove('date')\">date</a></th>";
			echo "<th class=\"messages\">file</th>";
			echo "<th class=\"messages\"><a href=\"#\" title=\"Sort by Reviewed\" onclick=\"remove('reviewed')\">reviewed</a></th>";
			echo "<tr>";
				echo "<input type=\"button\" id=\"" . $row['id'] . "\" name=\"removeMessage\" value=\"Delete\" title=\"" . $row['id'] . "\" onclick=\"removeMessage(this.title)\" />";
				echo "<td>" . $row['sender'] . "</td>";
				echo "<td>" . $row['receiver'] . "</td>";
				echo "<td>" . $row['subject'] . "</td>";
				echo "<td>" . $row['date'] . "</td>";
				echo "<td><a href=\"" . $row['file'] . "\">link</a></td>";
				// If message is reviewed, display green icon
				// Otherwise notify the user
				if($row['reviewed'] == "n") {
					echo "<td>Not Yet</td>";
				} else if ($row['reviewed'] == "y") {
					echo "<td><img src=\"../../media/success.ico\" /></td>";
				} else {
					echo "<td></td>";
				}
			echo "</tr>";
			echo "<th class=\"messages\" colspan=\"6\">message</th>";
			echo "<tr>";
				echo "<td colspan=\"6\">" . $row['message'] . "</td>";
			echo "</tr>";
		echo "</table>";
	}
} else if ($getAction == "delete") {

	// Remove row from the messages database table based on id
	$result = $db->removeMessage($getMessageId);

} else if ($getAction == "searchForm") {

	// Display HTML form for searching messages
	// The JS send value is used as search keyword
	echo "<table>";
		echo "<tr>";
			echo "<td>Search Messages: <input type=\"text\" onkeyup=\"searchMessages(this.value)\" /></td>";
		echo "</tr>";
	echo "</table>";

} else if ($getAction == "searchMessages") {

	// Search for messages matching keyword in the database table
	$result = $db->searchMessages($getKeyword);
	// Build TD structure for the found message in the database table
	// Highligh the TH which was matched in the database
	echo "<table>";
		if($result[0] == "sender") {echo "<th class=\"messages\" id=\"searchMessagesTH\">from</th>";} else {echo "<th class=\"messages\">from</th>";}
		if($result[0] == "receiver") {echo "<th class=\"messages\" id=\"searchMessagesTH\">to</th>";} else {echo "<th class=\"messages\">to</th>";}
		if($result[0] == "subject") {echo "<th class=\"messages\" id=\"searchMessagesTH\">subject</th>";} else {echo "<th class=\"messages\">subject</th>";}
		if($result[0] == "date") {echo "<th class=\"messages\" id=\"searchMessagesTH\">date</th>";} else {echo "<th class=\"messages\">date</th>";}
		if($result[0] == "file") {echo "<th class=\"messages\" id=\"searchMessagesTH\">file</th>";} else {echo "<th class=\"messages\">file</th>";}
		echo "<th class=\"messages\">reviewed</th>";
		echo "<tr>";
			echo "<td>" . $result['sender'] . "</td>";
			echo "<td>" . $result['receiver'] . "</td>";
			echo "<td>" . $result['subject'] . "</td>";
			echo "<td>" . $result['date'] . "</td>";
			echo "<td><a href=\"" . $result['file'] . "\">link</a></td>";
			// If message is reviewed, display green icon
			// Otherwise notify the user
			if($result['reviewed'] == "n") {
				echo "<td id=\"reviewed\">Not Yet</td>";
			} else if ($result['reviewed'] == "y") {
				echo "<td><img src=\"../../media/success.ico\" /></td>";
			} else {
				echo "";
			}
		echo "</tr>";
		// Display the retrieved message in text area HTML element
		if($result[0] == "message") {echo "<th class=\"messages\" id=\"searchMessagesTH\" colspan=\"6\">message</th>";} else {echo "<th class=\"messages\" colspan=\"6\">message</th>";}
		echo "<tr>";
			echo "<td colspan=\"6\">" . $result['message'] . "</td>";
		echo "</tr>";
	echo "</table>";

} else if ($getAction == "sendForm") {
	// Display HTML form for sending a message
	echo "<form method=\"POST\" action=\"ajaxMessages.php\" enctype=\"multipart/form-data\">";
	echo "<table>";
		echo "<th>Form: </th>";
		echo "<th>Contents: </th>";
		echo "<tr>";
			echo "<td><label for=\"receiver\">Send message to:</label></td>";
			echo "<td><input type=\"text\" id=\"receiver\" name=\"receiver\" /></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td><label for=\"subject\">Message subject: </label></td>";
			echo "<td><input type=\"text\" id=\"subject\" name=\"subject\" /></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td><label for=\"file\">Attach file: </label></td>";
			echo "<td><input type=\"file\" id=\"file\" name=\"file\" /></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td><label for=\"message\">Text message: </label></td>";
			echo "<td><textarea id=\"message\" name=\"message\" rows=\"10\"></textarea></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td><label for=\"submit\">Submit: </label></td>";
			echo "<td><input type=\"submit\" id=\"submit\" name=\"submit\" value=\"Send Message\" /></td>";
		echo "</tr>";
	echo "</table>";
	echo "</form>";
} else if (isset($_POST['submit'])) {
	// If the form was submitted, send the compiled message
	$result = $db->sendMessage();
	// Notify of the success / failure of the operation
	echo $result;
}

?>