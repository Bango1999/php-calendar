<?php
$title = "Join Group";
include_once "includes/init.php";
include_once 'includes/auth.php';
$keyfail = false;
$showform = true;

if (isset ($_GET["invite"])) {
	$sql = "SELECT * FROM groups WHERE invitekey = '" . $_GET["invite"] . "'";
		//echo $sql . "<br />";
	$query = mysqli_query($db_conx, $sql);
	$row = mysqli_fetch_array( $query );
	$gname = $row["name"];
	$gid = $row["groupid"];
	if (mysqli_num_rows($query) == 0) {
		$keyfail = true;
	} else {
		$showform = false;
		$sql = "SELECT * from members JOIN groups on members.groupid=groups.groupid WHERE members.userid='" . $_SESSION['userId'] . "' and groups.invitekey='" . $_GET['invite'] . "'";
		//echo $sql . "<br />";
		$query = mysqli_query($db_conx, $sql);
		if (mysqli_num_rows($query) == 0) {
			$msg = "You have successfully joined group: <br />" . $gname;
			
			$sql = "INSERT INTO `members` (`memberid`, `userid`, `groupid`, `level`) VALUES (NULL, '". $_SESSION["userId"] ."', '" . $gid . "', '2');";
			//echo $sql . "<br />";
			$query = mysqli_query($db_conx, $sql);
			if( mysqli_affected_rows($db_conx) == -1 ) $msg = "You were unable to join this group.";

		} else
			$msg = "You are already a member of this group.";
?>
	<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
		<tr>
		<td>
		<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
			<tr><td><center>
			<p><strong><?php echo $msg;?></strong></p>
			<p>Redirecting in 5s</p>
			</center></td></tr>
		</table>
		</td>
		</tr>
	</table>
<?php


		create_groups_session();
		header("refresh:5; url=mygroups.php");
	}
}
if ($showform) {
?>
<table border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
		<tr><td><h3>Join a Group</h3></td></tr>
		<tr>
		<td>
		<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF"><tr><td>
<form action="joingroup.php" method="get">
    <div>Group Invite Key:</div>
    <input name="invite" type="text" maxlength="30" value="<?php if(isset($_GET["invite"])) echo $_GET["invite"]; ?>">
    <span><?php if($keyfail) echo "<br><strong>Please enter a valid invite key.</strong></br><br />"; ?></span>
    <div align="center"><input type="submit" value="Join Group"></div>
    <span id="status"></span>
  </form>
  </td></tr></table></td></tr></table>
<?php ; } ?> 
  
<?php include_once "includes/footer.php"; ?>