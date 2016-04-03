<?php

/*
 * View Existing Products in the Database and Update
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

// Check whether the form was submitted
// If so perform SQL update for product based on id
// On success/failure notify the user

if(isset($_POST['submit'])) {
	$errorMessage = $db->updateProduct();
	if($errorMessage == ""){
		echo "The product was successfully updated.";
	} else {
		echo "There was an error. Please try again.";
	}
}

// Retrieve all products from the database

$result = $db->selectAllProductsUpdate();

?>

<!-- Display HTML Form to Update Product -->

<section>
		<table>
			<!-- 256KiB File Size Restriction  -->
			<input type="hidden" name="MAX_FILE_SIZE" value="262144"/>
			<th>Name: </th>
			<th>Quantity: </th>
			<th>Bulk Price: </th>
			<th>Retail Price: </th>
			<th>Barcode: </th>
			<th>Last Modified: </th>
			<th>Cover: </th>
			<?
			// Build TD structure for products in the database
			while($row = mysql_fetch_assoc($result)) {
				echo "<tr>";
				echo "<form id=\"update\" name=\"update\" method=\"POST\" action=\"AdminUpdateProduct\" enctype=\"multipart/form-data\">";
				echo "<input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\" />";
				echo "<td>" . "<input type=\"text\" name=\"name\" value=\"" . $row['name'] . "\" size=\"5\" /></td>";
				echo "<td>" . "<input type=\"text\" name=\"quantity\" value=\"" . $row['quantity'] . "\" size=\"10\" /></td>";
				echo "<td>" . "<input type=\"text\" name=\"man_price\" value=\"" . $row['man_price'] . "\" size=\"5\" /></td>";
				echo "<td>" . "<input type=\"text\" name=\"retail_price\" value=\"" . $row['retail_price'] . "\" size=\"5\" /></td>";
				echo "<td>" . "<input type=\"text\" name=\"barcode\" value=\"" . $row['barcode'] . "\" size=\"5\" /></td>";
				echo "<td>" . $row['modified'] . "</td>";
				echo "<input type=\"hidden\" name=\"modified\" value=\"" . $row['modified'] . "\" />";
				echo "<td><input type=\"file\" id=\"cover_file\" name=\"cover_file\" /></td>";
				echo "<td><input id=\"update\" name=\"submit\" type=\"submit\" value=\"Update\" /></td>";
				echo "</tr>";
				echo "</form>";
			}
			?>
		</table>
</section>

<?

include 'tail.php';

?>