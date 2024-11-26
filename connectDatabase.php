<?php
	if (session_status() === PHP_SESSION_NONE) { //check whether the session already started in the page//
    session_start();
	}

	require_once('config.inc.php'); // connect to database//
	$mysqli = new mysqli(HOST, USER, PASSWORD, DB, PORT);

	if($mysqli->connect_error){
		die('Connect Error');
	}

?>