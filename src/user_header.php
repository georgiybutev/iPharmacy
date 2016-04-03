<?php

/*
 * Site HTML5 Head for the User
 * Title, Author, Description, Keywords, Robots, Logo
 */

include 'settings.php';

$settings = new Settings();
$settings->connectToDatabase();

// Retrieve a row from the info database table
// On failure to do so, redirect the user

$result = mysql_query("select * from info where id=1");
if(!$result){
	header("Location: Error.php");
	exit;
}

// Retrieve the necessary Medical CMS information for SEO - meta

$row = mysql_fetch_assoc($result);
$title = $row['title'];
$author = $row['author'];
$description = $row['description'];
$keywords = $row['keywords'];
$robots = $row['robots'];
$logo = $row['logo'];
$footer = $row['footer'];
$path = $row['path'];
$sc = "../../"; // Shortcut Path

// Free MySQL server resources from the recent query result set

mysql_free_result($result);
?>

<!DOCTYPE html>
<html>

<!-- Display SEO Data -->

<head>
	<title><? echo $title ?></title>
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
	<link href="<? echo $sc ?>/media/style.css" rel="stylesheet" type="text/css" medial="all">
	<meta charset="utf-8">
	<meta name="author" content="<? echo $author ?>">
	<meta name="description" content="<? echo $description ?>">
	<meta name="keywords" content="<? echo $keywords ?>">
	<meta name="robots" content="<? echo $robots ?>">
</head>
<body>
	<header>
		<!-- Display Medical CMS Logo -->
		<h1><? echo $logo ?></h1>
		<!-- Display Medical CMS Navigation Menu -->
		<nav>
			<ul class="nav_user_interface">
				<li><a href="Interface"	class="<? if($page == "index"){echo "active";} ?>">home</a></li>
				<li><a href="Products" class="<? if($page == "products"){echo "active";} ?>">products</a></li>
				<li><a href="Messages" class="<? if($page == "messages"){echo "active";} ?>">messages</a></li>
				<li><a href="Report" class="<? if($page == "reports"){echo "active";} ?>">reports</a></li>
				<li><a href="Accounting" class="<? if($page == "accounting"){echo "active";} ?>">accounting</a></li>
				<li><a href="../../Logout" class="<? if($page == "logout"){echo "active";} ?>">logout</a></li>
			</ul>
		</nav>
	</header>