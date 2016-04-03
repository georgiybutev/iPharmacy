<?php

/*
 * Messages Interface
 * Mailbox, Receive, and Send
 * User can Attach Files - Images, PDF, and Doc.
 * Only for Registered Users
 * User Only Interface
 */

session_start();

// CSS highlight button

$page = "messages";
$path = "../../";

include '../../user_header.php';

/*if(($_SESSION['authenticated'] == true) && ($_SESSION['privilege'] == 2)) {
} else {
	header("Location: Error.php");
	exit;
}*/

?>

<script type="text/javascript">

// Load the ini() function on page load
window.onload = ini;
// Set animation variables
opacity = 0.5;
interval = 500;
hide = 1000;

function ini() {
	// Clear the HTML divisions of their contents
	document.getElementById("view").innerHTML = "";
	document.getElementById("search").innerHTML = "";
	document.getElementById("send").innerHTML = "";
	document.getElementById("remove").innerHTML = "";
	document.getElementById("result").innerHTML = "";
}

// Sort the displayed messages by field type
function view(sort) {

	// Create AJAX object
	var action = "showMessages";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		// On DONE and OK
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			// Clear HTML division
			document.getElementById("result").innerHTML = "";
			// Append the output of ajaxMessages to the HTML division
			document.getElementById("result").innerHTML = xmlhttp.responseText;
		}
	}
	// Call PHP script, pass variables, true means async
	xmlhttp.open("GET", "ajaxMessages.php?action=" + action + "&sort=" + sort, true);
	xmlhttp.send();
	// Queue animation (fade-out) effects
	setTimeout(function(){document.getElementById("result").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("result").style.opacity = 1;}, 1000);

	setTimeout(function(){document.getElementById("search").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("send").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("remove").style.opacity = opacity;}, interval);
	// Hide inactive HTML divisions
	setTimeout(function(){document.getElementById("search").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("send").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("remove").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("result").innerHTML = "";}, hide);

}

// Mark a message in the database as read or reviewed by message id
function markAsReviewed(messageId) {

	// Create AJAX object
	var action = "markAsReviewed";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		// One DONE and OK
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			// Disable Button
			setTimeout(function(){document.getElementById(messageId).value = "Reviewed";}, 500);
			setTimeout(function(){document.getElementById(messageId).disabled = "disabled";}, 1000);
			// Hide "Not Yet"
			setTimeout(function(){document.getElementById("reviewed").style.opacity = 0.5;}, 500);
			setTimeout(function(){document.getElementById("reviewed").innerHTML = "";}, 1000);
			// Show Success Icon
			setTimeout(function(){document.getElementById("reviewed").style.opacity = 0.5;}, 1500);
			setTimeout(function(){document.getElementById("reviewed").style.opacity = 1;}, 2000);
			setTimeout(function(){document.getElementById("reviewed").innerHTML = "<img src=\"../../media/success.ico\" />";}, 2000);
		}
	}
	// Call PHP script and pass variables, true means async
	xmlhttp.open("GET", "ajaxMessages?action=" + action + "&messageId=" + messageId, true);
	xmlhttp.send();

}

// Display form for seaching messages
function search() {

	// Create AJAX object
	var action = "searchForm";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		// On DONE and OK
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			// Clear the HTML division
			document.getElementById("search").innerHTML = "";
			// Append the result from ajaxMessages to the HTML division
			document.getElementById("search").innerHTML = xmlhttp.responseText;
		}
	}
	// Call the PHP script pass variable, true means async
	xmlhttp.open("GET", "ajaxMessages.php?action=" + action, true);
	xmlhttp.send();
	// Queue animation (fade-out) effect
	setTimeout(function(){document.getElementById("search").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("search").style.opacity = 1;}, 1000);

	setTimeout(function(){document.getElementById("view").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("send").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("remove").style.opacity = opacity;}, interval);
	// Hide inactive HTML divisions
	setTimeout(function(){document.getElementById("view").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("send").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("remove").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("result").innerHTML = ""};), hide;

}

