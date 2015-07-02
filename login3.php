<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
	// if (empty($_POST['username']) || empty($_POST['password'])) {
	if (empty($_POST['email']) || empty($_POST['password'])) {
		$error = "Correo o clave invalidos.";

	}
	else
	{
		// Includes
		//include "lib/db.php";
		
		//// Local variables
		//$server = "localhost";
		//$user = "sec_user";
		//$password = "eKcGZr59zAa2BEWU";
		//$database = "VotosJurado";

		// $server = "localhost";
		// $user = "root";
		// $password = "root";
		// $database = "DecideNow";

	 	// Server variables
		// $server = "zpanel.premiostw.co";
		// $user = "flwent";
		// $password = "ypyqate8y";
		// $database = "zadmin_flwent";
		
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
	
		$con = mysqli_connect($server, $user, $password, $database);
		
		// check connection
		if (mysqli_connect_errno()) {
			printf("Fallo en la conexion: %s\n", mysqli_connect_error());
			exit();
		}
		
		// Define $username and $password
		// $username=$_POST['username'];
		$email=$_POST['email'];
		$password=$_POST['password'];
		
		// Establishing Connection with Server by passing server_name, user_id and password as a parameter
		//$connection = mysql_connect("localhost", "sec_user", "");
		
		// To protect MySQL injection for Security purpose
		// $username = stripslashes($username);
		$email = stripslashes($email);
		$password = stripslashes($password);
		// $username = mysqli_real_escape_string($username);
		// $password = mysqli_real_escape_string($password);
		
		// $error = $password;
		//$myArray = array();


		$sql = "select * from members where password='$password' AND email='$email'"; // Localhost
		// $sql = "select * from Jurados where password='$password' AND username='$email'"; // Server
		
		//$error = $sql;
		// Getting data
		if ($result = $con->query($sql))
		{
			if (mysqli_num_rows($result) == 1) {
				while($row = $result->fetch_array(MYSQL_ASSOC)) {
					$_SESSION['login_user'] = $row['username']; // Initializing Session User Name
					$_SESSION['id_user'] = $row['id']; // Initializing Session User ID
				}
				header("location: mySurveys.php"); // Redirecting To Main Page
			}
			else
			{
				$error = "Correo o clave equivocados.";
			}
			$result->close();
		}		
		else
		{
			$error = "Error de conexion a la base de datos.";
		}
	
		// Closing connection
		mysqli_close($con);
	}
}
?>