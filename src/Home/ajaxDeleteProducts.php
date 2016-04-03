<?php

/*
 * Search Products in the Database
 * Delete Products from the Database
 * AJAX Enabled
 * User Only Interface
 */

// Get AJAX variables
$getForm = $_GET['form'];

if ($getForm == "search") {
	// Display HTML Form
	echo "<table>";
		echo "<form action=\"\">";
			echo "<tr>";
				echo "<td>Search Products: <input type=\"text\" id=\"searchField\" onkeyup=\"searchAndDeleteProducts(this.value)\" /></td>";
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
} else if ($getForm == "delete") {
	// SQL and HTML Form
	// To delete a product, first a connection to the database is established
	// Then all products are fetched from the database filtered by keyword, type, and order
	$keyword = $_GET['keyword'];
	$type = $_GET['type'];
	$order = $_GET['order'];

	include '../../settings.php';
	$settings = new Settings();
	$settings->connectToDatabase();

	include '../../library/database_operations.php';
	$db = new databaseOperations;
	$result = $db->searchAllProducts($keyword, $type, $order);

	// Process MySQL result set
	while($row = mysql_fetch_assoc($result)) {
		echo "<table>";
		echo "<form id=\"ajaxDeleteProducts\" name=\"ajaxDeleteProducts\" method=\"POST\" action=\"ajaxDeleteProducts\" >";
		echo "<th>Name: </th>";
		echo "<th>Brand: </th>";
		echo "<th>Quantity: </th>";
		echo "<th>Category: </th>";
		echo "<th>Size: </th>";
		echo "<th>Intake: </th>";
		echo "<input type=\"hidden\" id=\"id\" name=\"id\" value=\"" . $row['id'] . "\" />";
		echo "<tr>";
		echo "<td><a href=\"../../" . $row['kb'] . "\" title=\"Latin Name: " . $row['latin'] . "\">" . $row['name'] . "</a></td>";
		echo "<td><a href=\"#\" title=\"Manufacturer: " . $row['brand'] . "\">" . $row['manufacturer'] . "</a></td>";
		echo "<td>" . $row['quantity'] . "</td>";
		echo "<td>" . $row['category'] . "</td>";
		echo "<td>" . $row['size'] . "</td>";
		echo "<td>" . $row['intake'] . "</td>";
		echo "</tr>";
		echo "<th>Frequency: </th>";
		echo "<th>Volume: </th>";
		echo "<th>Delivery: </th>";
		echo "<th>Price: </th>";
		echo "<th>Reference: </th>";
		echo "<th>Barcode: </th>";
		echo "<tr>";
		echo "<td>" . $row['frequency'] . "</td>";
		
		// Translate character values from the database
		switch ($row['volume']) {
			case 'S':
				$volume = "Small";
				break;
			case 'M':
				$volume = "Medium";
				break;
			case 'L':
				$volume = "Large";
				break;
			case 'XL':
				$volume = "Extra Large";
				break;
			case 'XXL':
				$volume = "Extra Extra Large";
				break;
			default:
				$volume = "";
				break;
		}
		echo "<td>" . $volume . "</td>";

		// If delivery days are more than one, use dayS, weekS, and monthS
		if($row['delivery_num'] > 1) {
			$delivery = $row['delivery_num'] . " " . $row['delivery_days'] . "s";
		} else {
			$delivery = $row['delivery_num'] . $row['delivery_days'];
		}
		echo "<td>" . $delivery . "</td>";
		// The price is displayed with prefix - pound sing
		echo "<td><a href=\"#\" title=\"Manufacturer Price: &#163; " . $row['man_price'] . "\">&#163; " . $row['retail_price'] . "</a></td>";
		echo "<td><a href=\"" . $row['reference'] . "\" title=\"External Web Resource\">link</a></td>";
		echo "<td>" . $row['barcode'] . "</td>";
		echo "</tr>";
		echo "<th>Prescription: </th>";
		echo "<th>Cover: </th>";
		echo "<th>Submit: </th>";
		echo "<tr>";
		echo "<td>" . $row['prescription'] . "</td>";
		echo "<td><img src=\"../../" . $row['cover'] . "\" width=\"100\" height=\"100\"></td>";
		echo "<td><input title=\"" . $row['id'] . "\" type=\"submit\" id=\"submit\" name=\"submit\" value=\"Delete\" /></td>";
		echo "</tr>";
		echo "</form>";
		echo "</table>";
	}

} else if (isset($_POST['submit'])) {
	// SQL DELETE
	// Connect to database and delete product by id
	include '../../settings.php';
	$settings = new Settings();
	$settings->connectToDatabase();

	include '../../library/database_operations.php';
	$db = new databaseOperations;
	$success = $db->deleteProductUser();
	echo $success;

} else {
	// Exception
	echo "Exception";
}

?>