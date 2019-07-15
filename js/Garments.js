var app = angular.module('AppBase', ['ngAnimate', 'ngSanitize', 'ui.bootstrap', 'angular-growl']);

app.config(['growlProvider', function (growlProvider) {
	growlProvider.globalTimeToLive(3000);
}]);

app.factory('ConfigVariables', function($http, growl) {
  return {
		//URL : 'http://pruebas/bd_proyect/'
		URL : 'http://localhost/bd_proyect/',
		//URL : 'http://192.168.44.44/bd_proyect/'
		showWarning : function (message) {
			growl.warning(message, {	title: 'Adevertencia!' });
		},
		showError : function (message) {
			growl.error(message, { title: 'Error!' });
		},
		showSuccess : function (message) {
			growl.success(message, {
				title: 'Hecho!',
				onclose: function () {
					location.reload();
				}
			});
		},
		showInfo : function (message) {
			growl.info(message, { title: 'Info!' });
		}
  };
});

app.controller('Garments', function($scope, $http, $location, $window, $httpParamSerializerJQLike,
	$uibModal, ConfigVariables, growl){

	var absurl = $location.absUrl();
	var url = new URL(absurl);
	$scope.npage = url.searchParams.get("page");

	if ($scope.npage === null) {
		$scope.npage = 1;
	}

	$http({
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

	$scope.deleteGarment = function(row_id){
		$http({
			url: ConfigVariables.URL + 'garment/deleteGarment',
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			},
			data: $httpParamSerializerJQLike({'form_input': {'value':row_id}})
		}).then(function (response) {
			if (response.data.status === true) {
				ConfigVariables.showSuccess("Prenda Eliminada.");
			}else{
				ConfigVariables.showError("Error en la eliminación.");
			}
		});
	}

	$scope.addGarment = function () {
		var modalInstance = $uibModal.open({
			animation: true,
			ariaLabelledBy: 'modal-title',
			ariaDescribedBy: 'modal-body',
			templateUrl: ConfigVariables.URL + 'view/Garment/add_garment.html',
			controller: 'ModalGarments',
			resolve: {
				data: function () {
					return 'add_Garments';
				}
			}
		});
	}
});


app.controller('ModalGarments', function ($scope, $uibModalInstance, $http,
	$httpParamSerializerJQLike, ConfigVariables, data, growl) {

	// Posible Types.
	$scope.type_options = [
		{
			id: 1,
			label: 'IMPERMEABLE'
		}, {
			id: 2,
			label: 'TRANSFORMABLE'
		}, {
			id: 3,
			label: 'FORMAL'
		}, {
			id: 4,
			label: 'INFORMAL'
		}, {
			id: 5,
			label: 'ESTAMPADO'
		}, {
			id: 6,
			label: 'JEAN'
		}
	];

	// Posible Size.
	$scope.size_options = [
		{
			id: 1,
			label: 'S'
		}, {
			id: 2,
			label: 'M'
		}, {
			id: 3,
			label: 'L'
		}, {
			id: 4,
			label: 'XL'
		}, {
			id: 5,
			label: 'XXL'
		}
	];

	$scope.Add = function () {

		var validation = {
			'Precio' : $scope.garment_price,
			'Nombre' : $scope.garment_name,
			'Tallas' : $scope.garment_size,
			'Tipo' : $scope.garment_type,
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
			'garment_name': { 'value': $scope.garment_name },
			'garment_price': { 'value': $scope.garment_price },
			'garment_size': { 'value': $scope.garment_size.id },
			'garment_type': { 'value': $scope.garment_type.id }
		}

		$http({
			url: ConfigVariables.URL + 'garment/addGarment',
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			},
			data: $httpParamSerializerJQLike({ 'form_fields': form_fields })
		}).then(function (response) {
			if (response.data.status != false) {
				$uibModalInstance.close();
				ConfigVariables.showSuccess("Prenda Agregada.");
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
