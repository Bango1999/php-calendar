<?php
$title = "Promote User";
include_once "includes/init.php";
include_once 'includes/auth.php';
if(isset($_SERVER["HTTP_REFERER"])) $redirect = $_SERVER["HTTP_REFERER"]; else $redirect = "mygroups.php";
$rtime = "0";
$msg = "User successfully promoted to admin.";
if (isset($_GET["g"])&& isset($_GET["u"])) {
	$result = mysqli_query($db_conx, "SELECT * FROM members WHERE groupid='" . $_GET['g'] . "' and userid='". $_SESSION['userId'] . "';");
	$row = mysqli_fetch_array($result);
	if( $row['level'] == 0 ) {
		$sql = "SELECT * FROM members WHERE userid = '" . $_GET["u"] . "' and groupid = '" . $_GET["g"].  "'";
		//echo $sql . "<br />";
		$query = mysqli_query($db_conx, $sql);
		$row = mysqli_fetch_array($query);
		if( $row['level'] != 2 ) {
			$msg = "User cannot be promoted.";
			$rtime = "5";
		}	
		else {
			$sql = "UPDATE members SET level = '1' WHERE userid = '" . $_GET['u'] . "' and groupid = '" . $_GET['g'] . "'";
			//echo $sql . "<br />";
			$query = mysqli_query($db_conx, $sql);
			if( mysqli_affected_rows($db_conx) <=0 ) {
				$msg = "Promotion failed.";
				$rtime = "5";
			}			
		}
	}
	else {
		$msg = "You are not the creator of this group.";
		$rtime = "5";
	}
} else {
	$msg = "Error. Returning to My Groups.";
	$rtime = "5";
}
?>
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
		create_groups_session();
		header("refresh:". $rtime ."; url=".$redirect);

  
include_once "includes/footer.php"; 
?>