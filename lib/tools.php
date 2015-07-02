<?php 
 //**************************************//
// TOOLS INTERFACE WITH DB               //
// JUN 3RD - 2015                        //
//***************************************//

// Basic Send Email function
function sendEmail($msg, $sendTo, $subject){
    // use wordwrap() if lines are longer than 70 characters
    $msg = wordwrap($msg,70);

    // send email
    mail($sendTo,$subject,$msg);
}

// Log User Activity
function insertLog($userID, $logStatus, $ipAddress){
// Includes
include 'db.php';

$sql = 'INSERT INTO log_usersActivity(user_id, log_status, ip_address)
		VALUES ("' . $userID
		. '", "' . $logStatus
		. '", "' . $ipAddress
		. '")';

// Execute query
if ($con->query($sql) === TRUE) {
	// echo $returnMessage;
} else {
	echo "Error: " . $sql . "--->" . $con->error;
}

// $con->close();

}


// Declaring global variable so it can be used outside this file scope
// global $con;
// $con = mysqli_connect($server, $user, $password, $database);
	
// check connection
// if (mysqli_connect_errno()) {
// 	printf("Fallo en la conexion: %s\n", mysqli_connect_error());
// 	exit();
// }
// return $con;

?>