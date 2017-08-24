<?php
function ShowDayOptions() {
	
	$eventHtml = '<div class="AddEventInputField" style="color:white">';
	$eventHtml .= '<div id="showAddTrigger" onclick="showAddForm()">Add New Event</div>';
	$eventHtml .= '</div>';
	$eventHtml .= '<div class="AddEventInputField" style="color:white">';
	$level = $_SESSION['group']['level'];
	foreach ($_SESSION['dayEvents'] as $event) {
		if ($event['EventIsTemp'] == 0 || $level < 2) {
			//call to see if admin or creator here
			$level = $_SESSION['group']['level'];
			
			
			if ($level < 2) {
				if ($event['EventIsTemp'] == 1 && ($level == 0 || $level == 1)) {
					$eventHtml .= '<div onclick="sendApproveForm(\''.$event['EventID'].'\')" class="deleteBtn"><span>Approve Event</span></div>';
					$eventHtml .= '<form id="app" action="'.$_SERVER['PHP_SELF'].'" method="post" style="display:none"><input id="approve" type="hidden" name="approve" value="x" /></form>';
				}
					$eventHtml .= '<form id="del" action="'.$_SERVER['PHP_SELF'].'" method="post">';
					$eventHtml .= '<input type="hidden" id="deleteID" name="delete" value="x"></form>';
					$eventHtml .= '<form id="mod" action="'.$_SERVER['PHP_SELF'].'" method="post">';
					$eventHtml .= '<input type="hidden" id="modifyID" name="modify" value="x"></form>';
					$eventHtml .= '<div onclick="sendDeleteForm(\''.$event['EventID'].'\')" class="modifyBtn"><span>Delete Event</span></div>';
					$eventHtml .= '<div onclick="sendModifyForm(\''.$event['EventID'].'\')" class="modifyBtn"><span>Modify Event</span></div>';
			}
			
			if ($event['EventIsTemp'] == 0 || $level < 2) {
				$eventHtml .= '<div class="eventListItem">';
				$eventHtml .= '<br/><div class="fieldlabel" style="color:#ccc">Name:</div>';
				$eventHtml .= '<div style="display: inline-block;width: 38%;">'.$event['EventName'].'</div><br>';
				$eventHtml .= '<div class="fieldlabel" style="color:#ccc">Date:</div>';
				$eventHtml .= '<span>'.$event['EventDate'].'</span><br>';
				$eventHtml .= '<div class="fieldlabel" style="color:#ccc">Start Time:</div>';
				$eventHtml .= '<span>'.$event['EventStartTime'].'</span><br>';
				$eventHtml .= '<div class="fieldlabel" style="color:#ccc">End Time:</div>';
				$eventHtml .= '<span>'.$event['EventEndTime'].'</span><br>';
				$eventHtml .= '<div class="fieldlabel" style="color:#ccc">High Priority:</div>';
				
				if ($event['EventHighPriority'] == 1) {
					$eventHtml .= '<span>yes</span><br>';
				} else {
					$eventHtml.= '<span>no</span><br>';
				}
				$eventHtml .= '<div class="fieldlabel borderbottom" style="color:#ccc">Description:</div>';
				$eventHtml .= '<div style="display: inline-block;width: 40%;padding-bottom:10px">'.$event['EventDescription'].'</div><br>';
			}
			
			$eventHtml .= '</div>';
		}
	}
	$eventHtml .='</div>';
	
   if(isset($_POST['modify'])) {
        foreach($_SESSION['dayEvents'] as $modevent) {
			//$eventHtml .= '<div>modevent eventid = '.$modevent['EventID'].'</div>';
			if ($modevent['EventID'] == $_POST['modify']) {
				//$eventHtml .= 'modevent eventid='.$modevent['EventID'].'<br>post modify='.$_POST['modify'];
				$eventHtml .=  '<div class="AddEventInputField">';
				$eventHtml .=  '<form action="' .htmlspecialchars($_SERVER['PHP_SELF']).'"method="post" style="color:white">';
				$eventHtml .=   '<fieldset class="sidebarFieldset" style="margin-bottom:10px"><legend>Modify "'.$modevent['EventName'].'" </legend>';
				$eventHtml .= '<div class="AddEventInputField">';
				$eventHtml .= '<label>Event Name</label>';
				$eventHtml .=  '<input type="text" name="eventName" value= "'.$modevent['EventName'].'"/><br/>';
				$eventHtml .= '</div>';
				$eventHtml .= '<div class="AddEventInputField">';
				$eventHtml .=  '<label>Date</label>';
				$eventHtml .= '<input id="dateField" type="date" name="eventDate" value="'.$modevent['EventDate'].'"/><br/>';
				$eventHtml .= '</div>';
				$eventHtml .= '<div class="AddEventInputField">';
				$eventHtml .= '<label>Start Time</label>';
					$st = explode(':',$modevent['EventStartTime']);
					$et = explode(':',$modevent['EventEndTime']);
				$eventHtml .=   '<input type="time" name="eventStartTime" value="'.$st[0].':'.$st[1].':'.$st[2].'"/><br/>';
				$eventHtml .= '</div>';
				$eventHtml .= '<div class="AddEventInputField">';
				$eventHtml .= '<label>End Time</label>';
				$eventHtml .= '<input type="time" name="eventEndTime" value="'.$et[0].':'.$et[1].':'.$et[2].'"/><br/>';
				$eventHtml .= '</div>';
				$eventHtml .= '<div class="AddEventInputField">';
				$eventHtml .= '<label>High Priority</label>';
				if ($modevent['EventHighPriority'] == 1) {
					$eventHtml .= '<input type="checkbox" name="eventHP" checked/><br>';
				} else {
					$eventHtml .= '<input type="checkbox" name="eventHP" /><br>';
				}
				$eventHtml .= '</div>';
				$eventHtml .= '<div class="AddEventInputField">';
				$eventHtml .= '<label>Description</label>';
				$eventHtml .= '<textarea rows="6" cols="17" name="eventDescription" placeholder="Event Description">'.$event['EventDescription'].'</textarea>';
				$eventHtml .= '</div>';
				$eventHtml .= '<div class="AddEventInputField">';
				$eventHtml .= '<input type="hidden" name="modifyEvent" value="'.$modevent['EventID'].'" /><label style="height:5px;"></label><input type="submit" value="Submit Changes" />';
				$eventHtml .= '</div>';
				$eventHtml .= '</fieldset>';
				$eventHtml .= '</form> </div>';
			}
		}
	}



    // $eventHtml .= '<form action="'.$_SERVER["PHP_SELF"].'" method="post">';
    // $eventHtml .= '<select name="event">';
    
    // foreach($_SESSION['dayEvents'] as $event) {

        // $eventDispName = $event['EventName'];
        // $eventDispId = $event['EventID'];
        // $eventHtml .= '<option value="'.$eventDispId.'"> "'.$eventDispName.'"</option>"';
    // }
    // $eventHtml .= '<input type="submit" value="select">';
    // $eventHtml .= '</select></form>';
    
    
    
    
    if(isset($_SESSION['event'])) {
            $eventHtml .= "Event Name: ".$_SESSION['event']['EventName']. "<br>";
    }
	
	if (isset($DeleteEventErrors)) {
		$eventHtml .= '<div style="text-align:center;background:rgba(170,140,140,0.4);color:red;font-size:10pt;">';
		foreach ($DeleteEventErrors as $e) {
			$eventHtml .= $e . "<br/>";
		}
		$eventHtml .= '</div>';
	}    
    return $eventHtml;
} 


