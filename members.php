<?php

include_once "includes/init.php";
$result = mysqli_query($db_conx, "SELECT * FROM members WHERE groupid='" . $_GET['g'] . "' and userid='". $_SESSION['userId'] . "';");
$row = mysqli_fetch_array($result);
$level = $row['level'];
$result = mysqli_query($db_conx, "SELECT * FROM groups WHERE groups.groupid='" . $_GET['g'] . "';");
$row = mysqli_fetch_array($result);
?>
	<table border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
		<tr>
		<td>
			<?php echo "<H1>" . $row['name'] . "</H1>";?>
			<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">	
			<tr><td><?php echo "<H4>" . $row['description'] . "</H4>";?></td></tr>	
<tr>
<th>Members</th>
<th>User Level</th>
<th>Promote</th>
<th>Demote</th>
<th>Kick</th>
</tr>
<?php
$result = mysqli_query($db_conx, "SELECT users.userid, users.name, members.level FROM users JOIN members  on users.userid=members.userid WHERE members.groupid=" . $_GET['g'] . ";");

while ($row = mysqli_fetch_array($result)) {
	echo "<tr>";
	echo "<td>" . $row['name'] . "</td>";
	echo "<td>";
	switch( $row['level'] ) {
		case 0: echo "Creator"; break;
		case 1: echo "Admin"; break;
		case 2: echo "Member"; break; }
	echo "</td>";
	echo "<td>";
	if( $level == 0 && $row['level'] == 2) echo "<a href=\"promote.php?u=" . $row['userid'] . "&g=" . $_GET['g'] . "\">Promote</a>";
	echo "</td>";
	echo "<td>";
	if( $level == 0 && $row['level'] == 1) echo "<a href=\"demote.php?u=" . $row['userid'] . "&g=" . $_GET['g'] . "\">Demote</a>";
	echo "</td>";
	echo "<td>";
	if( $level <= 1 ) echo "<a href=\"kick.php?u=" . $row['userid'] . "&g=" . $_GET['g'] . "\">Kick</a>";
	echo "</td>";
	echo "</tr>";
}
echo "</table>";

mysqli_close($db_conx);
?>
<?php include_once "includes/footer.php"; ?>
