//-----------------------------//
// Messages Controller 1.0     //
// DecideNow                   //
// March 9 - 2015              //
//-----------------------------//

function messagesController($scope,$http) {
	// Variables Declaration
	$scope.talk_id = decodeURIComponent((new RegExp('[?|&]t=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])
				  [1].replace(/\+/g, '%20')) || null;

	// var site = "http://decidenow.co";
	var site = "http://localhost/DecideNow";
	var page = "/lib/get_talkmessages.php";
	var paramEvent = "?t=" + $scope.talk_id;
	
	$scope.edit = false; // To enable/disable controls
	$scope.visible = false; // Used to show/hide edit controls
	$scope.error = false;
	$scope.incomplete = false; // To control missing info
	$scope.result = ''; // To retrieve the Database operation result
	$scope.newData = false;
	//$scope.event_id = 0;
	
	$scope.result = site + page + paramEvent;

	$http.get(site + page + paramEvent)
  		.success(function(response) {$scope.messages = response;});	
	
}