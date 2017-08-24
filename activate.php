<?php
include 'includes/init.php';

$path = explode('/', $_SERVER["PHP_SELF"]);
$redirect = "http://" . $_SERVER["HTTP_HOST"] . "/" . $path[1] . "/" . "index.php";
$rtime = 5;

if (!empty ($_GET["signup_key"])) {
	$signup_key = $_GET["signup_key"];

	$sql = "SELECT * FROM users WHERE hashed_activation = '" . $signup_key . "'";
	$query = mysqli_query($db_conx, $sql);

	$row = mysqli_fetch_array($query);
	$key = $row['hashed_activation'];
	if ($row['activated']==1) {
		$msg = "User has already been activated.";
	}else if ($key == $signup_key) {
		//echo "key is " . $key . "<br>";
		mysqli_query($db_conx, "UPDATE users SET activated = '1' WHERE hashed_activation = '" . $signup_key . "'");
		$msg = "Account activation complete!<br>";		
	} else {
		$msg = "Incorrect activation key specified.";
	} ?>
		<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
		<tr>
		<td>
		<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
			<tr><td><center>
			<p><strong><?php echo $msg;?></strong></p>
			<p><a href="<?php echo $redirect; ?>">Redirecting in <?php echo $rtime;?>s <br />Click to continue</a></p>
			</center></td></tr>
		</table>
		</td>
		</tr>
	</table>
<?php
	mysqli_close($db_conx);
	header("refresh:". $rtime ."; url=".$redirect);
} else
	header("location:index.php");
?>