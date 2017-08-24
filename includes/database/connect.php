<?php
$db_conx = new mysqli("localhost", "bango", "pass", "db");
/*
  Database name: db
  user: bango
  pass: pass
*/

// Evaluate the connection
if ($db_conx->connect_errno > 0) {
   echo 'Unable to connect to database [' . $db_conx->connect_error . ']';
   die();
}
?>
