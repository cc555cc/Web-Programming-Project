<?php
	require_once('connectDatabase.php');//connect to database//

	$guest_id = $_SESSION['Logined_In_User']['userID'];  //get the user's ID from session//
	$event_id = $_GET['eventID'];  //get the event's ID that the user is viewing//

	if(!in_array($guest_id,$guestIDList) && $guest_id != $userID ){//check if the current user's id is already in the list//
		$guestIDList[] = $guest_id;//add user's id into the guest list//
		$newJSONGuestArray = json_encode($guestIDList); //turn the list into JSON//

		$stmt = $mysqli->prepare("UPDATE Events SET guestIDs = ? WHERE eventID = ?");//access the events table with the event ID//
		$stmt->bind_param("si", $newJSONGuestArray, $event_id);

		if ($stmt->execute()) {
    		echo "<script>alert('You are added to the guest list!');</script>";//confirm that user is registered in the event//
		} else {
    		echo "Error: " . $stmt->error;
		}

		$stmt->close();

		$mysqli -> close();
	}else{
		//reject the request//
		if($guest_id == $userID){
			echo "<script>alert('You cannot join your own event');</script>";
		}else{
			echo "<script>alert('You are already in the guest list');</script>";
		}
		
	}
?>