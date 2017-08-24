<?php

function check_login() {
	if (!isset($_SESSION['userId'])) {
		header("Location: index.php");
	}
}

function check_login_b() {
	if (!isset($_SESSION['userId'])) {
		return false;
	}
	else return true;
}

function check_groups() {
	if (!isset($_SESSION['groups'])) {
		header("Location: index.php");
	}
}

function check_groups_b() {
	if (!isset($_SESSION['groups'])) {
		return false;
	}
	else return true;
}

function user_exists($username) {
	$username = sanitize($username);
	$query = mysql_query("SELECT COUNT(`id`) FROM `users` WHERE `username` = '$username'");
	return (mysql_result($query,0)) ? true : false;
}

function email_exists($email) {
	$email = sanitize($email);
	$query = mysql_query("SELECT COUNT(`id`) FROM `users` WHERE `email` = '$email'");
	return (mysql_result($query,0)) ? true : false;
}

function id_from_username($username) {
	$username = sanitize($username);
	$result = mysql_result(mysql_query("SELECT `id` FROM `users` WHERE `username` = '$username'"),0,'id');
	return ($result);
}

function id_from_email($email) {
	$email = sanitize($email);
	$result = mysql_query("SELECT `id` FROM `users` WHERE `email` = '$email'");
	$result = mysql_result($result,0);
	return ($result);
}

function login($username, $password) {
	$id = id_from_username($username);
	$username = sanitize($username);
	$password = md5($password);
	$result = mysql_result(mysql_query("SELECT COUNT(`id`) FROM `users` WHERE `username` = '$username' AND `password` = '$password'"), 0);
	if ($result) {
		return $id;
	} else {
		return false;
	}
}

function set_events_session() {
if (isset($_SESSION['group'])) {
	$_SESSION['events'] = array();
	$db_conx = new mysqli("localhost", "nhnguyen", "pass", "zzzz");
	$sql = "SELECT * FROM events WHERE (EventGroupID = ". $_SESSION['group']['id'] . ")";
	if (!$result = $db_conx->query($sql)) {
		//echo "EventID not found. Error = " . $db_conx->error . "<br>";
	} else {
		while ($row = $result->fetch_assoc()) {

			$event = array(
				'EventName' => $row['EventName'],
				'EventID' => $row['EventID'],
				'EventDate' => $row['EventDate'],
				'EventStartTime' => $row['EventStartTime'],
				'EventEndTime' => $row['EventEndTime'],
				'EventHighPriority' => $row['EventHighPriority'],
				'EventDescription' => $row['EventDescription'],
				'EventGroupID' => $row['EventGroupID'],
				'EventCreatorID' => $row['EventCreatorID'],
				'EventIsTemp' => $row['EventIsTemp']
			);
			array_push($_SESSION['events'], $event);
		}
		$result->free();
	}
}
}

function update_user() {
	$field = '`' . implode('`, `', array_keys($_SESSION)) . '`';
	$data = '\'' . implode('\', \'', $_SESSION) . '\'';
	$update = array();
	foreach($_SESSION as $field=>$data) {
		$update[] = '`' . $field . '` = \'' . $data . '\'';
	}
	$x = implode(', ',$update);
	$y = "UPDATE `users` SET " . $x . " WHERE `id` = " . $_SESSION['id'];
	$query = mysql_query($y);
	$x = mysql_result($query,0);
	return ($x) ? true : false;
}

function register_user($data) {
	$data['username'] = sanitize($data['username']);
	$data['pass'] = sanitize($data['pass']);
	$data['pass'] = md5($data['pass']);
	$data['email'] = sanitize($data['email']);
	if (email_exists($data['email'])) {
		$id = id_from_email($data['email']);
		if ($id != 0) {
			$pass = mysql_result(mysql_query("SELECT `password` FROM `users` WHERE `id` = '$id'"), 0);
			if (!empty($pass)) {
				return 1;
			} else {
				$username = $data['username'];
				$pass = $data['pass'];
				$update = array();
				foreach($data as $field=>$data) {
					$update[] = '`' . $field . '` = \'' . $data . '\'';
				}
				$x = implode(', ', $update);
				$y = "UPDATE `users` SET " . $x . " WHERE `id` = " . $id;
				mysql_query($y);
				$_SESSION['id'] = $id;
				$_SESSION['username'] = $username;
				$_SESSION['pass'] = $pass;
				return 2;
			}
		}
	} else {
		return 0;
	}
}

function validate_current_pass($pass,$id) {
	$pass = sanitize($pass);
	$pass = md5($pass);
	$id = sanitize($id);
	$query = mysql_query("SELECT `id` FROM `users` WHERE `password` = '$pass' AND `id` = '$id'");
	$result = mysql_result($query,0);
	return ($result);
}

