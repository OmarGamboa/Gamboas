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
        <tr ng-repeat="talk in talks | filter:Filter">
    			<td>
              <button class="btn btn-info" ng-click="editTalk($index + 1)">
    				    <span class="glyphicon glyphicon-pencil"></span>
    				  </button>
          </td>
          <td>{{ talk.name }}</td>
          <td>{{ talk.start_date }}</td>
          <td>{{ talk.end_date }}</td>
          <td>{{ talk.hashtag }}</td>
          <td>{{ talk.twitter_account }}</td>
          <td> <a href="TalkStats.php?t={{talk.id}}"> Ver... </a></td>
        </tr>
      </tbody>
    </table>