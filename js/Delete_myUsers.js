//-----------------------------//
// Events Controller 1.0       //
// DecideNow                   //
// March 13 - 2015          //
//-----------------------------//

function usersController($scope,$http) {
	// Variables Declaration


	$scope.error = false;
	$scope.incomplete = false; // To control missing info
	$scope.result = 'hola'; // To retrieve the Database operation result

	$scope.test = function() {

	};
	
	// FUNCTION SAVE EVENT BUTTON
	$scope.saveUser = function(index) {
		$scope.result = $scope.username;
	}

}