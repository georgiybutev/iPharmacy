<?php
/*
 * User can View, Search, Add, Update, and Remove products from the Database
 * JavaScript Functions to Hide/Show View, Add, Update, and Remove HTML Forms
 * JavaScript Functions to Call PHP/MySQL Operations and Display the Result
 * AJAX Enabled
 * User Only Interface
 */

session_start();

// CSS highligh button

$page = "products";
$path = "../../";

include '../../user_header.php';

/*if(($_SESSION['authenticated'] == true) && ($_SESSION['privilege'] == 2)) {
} else {
	header("Location: Error.php");
	exit;
}*/

?>

<script type="text/javascript">

// Call the ini() function on web page load
window.onload = ini;
// Initiate animation variables
var interval = 500;
var opacity = 0.5;
var hide = 1000;

function ini() {
	// Clear all HTML diviosion on page load
	document.getElementById("viewProducts").innerHTML = "";
	document.getElementById("addProducts").innerHTML = "";
	document.getElementById("updateProducts").innerHTML = "";
	document.getElementById("removeProducts").innerHTML = "";
}

// Search for products in the database by user supplied keyword
function searchAllProducts(keyword) {

	// Create AJAX object
	var xmlhttp;
	var type = document.getElementById("type").value;
	var order;
	// Translate the form variable into valid SQL
	if(document.getElementById("alphabetical").checked) {
		order = "name desc";
	} else if (document.getElementById("date").checked) {
		order = "modified desc";
	} else if (document.getElementById("retail").checked) {
		order = "retail_price desc";
	} else {
		order = "id desc";
	}
	xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange = function() {
		// On objected created
		if(xmlhttp.readyState == 1) {
			// Notify the user that the request was compiled
			document.getElementById("result").innerHTML = "Searching . . .";
			// Set the mouse cursor state to wait
			document.body.style.cursor = "wait";
		} else if(xmlhttp.readyState == 3) { // On object sent
			// Notify the user that the request was sent
			document.getElementById("result").innerHTML = "Loading . . .";
			// Set the mouse cursor state to wait
			document.body.style.cursor = "wait";
		} else if(xmlhttp.readyState == 4 && xmlhttp.status == 200) { // On DONE and OK
			// Reset the mourse cursor state
			document.body.style.cursor = "auto";
			// Clear the designated HTML division
			document.getElementById("result").innerHTML = "";
			// Append the results from the script to the HTML division
			document.getElementById("result").innerHTML = xmlhttp.responseText;
		} else {
			// Notify the user on connection failure
			document.getElementById("result").innerHTML = "Connection Failure!";
		}
	}
	// Call the PHP script, pass variables, async
	xmlhttp.open("GET", "ajaxSearchProducts.php?keyword="+keyword+"&type="+type+"&order="+order,true);
	xmlhttp.send();
}

// Display products and update their contents in the database
function searchAndUpdateProducts(keyword) {

	var form = "update";
	var xmlhttp;
	var type = document.getElementById("type").value;
	var order;
	// Translate form variables to valid SQL
	if(document.getElementById("alphabetical").checked) {
		order = "name desc";
	} else if (document.getElementById("date").checked) {
		order = "modified desc";
	} else if (document.getElementById("retail").checked) {
		order = "retail_price desc";
	} else {
		order = "id desc";
	}
	// Create AJAX object
	xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange = function() {
		// On object created
		if(xmlhttp.readyState == 1) {
			// Notify the user that the request was compiled
			document.getElementById("result").innerHTML = "Searching . . .";
			// Set the mouse cursor state to wait
			document.body.style.cursor = "wait";
		} else if(xmlhttp.readyState == 3) { // On object sent
			// Notify the user that the request was sent
			document.getElementById("result").innerHTML = "Loading . . .";
			// Set the mouse cursor state to wait
			document.body.style.cursor = "wait";
		} else if(xmlhttp.readyState == 4 && xmlhttp.status == 200) { // On DONE and OK
			// Reset mouse cursor state
			document.body.style.cursor = "auto";
			// Clear the designated HTML division
			document.getElementById("result").innerHTML = "";
			// Append the results from the script to the division
			document.getElementById("result").innerHTML = xmlhttp.responseText;
		} else {
			// Notify the user on connection failure
			document.getElementById("result").innerHTML = "Connection Failure!";
		}
	}
	// Call the PHP script and pass variables, async
	xmlhttp.open("GET", "ajaxUpdateProducts.php?keyword="+keyword+"&type="+type+"&order="+order+"&form="+form,true);
	xmlhttp.send();
}

// Delete product from the database
function searchAndDeleteProducts(keyword) {
	var form = "delete";
	var xmlhttp;
	var type = document.getElementById("type").value;
	var order;
	// Translate form variables to valid SQL
	if(document.getElementById("alphabetical").checked) {
		order = "name desc";
	} else if (document.getElementById("date").checked) {
		order = "modified desc";
	} else if (document.getElementById("retail").checked) {
		order = "retail_price desc";
	} else {
		order = "id desc";
	}
	// Create AJAX object
	xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange = function() {
		// On object created
		if(xmlhttp.readyState == 1) {
			// Notify the user that the request was compiled
			document.getElementById("result").innerHTML = "Searching . . .";
			// Set the mouse cursor state to wait
			document.body.style.cursor = "wait";
		} else if(xmlhttp.readyState == 3) { // On object sent
			// Notify the user that the request was sent
			document.getElementById("result").innerHTML = "Loading . . .";
			// Set the mouse cursor state to wait
			document.body.style.cursor = "wait";
		} else if(xmlhttp.readyState == 4 && xmlhttp.status == 200) { // On DONE and OK
			// Reset the mouse cursor state
			document.body.style.cursor = "auto";
			// Clear the designated HTML division
			document.getElementById("result").innerHTML = "";
			// Append the results from the PHP script to the division
			document.getElementById("result").innerHTML = xmlhttp.responseText;
		} else {
			// Notify the user on connection failure
			document.getElementById("result").innerHTML = "Connection Failure!";
		}
	}
	// Call the PHP script and pass vairbales, async
	xmlhttp.open("GET", "ajaxDeleteProducts.php?keyword="+keyword+"&type="+type+"&order="+order+"&form="+form,true);
	xmlhttp.send();
}

