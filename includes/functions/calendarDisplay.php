<?php
//-----------------------------------------------------#!
//CALENDAR FUNCTIONS


//_-_-_-_-_-_-_
//draw controls
function draw_controls( $month, $year ) {
//this function was taken online and modified to use POST

	/* select month control */
	$select_month_control = '<select name="month" id="month">';
	for($x = 1; $x <= 12; $x++) {
		$select_month_control.= '<option value="'.$x.'"'.($x != $month ? '' : ' selected="selected"').'>'.date('F',mktime(0,0,0,$x,1,$year)).'</option>';
	}
	$select_month_control.= '</select>';

	/* select year control */
	$year_range = 5;
	$select_year_control = '<select name="year" id="year">';
	for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
		$select_year_control.= '<option value="'.$x.'"'.($x != $year ? '' : ' selected="selected"').'>'.$x.'</option>';
	}
	$select_year_control.= '</select>';

	/* "next month" control */
	$next_month_link = '<input type="hidden" name="month" value="' . ($month != 12 ? $month + 1 : 1) . '" />';
	$next_month_link .= '<input type="hidden" name="year" value="' . ($month != 12 ? $year : $year + 1) . '" />';
	$next_month_link .= '<input type="submit" value="Next Month ->" />';

	/* "previous month" control */
	$previous_month_link = '<input type="hidden" name="month" value="' . ($month != 1 ? $month - 1 : 12) . '" />';
	$previous_month_link .= '<input type="hidden" name="year" value="' . ($month != 1 ? $year : $year - 1) . '" />';
	$previous_month_link .= '<input type="submit" value="<- Prev Month" />';
	
	//$previous_month_link = '<a href="?month='.($month != 1 ? $month - 1 : 12).'&year='.($month != 1 ? $year : $year - 1).'" class="control"><< 	Previous Month</a>';

	/* bringing the controls together */
	$controls = '<div id="controlBar"><span style="margin:0 auto">';
	$controls .= '<form method="post" class="calFormInterface">'.$select_month_control.$select_year_control.'<input type="submit" name="submit" value="Go" /></form>';
	$controls .= '<form method="post" class="calFormInterface">'. $previous_month_link.'</form>';
	$controls .= '<form method="post" class="calFormInterface">'. $next_month_link.' </form>';
		// $controls .= '<form action="'. $_SERVER['PHP_SELF'] . '" method="post" style="position: relative;display: inline;float: right;z-index:100;margin:0;padding:0">';
		// $controls .= '<div style="position: relative;display: inline;float: left;z-index:100;">';
			//$controls .= '<span style="display: block;background: #414141;color: white;padding: 8px 10px;border-right: 1px solid #778;text-decoration: none;">Change Group (template form: NOT WORKING):</span></div>';
			// $controls .= '<select name="groups" style="display:inline;vertical-align:middle">';
			//populate the groups dropdown
			// foreach ($_SESSION['groups'] as $g) {
				// $controls .= '<option value="'.$g['id'].'"';
				
				// if ($_SESSION['group']['name'] == $g['name']) {
					// $controls .= ' selected="selected" ';
				// }
				 // $controls .= '>'.$g['name'].'</option>';
			// }
		// $controls .= '</select><input type="hidden" name="changeGroupForm" value="1" /><input type="submit" value="Switch Me" style="display:inline-block;width:100px;vertical-align:middle" /></div></form>';
	$controls .= '</span></div>';

	return $controls;
}


//_-_-_-_-_-_-_
//draw calendar
function draw_calendar($month,$year){
//this function was taken online and modified for stylization, event display, and linking to a function that displays the events for the selected day

	date_default_timezone_set('America/Chicago');
	/* draw table */
	$calendar = '<table id="calTable">';

	/* table headings */
	$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td 
class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
	
		$calendar .= '<td class="calendar-day">';
		
			/* add in the day number */
			$calendar .= '<div class="day-number" onclick="AddDate(\''.$_SESSION['year']."-".sprintf("%02s", $_SESSION['month'])."-".sprintf("%02s",$list_day).'\');slideOut(\'1\');showAddForm()">'.$list_day.'</div>';
			
			$calendar .= '<div class="calEventsDiv">';
			
			//checking if any of these events have temp, 
				$numEvents = 0;
				$hastemp = false;
				if (isset($_SESSION['events']) && count($_SESSION['events']) > 0) {
					foreach ($_SESSION['events'] as $listEvent) {
						$eventYear = substr($listEvent['EventDate'], 0, 4);
						$eventMonth = substr($listEvent['EventDate'], 5, 2);
						$eventDay = substr($listEvent['EventDate'], 8, 2);
						if ((int)$eventYear == $_SESSION['year'] && (int)$eventMonth == $_SESSION['month'] && (int)$eventDay == $list_day) {
							if ($listEvent['EventIsTemp'] == 1) {
								$hastemp = true;
								break;
							}
						}
					}
					
					if (($_SESSION['group']['level'] == 0 || $_SESSION['group']['level'] == 1) && $hastemp) {
						$calendar .= '<p class="calendarCellEvent tempsFlag" onclick="SendForm(\''.$list_day.'\')">>>> Approve Events! <<<</p>';
					}

					foreach ($_SESSION['events'] as $listEvent) {
						$eventYear = substr($listEvent['EventDate'], 0, 4);
						$eventMonth = substr($listEvent['EventDate'], 5, 2);
						$eventDay = substr($listEvent['EventDate'], 8, 2);
						if ((int)$eventYear == $_SESSION['year'] && (int)$eventMonth == $_SESSION['month'] && (int)$eventDay == $list_day) {
							if ($listEvent['EventIsTemp'] == 0) {
								$numEvents++;
								
								if ($numEvents < 4) {
								
									$calendar .= '<p class="calendarCellEvent" onclick="SendForm(\''.$list_day.'\')">';
									if ($listEvent['EventHighPriority'] == 1) {
									$calendar .= '<span style="font-weight:bold">';
									}
									if (strlen($listEvent['EventName']) > 15) {
										$calendar .= substr($listEvent['EventName'],0,15). '...<br/>';
									} else {
										$calendar .= $listEvent['EventName'] . '<br/>';
									}
									if ($listEvent['EventHighPriority'] == 1) {
										$calendar .= '</span>';
									}
									$calendar .= substr($listEvent['EventStartTime'],0,5).'-'.substr($listEvent['EventEndTime'],0,5).'</p>';
								
								} else {
									$calendar .= '<p class="calendarCellEvent" onclick="SendForm(\''.$list_day.'\')" style="height:26px;"><span style="vertical-align:-webkit-baseline-middle">Click to see all</span></p>';
									break;
								}
							}
							
						}
					}
			}
			$calendar .= '</div>';
			
		$calendar.= '</td>';
		
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
				$days_in_this_week = 0;
			endif;
			$running_day = -1;
			//$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';
	
	
	/* all done, return result */
	return $calendar;
}

?>