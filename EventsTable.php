    <p>Filtrar: <input type="text" ng-model="Filter"></p>
    
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Editar</th>
          <th>Nombre Evento</th>
          <th>Fecha Inicio</th>
          <th>Fecha Finalización</th>
          <th>Hashtag</th>
          <th>Charlas</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="event in events | filter:Filter">
    	  <td>
	    <!--<button class="btn btn-info" ng-click="editEvent(event.id)">-->
              <button class="btn btn-info" ng-click="editEvent($index + 1)"> 
    		<span class="glyphicon glyphicon-pencil"></span>
    	      </button>
          </td>
          <td>{{ event.name }}</td>
          <td>{{ event.start_date }}</td>
          <td>{{ event.end_date }}</td>
          <td>{{ event.hashtag }}</td>
          <td> <a href="myTalks.php?e={{event.id}}"> Ver... </a></td>
        </tr>
      </tbody>
    </table>