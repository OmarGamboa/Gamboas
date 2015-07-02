<?php
//**************************************//
// CREATE INFLUENCERS INTERFACE WITH DB //
// DEC 30TH - 2014                      //
//**************************************//

// Includes
include "db.php";
include('tools.php');

// Declaring variables
$sql = 'SELECT * FROM events'; // Default value
$returnMessage = '';

$Event_ID = strval($_GET['i']);
$Name = strval($_GET['n']);
$State = strval($_GET['s']);
$StartDate = strval($_GET['sd']);
$EndDate = strval($_GET['ed']);
$OwnerID = strval($_GET['o']);
$Hashtag = strval($_GET['h']);

// If is New/Old Influencer
if ($Event_ID == 'new') {	
	$sql = 'INSERT INTO events(name, state_id, start_date, end_date, owner_id, hashtag)
			VALUES ("' . $Name
			. '", "' . $State
			. '", "' . $StartDate
			. '", "' . $EndDate
			. '", "' . $OwnerID
			. '", "' . $Hashtag
				. '")';

	$returnMessage = "Nuevo evento creado. Para ver los cambios, refresca la pagina.";

	//Insert log Create Event
	insertLog($OwnerID, 4, "No IP captured.");

} else {
	$sql = 'UPDATE events SET name="' . $Name
			. '", state_id = "'. $State
			. '", start_date = "' . $StartDate
			. '", end_date = "' . $EndDate
			. '", owner_id = "' . $OwnerID
			. '", hashtag = "' . $Hashtag
			. '" WHERE id=' . $Event_ID;
	$returnMessage = "Evento actualizado. Para ver los cambios, refresca la pagina.";
}

// Execute query
if ($con->query($sql) === TRUE) {
	echo $returnMessage;
} else {
	echo "Error: " . $sql . "--->" . $con->error;
}

$con->close();
	
?>