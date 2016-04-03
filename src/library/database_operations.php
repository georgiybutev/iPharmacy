<?php

/*
 * Database Operations
 * Create, Select, Insert, Update, Delete
 */

class databaseOperations {
	
	function __construct() {
		$errorMessage = "";
		$selectResults = array();

		/*$createUserTable = "create table if not exists user (
		id smallint auto_increment primary key,
		occupation varchar(50),
		role varchar(50),
		forname varchar(25),
		surname varchar(25),
		username varchar(25),
		password varchar(25),
		repeat_password varchar(25),
		gender varchar(6),
		date varchar(50))";*/
	}

	function select($column, $table, $condition, $argument){
		$affectedRows = mysql_affected_rows();

		$selectResults[0] = $affectedRows;

		return $selectResults;
	}

	function insertIntoUserTable($form) {

		$query = sprintf("insert into user (id, occupation,	role, 
											forname, surname, username, 
											password, repeat_password, 
											gender, date, pin, privilege) values(
											'', '%s', '%s', 
											'%s', '%s', '%s', 
											SHA2('%s', 224), SHA2('%s', 224),
											'%s', '%s', '%d', '%d')",
			mysql_real_escape_string($form[0]),
			mysql_real_escape_string($form[1]),
			mysql_real_escape_string($form[2]),
			mysql_real_escape_string($form[3]),
			mysql_real_escape_string($form[4]),
			mysql_real_escape_string($form[5]),
			mysql_real_escape_string($form[6]),
			mysql_real_escape_string($form[7]),
			mysql_real_escape_string($form[8]),
			1234, 1);

		$result = mysql_query($query);
		if(mysql_affected_rows() == 0){
			$errorMessage = mysql_error();
		}
		// Get user id of the newly registered staff member.
		$query = sprintf("select id, username, password from user where username='%s' and password=SHA2('%s', 224)",
			mysql_real_escape_string($form[4]),
			mysql_real_escape_string($form[5]));

		$result = mysql_query($query);
		if(!$result) {
			$errorMessage = mysql_error();
		} else {
			while ($row = mysql_fetch_array($result)) {
				$meta_user_id = $row['id'];
			}
		}
		// Make reference id to meta_user table for additional user info.
		$query = sprintf("insert into meta_user (id) values ('%s')", 
			mysql_real_escape_string($meta_user_id));
		$result = mysql_query($query);
		if(mysql_affected_rows() == 0) {
			$errorMessage = "Error!";
		}

		mysql_free_result($result);

