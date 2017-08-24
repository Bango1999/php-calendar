<?php
//INDEX.PHP

//connect to database or die. require all the core functions
include 'includes/init.php';

//check that the user has everything needed to view the calendar
include_once 'includes/auth.php';

//ShowModifyEvent Pane
include "includes/eventsLogic.php";


$errors = array();

//-----------------------------------------------------#!
//DEBUG CONTROLLER VALUES
$iCanDebug = true; //set false to disable debug monitor
if ($iCanDebug) {
	$createEventCalled = false;
	$changeGroupCalled = false;
	$changeDateCalled = false;
	$showEventsCalled = false;
}

//-----------------------------------------------------#!
//FORM PROCESSING
if (isset($_POST['delete'])) {
	$deleteEventErrors = array();
	$deleteEventErrors[] = "delete event requested";
	
	delete_event();
}

if (isset($_POST['approve'])) {
	$approveEventErrors = array();
	$approveEventErrors[] = "approve event requested";
	
	approve_event();
}

if (isset($_POST['modifyEvent'])) {
	$modifyEventErrors = array();
	$modifyEventErrors[] = "modify event requested";
	
	modify_event();
}


if (isset($_POST['changeGroupForm'])) {
		if ($iCanDebug)
			$changeGroupCalled = true;
}
if (isset($_POST['createEventForm'])) {
	$createEventErrors = array();
	$createEventBad = process_create_event_form();
	if ($createEventBad) {
		foreach ($createEventBad as $c) {
			$createEventErrors[] = $c;
		}
	} else {
		create_event();
		if ($iCanDebug)
			$createEventCalled = true;
	}
}
if (isset($_POST['month']) || isset($_POST['year'])) {
	$changeDateBad = process_change_date_form();
	if ($changeDateBad) {
		foreach ($changeDateBad as $c) {
			$errors[] = $c;
		}
	} else {
		$_SESSION['month'] = $_POST['month'];
		$_SESSION['year'] = $_POST['year'];
		if ($iCanDebug)
			$changeDateCalled = true;
	}
}


if (isset($_POST['day'])) {
	$showEventsBad = process_show_events_form();
	if ($showEventsBad) {
		foreach ($showEventsBad as $s) {
			$errors[] = $s;
		}
	} else {
        SetDayEvents();
		if ($iCanDebug)
			$showEventsCalled = true;	
	}
}




if (isset($_POST['event'])) {
  SetEventSession();
} else {
	$_SESSION['event'] = NULL;
}

//-----------------------------------------------------#!
//POPULATE EVENTS ARRAY
set_events_session();

//-----------------------------------------------------#!
//SET TIMEZONE, MONTH, YEAR
date_default_timezone_set('America/Chicago');
if (!isset($_SESSION['month']) || !isset($_SESSION['year'])) {
	$_SESSION['month'] = (int) date('m');
	$_SESSION['year'] = (int) date('Y');
}
//make local page vars, easier to pass into functions
$month = (int)$_SESSION['month'];
$year = (int)$_SESSION['year'];



//-----------------------------------------------------#!
//ERROR OUTPUT (needs to be moved inside HTML)
if (!empty($errors)) {
	for ($i=0; $i<count($errors); $i++) {
		echo $errors[$i] . "<br />";
	}
}

//-----------------------------------------------------#!
// DEBUG MONITOR (to switch off, set iCanDebug false)
if ($iCanDebug) {
	show_debug($createEventCalled, $changeGroupCalled,$changeDateCalled,$showEventsCalled);
}

//-----------------------------------------------------#!
//HTML START

//CALENDAR CONTROLS
echo draw_controls($month,$year);

//EVENT PANE
include_once 'includes/eventPane.php';

//CALENDAR
echo draw_calendar($month,$year);

//SHOW EVENTS FORM
include_once 'includes/showEventsForm.php';

//HTML END
include_once 'includes/footer.php';
//-----------------------------------------------------#!
?>
