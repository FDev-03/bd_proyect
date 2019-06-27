var app = angular.module('AppBase', ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);

app.factory('ConfigVariables', function($http) {
  return {
		URL : 'http://localhost/bd_proyect/'
		//URL : 'http://192.168.44.44/bd_proyect/'
  };
});

app.controller('GetCtrl', function($scope, $http, $httpParamSerializerJQLike, $uibModal, $location, $window, ConfigVariables) {
	
	var absurl = $location.absUrl();
	var url = new URL(absurl);
	$scope.npage = url.searchParams.get("page");

	if ($scope.npage === null) {
		$scope.npage = 1;
	}

	$scope.url_base = 'gettest/';
	$scope.data = '';
	$http({
		url: $scope.url_base + 'gettest?npage=' + $scope.npage,
		method: 'GET',
		headers: {
			'Content-Type': 'application/json'
		}
	}).then(function (response) {
		if (response.data == 'false') {
			$window.location.href = ConfigVariables.URL + 'main/error';
		}else{
			$scope.data = response.data.data
			$scope.test = response.data.available
		}
	});

	$scope.updateRow = function(row_id){
    var modalInstance = $uibModal.open({
      animation: true,
      ariaLabelledBy: 'modal-title',
      ariaDescribedBy: 'modal-body',
      templateUrl: ConfigVariables.URL + 'view/GetTest/modal.html',
      controller: 'ModalInstanceCtrl',
      resolve: {
        data: function () {
          return row_id; 
        }
      }
    });
	}

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


app.controller('ModalInstanceCtrl', function ($scope, $uibModalInstance, $http, $httpParamSerializerJQLike, data) {
  
	$http({
		url: 'gettest/getSpecific',
		method: 'POST',
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded'
		},
		data: $httpParamSerializerJQLike({'form_input': {'value':data}})
	}).then(function (response) {
		if (response != false) {
			var data_form = response.data.data
			$scope.lastname = data_form.lastname
			$scope.name = data_form.name
			$scope.number = data_form.number
		}
	});

  $scope.Update = function () {
  	var form_fields = {
  		'id' : { 'value': data },
  		'name': { 'value': $scope.name },
  		'lastname': { 'value': $scope.lastname },
  		'number': { 'value': $scope.number }
  	}
		$http({
			url: 'settest/updateFields',
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			},
			data: $httpParamSerializerJQLike({'form_fields': form_fields})
		}).then(function (response) {
			if (response != false) {
				$uibModalInstance.close();
				location.reload();
			}
		});
  };

  $scope.Cancel = function () {
    $uibModalInstance.close();
  };
});

app.controller('Provider', function($scope, $http, $location, $window, $httpParamSerializerJQLike, $uibModal, ConfigVariables){

	var absurl = $location.absUrl();
	var url = new URL(absurl);
	var route_parameters = "";
	$scope.npage = url.searchParams.get("page");
	$scope.service = url.searchParams.get("service");

	if ($scope.npage === null) {
		$scope.npage = 1;
	}

	if ($scope.service != null && $scope.service != "false" && $scope.service != "true") {
		$window.location.href = ConfigVariables.URL + 'main/error';
	}else{
		route_parameters = "&service=" + $scope.service;
		$scope.service = ($scope.service === 'true');
	}

	$scope.dataProvider = '';
	$http({
		url: ConfigVariables.URL + 'provider/getProviders?npage=' + $scope.npage + route_parameters,
		method: 'GET',
		headers: {
			'Content-Type': 'application/json'
		}
	}).then(function (response) {
		if (response.data == 'false') {
			$window.location.href = ConfigVariables.URL + 'main/error';
		}else{
			$scope.dataProvider = response.data.data
			$scope.pagerProvider = response.data.available
		}
	});

	$scope.deleteRow = function(row_id){
		$http({
			url: ConfigVariables.URL + 'provider/deleteProviders',
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			},
			data: $httpParamSerializerJQLike({'form_input': {'value':row_id}})
		}).then(function (response) {
			if ($scope.npage <= response.data.available) {
				location.reload();
			}else if($scope.npage == 1) {
				$window.location.href = ConfigVariables.URL + 'provider?npage=1' + route_parameters;
			}else{
				$window.location.href = ConfigVariables.URL + 'provider?npage=' + ($scope.npage-1) + route_parameters;
			}
		});
	}

	$scope.removeProvider = function(row_id){
		var modalInstance = $uibModal.open({
			animation: true,
			ariaLabelledBy: 'modal-title',
			ariaDescribedBy: 'modal-body',
			templateUrl: ConfigVariables.URL + 'view/Provider/remove_providers.html',
			controller: 'ModalRemoveProvider',
			resolve: {
			data: function () {
			  return row_id; 
			}
		}
		});
	}	

});


app.controller('ModalRemoveProvider', function ($scope, $uibModalInstance, $http,
	$httpParamSerializerJQLike, ConfigVariables, data) {

  $scope.Update = function () {

  	if ($scope.reazon == null) {
  		alert("Error en la validación");
  		return;
  	}

  	var form_fields = {
  		'id' : { 'value': data },
  		'reazon': { 'value': $scope.reazon }
  	}
		$http({
			url: ConfigVariables.URL + 'provider/updateFields',
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			},
			data: $httpParamSerializerJQLike({'form_fields': form_fields})
		}).then(function (response) {
			if (response.data.status != false) {
				$uibModalInstance.close();
				alert("Proveedor retirado");
				location.reload();
			}else{
				alert("Error en la validación");
			}
		});
  };

  $scope.Cancel = function () {
    $uibModalInstance.close();
  };
});