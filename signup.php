<?php
// universal check for session
if (isset($_SESSION['userId'])) 
	header("Location: user.php?u=" . $SESSION["username"]);
?>
<?php

include_once 'includes/password.php';

// Ajax calls this NAME CHECK code to execute  (run when the usernamecheck run)
if (isset ($_POST["usernamecheck"])) {
	include_once ("includes/database/connect.php");
	$username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
	$sql = "SELECT userid FROM users WHERE username='$username' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$uname_check = mysqli_num_rows($query);
	if (strlen($username) < 3 || strlen($username) > 16) {
		echo '<strong style="color:#F00;">3 - 16 characters please</strong>';
		exit ();
	}
	if (is_numeric($username[0])) {
		echo '<strong style="color:#F00;">Usernames must begin with a letter</strong>';
		exit ();
	}
	if ($uname_check < 1) {
		echo '<strong style="color:#009900;">' . $username . ' is OK</strong>';
		exit ();
	} else {
		echo '<strong style="color:#F00;">' . $username . ' is taken</strong>';
		exit ();
	}
}
?>
<?php
// Ajax calls this REGISTRATION code to execute (run when the whole form filled)
if (isset ($_POST["u"])) {
	
	// CONNECT TO THE DATABASE
	include_once ("includes/database/connect.php");
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
	$n = preg_replace('#[^a-z ]#i', '', $_POST['n']);
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$p = $_POST['p'];
	$g = preg_replace('#[^a-z]#', '', $_POST['g']);
	$signup_key = sha1($u . time());

	// GET USER IP ADDRESS
	$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
	$sql = "SELECT userid FROM users WHERE username='$u' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$u_check = mysqli_num_rows($query);
	// -------------------------------------------
	$sql = "SELECT userid FROM users WHERE email='$e' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$e_check = mysqli_num_rows($query);
	// FORM DATA ERROR HANDLING
	if ($u == "" || $n == "" || $e == "" || $p == "" || $g == "") {
		echo "The form submission is missing values.";
		exit ();
	} else
		if ($u_check > 0) {
			echo "The username you entered is alreay taken";
			exit ();
		} else if ($e_check > 0){ 
        echo "That email address is already in use in the system";
        exit();
	} else if (strlen($u) < 3 || strlen($u) > 16) {
        echo "Username must be between 3 and 16 characters";
        exit(); 
    } else if (is_numeric($u[0])) {
        echo 'Username cannot begin with a number';
        exit();
    } else {
		// END FORM DATA ERROR HANDLING
	    // Begin Insertion of data into the database
		// Hash the password and apply your own mysterious unique salt
		
		$p_hash= password_hash($p, PASSWORD_DEFAULT, ['cost'=>12]);//md5($p);
		// Add user info into the database table for the main site table
		$sql = "INSERT INTO users (username, name, email, password, gender, ip, signup, lastlogin, notescheck, hashed_activation)       
		        VALUES('$u','$n','$e','$p_hash','$g','$ip',now(),now(),now(), '$signup_key')";
		$query = mysqli_query($db_conx, $sql); 

?>
		<?php

// Email the user their activation link
		$path = explode('/', $_SERVER["PHP_SELF"]);
		$to = "$e";
		$subject = "Group Schedule Account Activation";
		$message = 'Please click <a href="http://teamn.jc-lan.com/' . $path[1] . '/activate.php?signup_key=' . $signup_key . '">here</a> to activate your account.';
		$message = wordwrap($message, 70, "\r\n");
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		if (mail($to, $subject, $message, $headers)) {
			echo "Signup Successful.  Please check your email to activate your account";
		} else {
			echo "Oops, and error occurred.  Please wait a few minutes and try again.";
		}

		exit();
	}
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sign Up</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="style/style.css">
<style type="text/css">
#signupform{
	margin-top:24px;	
}
#signupform > div {
	margin-top: 12px;	
}
#signupform > input,select {
	width: 200px;
	padding: 3px;
	background: #F3F9DD;
}
#signupbtn {
	font-size:18px;
	padding: 12px;
}
#pageMiddle{
	margin-left: 200px;
}

