<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" style="color:#fff">
	<fieldset class="sidebarFieldset"><legend>Create Event</legend>
	<div class="AddEventInputField">
	
		<label>Event Name</label>
		<input type="text" name="eventName" placeholder="Event Name"/>
	</div>
	<div class="AddEventInputField">
	
		<label>Date</label>
		
		
	
		<script>
		$(function() {
		
			$( "#datepicker" ).datepicker({
				dateFormat: 'yy-mm-dd'
			});
			

			// Hover states on the static widgets
			$( "#dialog-link, #icons li" ).hover(
				function() {
					$( this ).addClass( "ui-state-hover" );
				},
				function() {
					$( this ).removeClass( "ui-state-hover" );
				}
			);
			
		});
		</script>
		
		
		
		<input id="datepicker" name="eventDate" />
		
	</div>
	<div class="AddEventInputField">
	
		<label>Start Time</label>
		
		<input name="eventStartTime" />
		<script type="text/javascript">
		$(document).ready(function(){
			$('input[name="eventStartTime"]').ptTimeSelect({
				hoursLabel:     'Hour',
				minutesLabel:   'Minutes',
				setButtonLabel: 'OK',
				onFocusDisplay: true,
				zIndex:         9999999
			});
		});
		</script>
		
		
		<!--<input type="time" name="eventStartTime"/><br/>-->
		
	</div>
	<div class="AddEventInputField">
	
		<label>End Time</label>
		
		<input name="eventEndTime"/>
		<script type="text/javascript">
		$(document).ready(function(){
			$('input[name="eventEndTime"]').ptTimeSelect({
				hoursLabel:     'Hour',
				minutesLabel:   'Minutes',
				setButtonLabel: 'OK',
				onFocusDisplay: true,
				zIndex:         9999999
			});
		});
		</script>
	</div>
	<div class="AddEventInputField">
	
		<label>Event Description</label>
		<textarea rows="6" cols="17" name="eventDescription" placeholder="Event Description"></textarea>
		
	</div>
	<div class="AddEventInputField">
		<label>High Priority</label>
		<input type="checkbox" name="eventHP" value="1"/>
		
		<input type="hidden" name="createEventForm" value="1" />
		<input type="submit" value="Add Event" style="margin-left:60px"/>
		
	</div>
	
	<?php if (isset($createEventErrors) && count($createEventErrors > 0)) {
		echo '<div style="text-align:center;background:rgba(170,140,140,0.4);color:red;font-size:10pt;">';
		foreach ($createEventErrors as $cee) {
			echo $cee . "<br/>";
		}
		echo '</div>';
	}
	?>
	
	</fieldset>
</form>

<br/>