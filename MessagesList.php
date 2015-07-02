<?php
  session_start();
  $TalkID = 0;
  if (isset($_SESSION["TalkID"]))
    $TalkID = $_SESSION["TalkID"];

?>
<!DOCTYPE html>
<html ng-app="">
<head>
    <link rel="stylesheet" href = "http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="shortcut icon" href="images/favicon.ico" />
    <script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
    <title>Detalle</title>

</head>
<?php if(isset($_SESSION['login_user'])) : ?>
<div class="container">
<body ng-controller="messagesController">
    <?php include_once("lib/analyticstracking.php") ?>
    <div><br></div>
    <table style="width:100%">
        <tr>
            <td align="left">
                <a href="http://decidenow.co"><img src="images/DecideNow-Beta.png" width="120"></a>
            </td>
            <td align="right">
                <div align="right">
                    <a href="lib/logout.php"><button class="btn btn-success" ng-click="Go('/lib/logout.php')">
                        <span class="glyphicon glyphicon-th"></span>  Cerrar sesion
                    </button> </a>
                    <h3> <p>Hola <?php echo htmlentities($_SESSION['login_user']); ?>!</p> </h3>
                </div>
            </td>
        </tr>
    </table>
    <br>
    <h4 align="left"><a href="TalkStats.php?t=<?php echo $TalkID; ?>">Volver a Graficas</a></h4>
    <h3 align="center">Detalle</h3>

    <p>Filtrar: <input type="text" ng-model="Filter"></p>
    
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Usuario</th>
          <th>Mensaje</th>
          <th>Fecha</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="message in messages | filter:Filter">
          <td><a href="http://twitter.com/{{ message.ScreenNameUser }}" target="_blank">@{{ message.ScreenNameUser }}</a></td>
          <td>{{ message.Text }}</td>
          <td><a href="http://twitter.com/{{ message.ScreenNameUser }}/status/{{ message.TweetID }}" target="_blank">{{ message.MessageDate }}</a></td>
        </tr>
      </tbody>
    </table>

        <script src="js/myMessages.js"></script>
    
<?php else : ?>
  <p>
      <img src="images/DecideNow-Beta.png" width="120">
    <h3><span class="error">Usted no está autorizado para ver esta pagina.</span> Por favor <a href="login.php">ingrese</a>.
  </p>
<?php endif; ?>
    </div>
</body>
</html>