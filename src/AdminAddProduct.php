<?php

/*
 * Add New Product to the CMS
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

// If the form has been submitted
// Perform SQL query to add entry
// On success / failure notify user

if (isset($_POST['submit'])) {
	include 'library/database_operations.php';
	$db = new databaseOperations;
	$errorMessage = $db->addNewProduct();
	if ($errorMessage == "") {
		echo "The product was successfully added to the database.";
	} else {
		echo "There was an error. Please try again.";
		//echo mysql_error();
	}

}

?>

<script type="text/javascript">

// Check whether the selected field was left blank
// If so notify the user

function checkIfEmpty(HTMLElement) {
	var element = HTMLElement;
	if(element.value == 0){
		alert(element.id + " field cannot be left blank!");
	}
}
</script>

<!-- Display HTML Form to Add New Product to the Database -->

<section>
	<form id="AdminAddProduct" action="AdminAddProduct" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="MAX_FILE_SIZE" value="1048576"/>
		<table>
			<th>Form: </th>
			<th>Contents: </th>
			<tr>
				<td><label for="name">Name: </label></td>
				<td><input type="text" id="name" name="name" value="Aspirin" onblur="checkIfEmpty(this)"></td>
			</tr>
			<tr>
				<td><label for="latin">Latin Name: </label></td>
				<td><input type="text" id="latin" name="latin" value="Acetylsalicylsäure" onblur="checkIfEmpty(this)"></td>
			</tr>
			<tr>
				<td><label for="brand">Brand: </label></td>
				<td><input type="text" id="brand" name="brand" value="Bayer Aspirin" onblur="checkIfEmpty(this)"></td>
			</tr>
			<tr>
				<td><label for="manufacturer">Manufacturer: </label></td>
				<td>
					<select id="manufacturer" name="manufacturer">
						<option></option>						
						<optgroup label="United Kingdom">
							<option value="GlaxoSmithKline">GlaxoSmithKline</option>
							<option value="AstraZeneca">AstraZeneca</option>
						</optgroup>
						<optgroup label="United States">
							<option value="Pfizer">Pfizer</option>
							<option value="Johnson &amp; Johnson">Johnson &amp; Johnson</option>
							<option value="Merck &amp; Co.">Merck &amp; Co.</option>
							<option value="Abbott">Abbott</option>
							<option value="Eli Lilly and Company">Eli Lilly and Company</option>
							<option value="Amgen">Amgen</option>
							<option value="Wyeth">Wyeth</option>
						</optgroup>
						<optgroup label="Swizerland">
							<option value="Novartis">Novartis</option>
							<option value="Hoffmann–La Roche">Hoffmann–La Roche</option>
						</optgroup>
						<optgroup label="France">
							<option value="Sanofi-Aventis">Sanofi-Aventis</option>
						</optgroup>
						<optgroup label="Germany">
							<option value="Bayer">Bayer</option>
						</optgroup>
						<optgroup label="Israel">
							<option value="Teva">Teva</option>
						</optgroup>
						<optgroup label="Japan">
							<option value="Takeda">Takeda</option>
						</optgroup>
						<option value="Other">Other</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="quantity">Quantity: </label></td>
				<td><input type="text" id="quantity" name="quantity" value="10 x Tabletes" onblur="checkIfEmpty(this)"/></td>
			</tr>
			<tr>
				<td><label for="category">Category: </label></td>
				<td><input type="text" id="category" name="category" value="tete" onblur="checkIfEmpty(this)"/></td>
			</tr>
			<tr>
				<td><label for="size">Size: </label></td>
				<td><input type="text" id="size" name="size" value="500mg" onblur="checkIfEmpty(this)"/></td>
			</tr>
			<tr>
				<td><label for="intake">Intake Type: </label></td>
				<td>
					<select id="intake" name="intake">
						<option value="Peroral">Peroral</option>
						<option value="Eye Drops">Eye Drops</option>
						<option value="Ear Drops">Ear Drops</option>
						<option value="Nose Drops">Nose Drops</option>
						<option value="Eye Gels">Eye Gels</option>
						<option value="Inhalers">Inhalers</option>
						<option value="Injections">Injection</option>
						<option value="Rectal Suppositories">Rectal Suppositories</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="frequency"></label>Purchase Frequency: </td>
				<td>
					<select id="frequency" name="frequency">
						<option value="Daily">Daily</option>
						<option value="Weekly">Weekly</option>
						<option value="Biweekly">Biweekly</option>
						<option value="Montly">Monthly</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="volume">Purcahse Volume: </label></td>
				<td>
					<select id="volume" name="volume">
						<option value="S">Small</option>
						<option value="M">Medium</option>
						<option value="L">Large</option>
						<option value="XL">Extra Large</option>
						<option value="XXL">Extra Extra Large</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="delivery">Delivery Time: </label></td>
				<td><input type="text" id="delivery_num" name="delivery_num" value="0" maxlength="2" />
					<select id="delivery_days" name="delivery_days">
						<option value="day">Days</option>
						<option value="week">Weeks</option>
						<option value="month">Months</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="man_price">Manufacturer's Price: </label></td>
				<td><input type="text" id="man_price" name="man_price" value="&#163;" /></td>
			</tr>
			<tr>
				<td><label for="retail_price">Retail Price: </label></td>
				<td><input type="text" id="retail_price" name="retail_price" value="&#163;" /></td>
			</tr>
			<tr>
				<td><label for="kb">Knowledge Base: </label></td>
				<td><input type="file" id="kb" name="product_file[]" /></td>
			</tr>
			<tr>
				<td><label for="cover">Product Cover: </label></td>
				<td><input type="file" id="cover" name="product_file[]" /></td>
			</tr>
			<tr>
				<td><label for="reference">Reference (Automatic): </label></td>
				<td><input type="text" id="reference" name="reference" value="" /></td>
			</tr>
			<tr>
				<td><label for="barcode">Barcode: </label></td>
				<td><input type="text" id="barcode" name="barcode" value="" /></td>
			</tr>
			<tr>
				<td><label for="prescription">Prescription: </label></td>
				<td><textarea id="prescription" name="prescription" rows="10" cols="40" onblur="checkIfEmpty(this)"></textarea></td>
			</tr>
			<tr>
				<td><label for="submit">Proceed: </label></td>
				<td><input type="submit" id="submit" name="submit" value="Continue" /></td>
			</tr>
		</table>
	</form>
</section>

<?

include 'tail.php';

?>