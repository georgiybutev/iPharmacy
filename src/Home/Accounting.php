<?php

/*
 * Accounting Interface
 *
 * Only for Registered Users
 * User Only Interface
 */

session_start();

// CSS highlight button
$page = "accounting";
// Path to base directory
$path = "../../";

include '../../user_header.php';
include '../../library/database_operations.php';

/*if(($_SESSION['authenticated'] == true) && ($_SESSION['privilege'] == 2)) {
} else {
	header("Location: Error.php");
	exit;
}*/

// Query the database for information to be used for the pie and column chart
$db = new databaseOperations();
$pieChartData = $db->accountingPieChart();
$columnChartData = $db->accountingColumnChart();

?>

<section>
	<!-- Display Pie Chart And Column Chart -->
	<table>
		<th>Accounting Pie Chart</th>
		<tr><td><div id="pieChart"></div></td></tr>
		<th>Accounting Line Chart</th>
		<tr><td><div id="columnChart"></div></td></tr>
	</table>

	<div id="db">
		<!-- Retrive Result from the DB -->

		<!-- Pie Chart -->
		<table>
			<th>Users</th>
			<th>Products</th>
			<th>Messages</th>
			<th>Visitors</th>
			<tr>
				<td id="total_users"><? echo $pieChartData['total_users'] ?></td>
				<td id="total_products"><? echo $pieChartData['total_products'] ?></td>
				<td id="total_messages"><? echo $pieChartData['total_messages'] ?></td>
				<td id="total_visitors"><? echo $pieChartData['total_visitors'] ?></td>
			</tr>
		</table>
		<!-- Column Chart -->
		<table>
			<th>Total Expenses</th>
			<th>Total Revenue</th>
			<th>Profit</th>
			<th>Max Manu Price</th>
			<th>Min Manu Price</th>
			<th>Average Manu Price</th>
			<th>Max Retail Price</th>
			<th>Min Retail Price</th>
			<th>Average Retail Price</th>
			<th>Year</th>
			<tr>
				<td id="total_expenses"><? echo $columnChartData['total_expenses'] ?></td>
				<td id="total_revenue"><? echo $columnChartData['total_revenue'] ?></td>
				<td id="profit"><? echo $columnChartData['profit'] ?></td>
				<td id="max_man_price"><? echo $columnChartData['max_man_price'] ?></td>
				<td id="min_man_price"><? echo $columnChartData['min_man_price'] ?></td>
				<td id="avg_man_price"><? echo $columnChartData['avg_man_price'] ?></td>
				<td id="max_retail_price"><? echo $columnChartData['max_retail_price'] ?></td>
				<td id="min_retail_price"><? echo $columnChartData['min_retail_price'] ?></td>
				<td id="avg_retail_price"><? echo $columnChartData['avg_retail_price'] ?></td>
				<td id="year"><? echo $columnChartData['year'] ?></td>
			</tr>
		</table>
	</div>
</section>


<!-- Load Google charting API -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<!-- Get Table Data Values And Draw The Charts -->
<script type="text/javascript">

// Initialise Google charting utility
google.load("visualization", "1", {packages:["corechart"]});
// Call pieChart function
google.setOnLoadCallback(pieChart);

function pieChart() {

	// Parse SQL returned string data to integer values compatible with the Google's API
	var total_users = parseInt(document.getElementById("total_users").innerHTML);
	var total_products = parseInt(document.getElementById("total_products").innerHTML);
	var total_messages = parseInt(document.getElementById("total_messages").innerHTML);
	var total_visitors = parseInt(document.getElementById("total_visitors").innerHTML);

	// Set pie chart data
	var pieChartData = google.visualization.arrayToDataTable([
		['Table', 'Records'], 
		['Total Users', total_users], 
		['Total Products', total_products], 
		['Total Messages', total_messages], 
		['Total Visitors', total_visitors]
	]);

	// Set pie chart options
	var pieChartOptions = {
		title: 'All Database Tables',
		fontName: 'Droid Sans',
		width: 640, 
		height: 480, 
		colors: ['#408080', '#404080', '#804080', '#800040'], 
		is3D: true
	};

	// Display the ready pie chart in the designated division
	var chart = new google.visualization.PieChart(document.getElementById('pieChart'));
	// Google API function call
	chart.draw(pieChartData, pieChartOptions);
}

</script>

<script type="text/javascript">

// Initialise Google charting utility
google.load("visualization", "1", {packages:["corechart"]});
// Call columnChart function
google.setOnLoadCallback(columnChart);

function columnChart() {

	// Parse SQL returned string data to decimal/float values compatible with the Google's API
	var total_expenses = parseFloat(document.getElementById("total_expenses").innerHTML);
	var total_revenue = parseFloat(document.getElementById("total_revenue").innerHTML);
	var profit = parseFloat(document.getElementById("profit").innerHTML);
	var max_man_price = parseFloat(document.getElementById("max_man_price").innerHTML);
	var min_man_price = parseFloat(document.getElementById("min_man_price").innerHTML);
	var avg_man_price = parseFloat(document.getElementById("avg_man_price").innerHTML);
	var max_retail_price = parseFloat(document.getElementById("max_retail_price").innerHTML);
	var min_retail_price = parseFloat(document.getElementById("min_retail_price").innerHTML);
	var avg_retail_price = parseFloat(document.getElementById("avg_retail_price").innerHTML);
	var year = document.getElementById("year").innerHTML;

	// Set column chart data
	var columnChartData = google.visualization.arrayToDataTable([
		['Year', 'Total Expenses', 'Total Revenue', 'Profit', 'Max_Man_Price', 'Min_Man_Price', 'Avg_Man_Price', 'Max_Retail_Price', 'Min_Retail_Price', 'Avg_Retail_Price'], 
		[year, total_expenses, total_revenue, profit, max_man_price, min_man_price, avg_man_price, max_retail_price, min_retail_price, avg_retail_price]
		]);

	// Set column chart options
	var columnChartOptions = {
		title: 'Product Database Table',
		fontName: 'Droid Sans',
		width: 640, 
		height: 480, 
		is3D: true
	};

	// Display the ready column chart in the designated division
	var chart = new google.visualization.ColumnChart(document.getElementById('columnChart'));
	// Google API function call
	chart.draw(columnChartData, columnChartOptions);
}

</script>

<?

include '../../tail.php';

?>