<?php

/*
 * Remove Selected Products from the Database
 * Admin Only Interface
 */

session_start();

// CSS highlight button

$page = "all_products";

include 'admin_header.php';

/*if(($_SESSION['authenticated'] == true) && ($_SESSION['privilege'] == 3)) {
} else {
	header("Location: Error.php");
	exit;
}*/

include 'library/database_operations.php';
$db = new databaseOperations;

// If the form was submitted
// Get all contents of the POST array
// Perform SQL delete row based on the id
// The POST array should be alphanumerical

if(isset($_POST['submit'])) {
	foreach ($_POST as $attributeName => $attributeValue) {
		if(is_numeric($attributeName)) {
			$errorMessage = $db->deleteProduct($attributeName);
			if($errorMessage == "") {
				echo "The product was successfully deleted.";
			} else {
				echo "There was an error. Please try again.";
			}
		}
	}
}

// Get all products from the database

$result = $db->selectAllProductsUpdate();

?>

<!-- Display HTML Delete Product Form -->

<section>
	<form id="delete" name="delete" method="POST" action="AdminRemoveProduct">
	<table>
		<th>Name: </th>
		<th>Quantity: </th>
		<th>Bulk Price: </th>
		<th>Retail Price: </th>
		<th>Barcode: </th>
		<th>Last Modified: </th>
		<th>To Delete: </th>
		<!-- Build TD Structure based on the SQL Result Set -->
		<?
		while($row = mysql_fetch_assoc($result)) {
			echo "<tr>";
			//echo "<form id=\"update\" name=\"update\" method=\"POST\" action=\"AdminUpdateProduct\">";
			echo "<input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\" />";
			echo "<td>" . "<input type=\"text\" name=\"name\" value=\"" . $row['name'] . "\" size=\"5\" /></td>";
			echo "<td>" . "<input type=\"text\" name=\"quantity\" value=\"" . $row['quantity'] . "\" size=\"10\" /></td>";
			echo "<td>" . "<input type=\"text\" name=\"man_price\" value=\"" . $row['man_price'] . "\" size=\"5\" /></td>";
			echo "<td>" . "<input type=\"text\" name=\"retail_price\" value=\"" . $row['retail_price'] . "\" size=\"5\" /></td>";
			echo "<td>" . "<input type=\"text\" name=\"barcode\" value=\"" . $row['barcode'] . "\" size=\"5\" /></td>";
			echo "<td>" . $row['modified'] . "</td>";
			echo "<input type=\"hidden\" name=\"modified\" value=\"" . $row['modified'] . "\" />";
			echo "<td><input type=\"checkbox\" name=\"" . $row['id'] . "\"/></td>";
			//echo "<td><input id=\"update\" name=\"submit\" type=\"submit\" value=\"Delete\" /></td>";
			echo "</tr>";
			//echo "</form>";
		}
		?>
	</table>
	<p>Make single or multi selection of products you want to delete from the database: 
		<input type="submit" id="submit" name="submit" value="Delete"> 
</form>
</section>

<?

include 'tail.php';

?>