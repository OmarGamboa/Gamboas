<?php 
 /*
 	// Server variables
	$server = "zpanel.premiostw.co";
	$user = "flwent";
	$password = "ypyqate8y";
	$database = "zadmin_flwent";


// Local variables
$server = "localhost";
$user = "root";
$password = "root";
$database = "DecideNow";
*/
 
if(strrpos($_SERVER['HTTP_HOST'],"localhost")  !==  false)
{
	$server 	 = "localhost";
	$user		 = "root";
	$password	 = "root";
	$database	 = "DecideNow";

}
else
{
	$server 	 = "zpanel.premiostw.co";
	$user		 = "decide";
	$password	 = "7anyzuted";
	$database	 = "zadmin_decidenowdata";
}


// Declaring global variable so it can be used outside this file scope
global $con;

$con = mysqli_connect($server, $user, $password, $database);
	
// check connection
if (mysqli_connect_errno()) {
	printf("Fallo en la conexion: %s\n", mysqli_connect_error());
	exit();
}
return $con;

?>