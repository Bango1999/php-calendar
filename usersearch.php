<?php
$sql = "SELECT username, avatar FROM users where avatar IS NOT NULL AND activated='1' ORDER BY RAND() LIMIT 32";
$query= mysqli_query($db_conx, $sql);
$userlist= "";
while ($row= mysqli_fetch_array($query, MYSQLI_ASSOC)) {
	$u= $row["username"];
	$avatar= $row["avatar"];
	$profile_pic= $avatar;
	$userlist .= '<a href="user.php?u=' .$u.'" title="'.$u.'"> <img src="'.$profile_pic.'" alt="'.$u.'" style="width:100px; height:100px; margin:10px;"</a>';
}

?>

<body>
<div id="middle page" style="margin-left: 200px;">
<h3> Random People Chosen from the Database: </h3>
<br>
<?php echo $userlist; ?>

</div>
</body>