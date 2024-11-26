<?php 
//this file handle the like action from event detail page//
	require_once('connectDatabase.php');
	$newPopularity = $_GET['popularity'] + 1;//get the existing popularity value, add 1//
	$event_id = $_GET['eventID'];  //get the event's ID that the user is viewing//

	$stmt = $mysqli->prepare("UPDATE Events SET popularity = ? WHERE eventID = ?");//access the events table with the event ID//
		$stmt->bind_param("ii", $newPopularity, $event_id);
		$stmt->execute();

		$stmt->close();

		$mysqli -> close();





?>