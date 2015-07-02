<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	// Start the session
	session_start();
	
	$talkID = $_GET['t'];
	$_SESSION["TalkID"] = $talkID;
	
	include "lib/db.php";
	$GraphicID = 0;

	if (isset($_POST['go']))
	{
	    $_SESSION['GraphicID'] = $_POST['SelectGraph'];
		$GraphicID = $_SESSION['GraphicID'];
	}
	
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href = "http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="shortcut icon" href="images/favicon.ico" />    
<title>Survey Stats - DecideNow</title>
</head>
<?php if(isset($_SESSION['login_user'])) : ?>
<div class="container">
<body>
	<?php include_once("lib/analyticstracking.php") ?>
<div><br></div>
    <table style="width:100%">
        <tr>
            <td align="left">
                <a href="http://decidenow.co"><img src="images/DecideNow-Beta.png" width="120"></a>
            </td>
            <td valign="top">
                <h4 align="right"><a href="myEvents.php">Ir a Eventos (grupos de charlas)</a></h4>
            </td>
            <td align="right">
                <div align="right">
                    <a href="lib/logout.php"><button class="btn btn-success" ng-click="Go('/lib/logout.php')">
                        <span class="glyphicon glyphicon-th"></span>  Cerrar sesion
                    </button> </a>
                    <h3> <p>Hola <?php echo htmlentities($_SESSION['login_user']); ?>!</p> </h3>
                </div>
            </td>
        </tr>
    </table>
    <br>
    <h4 align="left"><a href="mySurveys.php">Volver a Encuestas</a> </h4>
	<h3 align="center">Graficas Encuesta</h3>
	<div>
		<table style="width:100%">
			<tr>
				<td align="left">
				    <form method="post">
					    <div>Grafica:
					        <select  name="SelectGraph">
							<option value="0" <?php if($GraphicID == 0) echo " selected"; ?> > -- Escoge una grafica --</option>
							<option value="1" <?php if($GraphicID == 1) echo " selected"; ?> > Usuarios mas activos</option>
							<option value="2" <?php if($GraphicID == 2) echo " selected"; ?> > Palabras mas usadas</option>
							<option value="3" <?php if($GraphicID == 3) echo " selected"; ?> > Hashtag mas usados</option>
							<option value="4" <?php if($GraphicID == 4) echo " selected"; ?> > Influenciadores</option>
					        </select>
					    </div>
					    <div>
							<br>
					    	<input class="btn btn-info" type="submit" name="go" value="Cambiar grafica"/>
					    </div>
				    </form>
				</td>
				<td align="right">
					<a href="MessagesList.php?t=<?php echo $talkID; ?>">
						<button class="btn btn-success">
                        	<span class="glyphicon glyphicon-th"></span>  Detalle Mensajes
                    	</button>
                	</a>
				</td>	
		    </tr>
	    </table>
	</div>
<hr>
<div>
	<?php
        include 'Chart.php';
	?>
</div>
</body>
</div>
<?php else : ?>
	<p>
	    <img src="images/DecideNow-Beta.png" width="120">
		<h3><span class="error">Usted no esta autorizado para ver esta pagina.</span> Por favor <a href="login.php">ingrese</a>.
	</p>
<?php endif; ?>
</html>