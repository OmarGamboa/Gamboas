<?php
include('login3.php'); // Includes Login Script
include('lib/tools.php');

//session_start();
if(isset($_SESSION['login_user'])){
    // To send an email notification.
    $msg =  htmlentities($_SESSION['login_user']) . " acaba de iniciar sesión.";
    $sendTo = 'decidenow@premiostw.co';
    $subject = "Inicio de Sesion en DecideNow";
    sendEmail($msg, $sendTo, $subject);

    
    // Get the IP Address
    $ip = "No IP captured";
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    
    insertLog(htmlentities($_SESSION['id_user']), 1, $ip);

	header("location: mySurveys.php");
	//echo $_SESSION['login_user'];
}

// function sendEmail($msg, $sendTo, $subject){
//     // use wordwrap() if lines are longer than 70 characters
//     $msg = wordwrap($msg,70);

//     // send email
//     mail($sendTo,$subject,$msg);
// }

?>
<!DOCTYPE html>
<html>
	<head>
		<head>
    <link rel="stylesheet" href = "http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="shortcut icon" href="images/favicon.ico" />
    <script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>   

	<title>Ingreso DecideNow Beta</title>
</head>

<div class="container">
<body ng-controller="eventsController">
    <?php include_once("lib/analyticstracking.php") ?>
    <table style="width:100%">
        <tr>
            <td align="center">
                <a href="http://DecideNow.co"><img src="images/DecideNow-Beta.png" width="120"></a>
            </td>
            <td align="right">
            </td>
        </tr>
    </table>
    <br>
    <h3 align="center">Inicia tu sesión</h3>

    <div align="center">
    <div align="center" style="width:300px">
	<form action="" method="post">
		<!-- <input id="name" name="username" placeholder="usuario" type="text" class="form-control"> -->
        <input id="email" name="email" placeholder="correo" type="text" class="form-control">
		<p></p>
		<input id="password" name="password" placeholder="contraseña" type="password" class="form-control">
		<p></p>
		<input name="submit" type="submit" class="btn btn-success" value=" Ingresar ">
		<hr>
		<span><?php echo $error; ?></span>
	</form>
        <h3 align="center">¿No tienes usuario?</h3>
        <a href="register.php"><button class="btn btn-success">
            <span></span>Regístrate
        </button> </a>
    </div>
    </div>
</body>
</div>
</html>