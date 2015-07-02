//-----------------------------//
// Events Controller 1.0       //
// DecideNow                   //
// February 13 - 2015          //
//-----------------------------//

function eventsController($scope,$http) {
	// Variables Declaration

	// var site = "http://decidenow.co";
	var site = "http://localhost/DecideNow";
	var page = "/lib/get_events.php";
	
	$scope.edit = false; // To enable/disable controls
	$scope.visible = false; // Used to show/hide edit controls
	$scope.error = false;
	$scope.incomplete = false; // To control missing info
	$scope.result = ''; // To retrieve the Database operation result
	$scope.newData = false;
	
	$http.get(site + page)
  		.success(function(response) {$scope.events = response;});	
	
	// FUNCTION EDIT EVENT BUTTON
	$scope.editEvent = function(index) {

		if (index == 'new') {
			$scope.edit = true;
			$scope.incomplete = true;
			$scope.name = '';
			$scope.state_id = 0; // Initial State
			$scope.start_date = '';
			$scope.end_date = '';
			$scope.owner_id = ''; // CHECK THIS!
			$scope.hashtag = '';
			$scope.id = 'new';
			} else {
			$scope.edit = false;
			$scope.name = $scope.events[index-1].name;
			$scope.state_id = $scope.events[index-1].state_id;
			$scope.start_date = $scope.events[index-1].start_date;
			$scope.end_date = $scope.events[index-1].end_date;
			$scope.owner_id = $scope.events[index-1].owner_id;
			$scope.hashtag = $scope.events[index-1].hashtag;
			$scope.id = $scope.events[index-1].id;  
		}
	
		$scope.visible = true;
		$scope.result = '';
	};
		
	// Variables validation
	$scope.$watch('name', function() {$scope.test();});
	$scope.$watch('start_date', function() {$scope.test();});
	$scope.$watch('end_date', function() {$scope.test();});
	$scope.$watch('hashtag', function() {$scope.test();});

	$scope.test = function() {

		if ($scope.start_date >= $scope.end_date) {
			$scope.error = true;
		} else {
			$scope.error = false;
		}
		$scope.incomplete = false;
		if ($scope.edit && 
			(!$scope.name.length || !$scope.start_date.length || !$scope.end_date.length || !$scope.hashtag.length)) { 
				$scope.incomplete = true;
		}
	};
	
	// FUNCTION SAVE EVENT BUTTON
	$scope.saveEvent = function(id, userID) {
		page = "/lib/Events.php";
		var params = "?i=" + $scope.id + 
			"&n=" + $scope.name +
			"&s=" + $scope.state_id +
			"&sd=" + $scope.start_date +
			"&ed=" + $scope.end_date +
			"&o=" + userID + // $scope.owner_id +
			"&h=" + $scope.hashtag;

		var url = site + page + params;
		
		$http.get(url)
			.success(function(response) {$scope.result = response;});

		//Validates if there's an error on the SQL operation to hide edit controls
		if ($scope.result.search("Error:") == -1){
			$scope.visible = false;
		} else {
			$scope.visible = true;	
		}	
    	$scope.newData = true;
	}

	// FUNCTION CANCEL CHANGES BUTTON
	$scope.cancelChanges = function(id) {
		$scope.visible = false;
		$scope.result = "Cambios cancelados";
		$scope.newData = false;
	}
	
	// FUNCTION REFRESH
	$scope.loadData = function(id){
		page = "/lib/get_events.php";
    	$http.get(site + page)
  			.success(function(response) {$scope.events = response;});
		$scope.result = "Tabla Actualizada";
		$scope.newData = false;
	}

	$scope.GoToTalksPage = function(id){
		var URL = "/myTalks.php";
		var params = "?t=" + id;
		// $scope.result = site + URL + params;
		window.location = site + URL + params;
	}
}