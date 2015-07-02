<?php
	//session_start();
	include "lib/db.php";
	
	//$talkID = 'Not set';
	$GraphicID = 'Not set';
	
	if ($_POST['go'])
	{
	    //$_SESSION['TalkID'] = $_POST['SelectTalks'];
	    $_SESSION['GraphicID'] = $_POST['SelectGraph'];
		$GraphicID = $_SESSION['SelectGraph'];
		header('Location: Chart.php');
		//$_SESSION['TalkID'] = $_GET['t'];
	}
	else
	{
		$_SESSION['GraphicID'] = 0;
		$_SESSION['TalkID'] = 0;
	}
?>
<html>
<head>
</head>
<body>
	<!--<form action="#" method="post">-->
    <form method="post">
    <div>Grafica:
        <select  name="SelectGraph">
		<option value="0" <?php if($_SESSION['GraphicID'] == 0) echo " selected"; ?> > -- Escoge una grafica --</option>
		<option value="1" <?php if($_SESSION['GraphicID'] == 1) echo " selected"; ?> > Usuarios mas activos</option>
		<option value="2" <?php if($_SESSION['GraphicID'] == 2) echo " selected"; ?> > Palabras mas frecuentes</option>
		<option value="3" <?php if($_SESSION['GraphicID'] == 3) echo " selected"; ?> > Hashtag mas usados</option>
		<option value="4" <?php if($_SESSION['GraphicID'] == 4) echo " selected"; ?> > Influenciadores</option>
        </select>
	
    </div>
    <div>
	<br>
    	<input class="btn btn-info" type="submit" name="go" value="Cambiar grafica"/>
    </div>
    </form>
</body>
</html>