function change_pass($id,$pass) {
	$pass = md5($pass);
	mysql_query("UPDATE `users` SET `password` = '$pass' WHERE `id` = '$id'");
}

function random_string() {
	$length = 20;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function reset_password($email) {
	$plainpass = random_string();
	$pass = md5($plainpass);
	mysql_query("UPDATE `users` SET `password` = '$pass' WHERE `email` = '$email'");
	$message = "Your calendar account password has been reset.\n\nYour new password is " . $plainpass . "\n\nYou can change your password again when you log in at http://www.calendar.com/login.php\n\nIf you feel that you have recieved this email in error, please contact admin@calendar.com";
	mail($email,'PASSWORD RESET: Group Calendar Service',$message);
}

//display the debug monitor
function show_debug($createEventCalled,$changeGroupCalled,$changeDateCalled,$showEventsCalled) {

$style = "/* padding-left: 50px; */ /* padding-right:50px; */ width: 90%;float:none;  margin-bottom: 30px; background: rgba(255,255,255,0.8); border-radius:10px; -webkit-border-radius: 10px; -moz-border-radius: 10px; border: 3px dotted #cf0000; box-shadow: 3px 3px 2px black; -webkit-box-shadow: 3px 3px 2px black; -moz-box-shadow: 3px 3px 2px black;margin-left: 5%;";
$debugIcon = '<div class="hoverArea" style="'.$style.'" onclick="ShowDebug(' . "'child'" . ')" onmouseout="HideDebug('."'child'".')">';

$debugIcon .= '<h3 style="margin:0;width:100%;text-align:center;"><br>CLICK TO SHOW DEBUG MONITOR<div style="clear:both"><span style="font-size:13pt">(MouseOut to hide)</span><div style="clear:both"><br/></div></div></h3>';
$style = "width: 49%;margin:0;padding:0;margin-bottom: 10px; display:inline-block;";
	$debug = '<div class="child" style="display:none">';
	$debug .= '<table border="1" style="'.$style.'"><tr><th style="text-align:center">VARIABLE</th><th style="text-align:center">VALUE</th>';
	
	//display session variables
	if (isset($_SESSION['userId'])) {
		$debug .= "<tr><td>session['userId']</td><td>" . $_SESSION['userId'] . "</td></tr>";
	} else {
		$debug .= "<tr><td>session['userId']</td><td>null</td></tr>";
	}
	if (isset($_SESSION['username'])) {
		$debug .= "<tr><td>session['username']</td><td>" . $_SESSION['username'] . "</td></tr>";
	} else {
		$debug .= "<tr><td>session['username']</td><td>null</td></tr>";
	}
	if (isset($_SESSION['password'])) {
		$debug .= "<tr><td>session['password']</td><td>" . $_SESSION['password'] . "</td></tr>";
	} else {
		$debug .= "<tr><td>session['password']</td><td>null</td></tr>";
	}
	//$debug .= "<tr><td>md5(session['password'])</td><td>".md5($_SESSION['password']) . "</td></tr>";
	if (isset($_SESSION['groups'])) {
		$debug .= "<tr><td>session['groups']</td><td>ARRAY(<br>";
		foreach ($_SESSION['groups'] as $g) {
			$debug .= ' '.$g['id'].' => '.$g['name'].'<br>';
		}
		$debug .= ");</td></tr>";
	} else {
		$debug .= "<tr><td>session['groups']</td><td>null</td></tr>";
	}
	if (isset($_SESSION['group'])) {
	
	$debug .= "<tr><td>session['group']</td><td>ARRAY(<br>";
		$keys = array_keys($_SESSION['group']);
		for ($i = 0; $i < count($_SESSION['group']); $i++) {
			$debug .= " ".$keys[$i]." => ".$_SESSION['group'][$keys[$i]]."<br>";
		}
		$debug .= ");</td></tr>";
	
	//	$debug .= "<tr><td>session['group']</td><td>".$_SESSION['group']."</td></tr>";
	} else {
		$debug .= "<tr><td>session['group']</td><td>null</td></tr>";
	}
	if (isset($_SESSION['events'])) {
		$debug .= "<tr><td>session['events']</td><td>ARRAY(<br>";
		foreach ($_SESSION['events'] as $event) {
			$debug .= "EventName => ". $event['EventName']. "<br />";
		}
		$debug .= ");</td></tr>";
	} else {
		$debug .= "<tr><td>session['events']</td><td>null</td></tr>";
	}
	

	//display any form inputs
	if (count($_POST) > 0) {
		$debug .= "<tr><td>post[]</td><td>ARRAY(<br>";
		$keys = array_keys($_POST);
		for ($i = 0; $i < count($_POST); $i++) {
			$debug .= " ".$keys[$i]." => ".$_POST[$keys[$i]]."<br>";
		}
		$debug .= ");</td></tr>";
	}
	if (count($_GET) > 0) {
		$debug .= "<tr><td>get[]</td><td>ARRAY(<br>";
		$keys = array_keys($_GET);
		for ($i = 0; $i < count($_GET); $i++) {
			$debug .= " ".$keys[$i]." => ".$_GET[$keys[$i]]."<br>";
		}
		$debug .= ");</td></tr>";
	}
	$debug .= '</table>';
	
	
	if ($createEventCalled || $changeGroupCalled || $changeDateCalled || $showEventsCalled) {
		$debug .= '<div style="float:right;padding-right:2%; /* background: black; */ color: black; /* border-radius:10px; */ /* -webkit-border-radius:10px; */ -moz-border-radius:10px; /* box-shadow: 3px 3px 3px #cf0000; */ display:inline-block; width: 45%; padding-left: 10px;border: 1px solid black;"><h3>Called Function:</h3>';
		if ($createEventCalled) {
			$debug .= "create_event() was called<br>";
		}
		if ($changeGroupCalled) {
			$debug .= "change_group() was called<br>";
		}
		if ($changeDateCalled) {
			$debug .= "change_date() was called<br>";
		}
		if ($showEventsCalled) {
			$debug .= "show_events() was called<br>";
		}
		$debug .= '<br><hr color="#cf0000" /><br><img src="http://www.19hkd.com/upload/gigs/debug1385112055.jpg" alt="Your Friendly Neighborhood Debug Monitor!" width="100%" style="max-height:100%;" />';
		$debug .= '<br></div>';
	}
	
	$debug .= '<br></div></div>';
	
	echo $debugIcon . $debug;
}


//group creation
function create_groups_session() {
$db_conx = new mysqli("localhost", "nhnguyen", "pass", "zzzz");
/* Database name: zzzz
user: nhnguyen
pass: pass */
// Evaluate the connection
if ($db_conx->connect_errno > 0) {
   echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
   die();
}
	$_SESSION['groups'] = array ();
	unset( $_SESSION['group']);
	$sql = "SELECT * FROM members JOIN groups on members.groupid=groups.groupid WHERE members.userid = '" . 
$_SESSION["userId"] . "'";
	$query = mysqli_query($db_conx, $sql);

	while ($row = mysqli_fetch_array($query)) {
		$group = array (
			'name' => $row['name'],
			'id' => $row['groupid'],
			'level' => $row['level']
		);
		array_push($_SESSION['groups'], $group);
		if (!isset ($_SESSION['group'])) {
			$_SESSION['group'] = array (
				'name' => $row['name'],
				'id' => $row['groupid'],
				'level' => $row['level']
			); }
	}
mysqli_close($db_conx);
} 
//_-_-_-_-_-_-_
//create event
function create_event() {

	//sanitize all $_POST[''] vals
	//$_POST['eventName']
	//$_POST['eventDate']
	//$_POST['eventStartTime']
	//$_POST['eventEndTime']
	//$_POST['eventHP']
	//$_POST['eventDescription']
	//check if $_SESSION['userId'] is admin of $_SESSION
	
	$db_conx = new mysqli("localhost", "nhnguyen", "pass", "zzzz");
	
	//add this to core
	$_POST['eventStartTime'] .= ":00";
	$_POST['eventEndTime'] .= ":00";
	
	
	
	$sql="SELECT * FROM members WHERE userid = ".$_SESSION['userId']." && groupid = ".$_SESSION['group']['id'];
	$user_query=mysqli_query($db_conx,$sql);

	// Mysql_num_row is counting table row
	$numrows=mysqli_num_rows($user_query);
	$level = -1;
	// If result matched $myusername and $mypassword, table row must be 1 row
	if($numrows==1) {
		while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
			$level = $row["level"];
		}
	} else {
		$level = 2;
	}
	if ($level == 1 || $level == 0) {
		$isTemp = 0;
	} else {
		$isTemp = 1;
	}
	//1 = admin 2 = member
	$sql = "INSERT INTO events (
    EventName, 
    EventDate, 
    EventStartTime, 
    EventEndTime, 
    EventHighPriority,
    EventDescription,
    EventGroupID,
	EventCreatorID,
	EventIsTemp
	) 
	VALUES ('".$_POST['eventName']."','".$_POST['eventDate']."','".$_POST['eventStartTime']."','".$_POST['eventEndTime']."','".$_POST['eventHP']."','".$_POST['eventDescription']."','".$_SESSION['group']['id']."','".$_SESSION['userId']."',". $isTemp .")";
	
	mysqli_query($db_conx,$sql) or die(mysqli_error($db_conx));
	
	return true;
}

function approve_event() {

	//post is set, you have EventID
	$eventid = $_POST['approve'];

}

function modify_event() {

	//post is set, you have EventID
	$eventid = $_POST['modifyEvent'];

}

function delete_event() {

	//post is set, you have EventID
	$eventid = $_POST['delete'];

}
?>
