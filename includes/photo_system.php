

<div style="max-width:918px;margin:0 auto; text-align:center">
<?php
// check login
?><?php 
if ($_FILES["avatar"]["error"] > 0)
  {
  echo "Error: " . $_FILES["avatar"]["error"] . "<br>";
  }

if (isset($_FILES["avatar"]["name"]) && $_FILES["avatar"]["tmp_name"] != ""){
	$fileName = $_FILES["avatar"]["name"];
    $fileTmpLoc = $_FILES["avatar"]["tmp_name"];
	$fileType = $_FILES["avatar"]["type"];
	$fileSize = $_FILES["avatar"]["size"];
	$fileErrorMsg = $_FILES["avatar"]["error"];
	$kaboom = explode(".", $fileName);
	$fileExt = end($kaboom);
	list($width, $height) = getimagesize($fileTmpLoc);
	if($width < 10 || $height < 10){ 
		?>
		<div> ERROR: That image has no dimensions<br></div> ";
		<br><br> <div> <a href="changeimg.php">
            Click here </a> to go back to your Edit Profile picture page.</div> <br>
		<?php
        exit();	
	}
	$error=0;
	if($fileSize > 500000) {
		echo "<br>ERROR: Your image file was larger than 1mb<br>";
		exit();	
	} else if (!preg_match("/\.(gif|jpg|png)$/i", $fileName) ) {
		?>
		<br><br> <div style="margin-left: 200px"> ERROR: Your image file was not jpg, gif or png type. <br><br></div> 
		 <div style="margin-left: 200px"> <a href="changeimg.php">
            Click here </a> to go back to your Edit Profile picture page.</div> <br>
		<?php
        exit();
	} else if ($fileErrorMsg == 1) {
		echo "<br>ERROR: An unknown error occurred<br>";
		exit();
	}
	
	$myusername= $_SESSION['username'];
	//echo $myusername;
	//echo $fileSize;
	//echo $_SESSION['username'];
	//$sql = "UPDATE users SET avatar='images/".$myusername.".".$fileExt."' WHERE username='$myusername'";
	//include_once("database/connect.php");
	//$query = mysqli_query($db_conx, $sql);
	
	//$_SESSION['avatar'] = "images/".$myusername.".".$fileExt;
	$root = explode('/',$_SERVER['DOCUMENT_ROOT']);

	$moveResult = move_uploaded_file( $fileTmpLoc, "/". $root[1]. "/" .$root[2]. "/" .$root[3]."/images/" . $myusername.".".$fileExt);
	 if ($moveResult != true) {
	 	echo "<br>Not Stored<br>";
	}
	else {
		echo "<br>Successfully uploaded picture to server!<br>";
	}
	// include_once("image_resize.php");
	// $target_file = "/usr/home/nguyen/public_html/img/" . $myusername.".".$fileExt;
	// $resized_file ="/usr/home/nguyen/public_html/img/" . $myusername.".".$fileExt;
	// $wmax = 200;
	// $hmax = 300;
	// img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
	$file_name = "./images/".$myusername.".".$fileExt;
	$sql = "UPDATE users SET avatar='$file_name' WHERE username='$myusername' ";
	$_SESSION['avatar']=$file_name;
	$query = mysqli_query($db_conx, $sql);
	if ($query) {
		echo "Successfully updated profile picture! <br><br>"; ?>

		Please <a href="user.php">
		Click here </a> to go back to your User page.<br></div>
		<?php
	}
	mysqli_close($db_conx);
	//header("location: ../user.php?u=$log_username");
}
?>

