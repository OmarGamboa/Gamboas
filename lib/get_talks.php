<?php
	//*********************************//
	// JSON TO RETURN EVENTS INFO      //
	// FEB 13TH - 2015                 //
	//*********************************//
	
	header("Access-Control-Allow-Origin: *");
	
	// Includes
	include "db.php";
	
	// Declaring variables
	$eventID = $_GET['e'];
	// Validation
	if(is_null($eventID))
		$eventID = 0;
	
	$sql = "SELECT talks.*, events.name AS event_name FROM talks INNER JOIN events ON talks.event_id = events.id";
	$where = " WHERE event_id = " . $eventID;
	
	$myArray = array();
	
	// Getting data
	if ($result = $con->query($sql . $where)) {
	
		while($row = $result->fetch_array(MYSQL_ASSOC)) {
				$myArray[] = $row;
		}
		echo json_encode($myArray);
	}
	$result->close();

	// Closing connection
	mysqli_close($con);
?>