<?php
//core/functions/validate.php


//_-_-_-_-_-_-_
//process change date
function process_change_date_form() {
	$errors = array();
	//$errors[] = "entering process_change_date_form()<br>";
	//$errors[] = "post['year']=".$_POST['year']."<br>";
	//$errors[] = "post['month']=".$_POST['month']."<br>";
	//return $errors;
	if (isset($_POST['year']) && isset($_POST['month'])) {
		if (!((int)$_POST['year'] > 1900 && (int)$_POST['year'] < 3000)) {
			$errors[] = "Please specify a valid year between 1900 and 3000!";
		}
		if (!((int)$_POST['month'] > 0 && (int)$_POST['month'] < 13)) {
			$errors[] = "Please specify a valid month!";
		}
	} else {
		$errors[] = "You need to specify the month and year you wish to view";
	}
	
	if (count($errors) > 0) {
		return $errors;
	} else {
		return false;
	}
}

//_-_-_-_-_-_-_
//process create event
function process_create_event_form() {
	$errors = array();
	//$errors[] = "event date = ".$_POST['eventDate'];
	//$errors[] = "post['']=<br>";
	//return $errors;
	//echo count($_SESSION['groups']);
	//die();
	if (!isset($_SESSION['groups']) || count($_SESSION['groups']) == 0) {
		$errors[] = "You are not in any groups!";
		return $errors;
	} else if (!empty($_POST['eventName']) && !empty($_POST['eventDate']) && !empty($_POST['eventStartTime']) && !empty($_POST['eventEndTime']) && !empty($_POST['eventDescription'])) {
		//parse eventName
		if (strlen($_POST['eventName']) < 1) {
			$errors[] = "Please specify a name for your event!";
		} else if (strlen($_POST['eventName']) > 30) {
			$errors[] = "Your event name cannot exceed 30 characters!";
		}
		//silent corrections
		$_POST['eventName'] = str_replace("'","",$_POST['eventName']);
		
			$db_conx = new mysqli("localhost", "nhnguyen", "pass", "zzzz");
			//check db to see if time conflict
			$sql="SELECT * FROM events WHERE EventName = '".$_POST['eventName']."'";
			$user_query=mysqli_query($db_conx,$sql);

			// Mysql_num_row is counting table row
			$numrows=mysqli_num_rows($user_query);
			// If result matched $myusername and $mypassword, table row must be 1 row
			if($numrows>0) {
				while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
					//echo "EventStartTime=".$row["EventStartTime"] . "<br>EventEndTime=".$row["EventEndTime"]."<br><br>";
					$eventName = $row["EventName"];
					if (strcmp($_POST['eventName'],$eventName) === 0) {
						$errors[] = "That event name has already been taken!";
						break;
					}
				}
			}
		
		
		//parse eventDate
		$gregorian = explode('-',$_POST['eventDate']);
		if (count($gregorian) != 3) {
			$errors[] = "Please enter the date as yyyy-mm-dd";
		} else {
			if (!((int)$gregorian[0] > 1900 && (int)$gregorian[0] < 3000)) {
				$errors[] = "Please specify a year between 1900 and 3000!";
			}
			if (!((int)$gregorian[1] > 0 && (int)$gregorian < 13)) {
				$errors[] = "Please specify a valid month!";
			}
			if (!((int)$gregorian[2] > 0 && (int)$gregorian[2] < 32)) {
				$errors[] = "Please specify a valid day!";
			}
		}
		
		//parse eventStartTime
			$parseStartTime = date_parse($_POST['eventStartTime']);
			$_POST['eventStartTime'] = $parseStartTime['hour'].':'.$parseStartTime['minute'];
		
		$startTime = explode(':',$_POST['eventStartTime']);
		$timesgood = true;
		if (count($startTime) != 2) {
			$errors[] = "Please enter Start Time as hh:mm (24-hour)";
			$timesgood = false;
		} else {
			if (!((int)$startTime[0] >= 0 && (int)$startTime[0] < 24)) {
				$errors[] = "Please enter a valid Start Hour! (1-24)";
				$timesgood = false;
			}
			if (!((int)$startTime[1] >= 0 && (int)$startTime[1] < 60)) {
				$errors[] = "Please enter a valid Start Minute! (00-59)";
				$timesgood = false;
			}
		}
		//parse eventEndTime
			$parseEndTime = date_parse($_POST['eventEndTime']);
			$_POST['eventEndTime'] = $parseEndTime['hour'].':'.$parseEndTime['minute'];
		$endTime = explode(':',$_POST['eventEndTime']);
		if (count($endTime) != 2) {
			$errors[] = "Please enter End Time as hh:mm (24-hour)";
			$timesgood = false;
		} else {
			if (!((int)$endTime[0] > 0 && (int)$endTime < 25)) {
				$errors[] = "Please enter a valid End Hour! (1-24)";
				$timesgood = false;
			}
			if (!((int)$endTime[1] >= 0 && (int)$endTime < 60)) {
				$errors[] = "Please enter a valid End Minute! (00-59)";
				$timesgood = false;
			}
		}
		
		if ($startTime[0] == $endTime[0]) {
			if ($startTime[1] > $endTime[1]) {
				$errors[] = "End Time cannot come before Start Time!";
				$timesgood = false;
			} else if ($startTime[1] == $endTime[1]) {
				$errors[] = "Event cannot last 0 minutes!";
				$timesgood = false;
			}
		} else if ($startTime[0] > $endTime[0]) {
			$errors[] = "End Time cannot come before Start Time!";
			$timesgood = false;
		}
		if ($timesgood) {
			$db_conx = new mysqli("localhost", "nhnguyen", "pass", "zzzz");
			//check db to see if time conflict
			$sql="SELECT * FROM events WHERE EventGroupID = ".$_SESSION['group']['id']." && EventDate = '" . $_POST['eventDate'] . "' && EventIsTemp = 0";
			$user_query=mysqli_query($db_conx,$sql);

			// Mysql_num_row is counting table row
			$numrows=mysqli_num_rows($user_query);
			// If result matched $myusername and $mypassword, table row must be 1 row
			if($numrows>0) {
				while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
					//echo "EventStartTime=".$row["EventStartTime"] . "<br>EventEndTime=".$row["EventEndTime"]."<br><br>";
					$eventStartTime = explode(':',$row["EventStartTime"]);
					$eventEndTime = explode(':',$row["EventEndTime"]);
					//echo $startTime[0] ." > ". $eventStartTime[0]." && ".$startTime[0]." < ".$eventEndTime[0];
					if ($startTime[0] < $eventStartTime[0] && $endTime[0] > $eventStartTime[0]) {
						$AddEventErrors[] = "Add Event Error: There is already an approved event for your group during this time!";
						break;
					} else if ($startTime[0] > $eventStartTime[0] && $startTime[0] < $eventEndTime[0]) {
						$errors[] = "Add Event Error: There is already an approved event for your group during this time!";
						break;
					} else if ($startTime[0] == $eventStartTime[0]) {
						$errors[] = "Add Event Error: There is already an approved event for your group during this time!";
						break;
					} else if ($endTime[0] == $eventEndTime[0]) {
						$errors[] = "Add Event Error: There is already an approved event for your group during this time!";
						break;
					}
				}
			}
		}
		//parse eventDescription
		if (strlen($_POST['eventDescription']) > 150) {
			$errors[] = "Event Description cannot be greater than 150 characters!";
		}
		//silent corrections
		$_POST['eventDescription'] = str_replace("'","",$_POST['eventDescription']);
		
		//parse eventHP
		if (!isset($_POST['eventHP'])) {
			$_POST['eventHP'] = 0;
		} else {
			$_POST['eventHP'] = 1;
		}
		
	//something important is empty.  tell them so
	} else {
		if (empty($_POST['eventName'])) {
			$errors[] = "Event Name is a required field!";
		}
		if (empty($_POST['eventDate'])) {
			$errors[] = "Event Date is a required field!";
		}
		if (empty($_POST['eventStartTime'])) {
			$errors[] = "Start Time is a required field!";
		}
		if (empty($_POST['eventEndTime'])) {
			$errors[] = "End Time is a required field!";
		}
		if (empty($_POST['eventDescription'])) {
			$errors[] = "Event Description is a required field!";
		}
	}
		
	if (count($errors) > 0) {
		return $errors;
	} else {
		return false;
	}
}

