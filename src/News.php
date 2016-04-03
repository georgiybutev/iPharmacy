<?php

/*
 * News or Notices From The Admiinistrator
 * Only The Administrator can Send Message to News
 * Guest Only Module
 */

// CSS highlight button
$page = "news";

include 'head.php';

$query = "select sender, subject, date, message from messages where receiver='news'";
$result = mysql_query($query);
while($row = mysql_fetch_array($result)) {
	echo "<table>";
		echo "<th>From: </th>";
		echo "<th>Subject: </th>";
		echo "<th>Date: </th>";
		echo "<tr>";
			echo "<td>" . $row[0] . "</td>";
			echo "<td>" . $row[1] . "</td>";
			echo "<td>" . $row[2] . "</td>";
		echo "</tr>";
		echo "<th colspan=3>What's New: </th>";
		echo "<tr>";
			echo "<td colspan=3>" . $row[3] . "</td>";
		echo "</tr>";
	echo "</table>";
}

?>

<?

include 'tail.php';

?>