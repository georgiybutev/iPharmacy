<?php

/*
 * Site HTML5 Head
 * Title, Author, Description, Keywords, Robots, Logo
 */

include 'settings.php';

$settings = new Settings();
$settings->connectToDatabase();

// Process MySQL result set
// Else redirect the user
$result = mysql_query("select * from info where id=1");
if(!$result){
	header("Location: Error.php");
	exit;
}

// Receive SEO related data

$row = mysql_fetch_assoc($result);
$title = $row['title'];
$author = $row['author'];
$description = $row['description'];
$keywords = $row['keywords'];
$robots = $row['robots'];
$logo = $row['logo'];
$footer = $row['footer'];

?>

<!DOCTYPE html>
<html>
<!-- Display SEO Data  -->
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
<body>
	<header>
		<!-- Display Navigation Links For All Pages -->
		<h1><? echo $logo ?></h1>
		<nav>
			<ul>
				<li><a href="index"	class="<? if($page == "index"){echo "active";} ?>">home</a></li>
				<li><a href="Products" class="<? if($page == "products"){echo "active";} ?>">products</a></li>
				<li><a href="News" class="<? if($page == "news"){echo "active";} ?>">news</a></li>
				<li><a href="Login" class="<? if($page == "login"){echo "active";} ?>">login</a></li>
				<li><a href="Register" class="<? if($page == "register"){echo "active";} ?>">register</a></li>
			</ul>
		</nav>
	</header>