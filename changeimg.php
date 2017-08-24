<?php
$title = "Change User Image";
include_once "includes/init.php";
include_once 'includes/auth.php';
$avatar="";
if ($_SESSION['avatar'] == "")
	$avatar = "images/user_default.jpg";
else
    $avatar=$_SESSION['avatar'];

$debug = 0;
if ($debug == 1) {
	echo "avatar: ";
	echo $_SESSION['avatar'];
	echo "<br>";
}
?>

<!----------------------------------->
<!---  HTML page starts from here -->

<center>
  <fieldset id="uploadpic" style= "display: inline;clear:center;float:center;width:340px;">
        <legend>Edit Profile Picture</legend>
        Current profile picture: <br> <img src="<?php echo $avatar;?>" width="240px" height="180px;" /> <br> <br> 

        <form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        Choose your file here:
        <input name="avatar" type="file" required/><br /><br />
            <div id="note" style= "margin-bottom: 5px;font-size: 10pt;text-align:center;">
            [Image will be resized to 500x300 pixels]</div>
        <input type="submit" style="font-size:18px; padding: 12px;background: #F3F9DD;" value="Change my profile picture!"/>
		<br><br>
        
		<div style="margin: 5px;text-align:center"> or <a href="user.php">
    Click here </a> to go back to the your User page.<br></div>
        </form>
		<?php if (isset($_FILES['avatar'])) {
			include_once 'includes/photo_system.php';
		} ?>

    </fieldset>
    </center> <br><br><br>
<?php include_once "includes/footer.php"; ?>
