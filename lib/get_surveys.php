<?php
	//*********************************//
	// JSON TO RETURN EVENTS INFO      //
	// FEB 13TH - 2015                 //
	//*********************************//
	
	header("Access-Control-Allow-Origin: *");
	
	session_start();
	// $userID = 0;
	if (isset($_SESSION['id_user'])) {
		$userID = ($_SESSION['id_user']);
	}
	
	//$userID = 1;
	
	// Includes
	include "db.php";
	
	// Declaring variables
	$sql = "SELECT * FROM talks WHERE event_id = 0 AND owner_id = " . $userID;
	$myArray = array();
	
	// Getting data
	if ($result = $con->query($sql)) {
	
		while($row = $result->fetch_array(MYSQL_ASSOC)) {
				$myArray[] = $row;
		}
		echo json_encode($myArray);
	}
	$result->close();

	// Closing connection
	mysqli_close($con);
?>