<?php

/*
 * Site HTML5 Head for the Administrato
 * Title, Author, Description, Keywords, Robots, Logo
 */

include 'settings.php';

$settings = new Settings();
$settings->connectToDatabase();

// Get web site information stored in the database
// Else redirect to error page

$result = mysql_query("select * from info");
if(!$result){
	header("Location: Error.php");
	exit;
}

// Fetch the MySQL query result using assoc array

$row = mysql_fetch_assoc($result);
$title = $row['title'];
$author = $row['author'];
$description = $row['description'];
$keywords = $row['keywords'];
$robots = $row['robots'];
$logo = $row['logo'];
$footer = $row['footer'];

// Free MySQL server system resources

mysql_free_result($result);
?>

<!DOCTYPE html>
<html>

<!-- Display SEO Related Information -->

<head>
	<title><? echo $title ?></title>
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
	<link href="media/style.css" rel="stylesheet" type="text/css" medial="all">
	<meta charset="utf-8">
	<meta name="author" content="<? echo $author ?>">
	<meta name="description" content="<? echo $description ?>">
	<meta name="keywords" content="<? echo $keywords ?>">
	<meta name="robots" content="<? echo $robots ?>">
</head>

<!-- Display Admin Navigation Links -->

<body>
	<header>
		<h1><? echo $logo ?></h1>
		<nav>
			<ul class="nav_admin">
				<li><a href="Admin"	class="<? if($page == "admin"){echo "active";} ?>">home</a></li>
				<li><a href="AllProducts" class="<? if($page == "all_products"){echo "active";} ?>">products</a></li>
				<li><a href="Users" class="<? if($page == "users"){echo "active";} ?>">users</a></li>
				<li><a href="Messages" class="<? if($page == "messages"){echo "active";} ?>">messages</a></li>
				<li><a href="Reports" class="<? if($page == "reports"){echo "active";} ?>">reports</a></li>
				<li><a href="Accounting" class="<? if($page == "accounting"){echo "active";} ?>">accounting</a></li>
				<li><a href="Logout" class="<? if($page == "logout"){echo "active";} ?>">logout</a></li>
			</ul>
		</nav>
	</header>