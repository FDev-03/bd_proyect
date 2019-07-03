var app = angular.module('AppBase', ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);

app.factory('ConfigVariables', function($http) {
  return {
		URL : 'http://localhost/bd_proyect/'
		//URL : 'http://192.168.44.44/bd_proyect/'
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
		if (response.data == false) {
			$window.location.href = ConfigVariables.URL + 'main/error';
		}else if(response.data.status == 1){
			$scope.dataProvider = response.data.data
			$scope.pagerProvider = response.data.available
		}else{
			$scope.not_found_data = true;
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
			controller: 'ModalProviders',
			resolve: {
			data: function () {
			  return row_id;
			}
		}
		});
	}

	$scope.addProvider = function () {
		var modalInstance = $uibModal.open({
			animation: true,
			ariaLabelledBy: 'modal-title',
			ariaDescribedBy: 'modal-body',
			templateUrl: ConfigVariables.URL + 'view/Provider/add_providers.html',
			controller: 'ModalProviders',
			resolve: {
				data: function () {
					return 'add_providers';
				}
			}
		});
	}

});


app.controller('ModalProviders', function ($scope, $uibModalInstance, $http,
	$httpParamSerializerJQLike, ConfigVariables, data) {

  $scope.Update = function () {

  	if ($scope.reazon == null) {
  		alert("Debe llenar el campo 'Razón'.");
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

	$scope.Add = function () {

		var validation = {
			'Nombre' : $scope.contact_name,
			'Razón Social' : $scope.social_name,
			'Número' : $scope.telephone_number
		};
		var empty_fields = [];
		$.each(validation, function(key, value) {
			if (value == null) {
				empty_fields.push(key);
			}
		});

		if (empty_fields.length > 0) {
			if (empty_fields.length === 1) {
				alert('Debe llenar el campo ' + empty_fields.join());
			}else{
				alert('Debe llenar los campos ' + empty_fields.join());
			}
			return;
		}

		var form_fields = {
			'name': { 'value': $scope.contact_name },
			'social_name': { 'value': $scope.social_name },
			'number': { 'value': $scope.telephone_number }
		}

		$http({
			url: ConfigVariables.URL + 'provider/addProvider',
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			},
			data: $httpParamSerializerJQLike({ 'form_fields': form_fields })
		}).then(function (response) {
			if (response.data.status != false) {
				$uibModalInstance.close();
				alert("Proveedor Agregado");
				location.reload();
			} else {
				alert("Error en la adición.");
			}
		}); 
	};

  $scope.Cancel = function () {
    $uibModalInstance.close();
  };

});
