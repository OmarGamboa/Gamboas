//-----------------------------//
// Events Controller 1.0       //
// DecideNow                   //
// February 13 - 2015          //
//-----------------------------//

function talksController($scope,$http) {
	// Variables Declaration
	$scope.event_id = decodeURIComponent((new RegExp('[?|&]e=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])
				  [1].replace(/\+/g, '%20')) || null;

	// var site = "http://decidenow.co";
	var site = "http://localhost/DecideNow";
	var page = "/lib/get_talks.php";
	var paramEvent = "?e=" + $scope.event_id;
	
	$scope.edit = false; // To enable/disable controls
	$scope.visible = false; // Used to show/hide edit controls
	$scope.error = false;
	$scope.incomplete = false; // To control missing info
	$scope.result = ''; // To retrieve the Database operation result
	$scope.newData = false;
	//$scope.event_id = 0;
	
	$http.get(site + page + paramEvent)
  		.success(function(response) {$scope.talks = response;});	
	
	// FUNCTION EDIT TALK BUTTON
	$scope.editTalk = function(index) {

		if (index == 'new') {
			$scope.edit = true;
			$scope.incomplete = true;
			$scope.name = '';
			$scope.state_id = 0; // Initial State (Created)
			$scope.start_date = '';
			$scope.end_date = '';
			$scope.hashtag = '';
			$scope.twitter_account = '';
			$scope.id = 'new';
		} else {
			$scope.edit = false;
			$scope.name = $scope.talks[index-1].name;
			$scope.state_id = $scope.talks[index-1].state_id;
			$scope.start_date = $scope.talks[index-1].start_date;
			$scope.end_date = $scope.talks[index-1].end_date;
			$scope.hashtag = $scope.talks[index-1].hashtag;
			$scope.twitter_account = $scope.talks[index-1].twitter_account;
			$scope.id = $scope.talks[index-1].id;
			$scope.event_name = $scope.talks[index-1].event_name;
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
	
	// FUNCTION SAVE TALK BUTTON
	$scope.saveTalk = function(id, userID) {
		page = "/lib/Talks.php";
		var params = "?i=" + $scope.id + 
			"&n=" + $scope.name +
			"&s=" + $scope.state_id +
			"&sd=" + $scope.start_date +
			"&ed=" + $scope.end_date +
			"&e=" + $scope.event_id +
			"&h=" + $scope.hashtag +
			"&ta=" + $scope.twitter_account +
			"&o=" + userID;

		var url = site + page + params;
		//$scope.result = url;

		$http.get(url)
			.success(function(response) {$scope.result = response;});

		// Validates if there's an error on the SQL operation to hide edit controls
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
		page = "/lib/get_talks.php";
		$http.get(site + page + paramEvent)
  			.success(function(response) {$scope.talks = response;});
		$scope.result = "Tabla Actualizada";
		$scope.newData = false;
	}
	
	// $scope.Go = function(URL){	
	// 	// $scope.result = site + URL;
	// 	// $http.path(site + URL);
	// 	$http.path(URL);
	// }

	$scope.GoToGraphsPage = function(id){
		var URL = "/TalkStats.php";
		var params = "?t=" + id;
		// $scope.result = site + URL + params;
		window.location = site + URL + params;
	}
}