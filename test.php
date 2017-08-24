<?php

$eventsContainer = array();

$db_conx = new mysqli("localhost", "nhnguyen", "pass", "zzzz");
$sql = 'SELECT * FROM events WHERE EventGroupID = 0'; //change 0 later to the group id requested
if (!$result = $db_conx->query($sql)) {
	echo "EventID not found. Error = " . $db_conx->error . "<br>";
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
		array_push($eventsContainer, $event);
	}
	$result->free();
}

foreach ($eventsContainer as $event) {
	foreach ($event as $index => $value) {
		echo $index . " = " . $value . "<br />";
	}
}

?>