#terms {
	border:#CCC 1px solid;
	background: #F5F5F5;
	padding: 12px;
}
</style>
<script src="scripts/main.js"></script>
<script src="scripts/ajax.js"></script>
<script>
function restrict(elem){
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "email"){
		rx = /[' "]/gi;
	} else if(elem == "username"){
		rx = /[^a-z0-9]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}
function emptyElement(x){
	_(x).innerHTML = "";
}
function checkusername(){
	var u = _("username").value;
	if(u != ""){
		_("unamestatus").innerHTML = 'checking ...';
		var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            _("unamestatus").innerHTML = ajax.responseText;
	        }
        }
        ajax.send("usernamecheck="+u);
	}
}
function signup(){
	var u = _("username").value;
	var n = _("name").value;
	var e = _("email").value;
	var p1 = _("pass1").value;
	var p2 = _("pass2").value;
	var g = _("gender").value;
	var status = _("status");
	var good = true;
	
	if(u == "" || n == "" ||e == "" || p1 == "" || p2 == "" || g == ""){
		status.innerHTML = "Please fill out all form data.";
		good = false;
	} else if(p1 != p2){
		status.innerHTML = "Passwords do not match!";
		good = false;
	} else if( _("terms").style.display == "none"){
		status.innerHTML = "Please view our terms of use.";
		good = false;
	} else {
		_("signupbtn").style.display = "none";
		status.innerHTML = 'please wait ...';
		var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText != "signup_success"){
					status.innerHTML = ajax.responseText;
					_("signupbtn").style.display = "block";
				} else {
					window.scrollTo(0,0);
					_("signupform").innerHTML = "OK "+u+", check your email inbox and junk mail box at <u>"+e+"</u> in a moment to complete the sign up process by activating your account. You will not be able to do anything on the site until you successfully activate your account.";
				}
	        }
        }
        ajax.send("u="+u+"&n="+n+"&e="+e+"&p="+p1+"&g="+g);
	}
	
	if (good) {
		return true;
		} else {
		return false;
		}
}
function openTerms(){
	_("terms").style.display = "block";
	emptyElement("status");
}
</script>

<?php include_once "includes/header.php"; ?>

</head>
<body>
<div id="pageMiddle">
  <h3>Sign Up Here</h3>
  <form name="signupform" id="signupform" onsubmit="return false;">
    <div>Username: </div>
    <input id="username" type="text" onblur="checkusername()" onkeyup="restrict('username')" maxlength="16">
    <span id="unamestatus"></span>

    <div>Full Name: </div>
    <input id="name" type="text" maxlength="30">

    <div>Email Address:</div>
    <input id="email" type="text" onfocus="emptyElement('status')" onkeyup="restrict('email')" maxlength="88">
    <div>Create Password:</div>
    <input id="pass1" type="password" onfocus="emptyElement('status')" maxlength="16">
    <div>Confirm Password:</div>
    <input id="pass2" type="password" onfocus="emptyElement('status')" maxlength="16">
    <div>Gender:</div>
    <select id="gender" onfocus="emptyElement('status')">
      <option value=""></option>
      <option value="m">Male</option>
      <option value="f">Female</option>
    </select>
    <div>
      <a href="#" onclick="return false" onmousedown="openTerms()">
        View the Terms Of Use
      </a>
    </div>
    <div id="terms" style="display:none;">
      <h3>Group Scheduler Terms Of Use</h3>
      <p>1. Play nice here.</p>
      <p>2. Take a bath before you visit.</p>
      <p>3. Brush your teeth before bed.</p>
    </div>
    <br /><br />
    <button id="signupbtn" onclick="return signup()">Create Account</button>
    <span id="status"></span>
  </form>
</div>
<?php include_once "includes/footer.php"; ?>
