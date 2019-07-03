var app = angular.module('AppBase', ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);

app.factory('ConfigVariables', function($http) {
  return {
		URL : 'http://localhost/bd_proyect/'
		//URL : 'http://192.168.44.44/bd_proyect/'
  };
});

app.controller('RawMaterial', function($scope, $http, $location, $window, $httpParamSerializerJQLike, $uibModal, ConfigVariables){

	var absurl = $location.absUrl();
	var url = new URL(absurl);
	$scope.npage = url.searchParams.get("page");

	if ($scope.npage === null) {
		$scope.npage = 1;
	}

	$http({
		url: ConfigVariables.URL + 'rawmaterial/getRawMaterials?npage=' + $scope.npage,
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

	$scope.addMaterial = function () {
		var modalInstance = $uibModal.open({
			animation: true,
			ariaLabelledBy: 'modal-title',
			ariaDescribedBy: 'modal-body',
			templateUrl: ConfigVariables.URL + 'view/RawMaterial/add_materials.html',
			controller: 'ModalMaterials',
			resolve: {
				data: function () {
					return 'add_materials';
				}
			}
		});
	}

});


app.controller('ModalMaterials', function ($scope, $uibModalInstance, $http,
	$httpParamSerializerJQLike, ConfigVariables, data) {

	// Traer las categorías posibles.
	// (Crear una vista para 'getAllProviders');	

	$http({
		url: ConfigVariables.URL + 'provider/getAllProviders',
		method: 'GET',
		headers: {
			'Content-Type': 'application/json'
		}
	}).then(function (response) {
		if (response.data == false) {
			$window.location.href = ConfigVariables.URL + 'main/error';
		}else if(response.data.status == 1){
			$scope.providers_options = response.data.data
		}
	});

	$scope.unit_options = [
		{
			id: 'kg',
			label: 'Kilogramos'
		}, {
			id: 'mm',
			label: 'Metros'
		}, {
			id: 'un',
			label: 'Unidades'
		}
	];	

	$scope.Add = function () {

		var validation = {
			'Nombre' : $scope.material_name,
			'Precio' : $scope.material_price,
			'Unidad de medida' : $scope.unit_measurement,
			'Cantidad' : $scope.amount_material,
			'Proveedor' : $scope.provider
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
			'material_name': { 'value': $scope.material_name },
			'material_price': { 'value': $scope.material_price },
			'unit_measurement': { 'value': $scope.unit_measurement },
			'amount_material': { 'value': $scope.amount_material },
			'provider': { 'value': $scope.provider }
		}

		$http({
			url: ConfigVariables.URL + 'rawmaterial/addMaterial',
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
