<?php
$title = "Create Group";
include_once "includes/init.php";
include_once 'includes/auth.php';
$namefail = false;
$showform = true;
$rtime = "5";

if (isset ($_POST["groupname"]) && isset ($_POST["groupdesc"]) && strlen($_POST["groupdesc"]) > 9 && isset ($_POST["publicgroup"])) {
	$sql = "SELECT * FROM groups WHERE name = '" . $_POST["groupname"] . "'";
	//echo $sql;
	$query = mysqli_query($db_conx, $sql);
	if (mysqli_num_rows($query) > 0) {
		$namefail = true;
	} else {
		$showform = false;
		$msg = "Group Creation Success";
		if ($_POST["publicgroup"] == "true")
			$p = 1;
		else
			$p = 0;
		$sql = "INSERT INTO `groups` (`groupid`, `name`, `description`, `publicgroup`, `invitekey`) VALUES (NULL, '" . $_POST["groupname"] . "', '" . $_POST["groupdesc"] . "', '" . $p . "', SHA1('" . $_POST["groupname"] . $_POST["groupdesc"] . time() . "') );";
		//echo $sql . "<br />";
		$query = mysqli_query($db_conx, $sql);
		if (mysqli_affected_rows($db_conx) == -1) {
			$msg = "Group was unable to be created.";
		} else {
			$sql = "INSERT INTO `members` (`memberid`, `userid`, `groupid`, `level`) VALUES (NULL, '" . $_SESSION["userId"] . "', '" . $db_conx->insert_id . "', '0');";
			//echo $sql . "<br />";
			$query = mysqli_query($db_conx, $sql);
			if (mysqli_affected_rows($db_conx) == -1)
				$msg = "Creator was unable to be associated with group.";
			else
				$rtime = 0;
		}
?>
	<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
		<tr>
		<td>
		<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
			<tr><td><center>
			<p><strong><?php echo $msg;?></strong></p>
			<p>Redirect to My Groups in <?php echo $rtime; ?>s</p>
			</center></td></tr>
		</table>
		</td>
		</tr>
	</table>
<?php


		create_groups_session();
		header("refresh:" . $rtime . "; url=mygroups.php");
	}
}
if ($showform) {
?>

<table border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
		<tr><td><h3>Create a New Group</h3></td></tr>
		<tr>
		<td>
		<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF"><tr><td>
<h3>Create a new Group</h3>
<form action="creategroup.php" method="post">
    <div>Group Name:</div>
    <input name="groupname" type="text" maxlength="30" value="<?php if(isset($_POST["groupname"])) echo $_POST["groupname"]; ?>">
    <span><?php if(!isset($_POST["groupname"])) echo "<br><strong>Please input a group name.</strong></br><br />"; else if($namefail) echo "<br><strong>Group Name is already in use</strong></br><br />"; ?></span>
    <div>Group Description:</div>
    <input name="groupdesc" type="text" maxlength="30" value="<?php if(isset($_POST["groupdesc"])) echo $_POST["groupdesc"]; ?>">
    <span><?php if(!isset($_POST["groupdesc"])) echo "<br><strong>Please input a group description.</strong></br><br />"; else if ( strlen($_POST["groupdesc"]) < 10) echo "<br><strong>Please input a group description.<br />10 characters minimum.</strong></br><br />";?></span>
    <div>Would you like this group to be publicly listed?<br />
    <select name="publicgroup">
      <option value="true" <?php if(isset($_POST["publicgroup"]) && $_POST["publicgroup"]=="true" ) echo "selected"; ?>>Yes</option>
      <option value="false" <?php if(isset($_POST["publicgroup"]) && $_POST["publicgroup"]=="false" ) echo "selected"; ?>>No</option>
    </select></div>
    <div align="center"><input type="submit" value="Create Group"></div>
    <span id="status"></span>
  </form>
  </td></tr></table></td></tr></table>
<?php ; } ?> 
  
<?php include_once "includes/footer.php"; ?>