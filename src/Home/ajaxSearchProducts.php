<?php

/*
 * Search Products in the Database
 * Filter by User Supplied Keyword, Type, and Sort
 * Keyword - GET String
 * Type - name, latin, brand , manufacturer, category, barcode, and price
 * Sort - alphabetical, date stamp, retail price order
 * User Only Interface
 * AJAX Enabled
 */

// Get AJAX variables
$keyword = $_GET['keyword'];
$type = $_GET['type'];
$order = $_GET['order'];

// Connect to the database
include '../../settings.php';
$settings = new Settings();
$settings->connectToDatabase();

// Search for products in the database by keyword, type, and order
include '../../library/database_operations.php';
$db = new databaseOperations;
$result = $db->searchAllProducts($keyword, $type, $order);

// Process MySQL server result set
// Build TD structure for each product
while($row = mysql_fetch_assoc($result)) {
	echo "<table>";
	echo "<th>Name: </th>";
	echo "<th>Brand: </th>";
	echo "<th>Quantity: </th>";
	echo "<th>Category: </th>";
	echo "<th>Size: </th>";
	echo "<th>Intake: </th>";
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
	
	// Translate short form to meaningful string for product volume
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

	// Display postfix 's' after day, week, month if the delivery number is bigger than 1
	if($row['delivery_num'] > 1) {
		$delivery = $row['delivery_num'] . " " . $row['delivery_days'] . "s";
	} else {
		$delivery = $row['delivery_num'] . $row['delivery_days'];
	}
	echo "<td>" . $delivery . "</td>";
	// Append the pound sign to the price values
	echo "<td><a href=\"#\" title=\"Manufacturer Price: &#163; " . $row['man_price'] . "\">&#163; " . $row['retail_price'] . "</a></td>";
	echo "<td><a href=\"" . $row['reference'] . "\" title=\"External Web Resource\">link</a></td>";
	echo "<td>" . $row['barcode'] . "</td>";
	echo "</tr>";
	echo "<th>Prescription: </th>";
	echo "<th>Product Cover: </th>";
	echo "<tr>";
	echo "<td>" . $row['prescription'] . "</td>";
	// Restrict product image size
	echo "<td><img src=\"../../" . $row['cover'] . "\" width=\"100\" height=\"100\"></td>";
	echo "</tr>";
	echo "</table>";
}

?>