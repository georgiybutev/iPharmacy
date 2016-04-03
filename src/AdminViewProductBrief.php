<?php

/*
 * View Existing Products in the Database
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

// Select all products from the database

include 'library/database_operations.php';
$db = new databaseOperations;
$result = $db->selectAllProducts();

?>

<!-- Display HTML Form For all Products -->

<section>
		<table>
			<th>Name: </th>
			<th>Manufacturer: </th>
			<th>Retail Price: </th>
			<th>Cover: </th>
				<?
				// Process SQL result set
				while ($row = mysql_fetch_assoc($result)) {
					echo "<tr>";
					echo "<td><a href=" . $row['kb'] . ">" . $row['name'] . "</a></td>";
					echo "<td>" . $row['manufacturer'] . "</td>";
					echo "<td>" . $row['retail_price'] . "</td>";
					echo "<td><img src=" . $row['cover'] . " width=\"100px\" height=\"100px\"></td>";
					echo "</tr>";
				}
				?>
				<td>Aspirin</td>
				<td>Bayer</td>
				<td>$100</td>
				<td><img src=""></td>
		</table>
		<form id="AdminViewProductBrief" action="AdminViewProductBrief" method="POST">
			<p>
				Sort the results by type and range:  
				<select id="sort" name="sort">
					<option value="name">Product Name</option>
					<option value="manufacturer">Product's Manufacturer</option>
					<option value="price">Product's Retail Price</option>
					<option value="latest">Latest in Database</option>
					<option value="oldest">Oldest in Database</option>
				</select>
				<select id="limit" name="limit">
					<option value="5">5</option>
					<option value="25">25</option>
					<option value="50">50</option>
					<option value="100">100</option>
					<option value="none">none</option>
				</select>
				<input type="submit" id="submit" name="submit" value="Sort" />
			</p>
		</form>
</section>

<?

include 'tail.php';

?>