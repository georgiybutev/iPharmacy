<?php

/*
 * Home Page Body
 * Products, Categories, Users, Transactions
 */

?>

<!-- Display HTML Table For Various Database Information -->

<section>
	<table>
		<th><h2>Products</h2></th>
		<th><h2>Categories</h2></th>
		<th><h2>Users</h2></th>
		<th><h2>Transactions</h2></th>
		<?
		$i = 0;
		$product = mysql_query("select name, category, modified from product order by modified limit 0, 15");
		// Process SQL result set
		// Build TD structure
		while ($row = mysql_fetch_array($product)) {
			echo "<tr>";
			echo "<td>" . $row[0] . "</td>";
			echo "<form action=\"Products\" method=\"GET\"><td><input type=\"submit\" id=\"submit\" name=\"submit\" value=\"" . $row[1] . "\" /></td></form>";
			$user = mysql_query("select username, forname, surname, occupation, date from user order by date limit " . $i . ", 15");
			$userData = mysql_fetch_assoc($user);
			echo "<td title=" . $userData['username'] . "><a href=\"#\">" . $userData['forname'] . " " . $userData['surname'] . "</a></td>";
			echo "</tr>";
			$i++;
		}
		?>
	</table>
</section>