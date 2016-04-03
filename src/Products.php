<?php

/*
 * Display All Products as Tag Popularity
 * The Popularity of a Product is Determined by the Retail Price
 * The Most Popular:
 *		-> Text Color = Teal
 *		-> Font Size = 20px
 * Guest Only Interface
 */

// CSS highlight button
$page = "products";
// Counter for the number of products displayed in the table
$counter = 1;

include 'head.php';

// Select the highest product price
$query = "select name, max(retail_price) from product";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$max = $row[1];

// Select the lowest product price
$query = "select name, min(retail_price) from product";
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$min = $row[1];

// Select 15 products from the database, last added
$query = "select id, name, manufacturer, retail_price, prescription, modified from product order by id asc limit 0, 15";
$result = mysql_query($query);

// Build HTML table
echo "<table>";
echo "<th>#</th>";
echo "<th>Name</th>";
echo "<th>Manufacturer</th>";
echo "<th>Retail Price</th>";
echo "<th>Description</th>";

// If the user has made category selection
if (isset($_GET['submit'])) {
	
	// Select from the product database, match category
	$query = "select id, name, manufacturer, retail_price, prescription, modified from product where category='" . $_GET['submit'] . "' order by id asc limit 0, 15";
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)) {

		// Build TD structure
		echo "<tr>";
		echo "<td>" . $counter++ . "</td>";
		// If this is the highest price, change color to teal and size 20px
		if($row['retail_price'] == $max) {
			echo "<td><a id=\"max_retail_price\" href=\"#\" title=\"" . $row['modified'] . "\">" . $row['name'] . "</a></td>";

		// If this is the lowest price, change color to red and size 8px
		} else if ($row['retail_price'] == $min) {
			echo "<td><a id=\"min_retail_price\" href=\"#\" title=\"" . $row['modified'] . "\">" . $row['name'] . "</a></td>";

		// If neither highest nor lowest, default color and size
		} else {
			echo "<td><a id=\"avg_retail_price\" href=\"#\" title=\"" . $row['modified'] . "\">" . $row['name'] . "</a></td>";
	 	}
		echo "<td>" . $row['manufacturer'] . "</td>";
		echo "<td>" . $row['retail_price'] . "</td>";
		echo "<td>" . $row['prescription'] . "</td>";
		echo "</tr>";
	
	}

} else {

	while ($row = mysql_fetch_assoc($result)) {

		// Build TD structure
		echo "<tr>";
		echo "<td>" . $counter++ . "</td>";
		// If this is the highest price, change color to teal and size 20px
		if($row['retail_price'] == $max) {
			echo "<td><a id=\"max_retail_price\" href=\"#\" title=\"" . $row['modified'] . "\">" . $row['name'] . "</a></td>";

		// If this is the lowest price, change color to red and size 8px
		} else if ($row['retail_price'] == $min) {
			echo "<td><a id=\"min_retail_price\" href=\"#\" title=\"" . $row['modified'] . "\">" . $row['name'] . "</a></td>";

		// If neither highest nor lowest, default color and size
		} else {
			echo "<td><a id=\"avg_retail_price\" href=\"#\" title=\"" . $row['modified'] . "\">" . $row['name'] . "</a></td>";
	 	}
		echo "<td>" . $row['manufacturer'] . "</td>";
		echo "<td>" . $row['retail_price'] . "</td>";
		echo "<td>" . $row['prescription'] . "</td>";
		echo "</tr>";
	
	}

}

echo "</table>";

?>

<?

include 'tail.php';

?>