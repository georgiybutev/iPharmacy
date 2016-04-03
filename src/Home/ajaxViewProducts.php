<?php

/*
 * Display HTML Search Form
 * User Only Interface
 * AJAX Enabled
 */

echo "<table>";
	echo "<form action=\"\">";
		echo "<tr>";
			echo "<td>Search Products: <input type=\"text\" id=\"searchField\" onkeyup=\"searchAllProducts(this.value)\" /></td>";
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
					echo "<option value=\"prescription\">Prescription</option>";
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

?>