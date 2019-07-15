var app = angular.module('AppBase', ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);

app.factory('ConfigVariables', function($http) {
  return {
		//URL : 'http://localhost:1020/bd_proyect/'
		URL : 'http://localhost/bd_proyect/'
		//URL : 'http://192.168.44.44/bd_proyect/'
  };
});

app.controller('Client', function($scope, $http, $location, $window, $httpParamSerializerJQLike, $uibModal, ConfigVariables){

	var absurl = $location.absUrl();
	var url = new URL(absurl);
	$scope.npage = url.searchParams.get("page");

	if ($scope.npage === null) {
		$scope.npage = 1;
	}

	$http({
		url: ConfigVariables.URL + 'client/getClient?npage=' + $scope.npage,
		method: 'GET',
		headers: {
			'Content-Type': 'application/json'
		}
	}).then(function (response) {
		if (response.data == false) {
			$window.location.href = ConfigVariables.URL + 'main/error';
		}else if(response.data.status == 1){
			$scope.dataMaterial = response.data.data
			$scope.pagerMaterial = response.data.available
		}else{
			$scope.not_found_data = true;
		}
	});

	
	
});


