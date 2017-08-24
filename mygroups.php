<?php 
$title = "My Groups"; 
include_once "includes/init.php";
include_once 'includes/auth.php';

$result = mysqli_query($db_conx, "SELECT * FROM members JOIN groups on members.groupid=groups.groupid WHERE members.userid='" . $_SESSION["userId"] . "'" );
?>
<table border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
		<tr><td><h3>My Groups</h3></td></tr>
		<tr>
		<td>
		<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<th>Name</th>
<th>Description</th>
<th>Role</th>
<th>List Members</th>
<th>Leave Group</th>
</tr>
<?php
while ($row = mysqli_fetch_array($result)) {
	echo "<tr>";
	echo "<td>" . $row['name'] . "</td>";
	echo "<td>" . $row['description'] . "</td>";
	echo "<td>";
	switch( $row['level'] ) {
		case 0: echo "Creator"; break;
		case 1: echo "Admin"; break;
		case 2: echo "Member"; break; }
	echo "</td>";
	echo "<td><a href=\"members.php?g=" . $row['groupid'] . "\">Members</a></td>";
	if($row['level'] >= 1 ) echo "<td><a href=\"leavegroup.php?g=" . $row['groupid'] . "\">Leave Group</a></td>";
	echo "</tr>";
}
?>
</table></td></tr></table>

<?php
mysqli_close($db_conx);

include_once "includes/footer.php"; 
?>
