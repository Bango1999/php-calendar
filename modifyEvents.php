<?php
//_-_-_-_-_-_-_
//modifyEventDesc
//_-_-_-_-_-_-_-_
function modifyEventDesc($EventName, $newEventDesc)
{
  $db_conx = new mysqli("localhost", "nhnguyen", "pass", "zzzz");
        $sql = "SELECT * FROM events WHERE EventName = '".$EventName. 
"'";
        if (!$result = $db_conx->query($sql)) {
                echo "EventName not found. Error = " . $db_conx->error . 
"<br>";
        }
        else {
                while ($row = $result->fetch_assoc())
                 {
                         array_push($_SESSION['events'], $row);
                 if($row['EventCreatorID'] == $_SESSION['userId'])
                 {
                        $sql = "UPDATE events SET 
EventDescription='".$newEventDesc."' WHERE EventID= 
'".$row["EventID"]."'";
                        $query = mysqli_query($db_conx, $sql) or die();
                 }
                }
        }

}
//_-_-_-_-_-_-_
//modifyEventDate
//_-_-_-_-_-_-_
function modifyEventDate($EventName, $newEventDate)
{
	$db_conx = new mysqli("localhost", "nhnguyen", "pass", "zzzz");
	$sql = "SELECT * FROM events WHERE EventName = '".$EventName. 
"'"; 
	if (!$result = $db_conx->query($sql)) { 
		echo "EventName not found. Error = " . $db_conx->error . 
"<br>";
	} 
	else {
		while ($row = $result->fetch_assoc())
		 {
			 array_push($_SESSION['events'], $row); 
			 if($row['EventCreatorID'] == 
$_SESSION['userId'])
			 {
			 	$sql = "UPDATE events SET 
EventDate='".$newEventDate."' WHERE EventID= '".$row["EventID"]."'";
			 	$query = mysqli_query($db_conx, $sql) or 
die();
			 }  
		}
	}
}
//_-_-_-_-_-_-_
//modifyEventTime
//_-_-_-_-_-_-_
function modifyEventTime($EventName, $newEventTime)
{
  $db_conx = new mysqli("localhost", "nhnguyen", "pass", "zzzz");
        $sql = "SELECT * FROM events WHERE EventName = '".$EventName. 
"'";
        if (!$result = $db_conx->query($sql)) {
                echo "EventName not found. Error = " . $db_conx->error . 
"<br>";
        }
        else {
                while ($row = $result->fetch_assoc())
                 {
                         array_push($_SESSION['events'], $row);
                 if($row['EventCreatorID'] == $_SESSION['userId'])
                 {
                        $sql = "UPDATE events SET 
EventDescription='".$newEventTime."' WHERE EventID= 
'".$row["EventID"]."'";
                        $query = mysqli_query($db_conx, $sql) or die();
                 }
                }
        }

}
//_-_-_-_-_-_-_
//modifyEventTime
//_-_-_-_-_-_-_
?>

