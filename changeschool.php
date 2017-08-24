<?php

// Ajax calls this REGISTRATION code to execute (run when the whole form filled)
$title = "Change School";
include_once ("includes/init.php");
$check = 0;
include_once 'includes/auth.php';

if (!empty ($_POST)) {
	// NGHIA'S NOTE: fill in the SESSION array
	if ($_POST['modify'] == "true") {
		$_SESSION['class1'] = $_POST['class1'];
		$_SESSION['time1'] = $_POST['time1'];
		$_SESSION['class2'] = $_POST['class2'];
		$_SESSION['time2'] = $_POST['time2'];
		$_SESSION['class3'] = $_POST['class3'];
		$_SESSION['time3'] = $_POST['time3'];
		$_SESSION['class4'] = $_POST['class4'];
		$_SESSION['time4'] = $_POST['time4'];
		$_SESSION['class5'] = $_POST['class5'];
		$_SESSION['time5'] = $_POST['time5'];

		// update tables data
		$u = $_SESSION['username'];

		$c1 = $_SESSION['class1'];
		$c2 = $_SESSION['class2'];
		$c3 = $_SESSION['class3'];
		$c4 = $_SESSION['class4'];
		$c5 = $_SESSION['class5'];

		$t1 = $_SESSION['time1'];
		$t2 = $_SESSION['time2'];
		$t3 = $_SESSION['time3'];
		$t4 = $_SESSION['time4'];
		$t5 = $_SESSION['time5'];

		$sql = "UPDATE users SET class1='$c1' WHERE username='$u' ";
		$query = mysqli_query($db_conx, $sql);
		$sql = "UPDATE users SET time1='$t1' WHERE username='$u' ";
		$query = mysqli_query($db_conx, $sql);
		$sql = "UPDATE users SET class2='$c2' WHERE username='$u' ";
		$query = mysqli_query($db_conx, $sql);
		$sql = "UPDATE users SET time2='$t2' WHERE username='$u' ";
		$query = mysqli_query($db_conx, $sql);
		$sql = "UPDATE users SET class3='$c3' WHERE username='$u' ";
		$query = mysqli_query($db_conx, $sql);
		$sql = "UPDATE users SET time3='$t3' WHERE username='$u' ";
		$query = mysqli_query($db_conx, $sql);
		$sql = "UPDATE users SET class4='$c4' WHERE username='$u' ";
		$query = mysqli_query($db_conx, $sql);
		$sql = "UPDATE users SET time4='$t4' WHERE username='$u' ";
		$query = mysqli_query($db_conx, $sql);
		$sql = "UPDATE users SET class5='$c5' WHERE username='$u' ";
		$query = mysqli_query($db_conx, $sql);
		$sql = "UPDATE users SET time5='$t5' WHERE username='$u' ";
		$query = mysqli_query($db_conx, $sql);

		if ($query) {
			$check = 1;
		}
	}
}

$debug = '0';
if ($debug == '1') {
	echo $_SESSION['login'];
	echo "<br>";
	echo $_SESSION['userId'];
	echo "<br>";
	echo $_SESSION['username'];
	echo "<br>";
	echo $_SESSION['name'];
	echo "<br>";

	echo $_SESSION['email'];
	echo "<br>";
	echo $_SESSION['emailappear'];
	echo "<br>";
	echo $_SESSION['gender'];
	echo "<br>";
	echo $_SESSION['userlevel'];
	echo "<br>";
	echo $_SESSION['signup'];
	echo "<br>";
	echo $_SESSION['lastlogin'];
	echo "<br><br>";

	echo $_SESSION['avatar'];
	echo "<br>";
	echo $_SESSION['work'];
	echo "<br>";
	echo $_SESSION['phone'];
	echo "<br>";
	echo $_SESSION['phoneappear'];
	echo "<br>";
	echo $_SESSION['website'];
	echo "<br>";
	echo $_SESSION['country'];
	echo "<br><br>";

	echo "School<br>";
	echo $_SESSION['class1'];
	echo "<br>";
	echo $_SESSION['time1'];
	echo "<br>";
	echo $_SESSION['class2'];
	echo "<br>";
	echo $_SESSION['time2'];
	echo "<br>";
	echo $_SESSION['class3'];
	echo "<br>";
	echo $_SESSION['time3'];
	echo "<br>";
	echo $_SESSION['class4'];
	echo "<br>";
	echo $_SESSION['time4'];
	echo "<br>";
	echo $_SESSION['class5'];
	echo "<br>";
	echo $_SESSION['time5'];
	echo "<br>";

	echo $_COOKIE["user"];
	echo "<br>";
}
?>
<!----------------------------------->
<!---  HTML page starts from here -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit- School status</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style/style.css">
    <style type="text/css">

    #modifyform{
        margin-top:24px;    
    }
    #modifyform > div {
        margin-top: 12px;   
    }
    #modifyform > input,select {
        width: 200px;
        padding: 3px;
        background: #F3F9DD;
    }
    #update {
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

    <?php include_once "includes/header.php"; ?>
