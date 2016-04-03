<?php
/*
 * User Interface
 * Database Control - View, Add, Update, Remove, Search
 */

session_start();

// CSS highlight button

$page = "index";

include '../../user_header.php';

/*if(($_SESSION['authenticated'] == true) && ($_SESSION['privilege'] == 2)) {
} else {
	header("Location: Error.php");
	exit;
}*/

// Make SQL query for MySQL server status
// Round to 3 digits after the decimal point
// Devise by 1024 to get KiB, MiB, and GiB
// Devise by 60 for minutes, further 60 for hours, and 24 for days

$result = mysql_query("show global status");
while($row = mysql_fetch_array($result, MYSQL_NUM)) {
	if($row[0] == "Bytes_received") {
		$dbIncommingTraffic = round($row[1]/1024 , 3) . " KBytes";
		if($dbIncommingTraffic >= 999) {
			$dbIncommingTraffic = round($dbIncommingTraffic/1024, 3) . "MB";
			if($dbIncommingTraffic >= 999) {
				$dbIncommingTraffic = round($dbIncommingTraffic/1024, 3) . "GB";
			}
		}
	}
	if($row[0] == "Bytes_sent") {
		$dbOutgoingTraffic = round($row[1]/1024, 3) . " KBytes";
		if($dbOutgoingTraffic.length >= 999) {
			$dbOutgoingTraffic /= 1024 . "MBytes";
		}
	}
	if($row[0] == "Com_select") {
		$dbSelectStatements = $row[1];
	}
	if($row[0] == "Connections") {
		$dbTotalConnections = $row[1];
	}
	if($row[0] == "Max_used_connections") {
		$dbActiveUsers = $row[1];
	}
	if($row[0] == "Uptime") {
		$dbUptimeMinutes = round($row[1]/60);
		$dbUptimeHours = round($dbUptimeMinutes/60);
		$dbUptimeDays = round($dbUptimeHours/24);
		$dbUptime = $dbUptimeMinutes . 
					" Minutes " . 
					$dbUptimeHours . 
					" Hours " . 
					$dbUptimeDays . 
					" Days ";
	}
}

// Get HTTP headers send to the Apacher server

$language = apache_request_headers();

// Make a visitor log with date and client information

include '../../library/database_operations.php';
$db = new databaseOperations();
$error = $db->createIPLog();

?>

<script type="text/javascript" src="../../library/user_info.js"></script>

<!-- Display Apache and MySQL Server Variables -->

<section>
	<table>
		<tr>
			<td>Server IP Address: </td>
			<td><? echo $_SERVER['SERVER_ADDR'] ?></td>
			<td><img src="<? echo $sc ?>media/info.ico" /></td>
		</tr>
		<tr>
			<td>Server Host: </td>
			<td><? echo $_SERVER['SERVER_NAME'] ?></td>
			<td><img src="<? echo $sc ?>media/info.ico" /></td>
		</tr>
		<tr>
			<td>Server Setup: </td>
			<td><? echo $_SERVER['SERVER_SOFTWARE'] ?></td>
			<td><img src="<? echo $sc ?>media/info.ico" /></td>
		</tr>
		<tr>
			<td>Workstation IP Address: </td>
			<td><? echo $_SERVER['REMOTE_ADDR'] ?></td>
			<td><img src="<? echo $sc ?>media/info.ico" /></td>
		</tr>
		<tr>
			<td>Workstation Language: </td>
			<td>
				<? echo $language['Accept-Language']; ?></td>
			<td><img src="<? echo $sc ?>media/info.ico" /></td>
		</tr>
		<tr>
			<td>Web Browser Version: </td>
			<td id="browser"></td>
			<td><img src="<? echo $sc ?>media/info.ico" /></td>
		</tr>
		<tr>
			<td>Client Java Support: </td>
			<td id="javaInstalled"></td>
			<td><img src="<? echo $sc ?>media/info.ico" /></td>
		</tr>
		<tr>
			<td>Client Cookies Support: </td>
			<td id="cookies"></td>
			<td><img src="<? echo $sc ?>media/info.ico" /></td>
		</tr>
		<tr>
			<td>Operating System Version: </td>
			<td id="os"></td>
			<td><img src="<? echo $sc ?>media/info.ico" /></td>
		</tr>
		<tr>
			<td>Operating System Bits: </td>
			<td id="osbits"></td>
			<td><img src="<? echo $sc ?>media/info.ico"></td>
		</tr>
		<tr>
			<td>Database Incoming Traffic: </td>
			<td><? echo $dbIncommingTraffic ?></td>
			<td><img src="<? echo $sc ?>media/info.ico"></td>
		</tr>
		<tr>
			<td>Database Outgoing Traffic: </td>
			<td><? echo $dbOutgoingTraffic ?></td>
			<td><img src="<? echo $sc ?>media/info.ico"></td>
		</tr>
		<tr>
			<td>Total Select Statements: </td>
			<td><? echo $dbSelectStatements ?></td>
			<td><img src="<? echo $sc ?>media/info.ico"></td>
		</tr>
		<tr>
			<td>Total Database Connections: </td>
			<td><? echo $dbTotalConnections ?></td>
			<td><img src="<? echo $sc ?>media/info.ico"></td>
		</tr>
		<tr>
			<td>Number of Active Database Users: </td>
			<td><? echo $dbActiveUsers ?></td>
			<td><img src="<? echo $sc ?>media/info.ico"></td>
		</tr>
		<tr>
			<td>Database Uptime: </td>
			<td><? echo $dbUptime ?></td>
			<td><img src="<? echo $sc ?>media/uptime.ico"></td>
		</tr>
	</table>
</section>

<?

include '../../tail.php';

?>