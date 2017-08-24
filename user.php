<?php

// for this page, no need to check session, 
// because you dont' need to login to see pp's profile
$title = "Profile Page";
include 'includes/init.php';

$debug = '0';
if ($debug == '1') {
	echo "login: ".$_SESSION['login'] . "<br>";
	echo "userId: ".$_SESSION['userId'] . "<br>";
	echo "username: ".$_SESSION['username'] . "<br>";
	echo "name: ".$_SESSION['name'] . "<br>";

	echo "email: ".$_SESSION['email'] . "<br>";
	echo "emailappear: ".$_SESSION['emailappear'] . "<br>";
	echo "gender: ".$_SESSION['gender'] . "<br>";
	echo "userlevel: ".$_SESSION['userlevel'] . "<br>";
	echo "signup: ".$_SESSION['signup'] . "<br>";
	echo "lastlogin: ".$_SESSION['lastlogin'] . "<br><br>";

	echo "avatar: ".$_SESSION['avatar'] . "<br>";
	echo "work: ".$_SESSION['work'] . "<br>";
	echo "phone: ".$_SESSION['phone'] . "<br>";
	echo "phoneappear: ".$_SESSION['phoneappear'] . "<br>";
	echo "website: ".$_SESSION['website'] . "<br>";
	echo "country: ".$_SESSION['country'] . "<br><br>";

	echo "cookie user: ".$_COOKIE["user"] . "<br>";
}

// BIG PART: get user information from database
if (isset ($_GET["u"])) {
	// Initialize any variables that the page might echo

	$name = "";
	$work = "";
	$phone = "";
	$phoneappear = "";
	$email = "";
	$emailappear = "";
	$website = "";

	$isOwner = "no";
	$u = "";
	$gender = "";
	$sex = "Male";
	$country = "";
	$userlevel = "";
	$joindate = "";
	$lastlogin = "";
	$lastsession = "";

	$u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);

	// Select the member from the users table
	$sql = "SELECT * FROM users WHERE username='$u'";
	$user_query = mysqli_query($db_conx, $sql);
	// Now make sure that user exists in the table
	$numrows = mysqli_num_rows($user_query);
	if ($numrows < 1) {
		echo "That user does not exist or is not yet activated, press back";
		exit ();
	} else {
		// Check to see if the viewer is the account owner	
		if ((isset ($_SESSION['username']))) {
			if ($_COOKIE["user"] == $_GET["u"]) {
				$isOwner = "yes";
			}
		}

		while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
			//$profile_id = $row["id"];
			$name = $row["name"];
			$email = $row["email"];
			$emailappear = $row["emailappear"];
			$gender = $row["gender"];
			if ($gender == "f") {
				$sex = "Female";
			}
			//not here
			//$userlevel = $row["userlevel"];
			$signup = $row["signup"];
			$lastlogin = $row["lastlogin"];
			$joindate = strftime("%b %d, %Y", strtotime($signup));
			$lastsession = strftime("%b %d, %Y", strtotime($lastlogin));
		}

		$sql1 = "SELECT * FROM users WHERE username='$u'";
		$user_query1 = mysqli_query($db_conx, $sql1);
		// Now make sure that user exists in the table
		$numrows1 = mysqli_num_rows($user_query1);
		if ($numrows < 1) {
			echo "That user does not exist or is not yet activated, press back";
			exit ();
		}

		while ($row = mysqli_fetch_array($user_query1, MYSQLI_ASSOC)) {
			$avatar = $row["avatar"];
			if ($avatar == "")
				$avatar = "images/user_default.jpg";
			$work = $row["work"];
			$phone = $row["phone"];
			$phoneappear = $row["phoneappear"];
			$country = $row["country"];
			$website = $row["website"];
			$class1= $row["class1"];
			$time1= $row["time1"];
			$class2= $row["class2"];
			$time2= $row["time2"];
			$class3= $row["class3"];
			$time3= $row["time3"];
			$class4= $row["class4"];
			$time4= $row["time4"];
			$class5= $row["class5"];
			$time5= $row["time5"];
		}
	}

	// BIG PART: if pp go user.php without ?u=...  => need changes here
} else {
	// get current session
	header("location:user.php?u=" . $_SESSION["username"]);
	//include_once "usersearch.php";
}
?>



<!----------------------------------->
<!---  HTML page starts from here -->

<?php
// universal check for session
if (!isset($_SESSION['userId'])) { ?>
	<h4 style="margin-left: 40px"> You are viewing this page as a guest. <a href="index.php"> Login here</a> </h4>
<?php }

