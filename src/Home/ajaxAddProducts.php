<?php

/*
 * Add Products to the Database
 * Display HTML Form
 * User Only Interface
 * AJAX Enabled
 */

// Get AJAX variables
$getSubmit = $_GET['submit'];
$postSubmit = $_POST['submit'];

if ($getSubmit == "yes") {
	// SQL INSERT product
} else if ($getSubmit == "no") {
	// Display HTML Form
	echo "<form id=\"ajaxAddProducts\" action=\"ajaxAddProducts\" method=\"POST\" enctype=\"multipart/form-data\">";
		echo "<table>";
			echo "<th>Form: </th>";
			echo "<th>Contents: </th>";
			echo "<tr>";
				echo "<td><label for=\"name\">Product Name: </td><td><input type=\"text\" id=\"name\" name=\"name\" /></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><label for=\"latin\">Latin Name: </td><td><input type=\"text\" id=\"latin\" name=\"latin\" /></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><label for=\"brand\">Brand: </td><td><input type=\"text\" id=\"brand\" name=\"brand\" /></td>";
			echo "</tr>";
				echo "<td><label for=\"manufacturer\">Manufacturer: </label></td>";
				echo "<td>";
					echo "<select id=\"manufacturer\" name=\"manufacturer\">";
						echo "<option></option>";
						echo "<optgroup label=\"United Kingdom\">";
							echo "<option value=\"GlaxoSmithKline\">GlaxoSmithKline</option>";
							echo "<option value=\"AstraZeneca\">AstraZeneca</option>";
						echo "</optgroup>";
						echo "<optgroup label=\"United States\">";
							echo "<option value=\"Pfizer\">Pfizer</option>";
							echo "<option value=\"Johnson &amp; Johnson\">Johnson &amp; Johnson</option>";
							echo "<option value=\"Merck &amp; Co.\">Merck &amp; Co.</option>";
							echo "<option value=\"Abbott\">Abbott</option>";
							echo "<option value=\"Eli Lilly and Company\">Eli Lilly and Company</option>";
							echo "<option value=\"Amgen\">Amgen</option>";
							echo "<option value=\"Wyeth\">Wyeth</option>";
						echo "</optgroup>";
						echo "<optgroup label=\"Swizerland\">";
							echo "<option value=\"Novartis\">Novartis</option>";
							echo "<option value=\"Hoffmann–La Roche\">Hoffmann–La Roche</option>";
						echo "</optgroup>";
						echo "<optgroup label=\"France\">";
							echo "<option value=\"Sanofi-Aventis\">Sanofi-Aventis</option>";
						echo "</optgroup>";
						echo "<optgroup label=\"Germany\">";
							echo "<option value=\"Bayer\">Bayer</option>";
						echo "</optgroup>";
						echo "<optgroup label=\"Israel\">";
							echo "<option value=\"Teva\">Teva</option>";
						echo "</optgroup>";
						echo "<optgroup label=\"Japan\">";
							echo "<option value=\"Takeda\">Takeda</option>";
						echo "</optgroup>";
						echo "<option value=\"Other\">Other</option>";
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><label for=\"quantity\">Quantity: </label></td>";
				echo "<td><input type=\"text\" id=\"quantity\" name=\"quantity\" /></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><label for=\"category\">Category: </label></td>";
				echo "<td><input type=\"text\" id=\"category\" name=\"category\" /></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><label for=\"size\">Size: </label></td>";
				echo "<td><input type=\"text\" id=\"size\" name=\"size\" /></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><label for=\"intake\">Intake Type: </label></td>";
				echo "<td>";
					echo "<select id=\"intake\" name=\"intake\">";
						echo "<option value=\"Peroral\">Peroral</option>";
						echo "<option value=\"Eye Drops\">Eye Drops</option>";
						echo "<option value=\"Ear Drops\">Ear Drops</option>";
						echo "<option value=\"Nose Drops\">Nose Drops</option>";
						echo "<option value=\"Eye Gels\">Eye Gels</option>";
						echo "<option value=\"Inhalers\">Inhalers</option>";
						echo "<option value=\"Injections\">Injection</option>";
						echo "<option value=\"Rectal Suppositories\">Rectal Suppositories</option>";
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><label for=\"frequency\"></label>Purchase Frequency: </td>";
				echo "<td>";
					echo "<select id=\"frequency\" name=\"frequency\">";
						echo "<option value=\"Daily\">Daily</option>";
						echo "<option value=\"Weekly\">Weekly</option>";
						echo "<option value=\"Biweekly\">Biweekly</option>";
						echo "<option value=\"Montly\">Monthly</option>";
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><label for=\"volume\">Purcahse Volume: </label></td>";
				echo "<td>";
					echo "<select id=\"volume\" name=\"volume\">";
						echo "<option value=\"S\">Small</option>";
						echo "<option value=\"M\">Medium</option>";
						echo "<option value=\"L\">Large</option>";
						echo "<option value=\"XL\">Extra Large</option>";
						echo "<option value=\"XXL\">Extra Extra Large</option>";
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><label for=\"delivery\">Delivery Time: </label></td>";
				echo "<td><input type=\"text\" id=\"delivery_num\" name=\"delivery_num\" maxlength=\"2\" />";
					echo "<select id=\"delivery_days\" name=\"delivery_days\">";
						echo "<option value=\"day\">Days</option>";
						echo "<option value=\"week\">Weeks</option>";
						echo "<option value=\"month\">Months</option>";
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><label for=\"man_price\">Manufacturer's Price: </label></td>";
				echo "<td><input type=\"text\" id=\"man_price\" name=\"man_price\" value=\"&#163;\" /></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><label for=\"retail_price\">Retail Price: </label></td>";
				echo "<td><input type=\"text\" id=\"retail_price\" name=\"retail_price\" value=\"&#163;\" /></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><label for=\"kb\">Knowledge Base: </label></td>";
				echo "<td><input type=\"file\" id=\"kb\" name=\"product_file[]\" /></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><label for=\"cover\">Product Cover: </label></td>";
				echo "<td><input type=\"file\" id=\"cover\" name=\"product_file[]\" /></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><label for=\"reference\">Reference (Automatic): </label></td>";
				echo "<td><input type=\"text\" id=\"reference\" name=\"reference\" /></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><label for=\"barcode\">Barcode: </label></td>";
				echo "<td><input type=\"text\" id=\"barcode\" name=\"barcode\" /></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><label for=\"prescription\">Prescription: </label></td>";
				echo "<td><textarea id=\"prescription\" name=\"prescription\" rows=\"10\" cols=\"40\" ></textarea></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td><label for=\"submit\">Proceed: </label></td>";
				echo "<td><input type=\"submit\" id=\"submit\" name=\"submit\" value=\"Continue\" /></td>";
			echo "</tr>";
		echo "</table>";
	echo "</form>";

} else if (isset($_POST['submit'])) {
	// If the form was submitted, connect to the database and add new product to the database
	include '../../settings.php';
	$settings = new Settings();
	$settings->connectToDatabase();

	include '../../library/database_operations.php';
	$db = new databaseOperations;
	$success = $db->addNewProductUser();

	if($success){
		// Redirect
		echo "Success";
	} else {
		// Error
		echo "Error";
	}
} else {
	// Exception
	echo "Exception";
}

?>