</head>
<body>

    <center>
    <fieldset id="changeschool" style= "display: inline;clear:center;float:center;width:500px;">
        <legend>Edit School - Classes that I am taking </legend>

        <table width="500" border="0" align="center" cellpadding="0" cellspacing="1">
            <form>
                <tr height="30px">
                    <td width="280" align="center"><b>Class name </b></td>
                    <td width="6">-</td>
                    <td width="280"> <b> Time </b></td>
                </tr>

                <?php if ($_SESSION['class1']!="") { ?>
                <tr height="30px">
                    <td><?php echo $_SESSION['class1'];?></td>
                    <td>:</td>
                    <td><?php echo $_SESSION['time1'];?></td>
                </tr>
                <?php } ?>

                <?php if ($_SESSION['class2']!="") { ?>
                <tr height="30px">
                    <td><?php echo $_SESSION['class2'];?></td>
                    <td>:</td>
                    <td><?php echo $_SESSION['time2'];?></td>
                </tr>
                <?php } ?>

                <?php if ($_SESSION['class3']!="") { ?>
                <tr height="30px">
                    <td><?php echo $_SESSION['class3'];?></td>
                    <td>:</td>
                    <td><?php echo $_SESSION['time3'];?></td>
                </tr>
                <?php } ?>

                <?php if ($_SESSION['class4']!="") { ?>
                <tr height="30px">
                    <td><?php echo $_SESSION['class4'];?></td>
                    <td>:</td>
                    <td><?php echo $_SESSION['time4'];?></td>
                </tr>
                <?php } ?>

                <?php if ($_SESSION['class5']!="") { ?>
                <tr height="30px">
                    <td><?php echo $_SESSION['class5'];?></td>
                    <td>:</td>
                    <td><?php echo $_SESSION['time5'];?></td>
                </tr>
                <?php } ?>
            </form>
        </table>

        <br><br><div style="color:green;"><b> * Show top 5 classes in order that you find difficult </b></div><br>

        <table width="500" border="0" align="center" cellpadding="0" cellspacing="1">
            <form method="post" action="changeschool.php" name="modifyform" id="modifyform" enctype="multipart/form-data">

                <tr height="30px">
                    <td width="280">* Class name</td>
                    <td width="6"></td>
                    <td width="280"><input style="width: 200px; padding: 3px; background: #F3F9DD;" 
                        type="text" name="class1"  maxlength="200" value="<?php echo $_SESSION['class1']; ?>"></td>
                </tr>
                <tr height="30px">
                    <td>.   Time </td>
                    <td></td>
                    <td><input style="width: 200px; padding: 3px; background: #F3F9DD;"
                        type="text"name="time1"  maxlength="20" value="<?php echo $_SESSION['time1']; ?>"></td>
                </tr>
                
                <tr>
                    <td>* Class name</td>
                    <td></td>
                    <td><input style="width: 200px; padding: 3px; background: #F3F9DD;" 
                        type="text" name="class2"  maxlength="200" value="<?php echo $_SESSION['class2']; ?>"></td>
                </tr>
                <tr height="30px">
                    <td>.   Time </td>
                    <td></td>
                    <td><input style="width: 200px; padding: 3px; background: #F3F9DD;"
                        type="text"name="time2"  maxlength="20" value="<?php echo $_SESSION['time2']; ?>"></td>
                </tr>

                <tr>
                    <td>* Class name</td>
                    <td></td>
                    <td><input style="width: 200px; padding: 3px; background: #F3F9DD;" 
                        type="text" name="class3"  maxlength="200" value="<?php echo $_SESSION['class3']; ?>"></td>
                </tr>
                <tr height="30px">
                    <td>.   Time </td>
                    <td></td>
                    <td><input style="width: 200px; padding: 3px; background: #F3F9DD;"
                        type="text"name="time3"  maxlength="20" value="<?php echo $_SESSION['time3']; ?>"></td>
                </tr>

                <tr>
                    <td>* Class name</td>
                    <td></td>
                    <td><input style="width: 200px; padding: 3px; background: #F3F9DD;" 
                        type="text" name="class4"  maxlength="200" value="<?php echo $_SESSION['class4']; ?>"></td>
                </tr>
                <tr height="30px">
                    <td>.   Time </td>
                    <td></td>
                    <td><input style="width: 200px; padding: 3px; background: #F3F9DD;"
                        type="text"name="time4"  maxlength="20" value="<?php echo $_SESSION['time4']; ?>"></td>
                </tr>

                <tr>
                    <td>* Class name</td>
                    <td></td>
                    <td><input style="width: 200px; padding: 3px; background: #F3F9DD;" 
                        type="text" name="class5"  maxlength="200" value="<?php echo $_SESSION['class5']; ?>"></td>
                </tr>
                <tr height="30px">
                    <td>.   Time </td>
                    <td></td>
                    <td><input style="width: 200px; padding: 3px; background: #F3F9DD;"
                        type="text"name="time5"  maxlength="20" value="<?php echo $_SESSION['time5']; ?>"></td>
                </tr>

                <tr height="70px">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>   <input type="hidden" name="modify" value="true" />
                        <input type="submit" id="update" value="Update my profile!" /></td>
                </tr>
            </table>

          </form>
    </fieldset>
    </center>
    <br><br><br>
    <?php

if ($check == 1) {
?>
         <div style="margin-left: 200px">
            Successfully update classes!</div> 
    <?php }  ?>
           
           <br><br> <div style="margin-left: 200px"> <a href="user.php">
            Click here </a> to go back to the your User page.</div> <br>

<?php include_once "includes/footer.php"; ?>