if (isset ($_GET["u"])) { // show user  ?>

	<!--  PROFILE PICTURE -->
	<div id="pictures" style="float:right; margin-right: 200px; border: #999 2px solid; width:480px; height: 360px; margin: 20px 30px 0px 0px;">
		<img src="<?php echo $avatar;?>" width="480px" height="360px;"/> <br> <br>
	</div><br>
	
	<!--  BIG NAME -->
	<div id="pro_head" style="color:#2D00F0; margin-left: 80px; font-size:30pt; font-weight:bold; ">
		<?php echo $name; ?>
	</div>

	<!--  SHOW yourself -->
	<div id="aboutyou" style="margin-left: 150px;">
	<h3 style="color:green;"> * A little bit about me </h3>
		<div style="margin-left: 40px;">
		<table width="500" border="0" cellpadding="0" cellspacing="1">
	        <tr height="30px">
	            <td width="120">My name is </td>
	            <td width="6">:</td>
	            <td width="320"><?php echo $name?></td>
	        </tr>
	        <tr height="30px">
	            <td>Gender</td>
	            <td>:</td>
	            <td><?php echo $sex; ?></td>
	        </tr>
	        <?php if(!empty($work)) { ?><tr height="30px">
	            <td>Work/Education place</td>
	            <td>:</td>
	            <td> <?php echo $work; ?> </td>
	        </tr><?php } ?>
	        <?php if(!empty($phone) && $phoneappear == 1) { ?><tr height="30px">
	            <td>Phone number</td>
	            <td>:</td>
	            <td><?php

	if ($phoneappear == 1)
		echo $phone;
?>
	            </td>
	        </tr><?php } ?>
	        <tr height="30px">
	            <td>Email</td>
	            <td>:</td>
	            <td><?php

	if ($emailappear == 1)
		echo $email;
?>
	            </td>
	        </tr>
        </table>
		</div>

		        


	</div> <br><br> <br>

	<!--  SHOW CLASSES -->
	<div id="classes" style="margin-left: 150px;">
	<h3 style="color:green;"> * Classes that I am taking </h3>
		<div style="margin-left: 40px;">
        <table width="500" border="0" cellpadding="0" cellspacing="1">
            <form>
                <tr height="30px">
                    <td width="280" align="center"><b>Class name </b></td>
                    <td width="6">-</td>
                    <td width="280"> <b> Time </b></td>
                </tr>

                <?php if ($class1 !="") { ?>
                <tr height="30px">
                    <td><?php echo $class1;?></td>
                    <td>:</td>
                    <td><?php echo $time1;?></td>
                </tr>
                <?php } ?>

                <?php if ($class2 !="") { ?>
                <tr height="30px">
                    <td><?php echo $class2;?></td>
                    <td>:</td>
                    <td><?php echo $time2;?></td>
                </tr>
                <?php } ?>

                <?php if ($class3 !="") { ?>
                <tr height="30px">
                    <td><?php echo $class3;?></td>
                    <td>:</td>
                    <td><?php echo $time3;?></td>
                </tr>
                <?php } ?>

                <?php if ($class4 !="") { ?>
                <tr height="30px">
                    <td><?php echo $class4;?></td>
                    <td>:</td>
                    <td><?php echo $time4;?></td>
                </tr>
                <?php } ?>

                <?php if ($class5 !="") { ?>
                <tr height="30px">
                    <td><?php echo $class5;?></td>
                    <td>:</td>
                    <td><?php echo $time5;?></td>
                </tr>
                <?php } ?>
            </form>
        </table>

		</div>
	</div> <br><br> <br>	

	<!--  BASIC INFORMATION -->
	<div id="basic" style="margin-left: 150px;">
		<h3 style="color:green;"> * Basic information </h3>
			<div style="margin-left: 40px;">
			<table width="500" border="0" cellpadding="0" cellspacing="1">
		        <tr height="30px">
		            <td width="190">Are you <?php echo $name?> </td>
		            <td width="6">:</td>
		            <td width="210"><b> <?php echo $isOwner?> </b></td>
		        </tr>
		        <tr height="30px">
		            <td>Username</td>
		            <td>:</td>
		            <td> <?php echo $u; ?></td>
		        </tr>
		        <tr height="30px">
		            <td>Country</td>
		            <td>:</td>
		            <td> <?php echo $country; ?> </td>
		        </tr>
		        <tr height="30px">
		            <td>Website</td>
		            <td>:</td>
		            <td><?php echo $website?></td>
		        </tr>
		        <tr height="30px">
		            <td>User Level</td>
		            <td>:</td>
		            <td><?php echo $userlevel; ?></td>
		        </tr>
		        <tr height="30px">
		            <td>Member since</td>
		            <td>:</td>
		            <td><?php echo $joindate; ?></td>
		        </tr>
		        <tr height="30px">
		            <td>Last Login</td>
		            <td>:</td>
		            <td><?php echo $lastsession; ?></td>
		        </tr>
	        </table>
			</div>
	</div> <br><br>	



	<?php

	if (isset ($_SESSION['username']))
		if ($_COOKIE["user"] == $_GET["u"]) {
?>

	<div id="modification" style="margin-left: 150px; border-color: #cf0000;">
		<form id="modifyform">

            <fieldset id="modifyfieldset">
                <legend>Edit Information Panel</legend>      

                <!-- initial note -->              
                <div id="note" style= "margin-bottom: 5px;font-size: 10pt;text-align:center;">
                	Note: Only you can see this panel<br><br><br></div>

                <!-- NGHIA'S NOTE: UPLOAD PICTURE -->
                <p><a href="changeimg.php">Edit Profile Picture</a> </p>

                <!-- NGHIA'S NOTE: change infor -->
                 <p><a href="changeinfo.php">Edit Basic information</a> </p>

                <!-- NGHIA'S NOTE: change classes -->
                <p><a href="changepass.php">Edit security (change password)</a> </p>

                <!-- NGHIA'S NOTE: change classes -->
                <p><a href="changeschool.php">Change classes that I am taking</a> </p>

	   <!--  CHANGE PASSWORD -->
	   <!--  CHANGE CLASSES -->
	</div>
   <?php } ?>

		  <!--  LOGOUT -->
	<div id="logout" style="margin-left: 150px;">
		<?php

			if (isset ($_SESSION['username']))
				if ($_COOKIE["user"] == $_GET["u"]) {
?>
			<br><br><br>
			<a href="logout.php">Log out</a>
		<?php } ?>

	</div><br>
	
<?php } ?>
<?php include_once "includes/footer.php"; ?>
