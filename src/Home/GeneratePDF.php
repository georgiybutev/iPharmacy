<?php

/*
 * Generate PDF with FPDF Library
 * Format Data in Tables
 * -> Server Info
 * -> Messages
 * -> Medical Products
 * -> Users
 * -> Personal Comment
 * Cell format (width, height, 
 * string value, 
 * frame border and text position, 
 * new line option, 
 * text align (e.g. center), 
 * fill with background color(true|false), 
 * isURL)
 */

// Load FPDF library for PDF document file generation
require_once('../../library/fpdf17/fpdf.php');

class GeneratePDF extends FPDF {
	
	function __construct() {
		// Initialise class variables - document header
		$title = "Medical CMS";
		$author = "Georgi Butev";
		$creator = "Medical CMS PDF Class";
		$subject = "Medical CMS Report";
		$font = "helvetica";
	}

	function getTableHeader() {

		// Initialise document header array based on the user selected type
		$type = $_POST['type'];
		if($type == "info") {
			$th = array('Description', 'Value');
		} else if ($type == "messages") {
			$th = array('Sender', 'Receiver', 'Subject', 'Date', 'Reviewed');
		} else if ($type == "products") {
			$th = array('Name', 'Latin', 'Brand', 'Category', 'Barcode', 'Date');
		} else if ($type == "users") {
			$th = array('Forename', 'Surname', 'Username', 'Occupation', 'Role', 'Date');
		} else {
			// Exception
		}

		return $th;
	}

	function getTableData() {

		// Initialise document data based on the user selected type
		$type = $_POST['type'];
		if($type == "info") {
			// Display the bytes value in MiB
			$memory_usage =  round(memory_get_usage()/1024) . " MiB";
			$os = php_uname('s');
			$os_version = php_uname('r');
			$os_bits = php_uname('m');
			$hostname = php_uname('n');
			$php_version = phpversion();
			$php_zend_version = zend_version();
			$mysql_version = mysql_get_server_info();
			$mysql_status = explode(' ', mysql_stat());
				// Display the uptime value in hours
				$uptime = round($mysql_status[1]/60/60) . " Hours";
				$threads = $mysql_status[4];
				$opens = $mysql_status[14];
				$open_tables = $mysql_status[22];
				$average_queries = $mysql_status[28];
			// Shell command - display all processes from all users | filter mysql keyword | display only the first line
			$cmd = shell_exec('ps aux | grep mysql | head -1');
			$output = explode(' ', $cmd);
				$mysql_process = $output[26];
				$mysql_started = $output[23];
				$mysql_cpu = $output[8];
				$mysql_mem = $output[10];
			// Shell command - display all processes from all users | filter apache2 keyword | display only the first line
			$cmd = shell_exec('ps aux | grep apache2 | head -1');
			$output = explode(' ', $cmd);
				$apache_process = $output[30];
				$apache_started = $output[26];
				$apache_cpu = $output[8];
				$apache_mem = $output[10];
			// Return the collected data for server statistics
			$data = array("Memory Usage: ", $memory_usage, "Operating System: ", $os,
							"OS Version: ", $os_version, "OS Bits", $os_bits, 
							"Hostname: ", $hostname, "PHP Version: ", $php_version, 
							"Zend Version: ", $php_zend_version, "MySQL Server Version: ", $mysql_version,
							"Server Uptime: ", $uptime, "Active Threads: ", $threads, 
							"Server Opens: ", $opens, "Open Tables: ", $open_tables, 
							"Average Queries Load: ", $average_queries, "MySQL Active Processes: ", $mysql_process, 
							"MySQL Started: ", $mysql_started, "MySQL CPU Load: ", $mysql_cpu, 
							"MySQL Memory Load: ", $mysql_mem, "Apache Active Processes: ", $apache_process, 
							"Apache Started: ", $apache_started, "Apache CPU Load: ", $apache_cpu, 
							"Apache Memory Load: ", $apache_mem);
		
		} else if ($type == "messages") {

			// Get messages from the database table based on the sender - georgi
			$sender = "georgi";
			$query = "select * from messages where sender='" . $sender . "' order by date desc";
			$data = mysql_query($query);

		} else if ($type == "products") {

			// Get all messages, order by date (latest)
			$query = "select name, latin, brand, category, barcode, modified from product order by modified desc limit 0, 20";
			$data = mysql_query($query);

		} else if ($type == "users") {

			// Get all messages, order by date (latest)			
			$query = "select forname, surname, username, occupation, role, date from user order by date desc limit 0, 20";
			$data = mysql_query($query);

		} else {
			// Exception
		}

		return $data;
	}

