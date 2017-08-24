<?php
$stime = microtime(true);
?>
<?php
session_start();

//connect to database. if that fails, die on the spot.
require 'database/connect.php';

//all of our important database functions are in here.
require 'functions/users.php';
require 'functions/general.php';
require 'functions/validate.php';
require 'functions/calendarDisplay.php';


if (isset($_POST['changeGroupForm'])) {
	change_group();
}


include_once "header.php";

//if we get any errors, we can append them to an array, it helps to debug
$errors = array();
?>
