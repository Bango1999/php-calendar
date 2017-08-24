<?php
$title = "Invite to Group";
include_once "includes/init.php";
include_once 'includes/auth.php';
$keyfail = false;
$showform = true;
if (isset ($_SERVER["HTTP_REFERER"]))
	$redirect = $_SERVER["HTTP_REFERER"];
else
	$redirect = "mygroups.php";
$rtime = "0";
$msg = "User successfully invited.";
$sql = "SELECT * FROM users WHERE userid = '" . $_SESSION["userId"] . "'";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_array($query);
$fromn = $row['name'];
$frome = $row['email'];
$gname = $_SESSION['group']['name'];
$sql = "SELECT * FROM groups WHERE groupid = '" . $_SESSION["group"]["id"] . "'";
$query = mysqli_query($db_conx, $sql);
$row = mysqli_fetch_array($query);
$invite_key = $row['invitekey'];
$subject = "TeamN Group Scheduler: You have been invited to join the group: " . $gname;
$path = explode('/', $_SERVER["PHP_SELF"]);
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$message = '<html><head><title>'.$subject.'</title></head><body>Hello ';
!empty($_POST['name']) ? $message .=$_POST['name'] : $message.= '<i>name</i>';
$message .= ', <br /><br /> I would like to invite you to join our group "' . $gname . '."<br /><br />To accept this invite, click the link below or copy and paste it into the web browser of your choice. <br /><a href="http://teamn.jc-lan.com/' . $path[1] . '/joingroup.php?invite=' . $invite_key . '">http://teamn.jc-lan.com/' . $path[1] . '/joingroup.php?invite=' . $invite_key . '</a><br /><br />Thanks,<br />'. $fromn . '<br />' . $frome .'</body></html>';
$message = wordwrap($message, 70, "\r\n");

function check_email($email) {
  return filter_var($email, FILTER_VALIDATE_EMAIL);
}
if( !empty($_REQUEST['Send']) && !empty($_POST['name']) && check_email( $_POST['email'] ) ){
	$showform = false;	
	$headers .= 'To: '.$_POST['name'].' <'.$_POST['email'].'>' . "\r\n";
	//$headers .= 'From: '.$fromn.' <'. $frome .'>' . "\r\n";
	$result = mysqli_query($db_conx, "SELECT * FROM members WHERE groupid='" . $_SESSION['group']['id'] . "' and userid='". $_SESSION['userId'] . "';");
	$row = mysqli_fetch_array($result);
	if( $row['level'] <= 1 ) { 
	if (!mail($_POST['email'], $subject, $message, $headers)) {
			$msg = "Oops, and error occurred.  Please wait a few minutes and try again.";
		}
	}
	else {
		$msg = "You are not an admin of this group.";
	}
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
		header("refresh:5; url=invite.php");
}
if ($showform) {
?>
<table border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
		<tr><td><h3>Invite someone to a Group</h3></td></tr>
		<tr>
		<td>
		<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF"><tr><td>
<form action="invite.php" method="post">
    <div>Name:</div>
    <input name="name" type="text" maxlength="30" value="<?php if(isset($_POST["name"])) echo $_POST["name"]; ?>">
    <div>Email address:</div>
    <input name="email" type="text" maxlength="30" value="<?php if(isset($_POST["email"])) echo $_POST["email"]; ?>">
    <?php if(isset($_POST['email']) && !check_email($_POST['email'])) echo "<br /><strong>Please enter a valid email address.</strong>"; ?>
    <div align="center"><input type="submit" name="Preview" value="Preview Message"><?php if( !empty($_REQUEST['Preview']) && !empty($_POST['name']) && check_email( $_POST['email'] ) ){ ?><br /><input type="submit" name="Send" value="Send Message"><?php } ?></div>
    <span id="status"></span>
  </form>
  </td>
  <td>
  <table><tr><th>Email preview:</th></tr>
  <tr><td>
  <strong>To: </strong><?php if(!empty($_POST["name"])) echo $_POST["name"]; ?> (<?php if(!empty($_POST["email"])) echo $_POST["email"]; ?>)<br />
  <strong>From: </strong><?=$fromn ?> (<?=$frome ?>)<br />
  <strong>Subject: </strong><?=$subject ?><br />
  <strong>Message: </strong><br /><?=$message ?><br />
  </td></tr>
  </table></td>
  </tr></table></td></tr></table>
<?php ; } ?> 
  
<?php include_once "includes/footer.php"; ?>
