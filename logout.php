<?php
$title="Logging Out";
$loggingout=true;
include "includes/init.php";
 
// Destroy the session variables
session_destroy();

// Expire their cookie files
setcookie("user", "", time()-3600);
setcookie("PHPSESSID", "", time()-3600);
?>
	<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
		<tr>
		<td>
		<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
			<tr><td><center>
			<p><strong>Logout success!</strong></p>
			<p>Redirect to Login page in 1s</p>
			</center></td></tr>
		</table>
		</td>
		</tr>
	</table>
<?php
header("refresh:1; url=index.php");

include_once "includes/footer.php";
?>
