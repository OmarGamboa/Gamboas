<?php
session_start();
?>
<!DOCTYPE html>
<html ng-app="">
<head>
    <link rel="stylesheet" href = "http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="shortcut icon" href="images/favicon.ico" />
    <script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>   
<title>Mis Encuestas</title>

</head>
<?php if(isset($_SESSION['login_user'])) : ?>
<div class="container">
<body ng-controller="surveysController">
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
                        <span class="glyphicon glyphicon-th"></span>  Cerrar sesion
                    </button> </a>
                    <h3> <p>Hola <?php echo htmlentities($_SESSION['login_user']); ?>!</p> </h3>
                </div>
            </td>
        </tr>
    </table>
    <br>
    <h3 align="center">Mis Encuestas/Charlas</h3>
    <div ng-include="'SurveysTable.php'"></div>
    <hr>
    <button class="btn btn-success" ng-click="editSurvey('new')">
        <span class="glyphicon glyphicon-user"></span>  Crear nueva encuesta
    </button>
    <p></p>
    
    <div ng-show="visible">
        <hr>
        <h3 ng-show="edit">Crear nueva encuesta <font color="#0099FF">{{name}}</font>:</h3>
        <h3 ng-hide="edit">Editar encuesta <font color="#0099FF">{{name}}</font>:</h3>
        
        <form name="surveyform" class="form-horizontal">
           <div class="form-group" ng-show="false">
            <label class="col-sm-2 control-label">ID:</label>
            <div class="col-sm-10">
             <input type="text" ng-model="id" ng-disabled="true" ng-show="true" placeholder="ID">
            </div>
          </div> 
          <div class="form-group">
            <label class="col-sm-2 control-label">Nombre:</label>
            <div class="col-sm-10">
             <input type="text" ng-model="name" placeholder="Nombre de la encuesta">
            </div>
          </div> 
          <div class="form-group">
            <label class="col-sm-2 control-label">Fecha Inicio:</label>
            <div class="col-sm-10">
                <input name="start_date" type="text" ng-model="start_date" placeholder="AAAA-MM-DD hh:mm" >
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
            <input type="text" ng-model="hashtag" placeholder="Hashtag de la Encuesta">
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
        <button class="btn btn-success" ng-disabled="error || incomplete" ng-click="saveSurvey(id, <?php echo $_SESSION['id_user']; ?> )">
            <span class="glyphicon glyphicon-save"></span>  Guardar Cambios
        </button>
        <button class="btn btn-danger" ng-click="cancelChanges('cancel')">
            <span class="glyphicon glyphicon-minus"></span>  Cancelar
        </button>
    </div>
    <hr>
    <div>
        <label class="col-sm-15 a.list-group.item-success" align="center">{{ result }}</label>
    </div>
    <button class="btn btn-warning" ng-show="newData" ng-click="loadData('reload')">
        <span class="glyphicon glyphicon-refresh"></span>  Refrescar
    </button>
    <br>
    <hr>

	<script src="js/mySurveys.js"></script>

<?php else : ?>
	<p>
	    <img src="images/DecideNow-Beta.png" width="120">
		<h3><span class="error">Usted no está autorizado para ver esta pagina.</span> Por favor <a href="login.php">ingrese</a>.
	</p>
<?php endif; ?>
    </div>
</body>
</html>
