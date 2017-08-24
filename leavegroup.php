<?php
$title = "Leave Group";
include_once "includes/init.php";
include_once 'includes/auth.php';
$msg = "Group Left Successfully";
$rtime = "0";
$redirect = "mygroups.php";

if (isset ($_GET["g"])) {
		$sql = "SELECT * FROM members WHERE userid = '" . $_SESSION["userId"] . "' and groupid = '" . $_GET["g"].  "'";
		//echo $sql . "<br />";
		$query = mysqli_query($db_conx, $sql);
		$row = mysqli_fetch_array($query);
		if( $row['level'] == 0 ) {
			$msg = "At this time, Creators can not leave groups.";
			$rtime = "5";
		} else {
			$sql = "DELETE FROM members WHERE userid = '" . $_SESSION['userId'] . "' and groupid = '" . $_GET['g'] . "'";
			//echo $sql . "<br />";
			$query = mysqli_query($db_conx, $sql);
			if( mysqli_affected_rows($db_conx) <=0 ) {
				$msg = "Leave failed.";
				$rtime = "5";
			}			
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