function SetDayEvents() {
	$sql = "SELECT level FROM members WHERE userid = ".$_SESSION['userId']." AND groupid = ".$_SESSION['group']['id'];
            
        include "database/connect.php";
        if (!$result = $db_conx->query($sql)) {
            echo "EventName not found. Error = " . $db_conx->error . "<br>";
        }
        else {
            if($result)
            {
                $sqli = "SELECT * from events  WHERE EventDate = '". $_SESSION['year']."-". str_pad($_SESSION['month'], 2, "0", STR_PAD_LEFT)."-".str_pad($_POST['day'], 2, "0", STR_PAD_LEFT)."'";
                $_SESSION['dayEvents'] = array();
                if (!$result = $db_conx->query($sqli)) {
                    
                } else {
                    
                    while ($row = $result->fetch_assoc())
                    {
                        array_push($_SESSION['dayEvents'], $row);
                    }
                     //function to write the html string
                    
                    
                }
        } else {
                echo "bad result";
                die();
            }
        }
}

function SetEventSession() {
	$_SESSION['event'] = array();
        
        foreach ($_SESSION['dayEvents'] as $event) {
            if ($event['EventID'] == $_POST['event']) {
                
                $_SESSION['event'] = array(
				   'EventID' => $_POST['event'],
				   'EventName' => $event['EventName'],
				   'EventDate' => $event['EventDate'],
				   'EventDescription' => $event['EventDescription'],
				   'EventStartTime' => $event['EventStartTime'],
				   'EventEndTime' => $event['EventEndTime'],
				   'EventIsTemp' => $event['EventIsTemp'],
				   'EventHightPriority' => $event['EventHighPriority']
			   );
                
                
                break;
            }
        }
}





function DeleteEvent() {
	//sql to delete the event with event id = whatevers in post deleteform
}

function ModifyEvent() {
	//sql to place all the new input values into the row where eventid whatevers in post modifyform
}
    




?>

