<?php

/*
 * Site HTML5 Tail
 * Footer
 */

?>
<!-- Display Default Site Footer -->
<footer>
	<p><? echo $footer ?></p>
	<?
	// If the user was authenticated
	// Welcome him / her by forename
	if(($_SESSION['forename'] != null) && ($page == "index")) {
		echo "<p>Hello " . $_SESSION['forename'] . "!</p>";
	}
	?>
</footer>
</body>
</html>