// Display the view products HTML form
function view() {

	// Create AJAX object
	var xmlhttp;
	var submit = "no";
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		// On DONE and OK
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			// Clear the designated HTML division
			document.getElementById("viewProducts").innerHTML = "";
			// Append the results from the script to the division
			document.getElementById("viewProducts").innerHTML = xmlhttp.responseText;
		}
	}
	// Call the PHP script and pass variable, async
	xmlhttp.open("GET", "ajaxViewProducts.php?submit="+submit,true);
	xmlhttp.send();
	document.getElementById("viewProducts").style.opacity = 1; // software bug
	// Queue animation (fade-out) effect
	setTimeout(function(){document.getElementById("addProducts").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("updateProducts").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("removeProducts").style.opacity = opacity;}, interval);
	// Hide inactive divisions
	setTimeout(function(){document.getElementById("addProducts").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("updateProducts").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("removeProducts").innerHTML = "";}, hide);
}

// Display the add product HTML form
function add() {

	// Create AJAX object
	var xmlhttp;
	var submit = "no";
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		// On DONE and OK
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			// Clear the designated HTML division
			document.getElementById("addProducts").innerHTML = "";
			// Append the response from the script to the division
			document.getElementById("addProducts").innerHTML = xmlhttp.responseText;
		}
	}
	// Call the PHP script and pass variable, async
	xmlhttp.open("GET", "ajaxAddProducts.php?submit="+submit,true);
	xmlhttp.send();
	document.getElementById("addProducts").style.opacity = 1;
	// Queue animation (fade-out) effect
	setTimeout(function(){document.getElementById("viewProducts").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("updateProducts").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("removeProducts").style.opacity = opacity;}, interval);

	setTimeout(function(){document.getElementById("result").style.opacity = opacity;}, interval);
	// Hide inactive HTML divisions
	setTimeout(function(){document.getElementById("viewProducts").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("updateProducts").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("removeProducts").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("result").innerHTML = "";}, hide);
}

// Display update product form
function update() {

	// Create AJAX object
	var form = "search";
	var xmlhttp;
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		// On DONE and OK
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			// Clear the designated HTML division
			document.getElementById("updateProducts").innerHTML = "";
			// Append the results from the script to the HTML division
			document.getElementById("updateProducts").innerHTML = xmlhttp.responseText;
		}
	}
	// Call the PHP script and pass variable, async
	xmlhttp.open("GET", "ajaxUpdateProducts.php?form="+form,true);
	xmlhttp.send();
	document.getElementById("updateProducts").style.opacity = 1;
	// Queue animation (fade-out) effect
	setTimeout(function(){document.getElementById("viewProducts").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("addProducts").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("removeProducts").style.opacity = opacity;}, interval);

	setTimeout(function(){document.getElementById("result").style.opacity = opacity;}, interval);
	// Hide inactive HTML divisions
	setTimeout(function(){document.getElementById("viewProducts").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("addProducts").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("removeProducts").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("result").innerHTML = "";}, hide);
}

// Display remove product form
function remove() {

	// Create AJAX object
	var form = "search";
	var xmlhttp;
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		// On DONE and OK
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			// Clear the designated HTML division
			document.getElementById("removeProducts").innerHTML = "";
			// Append the results from the script to the division
			document.getElementById("removeProducts").innerHTML = xmlhttp.responseText;
		}
	}
	// Call the PHP script and pass variable, async
	xmlhttp.open("GET", "ajaxDeleteProducts.php?form=" + form, true);
	xmlhttp.send();
	document.getElementById("removeProducts").style.opacity = 1;
	// Queue animation (fade-out) effect
	setTimeout(function(){document.getElementById("viewProducts").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("addProducts").style.opacity = opacity;}, interval);
	setTimeout(function(){document.getElementById("updateProducts").style.opacity = opacity;}, interval);

	setTimeout(function(){document.getElementById("result").style.opacity = opacity;}, interval);
	// Hide inactive HTML divisions
	setTimeout(function(){document.getElementById("viewProducts").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("updateProducts").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("addProducts").innerHTML = "";}, hide);
	setTimeout(function(){document.getElementById("result").innerHTML = "";}, hide);
}
</script>

<section>
	<!-- Display Manage Product Navigation Menu -->
	<table>
		<td><a class="admin_products" href="#">View<br/><img src="../../media/view.ico" onclick="view()"></a></td>
		<td><a class="admin_products" href="#">Add New<br/><img src="../../media/add.ico" onclick="add()"></a></td>
		<td><a class="admin_products" href="#">Update<br/><img src="../../media/update.ico" onclick="update()"></a></td>
		<td><a class="admin_products" href="#">Remove<br/><img src="../../media/remove.ico" onclick="remove()"></a></td>
	</table>
	<!-- Display Manage Product JS Controlled Divisions -->
	<div id="viewProducts"></div>
	<div id="result"></div>
	<div id="addProducts"></div>
	<div id="updateProducts"></div>
	<div id="resultUpdate"></div>
	<div id="removeProducts"></div>
</section>

<?

include '../../tail.php';

?>