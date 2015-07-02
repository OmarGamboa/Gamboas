<?php

// Variable de control
$varDisplay = "";
$varName = "";
$varEmail = "";
$varPassword = "";
$varPassword2 = "";
$varCountry = "";

$errorMessage = "";
$message = "";

// Funcion POST
function do_post_request($url, $data, $optional_headers = null)
{
    $params = array('http' => array(
            'method' => 'POST',
            'content' => $data
        ));
    if ($optional_headers !== null) {
        $params['http']['header'] = $optional_headers;
    }
    $ctx = stream_context_create($params);
    $fp = @fopen($url, 'rb', false, $ctx);
    if (!$fp) {
        throw new Exception("Problem with $url, $php_errormsg");
    }
    $response = @stream_get_contents($fp);
    if ($response === false) {
        throw new Exception("Problema leyendo info de $url, $php_errormsg");
    }
    return $response;
}

// Validacion de Post
if(isset($_POST['submit'])){
    if($_POST['submit'] == " Enviar ") 
    {
        // Init Variables
        $varSite = "http://localhost/DecideNow";
        // $varSite = "http://DecideNow.co";
        $varPage = "/lib/Users.php";

        if(isset($_POST['username'])){
            $varName = $_POST['username'];
        }
        if(isset($_POST['email'])){
            $varEmail = $_POST['email'];
        }
        if(isset($_POST['password'])){
            $varPassword = $_POST['password'];
        }
        if(isset($_POST['password2'])){
            $varPassword2 = $_POST['password2'];
        }
        if(isset($_POST['countries'])){
            $varCountry = $_POST['countries'];
        }
       
        $errorMessage = "";
        $message = "";
        
        // Variable Validation
        if(empty($varName)) {
          $errorMessage .= "<li>¡Olvidaste escribir tu nombre de usuario!</li>";
        }
        if(empty($varEmail)) {
          $errorMessage .= "<li>¡Olvidaste escribir tu correo!</li>";
        }
        else if(!filter_var($varEmail, FILTER_VALIDATE_EMAIL)) {
          $errorMessage .= "<li>¡El correo no es válido!</li>";
        }
        
        if(empty($varPassword)) {
          $errorMessage .= "<li>¡Olvidaste escribir tu contraseña!</li>";
        }
        elseif(empty($varPassword2)) {
          $errorMessage .= "<li>¡Olvidaste confirmar tu contraseña!</li>";
        }
        elseif($varPassword != $varPassword2) {
          $errorMessage .= "<li>¡Las contraseñas no coinciden!</li>";
        }

        if(empty($varCountry)) {
          $errorMessage .= "<li>¡Olvidaste indicar tu país!</li>";
        }

        // Get the IP Address
        $ip = "No IP captured";
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $varParams = "?n=" . $varName .
                "&e=" . $varEmail .
                "&p=" . $varPassword .
                "&c=" . $varCountry .
                "&ad=" . $ip;

        // IF NO ERROR - SAVE
        if (empty($errorMessage)){
            $varDisplay = 'style="display:none;"';
            $message = do_post_request($varSite . $varPage . $varParams, "");
            if (strpos(strtolower($message), "error"))
            {
                $errorMessage = $message;
            }
            else
            {
                header("Location: " . $varSite . "/confirmation.php");
            }
        }
    }
}


?>
<!DOCTYPE html>
<html ng-app="">
    <head>
    <link rel="stylesheet" href = "http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="shortcut icon" href="images/favicon.ico" />
    <script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>

    <title>Registro DecideNow Beta</title>
</head>

<div class="container">
<body ng-controller="usersController">
    <?php include_once("lib/analyticstracking.php") ?>
    <table style="width:100%">
        <tr>
            <td align="center">
                <a href="http://DecideNow.co"> <img src="images/DecideNow-Beta.png" width="120"> </a>
            </td>
            <td align="right">
            </td>
        </tr>
    </table>
    <br>
    <div align="center" >
            <div style="width:300px">
                <div <?php echo $varDisplay; ?> > 
                    <h3>Regístrate</h3>
                    <form name="userform" action="" method="post">
                        <input id="name" name="username"  placeholder="usuario" type="text" class="form-control" ng-model="username" value="<?php echo $varName; ?>">
                        <p></p>
                        <input id="email" name="email" placeholder="correo" type="text" class="form-control" ng-model="email" value="<?php echo $varEmail; ?>">
                        <p></p>
                        <input id="password" name="password" placeholder="contraseña" type="password" class="form-control" ng-model="password">
                        <p></p>
                        <input id="password2" name="password2" placeholder="repite contraseña" type="password" class="form-control" ng-model="password2">
                        <p></p>
                        <input list="countries" name="countries" placeholder="país" class="form-control" ng-model="country" value="<?php echo $varCountry; ?>">
                            <?php include "lib/paises.html"; ?>
                        <p></p>
                        <input name="submit" type="submit" class="btn btn-success" value=" Enviar ">
                        <hr>                
                    </form>
                    <h3>¿Ya tienes usuario?</h3>
                    <a href="login.php"><button class="btn btn-success">
                        <span></span>Ingresa
                    </button> </a>
                </div>
                <span align="left"><?php echo $errorMessage; echo $message; ?> </span>
        </div>
    </div>
    
</body>
</div>
</html>