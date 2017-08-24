<?php 
// Connect to server and select databse.
include_once "includes/init.php";
include_once "includes/password.php";

// username and password sent from form 
if( !isset($_POST['myusername']) || !isset($_POST['mypassword']) ) {
	if(isset($_GET['r']))
		header("url=index.php?r=" . $_GET['r']);
	else
		header("url=index.php");
} else {
$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword']; 

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
//$mypassword = md5($mypassword);
$sql="SELECT * FROM users WHERE username='$myusername'";
$user_query=mysqli_query($db_conx,$sql);
// Mysql_num_row is counting table row
$numrows=mysqli_num_rows($user_query);
$row=mysqli_fetch_array($user_query);

// If result matched $myusername and $mypassword, table row must be 1 row
if(password_verify($mypassword, $row['password']) ){
	// CREATE THEIR SESSIONS AND COOKIES
	session_start();
//	while (true) {
		$_SESSION['userId'] = $row["userid"];
		$_SESSION['name'] = $row["name"];
		$_SESSION['password'] = $row["password"];
		$_SESSION['email'] = $row["email"];
		$_SESSION['emailappear'] = $row["emailappear"];
		$_SESSION['gender'] = $row["gender"];
		$_SESSION['userlevel'] = $row["userlevel"];
		$_SESSION['signup'] = $row["signup"];
		$_SESSION['lastlogin'] = $row["lastlogin"];
//		break;
//	}



//	$sql1 = "SELECT * FROM users WHERE username='$myusername'";
//	$user_query1 = mysqli_query($db_conx, $sql1);
//	// Now make sure that user exists in the table
//	$numrows1 = mysqli_num_rows($user_query1);
//	if($numrows < 1){
//		echo "That user does not exist or is not yet activated, press back";
//	    exit();	
//	}
//
//	while ($row = mysqli_fetch_array($user_query1, MYSQLI_ASSOC)) {
		$_SESSION['avatar'] = $row["avatar"];
		$_SESSION['work'] = $row["work"];
		$_SESSION['phone'] = $row["phone"];
		$_SESSION['phoneappear'] = $row["phoneappear"];
		$_SESSION['website'] = $row["website"];
		$_SESSION['country'] = $row["country"];
		$_SESSION['work'] = $row["work"];
		$_SESSION['class1'] = $row["class1"];
		$_SESSION['class2'] = $row["class2"];
		$_SESSION['class3'] = $row["class3"];
		$_SESSION['class4'] = $row["class4"];
		$_SESSION['class5'] = $row["class5"];
		$_SESSION['time1'] = $row["time1"];
		$_SESSION['time2'] = $row["time2"];
		$_SESSION['time3'] = $row["time3"];
		$_SESSION['time4'] = $row["time4"];
		$_SESSION['time5'] = $row["time5"];
//	}

	$_SESSION['login'] = 1;
	$_SESSION['username'] = $myusername;
	setcookie("user", $myusername, strtotime( '+30 days' ), "/", "", "", TRUE);
	// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
	$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	$sql = "UPDATE users SET ip='$ip', lastlogin=now() WHERE username='$myusername' and password='$mypassword'";
    $query = mysqli_query($db_conx, $sql);
	echo $myusername;
    
	create_groups_session();

	$redir = ""; 
	if( isset($_GET['r']) )
		$redir = $_GET['r'];
	else
		$redir = "user.php?u=" . $myusername;

	header("location:" . $redir); //appemnd
	//window.location = "php_includes/login_success.php"
	echo "login success";
}
else { ?>
	<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
		<tr>
		<td>
		<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
			<tr><td><center>
			<p><strong>Wrong Username or Password</strong></p>
			<p>Redirect to Login page in 5s</p>
			</center></td></tr>
		</table>
		</td>
		</tr>
	</table>		
	<?php
	$redir = "index.php"; 
	if( isset($_GET['r']) )
		$redir .= "?r=" . $_GET['r'];
	header("refresh:5; url=". $redir );
}
} ?>
<?php include_once "includes/footer.php"; ?>
