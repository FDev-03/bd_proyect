var app = angular.module('GetApp', []);

app.controller('GetCtrl', function($scope, $http, $httpParamSerializerJQLike) {

	$scope.url_base = 'gettest/';
	$scope.data = '';
	$http({
		url: $scope.url_base + 'gettest',
		method: 'POST',
		headers: {
			'Content-Type': 'application/json'
		}
	}).then(function (response) {
		$scope.data = response.data
	});

/*	$scope.updateRow = function(row_id){
		console.log(row_id)
	}*/

	$scope.deleteRow = function(row_id){
		$http({
			url: $scope.url_base + 'deletetest',
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			},
			data: $httpParamSerializerJQLike({'form_input': {'value':row_id}})
		}).then(function (response) {
			if (response.data.status === true) {
				location.reload();
			}
		});
	}
});