<?php
//Any page where header is displayed will be a page which the user needs to be logged in to view.
//If they are not logged in, redirect them to the login page


if(!isset($title)) $title = "Group Calendar";
require "./functions/users.php";
?>
<!doctype html>
<html lang=en>
<head>
<meta charset="utf-8"/>
<title><?php echo $title; ?></title>
<link rel="stylesheet" type="text/css" href="styles/jqueryslidemenu.css" />
<link rel="stylesheet" type="text/css" href="styles/cal.css" />
<link rel="stylesheet" type="text/css" href="styles/jquery.ptTimeSelect.css" />


<link href="styles/ui-darkness/jquery-ui-1.10.4.custom.css" rel="stylesheet" />

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
	<script src="scripts/jquery-1.10.2.js"></script>
	<script src="scripts/jquery-ui-1.10.4.custom.js"></script>


<!--[if lte IE 7]>
<style type="text/css">
html .jqueryslidemenu{height: 1%;} /*Holly Hack for IE7 and below*/
</style>
<![endif]-->
<script type="text/javascript" src="scripts/jqueryslidemenu.js"></script>
<script type="text/javascript" src="scripts/debug.js"></script>
<script type="text/javascript" src="scripts/tableClickSubmit.js"></script>
<script type="text/javascript" src="scripts/jquery.ptTimeSelect.js"></script>

</head>
<body>
<div id="header-wrap">
<div id="header-container">
<div id="header">
<div id="letterpress">
<h1>Group Calendar</h1>
</div>


<?php if(check_login_b() && (!isset($loggingout))) { ?>
	<div id="myslidemenu" class="jqueryslidemenu">
	<ul>
	<li><a href="user.php"><?=$_SESSION['name'] ?></a></li>
	<li><a href="cal.php">Calendar</a></li>
	  <li><a href="groups.php">View Public Groups</a></li>
	  <li><a href="creategroup.php">Create Group</a></li>
	</li>
	
	<?php
		//this next list item is only if the user is an admin of at least 1 group
		if (isset($_SESSION['group'])) {
		
		if ($_SESSION['group']['level'] <= 1) {
	?>
	<li><a href="invite.php">Invite</a></li>
	<?php } ?>
	</ul>
	<div style="position: relative;display: inline-block;float: left;z-index:100;width:100px;height:30px;border-right: 1px solid #778;">
	</div>
	
<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']);?>" method="post" style="position: relative;display: inline;float: left;z-index:100;margin:0;padding:0">
	<div style="position: relative;display: inline;float: left;z-index:100;">
		<span style="display: block;background: #414141;color: white;padding: 8px 10px;border-right: 1px solid #778;text-decoration: none;">Change Group:</span>
	</div>
	<select name="groups" style="display:inline;vertical-align:middle">
		<?php
		
		//populate the groups dropdown
		foreach ($_SESSION['groups'] as $g) {
			echo '<option value="'.$g['id'].'"';
			
			if ($_SESSION['group']['name'] == $g['name']) {
				echo ' selected="selected" ';
			}
			 echo '>'.$g['name'].'</option>';
		}
		?>
	</select>
	<input type="hidden" name="changeGroupForm" value="1" />
	<input type="submit" value="Switch Me" style="display:inline-block;width:100px;vertical-align:middle" />
</form>
<?php } else {
	?>
	</ul>
	<h3 style="display:inline-block;padding-left:20px;color:white;padding-top:6px;margin:0 auto;text-align:center">
	<span style="color:#cf0000;display: inline-block;border:1px solid #cf0000;background:#ccc;padding:0px 5px 0px 5px;box-shadow:2px 2px 2px black;-webkit-box-shadow:2px 2px 2px black;-moz-box-shadow:2px 2px 2px black">NO GROUPS!</span>
		<span style="display: inline-block;">You need to <a href="joingroup.php" style="color:#cf0000;text-shadow:2px 2px 2px black">join a group</a> or <a href="creategroup.php" style="color:#cf0000;text-shadow:2px 2px 2px black">create a new one</a> to get started!</span>
	</h3>
	<?php
} ?>


	<ul style="float:right">
	<li><a href="mygroups.php">My Groups</a>
	<li><a href="#">Edit Account</a>
		<ul>
		<li><a href="joingroup.php">Join Group</a></li>
		<li><a href="changeimg.php">Change Profile picture</a></li>
		<li><a href="changeinfo.php">Change Basic information</a></li>
		<li><a href="changepass.php">Change Password</a></li>
		<li><a href="changeschool.php">Update Classes </a></li>
		<li><a href="changeemail.php">Change Email</a></li>
		</ul>
	</li>
	<li><a href="logout.php">Logout</a></li>
	</ul>
	<br style="clear: left" />
	</div>
</div>
</div>
</div>
<?php } ?>
<div id="container">
<div id="content">

