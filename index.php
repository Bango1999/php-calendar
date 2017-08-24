<?php
include "includes/init.php";

//if the user has a session going, they shouldn't be seeing the login page.
//so redirect them to their calendar
if (isset ($_SESSION['userId'])) {
	header("location:user.php");
}
include_once "login.inc.html";
include_once "includes/footer.php";
?>