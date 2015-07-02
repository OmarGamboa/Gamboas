    <p>Filtrar: <input type="text" ng-model="Filter"></p>
    
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Editar</th>
          <th>Nombre Charla</th>
          <th>Fecha Inicio</th>
          <th>Fecha Finalización</th>
          <th>Hashtag</th>
	        <th>Cuenta de Twitter</th>
          <th>Graficos</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="survey in surveys | filter:Filter">
    			<td>
              <button class="btn btn-info" ng-click="editSurvey($index + 1)">
    				    <span class="glyphicon glyphicon-pencil"></span>
    				  </button>
          </td>
          <td>{{ survey.name }}</td>
          <td>{{ survey.start_date }}</td>
          <td>{{ survey.end_date }}</td>
          <td>{{ survey.hashtag }}</td>
          <td>{{ survey.twitter_account }}</td>
          <td> <a href="SurveyStats.php?t={{survey.id}}"> Ver... </a></td>
        </tr>
      </tbody>
    </table>