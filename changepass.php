<?php
$title = "Change Password";
include("includes/init.php");

include_once 'includes/auth.php';
include_once 'includes/password.php';
$check = 0;

$debug = '0';
if ($debug == '1') {
	//Retrieve all relevant information from SESSION
	echo $_SESSION['login'] . "<br>";
	echo $_SESSION['userId'] . "<br>";
	echo $_SESSION['username'] . "<br>";
	echo $_SESSION['name'] . "<br>";

	echo $_SESSION['email'] . "<br>";
	echo $_SESSION['emailappear'] . "<br>";
	echo $_SESSION['gender'] . "<br>";
	echo $_SESSION['userlevel'] . "<br>";
	echo $_SESSION['signup'] . "<br>";
	echo $_SESSION['lastlogin'] . "<br><br>";

	echo $_SESSION['avatar'] . "<br>";
	echo $_SESSION['work'] . "<br>";
	echo $_SESSION['phone'] . "<br>";
	echo $_SESSION['phoneappear'] . "<br>";
	echo $_SESSION['website'] . "<br>";
	echo $_SESSION['country'] . "<br><br>";

	echo $_COOKIE["user"] . "<br>";
}

if (!empty ($_POST)) {
	$u = $_SESSION['username'];

	//Get and hash passwords for comparison
	$cur = $_POST['cur_pwd'];
	$pwd = $_POST['pwd'];
	$confirm_pwd = $_POST['confirm_pwd'];
//    $cur = md5($cur);
//    $pwd = md5($pwd);
//    $confirm_pwd = md5($confirm_pwd);

	$sql = "SELECT * FROM users WHERE username='$u' ";
	$user_query = mysqli_query($db_conx, $sql);

	// Mysql_num_row is counting table row
	$numrows = mysqli_num_rows($user_query);

	// If result matched $myusername and $mypassword, table row must be 1 row
	if ($numrows == 1) {
		// take info down
		while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
			$data_pwd = $row["password"];
		}

		//If new password is valid and input password matches database password, change database password
		if ($pwd == $confirm_pwd && password_verify($cur, $data_pwd)) {
		
			$pwd = password_hash( $pwd, PASSWORD_DEFAULT, ['cost'=>12] );
			$sql = "UPDATE users SET password='$pwd' WHERE username='$u' ";
			$query = mysqli_query($db_conx, $sql);
			if ($query) {
				$check = 1;
			}
		} else {
			$check = -1;
		}
	}
}
?>
<!----------------------------------->
<!---  HTML page starts from here -->
<script>
function changepw() {
        var old = document.getElementById('old').value;
        var new1 = document.getElementById('new').value;
        var new2 = document.getElementById('new2').value;
        
        var oldgood = 0;
        var new1good = 0;
        var new2good = 0;
        var passmatch = 0;
        
        //check for errors
            if (old.length == 0) {
                oldgood = 0;
            } else {
                oldgood = 1;
            }
            if (new1.length == 0) {
                new1good = 0;
            } else {
                new1good = 1;
            }
            if (new2.length == 0) {
                new2good = 0;
            } else {
                new2good = 1;
            }
            if (new1good && new2good) {
                if (new1 == new2) {
                    passmatch = 1;
                } else {
                    passmatch = 0;
                }
            }
            
            if (oldgood && new1good && new2good && passmatch) {
                document.getElementById('loginerrors').style.display="none";
                return true;
            } else {
                document.getElementById('loginerrors').style.display="block";
                if (!oldgood) {
                    document.getElementById('loginerrors').innerHTML="Please provide your current account password to continue!";
                } else if (!new1good) {
                    document.getElementById('loginerrors').innerHTML="Please provide your new password!";
                } else if (!new2good) {
                    document.getElementById('loginerrors').innerHTML="Please repeat your new password!";
                } else if (!passmatch) {
                    document.getElementById('loginerrors').innerHTML="Passwords to not match!";
                }
                return false;
            }
    }
</script>

    <center>
    <fieldset id="uploadpic" style= "display: inline;clear:center;float:center;width:450px;">
        <legend>Edit Security</legend>

        <table width="500" border="0" align="center" cellpadding="0" cellspacing="1">
            <form method="post" action="changepass.php" id="pwdchngform" onsubmit="return changepw()" enctype="multipart/form-data">
               
               <tr height="30px">
                    <td width="280"> Current Password </td>
                    <td width="6">?</td>
                    <td width="320"><input name="cur_pwd"  type="password"  width="320px" maxlength="50"></td>
                </tr>
                <tr height="30px">
                    <td width="280"> * New password: </td>
                    <td width="6">?</td>
                    <td width="320"><input name="pwd" id="password" type="password"  width="320px" maxlength="50"></td>
                </tr>
                <tr height="30px">
                    <td width="280"> * Retype new password: </td>
                    <td width="6">?</td>
                    <td width="320"><input name="confirm_pwd" type="password"  width="320px" maxlength="50"></td>
                </tr>

                <tr height="70px">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td> <input type="hidden" name="changepass" value="true" />
                        <input type="submit" style="font-size:18px;padding: 12px;background: #F3F9DD;" value="Change my password!" /></td>
                </tr>
            </table>

          </form>
    </fieldset>
    </center>
    <br><br><br>
    <?php if ($check==1) {?>
         <div style="margin-left: 200px">
            You have successfully updated your password!</div> 
    <?php } else if ($check==-1) { ?>
         <div style="margin-left: 200px">
            ERROR: cannot update your password! Retype and make sure they are correct </div> 
    <?php } ?>
           
           <br><br> <div style="margin-left: 200px"> <a href="user.php">
            Click here </a> to go back to the your profile page.</div> <br>

<?php include_once "includes/footer.php"; ?>
