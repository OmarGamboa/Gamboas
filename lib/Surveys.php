<?php
//**************************************//
// CREATE SURVEYS INTERFACE WITH DB     //
// JUN 12TH - 2015                      //
//**************************************//

// Includes
include 'db.php';
include 'tools.php';

// Declaring variables
$sql = 'SELECT * FROM talks'; // Default value
$returnMessage = '';

$Talk_ID = strval($_GET['i']);
$Name = strval($_GET['n']);
$State = strval($_GET['s']);
$StartDate = strval($_GET['sd']);
$EndDate = strval($_GET['ed']);
$Hashtag = strval($_GET['h']);
$TW_Account = strval($_GET['ta']);
$OwnerID = strval($_GET['o']);

// If is New/Old Influencer
if ($Talk_ID == 'new') {
	$sql = 'INSERT INTO talks(name, owner_id, state_id, start_date, end_date, event_id, hashtag, twitter_account)
			VALUES ("' . $Name
			. '", "' . $OwnerID
			. '", "' . $State
			. '", "' . $StartDate
			. '", "' . $EndDate
			. '", "' . "0"
			. '", "' . $Hashtag
			. '", "' . $TW_Account
				. '")';
	$returnMessage = "Nueva charla/encuesta creada. Para ver los cambios, refresca la pagina.";	

	// To send an email notification.
    // $msg =  htmlentities($_SESSION['login_user']) . " acaba de crear una charla.";
    $msg =  "Se acaba de crear la encuesta:\n" . $Name . "\n\nCon el hashtag:\n#" . $Hashtag;
    $sendTo = "decidenow@premiostw.co";
    $subject = "Encuesta creada en DecideNow";
    
    sendEmail($msg, $sendTo, $subject);

    //Insert log Create Talk
	insertLog($OwnerID, 6, "No IP captured.");

} else {
	$sql = 'UPDATE talks SET name="' . $Name
			. '", state_id = "'. $State
			. '", start_date = "' . $StartDate
			. '", end_date = "' . $EndDate
			. '", hashtag = "' . $Hashtag
			. '", twitter_account = "' . $TW_Account
			. '" WHERE id=' . $Talk_ID;
	$returnMessage = "Charla/Encuesta actualizada. Para ver los cambios, refresca la pagina.";
}

// Execute query
if ($con->query($sql) === TRUE) {
	echo $returnMessage;
} else {
	echo "Error: " . $sql . "--->" . $con->error;
}

$con->close();
	
?>