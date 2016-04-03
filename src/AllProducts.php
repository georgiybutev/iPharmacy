<?php
/*
 * Products
 * Manage Products
 * View, Add, Update, and Remove Product Information
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

?>

<!-- Display Admin Product Management Navigation -->

<section>
	<table>
		<td><a class="admin_products" href="AdminViewProductBrief">View<br/><img src="media/view.ico"></a></td>
		<td><a class="admin_products" href="AdminAddProduct">Add New<br/><img src="media/add.ico"></a></td>
		<td><a class="admin_products" href="AdminUpdateProduct">Update<br/><img src="media/update.ico"></a></td>
		<td><a class="admin_products" href="AdminRemoveProduct">Remove<br/><img src="media/remove.ico"></a></td>
	</table>
</section>

<?

include 'tail.php';

?>