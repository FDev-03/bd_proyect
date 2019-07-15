var app = angular.module('AppBase', ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);

app.factory('ConfigVariables', function($http) {
  return {
		//URL : 'http://pruebas/bd_proyect/'
		URL : 'http://localhost/bd_proyect/'
		//URL : 'http://192.168.44.44/bd_proyect/'
  };
});

app.controller('Reports', function($scope, $http, $location, $window, $httpParamSerializerJQLike,
	$uibModal, ConfigVariables){

/*	$http({
		url: ConfigVariables.URL + 'garment/getGarment?npage=' + $scope.npage,
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
*/
	$scope.ShowChange = function (event) {
		console.log(event.target.id);
		$('#dataResponse .values').hide();
		$('#' + event.target.id + '_value').show();
	}
});

