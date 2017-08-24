<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>CSS Slideout</title>
	<style type="text/css" media="screen">
		
		#slideout {
			position: fixed;
			top: 40px;
			left: 0;
			width: 35px;
			padding: 12px 0;
			text-align: center;
			background: #6DAD53;
			-webkit-transition-duration: 0.3s;
			-moz-transition-duration: 0.3s;
			-o-transition-duration: 0.3s;
			transition-duration: 0.3s;
			-webkit-border-radius: 0 5px 5px 0;
			-moz-border-radius: 0 5px 5px 0;
			border-radius: 0 5px 5px 0;
		}
		#slideout_inner {
			position: fixed;
			top: 40px;
			left: -250px;
			background: #6DAD53;
			width: 200px;
			padding: 25px;
			height: 130px;
			-webkit-transition-duration: 0.3s;
			-moz-transition-duration: 0.3s;
			-o-transition-duration: 0.3s;
			transition-duration: 0.3s;
			text-align: left;
			-webkit-border-radius: 0 0 5px 0;
			-moz-border-radius: 0 0 5px 0;
			border-radius: 0 0 5px 0;
		}
		#slideout_inner textarea {
			width: 190px;
			height: 100px;
			margin-bottom: 6px;
		}
		#slideout:hover {
			left: 250px;
		}
		#slideout:hover #slideout_inner {
			left: 0;
		}
		
	</style>
</head>

<body>
 <?php 
 $db_conx = new mysqli("localhost", "nhnguyen", "pass", "zzzz");
	if ($_SESSION['isAdmin'] == true) {
		//show events and event modification options
	} else {
		//show only events
	}
		
		//this will be searching every single event in events where eventID
	$sql = "SELECT EventCreatorID FROM events WHERE EventID = '".$_SESSION['dayEvents']['EventID']. "'";
?>
	<div id="slideout">
		<img src="feedback.png" alt="Feedback" />
		<div id="slideout_inner">
			<form>
				<textarea></textarea>
				<input type="submit" value="Post feedback"></input>
			</form>
		</div>
	</div>

</body>
</html>