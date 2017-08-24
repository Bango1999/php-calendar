<?php

//-----------------------------------------------------#!
//CHECK FOR VALID GROUPS
//check_groups();

//-----------------------------------------------------#!
//CHECK FOR VALID LOGIN
//check_login();
if(check_login_b() && check_groups_b()) {
	
} else {
	header("Location: index.php?r=".$_SERVER["REQUEST_URI"]);
}

?>