		return $errorMessage;

	}

	function createIPLog() {
		// create table log (id, ip, language, browser, os, osbits, username, date) 
		// values (id int auto_increment primary key, ip varchar(15), language varchar(5), browser varchar(15), os varchar(15), osbits varchar(15), username varchar(25), date timestamp)

		$header = apache_request_headers();
		$language = $header['Accept-Language'];
		$headers = explode(";", $header['User-Agent']);
		if(empty($_SESSION['username'])){
			$username = "anonymous";
		}

		$query = sprintf("insert into log (id, ip, language, browser, os, osbits, username, date) 
			values (null, '%s', '%s', '%s', '%s', '%s', '%s', NOW())",
			$_SERVER['REMOTE_ADDR'],
			$language,
			$headers[1],
			$headers[2],
			$headers[3],
			$username);

		$result = mysql_query($query);

		if(mysql_affected_rows() == 0) {
			$errorMessage = "Error!";
		}

		//mysql_free_result($result);

		return $errorMessage;

	}

	function addNewProduct() {

		// Upload PDF
		// Upload Product Cover

		$kbLink = "Documents/" . $_POST['name'] . "_" . $_POST['barcode'] . "_" . ucfirst($_FILES['product_file']['name'][0]);
		$kb_file_type = $_FILES['product_file']['type'][0];
		$kb_file_size = $_FILES['product_file']['size'][0];

		$coverLink = "Documents/" . $_POST['name'] . "_" . $_POST['barcode'] . "_" . ucfirst($_FILES['product_file']['name'][1]);
		$cover_file_type = $_FILES['product_file']['type'][1];
		$cover_file_size = $_FILES['product_file']['size'][1];


		foreach ($_FILES["product_file"]["error"] as $key => $error) {
			if($error == UPLOAD_ERR_OK) {
				$temporary = $_FILES["product_file"]["tmp_name"][$key];
				$final = $_POST['name'] . "_" . $_POST['barcode'] . "_" . ucfirst($_FILES["product_file"]["name"][$key]);
				move_uploaded_file($temporary, "Documents/$final");
			}
		}

		$query = sprintf("insert into product (id, name, latin, brand, manufacturer, quantity, category, size, intake, frequency, volume, delivery_num, delivery_days, man_price, retail_price, kb, cover, reference, barcode, prescription, kb_file_type, kb_file_size, cover_file_type, cover_file_size, modified) 
						values (null, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', NOW())",
						mysql_real_escape_string($_POST['name']), 
						mysql_real_escape_string($_POST['latin']), 
						mysql_real_escape_string($_POST['brand']), 
						$_POST['manufacturer'], 
						mysql_real_escape_string($_POST['quantity']), 
						mysql_real_escape_string($_POST['category']), 
						mysql_real_escape_string($_POST['size']), 
						$_POST['intake'], 
						$_POST['frequency'], 
						$_POST['volume'], 
						mysql_real_escape_string($_POST['delivery_num']), 
						$_POST['delivery_days'], 
						mysql_real_escape_string($_POST['man_price']),
						mysql_real_escape_string($_POST['retail_price']),
						$kbLink, 
						$coverLink, 
						mysql_real_escape_string($_POST['reference']), 
						mysql_real_escape_string($_POST['barcode']), 
						mysql_real_escape_string($_POST['prescription']), 
						$kb_file_type,
						$kb_file_size,
						$cover_file_type,
						$cover_file_size);

		$result = mysql_query($query);

		if(mysql_affected_rows() == 0) {
			$errorMessage = "Error!";
		}

		//mysql_free_result($result);

		return $errorMessage;
	}

	function addNewProductUser() {

		// Upload PDF
		// Upload Product Cover

		$kbLink = "Documents/" . $_POST['name'] . "_" . $_POST['barcode'] . "_" . ucfirst($_FILES['product_file']['name'][0]);
		$kb_file_type = $_FILES['product_file']['type'][0];
		$kb_file_size = $_FILES['product_file']['size'][0];

		$coverLink = "Documents/" . $_POST['name'] . "_" . $_POST['barcode'] . "_" . ucfirst($_FILES['product_file']['name'][1]);
		$cover_file_type = $_FILES['product_file']['type'][1];
		$cover_file_size = $_FILES['product_file']['size'][1];


		foreach ($_FILES["product_file"]["error"] as $key => $error) {
			if($error == UPLOAD_ERR_OK) {
				$temporary = $_FILES["product_file"]["tmp_name"][$key];
				$final = $_POST['name'] . "_" . $_POST['barcode'] . "_" . ucfirst($_FILES["product_file"]["name"][$key]);
				move_uploaded_file($temporary, "../../Documents/$final");
			}
		}

		$reference = "";
		if ($_POST['reference'] == "") {
			$reference = "http://www.drugs.com/" . strtolower($_POST['name']) . ".html";
		} else {
			$reference = $_POST['reference'];
		}

		$query = sprintf("insert into product (id, name, latin, brand, manufacturer, quantity, category, size, intake, frequency, volume, delivery_num, delivery_days, man_price, retail_price, kb, cover, reference, barcode, prescription, kb_file_type, kb_file_size, cover_file_type, cover_file_size, modified) 
						values (null, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', NOW())",
						mysql_real_escape_string($_POST['name']), 
						mysql_real_escape_string($_POST['latin']), 
						mysql_real_escape_string($_POST['brand']), 
						$_POST['manufacturer'], 
						mysql_real_escape_string($_POST['quantity']), 
						mysql_real_escape_string($_POST['category']), 
						mysql_real_escape_string($_POST['size']), 
						$_POST['intake'], 
						$_POST['frequency'], 
						$_POST['volume'], 
						mysql_real_escape_string($_POST['delivery_num']), 
						$_POST['delivery_days'], 
						mysql_real_escape_string($_POST['man_price']),
						mysql_real_escape_string($_POST['retail_price']),
						$kbLink, 
						$coverLink, 
						$reference, 
						mysql_real_escape_string($_POST['barcode']), 
						mysql_real_escape_string($_POST['prescription']), 
						$kb_file_type,
						$kb_file_size,
						$cover_file_type,
						$cover_file_size);

		$result = mysql_query($query);

		$affected = mysql_affected_rows();

		$success = false;
		if($affected == 1) {
			$success = true;
		}

		return $success;
	}

	function updateProductUser() {

		$query = sprintf("update product set name='%s', 
			latin='%s', 
			brand='%s', 
			manufacturer='%s', 
			quantity='%s', 
			category='%s', 
			size='%s', 
			intake='%s', 
			frequency='%s', 
			volume='%s', 
			delivery_num='%s', 
			delivery_days='%s', 
			man_price='%s', 
			retail_price='%s', 
			barcode='%s' where id='%s'", 
			$_POST['name'],
			$_POST['latin'], 
			$_POST['brand'], 
			$_POST['manufacturer'], 
			$_POST['quantity'], 
			$_POST['category'], 
			$_POST['size'], 
			$_POST['intake'],
			$_POST['frequency'], 
			$_POST['volume'], 
			$_POST['delivery_num'], 
			$_POST['delivery_days'], 
			$_POST['man_price'], 
			$_POST['retail_price'], 
			$_POST['barcode'],
			$_POST['id']);

		$result = mysql_query($query);

		$affected = mysql_affected_rows();

		if($affected == 1) {
			$success = "Success";
		} else if($affected == 0) {
			$success = mysql_error();
		} else {
			$success = "Exception";
		}

		return $success;
	}

	function deleteProductUser() {

		$query = sprintf("delete from product where id='%s'", $_POST['id']);

		$result = mysql_query($query);

		include '../../library/execution_success.php';
		$rs = new ExecutionSuccess();
		$success = $rs->executionSuccess();

		return $success;
	}

	function selectAllProducts() {

		$sort = "name ";
		$limit = " limit 0, 5";

		switch ($_POST['sort']) {
			case 'name':
				$sort = "name";
				break;
			case 'manufacturer':
				$sort = "manufacturer";
				break;
			case 'price':
				$sort = "retail_price";
				break;
			case 'latest':
				$sort = "modified DESC";
				break;
			case 'oldest':
				$sort = "modified ASC";
				break;
			default:
				$sort = "RAND()";
				break;
		}

		switch ($_POST['limit']) {
			case 5:
				$limit = " limit 0, 5";
				break;
			case 25:
				$limit = " limit 0, 25";
				break;
			case 50:
				$limit = " limit 0, 50";
				break;
			case 100:
				$limit = " limit 0, 100";
			case 'none':
				$limit = "";
			default:
				$limit = " limit 0, 25";
				break;
		}

		$query = "select name, manufacturer, retail_price, kb, cover, modified from product order by " . $sort . $limit;

		$result = mysql_query($query);

		//mysql_free_result($result);

		return $result;

	}

	function selectAllProductsUpdate() {
		$query = "select id, name, quantity, man_price, retail_price, barcode, modified from product order by modified desc limit 0, 25";

		$result = mysql_query($query);

		return $result;
	}

	function updateProduct() {

		$final = $_POST['name'] . "_" . $_POST['barcode'] . "_" . ucfirst($_FILES["cover_file"]["name"]);
		$coverLink = "Documents/" . $_POST['name'] . "_" . $_POST['barcode'] . "_" . ucfirst($_FILES['cover_file']['name']);
		$cover_file_type = $_FILES['cover_file']['type'];
		$cover_file_size = $_FILES['cover_file']['size'];

		if($_FILES['cover_file']['size'] != 0) {
			move_uploaded_file($_FILES['cover_file']['tmp_name'], "Documents/$final");
			$queryFileUpload = sprintf("update product set cover='%s', cover_file_type='%s', cover_file_size='%s' where id='%s'", 
				$coverLink, 
				$cover_file_type, 
				$cover_file_size, 
				$_POST['id']);
			$resultFileUpload = mysql_query($queryFileUpload);
			if(mysql_affected_rows() == 0) {
				$errorMessage = "Error!";
			}
		}

		$query = sprintf("update product set name='%s', quantity='%s', man_price='%s', retail_price='%s', barcode='%s' where id='%s'", 
			$_POST['name'], 
			$_POST['quantity'], 
			$_POST['man_price'], 
			$_POST['retail_price'], 
			$_POST['barcode'], 
			$_POST['id']);
		$result = mysql_query($query);
		if(mysql_affected_rows() == 0) {
			$errorMessage = "Error!";
		}

		return $errorMessage;
	}

	function selectAllProductsDelete() {
		$query = "select id, name, quantity, man_price, retail_price, barcode, modified from product order by modified desc limit 0, 25";

		$result = mysql_query($query);

		return $result;
	}

	function deleteProduct($attributeName) {
		$query = sprintf("delete from product where id='%s'", $attributeName);

		$result = mysql_query($query);

		if(mysql_affected_rows() == 0) {
			$errorMessage = "Error!";
		}

		return $errorMessage;
	}

	function addNewUser() {
		$date = date("l jS \of F Y \@ GA e");
		$random = mt_rand(0, 9999);
		$final = $_POST['username'] . $random . $_FILES["avatar"]["name"];
		$avatarLink = "Documents/" . $_POST['username'] . $random . $_FILES['avatar']['name'];
		
		move_uploaded_file($_FILES['avatar']['tmp_name'], "Documents/$final");

		$query = sprintf("insert into user (id, occupation, 
			role, 
			forname, 
			surname, 
			username, 
			password, 
			repeat_password, 
			gender, 
			date, 
			pin, 
			privilege, 
			avatar, 
			notes) values('', '%s', '%s', '%s', '%s', '%s', SHA2('%s', 224), SHA2('%s', 224), '%s', '%s', '%s', '%s', '%s', '%s')", 
			$_POST['occupation'], 
			$_POST['role'], 
			$_POST['forname'], 
			$_POST['surname'], 
			$_POST['username'], 
			$_POST['password'], 
			$_POST['password'], 
			$_POST['gender'], 
			$date, 
			$_POST['pin'], 
			$_POST['privilege'], 
			$avatarLink, 
			$_POST['notes']);

		$result = mysql_query($query);
		
		if(mysql_affected_rows() == 0) {
			$errorMessage = "Error!";
		}

		return mysql_error();
	}

	function selectAllUsers() {
		//$limit = ;
		//$offset = ;
		$query = "select * from user order by forname";
		$result = mysql_query($query);
		$errorMessage = mysql_error();

		return $result;
	}

	function searchAllUsers($name) {
		if($name == "all") {
			$query = "select * from user order by forname";
		}
		$query = sprintf("select * from user where forname='%s'", $name);
		$result = mysql_query($query);
		$errorMessage = mysql_error();

		return $result;
	}

	function searchAllUsersSort($type, $limit) {
		$query = sprintf("select * from user order by %s limit 0, %s", $type, $limit);
		$result = mysql_query($query);
		$errorMessage = mysql_error();

		return $result;
	}

	function updateUser() {

		$avatarLink = "";

		if($_FILES['avatar']['error'] == 0) {
			$random = mt_rand(0, 9999);
			$final = $_POST['usernameU'] . $random . $_FILES["avatar"]["name"];
			$avatarLink = "Documents/" . $_POST['usernameU'] . $random . $_FILES['avatar']['name'];
		
			move_uploaded_file($_FILES['avatar']['tmp_name'], "Documents/$final");
		} elseif($_FILES['avatar']['error'] == 1 || $_FILES['avatar']['error'] == 2) {
			// The file was too big.
		} elseif ($_FILES['avatar']['error'] == 3) {
			// The file was partially uploaded.
		} elseif ($_FILES['avatar']['error'] == 4) {
			// No file was uploaded.
		} elseif ($_FILES['avatar']['error'] == 6 || $_FILES['avatar']['error'] == 1) {
			// General server error.
		}

		if($_POST['passwordU'] == "") {
			$errorMessage = "The password cannot be NULL!";
		} elseif($_FILES['avatar']['size'] == 0) {
			$query = sprintf("update user set username='%s', 
			password=SHA2('%s', 224), 
			privilege='%s', 
			avatar='%s', 
			notes='%s' where id='%s'", $_POST['usernameU'], 
			$_POST['passwordU'], 
			$_POST['privilegeU'],
			$_POST['backupAvatar'], 
			$_POST['notes'], 
			$_POST['user_id']);
			$result = mysql_query($query);
			$errorMessage = mysql_error();
		} else {
			$query = sprintf("update user set username='%s', 
			password=SHA2('%s', 224), 
			privilege='%s', 
			avatar='%s', 
			notes='%s' where id='%s'", $_POST['usernameU'], 
			$_POST['passwordU'], 
			$_POST['privilegeU'], 
			$avatarLink, 
			$_POST['notes'], 
			$_POST['user_id']);
			$result = mysql_query($query);
			$errorMessage = mysql_error();
		}

		return $errorMessage;
	}

	function deleteUser() {
		$query = sprintf("delete from user where id='%s'", $_POST['user_id']);

		$result = mysql_query($query);

		$errorMessage = mysql_error();

		return $errorMessage;
	}

	function searchAllProducts($keyword, $type, $order) {
		if($keyword == "all"){
			$query = sprintf("select * from product order by %s", $order);
		} else if ($type == "prescription") {
			//$query = sprintf("select * from product where prescription like '%%s%' order by %s", $keyword, $order);
			$query = "select * from product where prescription like '%" . $keyword . "%'";
		} else {
			$query = sprintf("select * from product where %s='%s' order by %s", $type, $keyword, $order);
		}

		$result = mysql_query($query);

		$errorMessage = mysql_error();

		return $result;
	}

	function viewAllMessages($sort) {
		$query = "select * from messages" . $sort;
		$result = mysql_query($query);

		return $result;
	}

	function markMessageAsRead($messageId) {
		$query = sprintf("update messages set reviewed='y' where id='%s'", $messageId);
		$result = mysql_query($query);

		return $result;
	}

	function removeMessage($messageId) {
		$query = sprintf("delete from messages where id='%s'", $messageId);
		$result = mysql_query($query);

		return mysql_error();
	}

	function searchMessages($keyword) {
		$query = sprintf("select * from messages where sender='%s'", $keyword);
		$result = mysql_query($query);
		if(mysql_affected_rows() == 1) {
			$found = mysql_fetch_assoc($result);
			array_push($found, "sender");
		} else {
			$query = sprintf("select * from messages where receiver='%s'", $keyword);
			$result = mysql_query($query);
			if(mysql_affected_rows() == 1) {
				$found = mysql_fetch_assoc($result);
				array_push($found, "receiver");
			} else {
				$query = sprintf("select * from messages where subject='%s'", $keyword);
				$result = mysql_query($query);
				if(mysql_affected_rows() == 1) {
					$found = mysql_fetch_assoc($result);
					array_push($found, "subject");
				} else {
					$query = "select * from messages where file like '%" . $keyword . "%'";
					$result = mysql_query($query);
					if(mysql_affected_rows() == 1) {
						$found = mysql_fetch_assoc($result);
						array_push($found, "file");
					} else {
						$query = "select * from messages where message like '%" . $keyword . "%'";
						$result = mysql_query($query);
						if(mysql_affected_rows() == 1) {
							$found = mysql_fetch_assoc($result);
							array_push($found, "message");
						}
					}
				}
			}
		}

		return $found;
	}

	function sendMessage() {

		if(!isset($_POST['sender'])) {
			$sender = "georgi";
		}

		$file = $sender . "_" . $_POST['receiver'] . "_" . ucfirst($_FILES['file']['name']);
		$fileLink = "Attachments/" . $sender . "_" . $_POST['receiver'] . "_" . ucfirst($_FILES['file']['name']);
		$file_type = $_FILES['file']['type'];
		$file_size = $_FILES['file']['size'];

		if($_FILES['file']['size'] != 0) {
			move_uploaded_file($_FILES['file']['tmp_name'], "../../Attachments/$file");
		}

		$query = sprintf("insert into messages set sender='%s', receiver='%s', subject='%s', file='%s', reviewed='n', message='%s'", 
			$sender, 
			$_POST['receiver'], 
			$_POST['subject'], 
			$fileLink, 
			$_POST['message']);

		$result = mysql_query($query);

		include '../../library/execution_success.php';
		$rs = new ExecutionSuccess();
		$success = $rs->executionSuccess();

		return $success;
	}

	function accountingPieChart() {

		$query = "select id from user";
		$result = mysql_query($query);
		$total_users = mysql_num_rows($result);

		$query = "select id from product";
		$result = mysql_query($query);
		$total_products = mysql_num_rows($result);

		$query = "select id from messages";
		$result = mysql_query($query);
		$total_messages = mysql_num_rows($result);

		$query = "select id from log";
		$result = mysql_query($query);
		$total_visitors = mysql_num_rows($result);

		$pieChartData = array('total_users' => $total_users, 
							  'total_products' => $total_products, 
							  'total_messages' => $total_messages, 
							  'total_visitors' => $total_visitors);

		return $pieChartData;

	}

	function accountingColumnChart() {

		$query = "select sum(man_price) from product";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		$total_expenses = round($row[0], 2);

		$query = "select sum(retail_price) from product";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		$total_revenue = round($row[0], 2);
		
		$profit = $total_revenue - $total_expenses;

		$query = "select max(man_price) from product";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		$max_man_price = round($row[0], 2);

		$query = "select min(man_price) from product";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		$min_man_price = round($row[0], 2);

		$query = "select avg(man_price) from product";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		$avg_man_price = round($row[0], 2);

		$query = "select max(retail_price) from product";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		$max_retail_price = round($row[0], 2);

		$query = "select min(retail_price) from product";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		$min_retail_price = round($row[0], 2);

		$query = "select avg(retail_price) from product";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		$avg_retail_price = round($row[0], 2);

		$query = "select id, modified from product order by id desc";
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		$explode = explode('-', $row[1]);
		$year = $explode[0];

		$columnChartData = array('total_expenses' => $total_expenses,
								 'total_revenue' => $total_revenue, 
								 'profit' => $profit, 
								 'max_man_price' => $max_man_price, 
								 'min_man_price' => $min_man_price, 
								 'avg_man_price' => $avg_man_price,
								 'max_retail_price' => $max_retail_price,
								 'min_retail_price' => $min_retail_price,
								 'avg_retail_price' => $avg_retail_price, 
								 'year' => $year);

		return $columnChartData;

	}
}

?>