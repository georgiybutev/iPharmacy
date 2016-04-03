<?php

/*
 * Update Products in the Database
 * Display HTML Search Form
 * User Only Interface
 * AJAX Enabled
 */

// Get AJAX variables
$getForm = $_GET['form'];

// Display HTML form for searching products in the database
if($getForm == "search") {
	echo "<table>";
		echo "<form action=\"\">";
			echo "<tr>";
				echo "<td>Search Products: <input type=\"text\" id=\"searchField\" onkeyup=\"searchAndUpdateProducts(this.value)\" /></td>";
				echo "<td>Select type: ";
					echo "<select id=\"type\">";
						echo "<option value=\"name\">Name</option>";
						echo "<option value=\"latin\">Latin</option>";
						echo "<option value=\"brand\">Brand</option>";
						echo "<option value=\"manufacturer\">Manufacturer</option>";
						echo "<option value=\"category\">Category</option>";
						echo "<option value=\"barcode\">Barcode</option>";
						echo "<option value=\"man_price\">Manufacturer Price</option>";
						echo "<option value=\"retail_price\">Retail Price</option>";
					echo "</select>";
				echo "</td>";
				echo "<td>Order:<br/>Alphabetically ";
					echo "<input type=\"radio\" name=\"order\" id=\"alphabetical\" value=\"alphabetical\" />";
					echo "<br/>Date <input type=\"radio\" name=\"order\" id=\"date\" value=\"date\" />";
					echo "<br/>Retail Price <input type=\"radio\" name=\"order\" id=\"retail\" value=\"retail\" />";
				echo "</td>";
			echo "</tr>";
		echo "</form>";
	echo "</table>";
} else if ($getForm == "update") {
	// SQL and HTML Form
	$keyword = $_GET['keyword'];
	$type = $_GET['type'];
	$order = $_GET['order'];
	// Connect to the database
	include '../../settings.php';
	$settings = new Settings();
	$settings->connectToDatabase();
	// Search for product in the database by keyword, type, and order
	include '../../library/database_operations.php';
	$db = new databaseOperations;
	$result = $db->searchAllProducts($keyword, $type, $order);
	// Process MySQL server result set
	while($row = mysql_fetch_assoc($result)) {
		echo "<table>";
		echo "<form id=\"ajaxUpdateProducts\" name=\"ajaxUpdateProducts\" method=\"POST\" action=\"ajaxUpdateProducts\" >";
		echo "<th>Name: </th>";
		echo "<th>Latin: </th>";
		echo "<th>Brand: </th>";
		echo "<input type=\"hidden\" id=\"id\" name=\"id\" value=\"" . $row['id'] . "\" />";
		echo "<tr>";
		echo "<td><input type=\"text\" id=\"name\" name=\"name\" value=\"" . $row['name'] . "\" /></td>";
		echo "<td><input type=\"text\" id=\"latin\" name=\"latin\" value=\"" . $row['latin'] . "\" /></td>";
		echo "<td><input type=\"text\" id=\"brand\" name=\"brand\" value=\"" . $row['brand'] . "\" /></td>";
		echo "</tr>";
		echo "<th>Manufacturer: </th>";
		echo "<th>Quantity: </th>";
		echo "<th>Category: </th>";
		echo "<tr>";
		echo "<td><input type=\"text\" id=\"manufacturer\" name=\"manufacturer\" value=\"" . $row['manufacturer'] . "\" /></td>";
		echo "<td><input type=\"text\" id=\"quantity\" name=\"quantity\" value=\"" . $row['quantity'] . "\" /></td>";
		echo "<td><input type=\"text\" id=\"category\" name=\"category\" value=\"" . $row['category'] . "\" /></td>";
		echo "</tr>";
		echo "<th>Size: </th>";
		echo "<th>Intake: </th>";
		echo "<th>Frequency: </th>";
		echo "<tr>";
		echo "<td><input type=\"text\" id=\"size\" name=\"size\" value=\"" . $row['size'] . "\" /></td>";
		echo "<td>";
			// Make sure the correct intake type is selected from the select-option list
			echo "<select id=\"intake\" name=\"intake\">";
				if($row['intake'] == "Peroral") {echo "<option selected=\"selected\" value=\"Peroral\">Peroral</option>";} else {echo "<option value=\"Peroral\">Peroral</option>";}
				if($row['intake'] == "Eye Drops") {echo "<option selected=\"selected\" value=\"Eye Drops\">Eye Drops</option>";} else {echo "<option value=\"Eye Drops\">Eye Drops</option>";}
				if($row['intake'] == "Ear Drops") {echo "<option selected=\"selected\" value=\"Ear Drops\">Ear Drops</option>";} else {echo "<option value=\"Ear Drops\">Ear Drops</option>";}
				if($row['intake'] == "Nose Drops") {echo "<option selected=\"selected\" value=\"Nose Drops\">Nose Drops</option>";} else {echo "<option value=\"Nose Drops\">Nose Drops</option>";}
				if($row['intake'] == "Eye Gels") {echo "<option selected=\"selected\" value=\"Eye Gels\">Eye Gels</option>";} else {echo "<option value=\"Eye Gels\">Eye Gels</option>";}
				if($row['intake'] == "Inhalers") {echo "<option selected=\"selected\" value=\"Inhalers\">Inhalers</option>";} else {echo "<option value=\"Inhalers\">Inhalers</option>";}
				if($row['intake'] == "Injections" || $row['intake'] == "Injection") {echo "<option selected=\"selected\" value=\"Injections\">Injections</option>";} else {echo "<option selected=\"selected\" value=\"Injections\">Injections</option>";}
				if($row['intake'] == "Rectal Suppositories") {echo "<option selected=\"selected\" value=\"Rectal Suppositories\">Rectal Suppositories</option>";} else {echo "<option value=\"Rectal Suppositories\">Rectal Suppositories</option>";}
			echo "</select>";
		echo "</td>";
		echo "<td>";
			// Make sure the correct frequency is selected from the select-option list
			echo "<select id=\"frequency\" name=\"frequency\">";
					if($row['frequency'] == "Daily") {echo "<option selected=\"selected\" value=\"Daily\">Daily</option>";} else {echo "<option value=\"Daily\">Daily</option>";}
					if($row['frequency'] == "Weekly") {echo "<option selected=\"selected\" value=\"Weekly\">Weekly</option>";} else {echo "<option value=\"Weekly\">Weekly</option>";}
					if($row['frequency'] == "Biweekly") {echo "<option selected=\"selected\" value=\"Biweekly\">Biweekly</option>";} else {echo "<option value=\"Biweekly\">Biweekly</option>";}
					if($row['frequency'] == "Montly") {echo "<option selected=\"selected\" value=\"Montly\">Monthly</option>";} else {echo "<option value=\"Montly\">Monthly</option>";}
			echo "</select>";
		echo "</td>";
		echo "</tr>";
		echo "<th>Volume: </th>";
		echo "<th>Delivery Time: </th>";
		echo "<th>Manufacturer Price: </th>";
		echo "<tr>";
		echo "<td>";
			// Make sure the correct product volume is selected from the select-option list
			echo "<select id=\"volume\" name=\"volume\">";
				if($row['volume'] == "S") {echo "<option selected=\"selected\" value=\"S\">Small</option>";} else {echo "<option value=\"S\">Small</option>";}
				if($row['volume'] == "M") {echo "<option selected=\"selected\" value=\"M\">Medium</option>";} else {echo "<option value=\"M\">Medium</option>";}
				if($row['volume'] == "L") {echo "<option selected=\"selected\" value=\"L\">Large</option>";} else {echo "<option value=\"L\">Large</option>";}
				if($row['volume'] == "XL") {echo "<option selected=\"selected\" value=\"XL\">Extra Large</option>";} else {echo "<option value=\"XL\">Extra Large</option>";}
				if($row['volume'] == "XXL") {echo "<option selected=\"selected\" value=\"XXL\">Extra Extra Large</option>";} else {echo "<option value=\"XXL\">Extra Extra Large</option>";}
			echo "</select>";
		echo "</td>";
		echo "<td><input type=\"text\" id=\"delivery_num\" name=\"delivery_num\" maxlength=\"2\" value=\"" . $row['delivery_num'] . "\" />";
			// Make sure the correct delivery days is selected from the select-option list
			echo "<select id=\"delivery_days\" name=\"delivery_days\">";
				if($row['delivery_days'] == "day") {echo "<option selected=\"selected\" value=\"day\">Days</option>";} else {echo "<option value=\"day\">Days</option>";}
				if($row['delivery_days'] == "week") {echo "<option selected=\"selected\" value=\"week\">Weeks</option>";} else {echo "<option value=\"week\">Weeks</option>";}
				if($row['delivery_days'] == "month") {echo "<option selected=\"selected\" value=\"month\">Months</option>";} else {echo "<option value=\"month\">Months</option>";}
			echo "</select>";
		echo "</td>";
		echo "<td><input type=\"text\" id=\"man_price\" name=\"man_price\" value=\"" . $row['man_price'] . "\" /></td>";
		echo "</tr>";
		echo "<th>Retail Price: </th>";
		echo "<th>Barcode: </th>";
		echo "<th>Cover: </th>";
		echo "<tr>";
		echo "<td><input type=\"text\" id=\"retail_price\" name=\"retail_price\" value=\"" . $row['retail_price'] . "\" /></td>";
		echo "<td><input type=\"text\" id=\"barcode\" name=\"barcode\" value=\"" . $row['barcode'] . "\" /></td>";
		// Restric the product image size
		echo "<td><img src=\"../../" . $row['cover'] . "\" width=\"100\" height=\"100\"></td>";
		echo "</tr>";
		echo "<th></th>";
		echo "<th>Submit: </th>";
		echo "<tr>";
		echo "<td></td>";
		echo "<td><input title=\"" . $row['id'] . "\" id=\"submit\" name=\"submit\" type=\"submit\" value=\"Update\" /></td>";
		echo "</tr>";
		echo "</form>";
		echo "</table>";
	}

} else if (isset($_POST['submit'])) {
	// SQL UPDATE

	// Connect to the database
	include '../../settings.php';
	$settings = new Settings();
	$settings->connectToDatabase();
	// Update the product data in the database
	include '../../library/database_operations.php';
	$db = new databaseOperations;
	$success = $db->updateProductUser();
	// Notify the user of success or failure
	echo $success;

} else {
	// Exception
	echo "Exception";
}

?>