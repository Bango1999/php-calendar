<div id="slideout">
  <img src="slideout.png" alt="Events" onclick="slideOut()"/>
  <div id="slideout_inner" class="scroll">

<?php if (isset($_POST['day']) || isset($_POST['event']) || isset($_POST['delete']) || isset($_POST['modifyEvent']) || isset($_POST['modify']) || isset($_POST['approve'])) {
		echo '<div id="showAdd" style="display:none">';
		include_once 'calControl.php';
		echo '</div>';
        $Html = ShowDayOptions();
        echo $Html;
		
		
		
		
		if (isset($deleteEventErrors) && count($deleteEventErrors > 0)) {
			echo '<div style="text-align:center;background:rgba(170,140,140,0.4);color:red;font-size:10pt;">';
			foreach ($deleteEventErrors as $cee) {
				echo $cee . "<br/>";
			}
			echo '</div>';
		}
		if (isset($approveEventErrors) && count($approveEventErrors > 0)) {
			echo '<div style="text-align:center;background:rgba(170,140,140,0.4);color:red;font-size:10pt;">';
			foreach ($approveEventErrors as $cee) {
				echo $cee . "<br/>";
			}
			echo '</div>';
		}
		if (isset($modifyEventErrors) && count($modifyEventErrors > 0)) {
			echo '<div style="text-align:center;background:rgba(170,140,140,0.4);color:red;font-size:10pt;">';
			foreach ($modifyEventErrors as $cee) {
				echo $cee . "<br/>";
			}
			echo '</div>';
		}
		if (isset($createEventErrors) && count($createEventErrors > 0)) {
			echo '<div style="text-align:center;background:rgba(170,140,140,0.4);color:red;font-size:10pt;">';
			foreach ($createEventErrors as $cee) {
				echo $cee . "<br/>";
			}
			echo '</div>';
		}
		
		
		

} else {
	//GROUP CONTROLS
	include_once 'includes/calControl.php';
    
}?>

	</div>
</div>

<script>
function slideOut(out) {
	var slideout = document.getElementById("slideout").style;
	var inner = document.getElementById("slideout_inner").style;
	if (out == '1') {
		slideout.left = "500px";
		inner.left = "0px";
	} else {
	
		if (slideout.left == "500px") {
			slideout.left = "0px";
			inner.left = "-500px";
		} else {
			slideout.left = "500px";
			inner.left = "0px";
		}
	}
}	
</script>

<?php if (isset($_POST['createEventForm']) || isset($_POST['day']) || isset($_POST['event']) || isset($_POST['modifyEvent']) || isset($_POST['modify']) || isset($_POST['delete']) || isset($_POST['approve'])) {?>
	<script>
		slideOut('1');
	</script>
<?php } ?>