<?php
    session_start();
    $EventID = $_GET['e'];
    $_SESSION["EventID"] = $EventID;
?>
<!DOCTYPE html>
<html ng-app="">
<head>
    <link rel="stylesheet" href = "http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="shortcut icon" href="images/favicon.ico" />
    <script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
    <title>Mis Charlas</title>

</head>
<?php if(isset($_SESSION['login_user'])) : ?>
<div class="container">
<body ng-controller="talksController">
    <?php include_once("lib/analyticstracking.php") ?>
    <div><br></div>
    <table style="width:100%">
        <tr>
            <td align="left">
                <a href="http://decidenow.co"><img src="images/DecideNow-Beta.png" width="120"></a>
            </td>
            <td valign="top">
                <h4 align="right"><a href="mySurveys.php">Ir a Encuestas (charlas individuales)</a></h4>
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
    <h4 align="left"><a href="myEvents.php">Volver a Mis Eventos</a></h4>
    <h3 align="center">Mis Charlas en "{{talks[0].event_name}}"</h3>
    <div ng-include="'TalksTable.php'"></div>
    
    <hr>
    
    <button class="btn btn-success" ng-click="editTalk('new')">
        <span class="glyphicon glyphicon-user"></span>  Crear nueva charla
    </button>
    <p></p>
    
    <div ng-show="visible">
        <hr>
        <h3 ng-show="edit">Crear nueva charla <font color="#0099FF">{{name}}</font>:</h3>
        <h3 ng-hide="edit">Editar charla <font color="#0099FF"> {{name}} </font>:</h3>
        
        <form class="form-horizontal">
           <div class="form-group" ng-show="false">
            <label class="col-sm-2 control-label">ID:</label>
            <div class="col-sm-10">
             <input type="text" ng-model="id" ng-disabled="true" ng-show="true" placeholder="ID">
            </div>
          </div> 
          <div class="form-group">
            <label class="col-sm-2 control-label">Nombre:</label>
            <div class="col-sm-10">
             <input type="text" ng-model="name" placeholder="Nombre de la charla">
            </div>
          </div> 
          <div class="form-group">
            <label class="col-sm-2 control-label">Fecha Inicio:</label>
            <div class="col-sm-10">
            <input type="text" ng-model="start_date" placeholder="AAAA-MM-DD hh:mm">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Fecha Fin:</label>
            <div class="col-sm-10">
            <input type="text" ng-model="end_date" placeholder="AAAA-MM-DD hh:mm">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Hashtag:</label>
            <div class="col-sm-10">
            <input type="text" ng-model="hashtag" placeholder="Hashtag de la charla">
            </div>
          </div>
	  <div class="form-group">
            <label class="col-sm-2 control-label">Cuenta de Twitter*:</label>
            <div class="col-sm-10">
            <input type="text" ng-model="twitter_account" placeholder="(Opcional)">
            </div>
          </div>
        </form>
        <hr>
        <button class="btn btn-success" ng-disabled="error || incomplete" ng-click="saveTalk(id, <?php echo $_SESSION['id_user']; ?>)">
          <span class="glyphicon glyphicon-save"></span>  Guardar Cambios 
        </button>
        <button class="btn btn-danger" ng-click="cancelChanges('cancel')">
          <span class="glyphicon glyphicon-minus"></span>  Cancelar
        </button>
    </div>
    <hr>
    <div>
        <label class="col-sm-15 a.list-group.item-success" align="center">{{ result }}</label>
	<label class="col-sm-15 a.list-group.item-success" align="center">{{ eventID }}</label>
    </div>
    <button class="btn btn-warning" ng-show="newData" ng-click="loadData('reload')">
        <span class="glyphicon glyphicon-refresh"></span>  Refrescar
    </button>
    <br>
    <hr>

    <script src="js/myTalks.js"></script>
    
<?php else : ?>
	<p>
	    <img src="images/DecideNow-Beta.png" width="120">
		<h3><span class="error">Usted no está autorizado para ver esta pagina.</span> Por favor <a href="login.php">ingrese</a>.
	</p>
<?php endif; ?>
    </div>
</body>
</html>
