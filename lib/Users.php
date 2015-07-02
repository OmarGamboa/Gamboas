<?php
//**************************************//
// CREATE USERS INTERFACE WITH DB       //
// MAR 26TH - 2015                      //
//**************************************//

// Includes
include "db.php";
include 'tools.php';

// Declaring variables
$sql = 'SELECT * FROM members'; // Default value
$returnMessage = '';

//$userID = strval($_GET['u']);
$name = ($_GET['n']);
$email = strval($_GET['e']);
$password = strval($_GET['p']);
$country = strval($_GET['c']);
$ip = strval($_GET['ad']);

// If is New/Old Influencer
//if ($userID == 'new') {	
$sql = 'INSERT INTO members(username, email, password, state, country)
		VALUES ("' . $name
		. '", "' . $email
		. '", "' . $password
		. '", "1'
		. '", "' . $country
			. '")';

$returnMessage = "Tu usuario fue creado.";

// } else {
// 	$sql = 'UPDATE events SET name="' . $Name
// 			. '", state_id = "'. $State
// 			. '", start_date = "' . $StartDate
// 			. '", end_date = "' . $EndDate
// 			. '", owner_id = "' . $OwnerID
// 			. '", hashtag = "' . $Hashtag
// 			. '" WHERE id=' . $Event_ID;
// 	$returnMessage = "Evento actualizado. Para ver los cambios, refresca la pagina.";
// }

// Execute query
if ($con->query($sql) === TRUE) {
	// To send an email notification.
    $msg =  "Se acaba de registrar el usuario:\n" . $name . "\n\nDe:\n" . $country;
    $sendTo = "decidenow@premiostw.co";
    $subject = "Nuevo usuario registrado en DecideNow";
    sendEmail($msg, $sendTo, $subject);
    
    insertLog(0, 5, $ip);

	echo $returnMessage;
} else {
	echo "Error: " . $sql . "--->" . $con->error;
}

$con->close();
	
?>