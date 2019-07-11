var app = angular.module('AppBase', ['ngAnimate', 'ngSanitize', 'ui.bootstrap', 'angular-growl']);

app.config(['growlProvider', function (growlProvider) {
	growlProvider.globalTimeToLive(3000);
}]);

app.factory('ConfigVariables', function ($http, growl) {
	return {
		URL: 'http://pruebas/bd_proyect/',
		//URL : 'http://localhost/bd_proyect/',
		//URL : 'http://192.168.44.44/bd_proyect/',
		showWarning: function (message) {
			growl.warning(message, { title: 'Adevertencia!' });
		},
		showError: function (message) {
			growl.error(message, { title: 'Error!' });
		},
		showSuccess: function (message) {
			growl.success(message, {
				title: 'Hecho!',
				onclose: function () {
					location.reload();
				}
			});
		},
		showInfo: function (message) {
			growl.info(message, { title: 'Info!' });
		}
	};
});

app.controller('RawMaterial', function($scope, $http, $location, $window,
	$httpParamSerializerJQLike, $uibModal, ConfigVariables, growl){

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
	$httpParamSerializerJQLike, ConfigVariables, data, growl) {

	// possible categories.
	$http({
		url: ConfigVariables.URL + 'rawmaterial/getCategories',
		method: 'GET',
		headers: {
			'Content-Type': 'application/json'
		}
	}).then(function (response) {
		if (response.data == false) {
			$window.location.href = ConfigVariables.URL + 'main/error';
		}else if(response.data.status == 1){
			$scope.category_options = response.data.data
		}
	});

	// possible providers.
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
			id: 'kilogramos',
			label: 'Kilogramos'
		}, {
			id: 'metros',
			label: 'Metros'
		}, {
			id: 'unidades',
			label: 'Unidades'
		}
	];

	$scope.Add = function () {

		var validation = {
			'Categoría' : $scope.material_category,
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
				ConfigVariables.showWarning('Debe llenar el campo ' + empty_fields.join());
			}else{
				ConfigVariables.showWarning('Debe llenar los campos ' + empty_fields.join());
			}
			return;
		}

		var form_fields = {
			'material_category': { 'value': $scope.material_category.id },
			'material_price': { 'value': $scope.material_price },
			'unit_measurement': { 'value': $scope.unit_measurement.id },
			'amount_material': { 'value': $scope.amount_material },
			'provider': { 'value': $scope.provider.id }
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
				ConfigVariables.showSuccess("Material Agregado (Se Recarará la página)");
				//location.reload();
			} else {
				ConfigVariables.showError("Error en la adición.");
			}
		});
	};

  $scope.Cancel = function () {
    $uibModalInstance.close();
  };

});