// Perform dabase search for message by user supplied keyword
function searchMessages(keyword) {
	
	// Create AJAX object
	var action = "searchMessages";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		// On object created
		if(xmlhttp.readyState == 1) {
			// Notify user that the request was compiled
			document.getElementById("result").innerHTML = "Searching . . .";
			// The mouse cursor is set to wait state
			document.body.style.cursor = "wait";
		} else if(xmlhttp.readyState == 3) { // One object sent
			// Notify user that the request was sent
			document.getElementById("result").innerHTML = "Loading . . .";
			// The mouse cursor is set to wait state
			document.body.style.cursor = "wait";
		} else if(xmlhttp.readyState == 4 && xmlhttp.status == 200) { // On DONE and OK
			// The mouse cursor is set to normal state
			document.body.style.cursor = "auto";
			// Clear the HTML division
			document.getElementById("result").innerHTML = "";
			// Append the result to the HTML division
			document.getElementById("result").innerHTML = xmlhttp.responseText;
		} else {
			// Notify the user on connection failur
			document.getElementById("result").innerHTML = "Connection Failure!";
		}
	}
	// Call PHP script with variables, true means async
	xmlhttp.open("GET", "ajaxMessages.php?action=" + action +"&keyword=" + keyword, true);
	xmlhttp.send();

}

// Display HTML form for sending a message
function send() {

	// Create AJAX message
	var action = "sendForm";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		// On DONE and OK
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			// Clear the HTML division
			document.getElementById("send").innerHTML = "";
			// Append the result from the script to the HTML division
			document.getElementById("send").innerHTML = xmlhttp.responseText;
		}
	}
	// Call  the PHP script with variable, true means async
	xmlhttp.open("GET", "ajaxMessages.php?action=" + action, true);
	xmlhttp.send();
	// Queue animation (fade-out) effect
	setTimeout(function(){document.getElementById("send").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("send").style.opacity = 1;}, 1000);

	setTimeout(function(){document.getElementById("view").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("search").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("remove").style.opacity = opacity;}, interval);
	// Hide inactive HTML divisions
	setTimeout(function(){document.getElementById("view").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("search").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("remove").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("result").innerHTML = ""};), hide;
}

// Display the HTML remove message form
function remove(sort) {

	// Create AJAX object
	var action = "removeMessage";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		// On DONE and OK
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			// Clear the designated division
			document.getElementById("result").innerHTML = "";
			// Append the results from the script to the HTML division
			document.getElementById("result").innerHTML = xmlhttp.responseText;
		}
	}
	// Call the PHP script with variables, true means async
	xmlhttp.open("GET", "ajaxMessages?action=" + action + "&sort=" + sort, true);
	xmlhttp.send();
	// Queue animation (fade-out) effect
	setTimeout(function(){document.getElementById("result").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("result").style.opacity = 1;}, 1000);

	setTimeout(function(){document.getElementById("search").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("send").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("view").style.opacity = opacity;}, interval);
	// Hide inactive HTML divisions
	setTimeout(function(){document.getElementById("search").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("send").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("view").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("result").innerHTML = ""};), hide;

}

// Remove message from the database by message id
function removeMessage(messageId) {

	// Create AJAX object
	var action = "delete";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		// On DONE and OK
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			// Disable Button
			setTimeout(function(){document.getElementById(messageId).value = "Deleted";}, 500);
			setTimeout(function(){document.getElementById(messageId).disabled = "disabled";}, 1000);
			//document.getElementById("result").innerHTML = xmlhttp.responseText;
		}
	}
	// Call the PHP script with variable, true means async
	xmlhttp.open("GET", "ajaxMessages?action=" + action + "&messageId=" + messageId, true);
	xmlhttp.send();
}

</script>

<!-- Display HTML Divisions and Navigation Links -->
<section>
	<table>
		<td><a class="messages" href="#">View<br/><img src="../../media/receive.ico" onclick="view('nosort')"></a></td>
		<td><a class="messages" href="#">Search<br/><img src="../../media/search.ico" onclick="search()"></a></td>
		<td><a class="messages" href="#">Send<br/><img src="../../media/send.ico" onclick="send()"></a></td>
		<td><a class="messages" href="#">Remove<br/><img src="../../media/remove.ico" onclick="remove('nosort')"></a></td>
	</table>
	<div id="view">view</div>
	<div id="search">search</div>
	<div id="send">send</div>
	<div id="remove">remove</div>
	<div id="result">result</div>
</section>

<?

include '../../tail.php';

?>