//_-_-_-_-_-_-_
//process show events
function process_show_events_form() {
	$errors = array();
	//$errors[] = "entering process_show_events_form()<br>";
	//$errors[] = "post['day']=".$_POST['day']."<br>";
	//return $errors;
	
		
	if (count($errors) > 0) {
		return $errors;
	} else {
		return false;
	}
}

//_-_-_-_-_-_-_
//process change group
function process_change_group_form() {
	$errors = array();
	//$errors[] = "entering process_change_group_form()<br>";
	//$errors[] = "post['groups']=".$_POST['groups']."<br>";
	//return $errors;
	
		
	if (count($errors) > 0) {
		return $errors;
	} else {
		return false;
	}
}

//_-_-_-_-_-_-_
//change group
function change_group() {
//this function is called when the user wants to change which group they want to see events for
	$errors = array();
	$found = false;
	$name = NULL;
	$id = NULL;
	
	//page has form data for which group they want to be in.
	//now check for a match in groups
	foreach ($_SESSION['groups'] as $g) {
		//if match, update session vars and return success
		if ($g['id'] == $_POST['groups']) {
			$_SESSION['group']['name'] = $g['name'];
			$_SESSION['group']['id'] = $g['id'];
			$_SESSION['group']['level'] = $g['level'];
			$found = true;
			return false;
		}
	}
	
	$sql = "SELECT level FROM members WHERE userid = '".$_SESSION['userid']. "' && groupid = '". $_SESSION['group']['id'] . "'";
	if (!$result = $db_conx->query($sql)) { 
		echo "EventName not found. Error = " . $db_conx->error . "<br>";
	} 
	else {
		if($result == 1)
		$_SESSION['isAdmin'] = true;
		else
		$_SESSION['isAdmin'] = false;
		//found is still false, meaning user is not in the group they chose
		if (!$found) {
			$errors[] = "You are not in this group!";
			return $errors;
		}
	}
}
?>