	function document() {

		// Build PDF document, combine header, data, and options

		$type = $_POST['type'];
		$comment = $_POST['comment'];
		// PDF document in Landscape mode, mm measurements, international A4 size
		$pdf = new FPDF('L', 'mm', 'A4');
		// Set document properties, true means UTF-8
		$pdf->SetTitle($title, true);
		$pdf->SetAuthor($author, true);
		$pdf->SetCreator($creator, true);
		$pdf->SetSubject($subject, true);
		// Create single PDF page
		$pdf->AddPage();

		if($type == "info") {

			// Set the font - Times, bold, 20 px
			$pdf->SetFont('times','B', 20);
			// Set background and text color - teal and white
			$pdf->SetFillColor(64, 128, 128);
			$pdf->SetTextColor(255, 255, 255);
			$th = $this->getTableHeader();
			// Display all data for document header using the header array
			for ($i=0; $i < count($th); $i++) { 
				$pdf->Cell(80, 10, $th[$i], 1, 0, 'C', true);
			}
			// New Line
			$pdf->Ln();
			// Set the font - Helvetica, normal, 16 px
			$pdf->SetFont('helvetica','',16);
			$td = $this->getTableData();
			// Set text color - black
			$pdf->SetTextColor(0, 0, 0);
			// Display all data for document table using the data array
			for ($j=0; $j < count($td); $j++) {
				// Set background and text color - teal and white
				$pdf->SetFillColor(64, 128, 128);
				$pdf->SetTextColor(255, 255, 255);
				$pdf->Cell(80, 10, $td[$j], 1, 0, 'L', true);
				// Display adjecent table cell
				$j += 1;
				// Set background and text color - black and white
				$pdf->SetFillColor(255, 255, 255);
				$pdf->SetTextColor(0, 0, 0);
				$pdf->Cell(80, 10, $td[$j], 1, 0, 'R', true);
				// New Line
				$pdf->Ln();
			}

		} else if ($type == "messages") {

			// Set font - Times, bold, 16 px
			$pdf->SetFont('times','B',16);
			// Set background and text color - teal and white
			$pdf->SetFillColor(64, 128, 128);
			$pdf->SetTextColor(255, 255, 255);
			$th = $this->getTableHeader();
			// Display all header data fro the array
			for ($i=0; $i < count($th); $i++) { 
				$pdf->Cell(45, 10, $th[$i], 1, 0, 'C', true);
			}
			// New Line
			$pdf->Ln();
			// Set font - Helvetica, normal, 12 px
			$pdf->SetFont('helvetica','',12);
			$td = $this->getTableData();
			// Set text and background color - black and white
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			// Total number of messages
			$total = mysql_num_rows($td);
			// Process MySQL server result set
			while($row = mysql_fetch_assoc($td)) {
				$pdf->Cell(45, 10, $row['sender'], 1, 0, 'L', true);
				$pdf->Cell(45, 10, $row['receiver'], 1, 0, 'L', true);
				$pdf->Cell(45, 10, $row['subject'], 1, 0, 'L', true);
				$pdf->Cell(45, 10, $row['date'], 1, 0, 'L', true);
				$pdf->Cell(45, 10, $row['reviewed'], 1, 0, 'L', true);
				$pdf->Ln();
			}
			// Set font - Times, bold, 16 px
			$pdf->SetFont('times','B',16);
			// Set background and text color - teal and white
			$pdf->SetFillColor(64, 128, 128);
			$pdf->SetTextColor(255, 255, 255);
			$pdf->Cell(45, 10, 'Total ', 1, 0, 'C', true);
			// New Line
			$pdf->Ln();
			// Set font - Helvetica, normal, 12 px
			$pdf->SetFont('helvetica','',12);
			// Set text and background color - black and white
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Cell(45, 10, $total, 1, 0, 'C', true);
			// New Line
			$pdf->Ln();

		} else if ($type == "products") {

			// Set font - Times, bold, 16 px
			$pdf->SetFont('times','B',16);
			// Set background and text color - teal and white
			$pdf->SetFillColor(64, 128, 128);
			$pdf->SetTextColor(255, 255, 255);
			$th = $this->getTableHeader();
			// Display all header data from array
			for ($i=0; $i < count($th); $i++) { 
				$pdf->Cell(45, 10, $th[$i], 1, 0, 'C', true);
			}
			// New Line
			$pdf->Ln();
			// Set font - Helvetica, normal, 12 px
			$pdf->SetFont('helvetica','',12);
			$td = $this->getTableData();
			// Set text and background color - black and white
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			// Get the total number of products in the database
			$total = mysql_num_rows($td);
			// Process MySQL server result set
			while($row = mysql_fetch_assoc($td)) {
				$pdf->Cell(45, 10, $row['name'], 1, 0, 'L', true);
				$pdf->Cell(45, 10, $row['latin'], 1, 0, 'L', true);
				$pdf->Cell(45, 10, $row['brand'], 1, 0, 'L', true);
				$pdf->Cell(45, 10, $row['category'], 1, 0, 'L', true);
				$pdf->Cell(45, 10, $row['barcode'], 1, 0, 'L', true);
				$pdf->Cell(45, 10, $row['modified'], 1, 0, 'L', true);
				$pdf->Ln();
			}
			// Set font - Times, bold, 16 px
			$pdf->SetFont('times','B',16);
			// Set background and text color - teal and white
			$pdf->SetFillColor(64, 128, 128);
			$pdf->SetTextColor(255, 255, 255);
			$pdf->Cell(45, 10, 'Total ', 1, 0, 'C', true);
			// New Line
			$pdf->Ln();
			// Set font - Helvetica, normal, 12 px
			$pdf->SetFont('helvetica','',12);
			// Set text and background color - black and white
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Cell(45, 10, $total, 1, 0, 'C', true);
			// New Line
			$pdf->Ln();

		} else if ($type == "users") {

			// Set font - Times, bold, 16 px
			$pdf->SetFont('times','B',16);
			// Set background and text color - teal and white
			$pdf->SetFillColor(64, 128, 128);
			$pdf->SetTextColor(255, 255, 255);
			$th = $this->getTableHeader();
			// Display all document header data from the array
			for ($i=0; $i < count($th); $i++) { 
				$pdf->Cell(45, 10, $th[$i], 1, 0, 'C', true);
			}
			// New Line
			$pdf->Ln();
			// Set font - Helvetica, normal, 12 px
			$pdf->SetFont('helvetica','',12);
			$td = $this->getTableData();
			// Set text and background color - black and white
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			// Get the total number of users in the database
			$total = mysql_num_rows($td);
			// Process MySQL server result set
			while($row = mysql_fetch_assoc($td)) {
				$pdf->Cell(45, 10, $row['forname'], 1, 0, 'L', true);
				$pdf->Cell(45, 10, $row['surname'], 1, 0, 'L', true);
				$pdf->Cell(45, 10, $row['username'], 1, 0, 'L', true);
				$pdf->Cell(45, 10, ucfirst($row['occupation']), 1, 0, 'L', true);
				$pdf->Cell(45, 10, $row['role'], 1, 0, 'L', true);
				// Display only the data part of the SQL TIMESTAMP - first 4 characters
				$explode = explode(' ', $row['date']);
				$date = $explode[1] . " of " . $explode[3] . " " . $explode[4] . " " . substr($explode[5], 4);
				$pdf->Cell(45, 10, $date, 1, 0, 'L', true);
				// New Line
				$pdf->Ln();
			}
			// Set font - Times, bold, 16 px
			$pdf->SetFont('times','B',16);
			// Set background and text color - teal and white
			$pdf->SetFillColor(64, 128, 128);
			$pdf->SetTextColor(255, 255, 255);
			$pdf->Cell(45, 10, 'Total ', 1, 0, 'C', true);
			// New Line
			$pdf->Ln();
			// Set font - Helvetica, normal, 12 px
			$pdf->SetFont('helvetica','',12);
			// Set text and background color - black and white
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Cell(45, 10, $total, 1, 0, 'C', true);
			// New Line
			$pdf->Ln();

		} else {
			// Exception
		}

		// Print new line escape character to seperate the table data from the user's personal comment
		$pdf->Ln();
		$pdf->Cell(275, 50, $comment, 1, 0, 'C', true);
		// Get the current date in the format of - day, month, year, hour, minute, second, AM or PM
		$date = date('d') . "-" . date('m') . "-" . date('Y') . "-" . date('h') . "-" . date('i') . "-" . date('s') . "-" . date('A');
		// Save the generated document in the users's Report directory
		// The names should be unique - the date string
		$pdf->Output("Reports/report-" . $date . ".pdf", "F");
		// The file is offered to the user for download or open
		$pdf->Output("report.pdf-" . $date . ".pdf", "D");

	}

}

?>