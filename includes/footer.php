<div style="clear:both" id="calendarFooter">
<center>
<?php

if (isset($stime)) {
echo 'Page generated in '.number_format((microtime(true) - $stime)*1000000, 
0).' 
 &micro;s.';
}
?>
<br/ >
<a href="info.php">phpInfo</a></center>
</div>
</div>
</body>
</html>
