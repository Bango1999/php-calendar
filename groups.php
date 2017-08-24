<?php $title = "Public Groups"; include_once "includes/init.php";

$result = mysqli_query($db_conx, "SELECT * FROM groups WHERE publicgroup='1'");

?>
<table border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
		<tr><td><h3>Public Groups</h3></td></tr>
		<tr>
		<td>
		<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<th>Name</th>
<th>Description</th>
<th>List Members</th>
<th>Join Public Group</th>
</tr>

<?php
while ($row = mysqli_fetch_array($result)) {
	echo "<tr>";
	echo "<td>" . $row['name'] . "</td>";
	echo "<td>" . $row['description'] . "</td>";
	echo "<td><a href=\"members.php?g=" . $row['groupid'] . "\">Members</a></td>";
	if($row['publicgroup'] == 1 ) {
		$result2 = mysqli_query($db_conx, "SELECT * FROM members WHERE groupid='".$row['groupid']."' and userid='".$_SESSION['userId']."'");
		if( mysqli_num_rows($result2)==0 )		
			echo "<td><a href=\"joingroup.php?invite=" . $row['invitekey'] . "\">Join Now</a></td>";
	}
	echo "</tr>";
}
?>
</table></td></tr></table>

<?php
mysqli_close($db_conx);

include_once "includes/footer.php"; 
?>
