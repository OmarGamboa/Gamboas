<?php
	//*********************************//
	// JSON TO RETURN MESSAGES INFO    //
	// MAR 9TH - 2015                  //
	//*********************************//
	
	header("Access-Control-Allow-Origin: *");
	
	// Includes
	include "db.php";

	// Declaring variables
	$talkID = $_GET['t'];
	// Validation
	if(is_null($talkID))
		$talkID = 0;
	
	$sql = "SELECT messages.*, talks.name AS Talk_Name FROM messages INNER JOIN talks ON messages.Talk_ID = talks.id";
	$where = " WHERE Talk_ID = " . $talkID;
	$order = " ORDER BY MessageDate DESC";
	
	$myArray = array();
	
	// Getting data
	if ($result = $con->query($sql . $where . $order)) {
	
		while($row = $result->fetch_array(MYSQL_ASSOC)) {
				$myArray[] = $row;
		}
		echo json_encode($myArray);
	}
	$result->close();

	// Closing connection
	mysqli_close($con);
	
?>