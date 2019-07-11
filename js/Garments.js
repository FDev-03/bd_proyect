var app = angular.module('AppBase', ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);

app.factory('ConfigVariables', function($http) {
  return {
		URL : 'http://pruebas/bd_proyect/'
		//URL : 'http://localhost/bd_proyect/'
		//URL : 'http://192.168.44.44/bd_proyect/'
  };
});

app.controller('Garments', function($scope, $http, $location, $window, $httpParamSerializerJQLike, $uibModal, ConfigVariables){

	var absurl = $location.absUrl();
	var url = new URL(absurl);
	$scope.npage = url.searchParams.get("page");

	if ($scope.npage === null) {
		$scope.npage = 1;
	}

	$http({
		url: ConfigVariables.URL + 'Garment/getGarment?npage=' + $scope.npage,
		method: 'GET',
		headers: {
			'Content-Type': 'application/json'
		}
	}).then(function (response) {
		console.log(response)
		if (response.data == false) {
			$window.location.href = ConfigVariables.URL + 'main/error';
		}else if(response.data.status == 1){
			$scope.dataMaterial = response.data.data
			$scope.pagerMaterial = response.data.available
		}else{
			$scope.not_found_data = true;
		}
	});

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
	$httpParamSerializerJQLike, ConfigVariables, data) {
	$scope.Add = function () {

		var validation = {
			'Precio' : $scope.prenda_precio,
			'Nombre' : $scope.prenda_nombre,
			'Tallas' : $scope.prenda_talla,
			'Tipo' : $scope.prenda_tipo,
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
			'prenda_precio': { 'value': $scope.prenda_precio },
			'prenda_nombre': { 'value': $scope.prenda_nombre },
			'prenda_talla': { 'value': $scope.prenda_talla },
			'prenda_tipo': { 'value': $scope.prenda_tipo }
		}

		$http({
			url: ConfigVariables.URL + 'garment/addGarment',
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			},
			data: $httpParamSerializerJQLike({ 'form_fields': form_fields })
		}).then(function (response) {
			console.log(response)
			if (response.data.status != false) {
				$uibModalInstance.close();
				alert("Prenda Agregado");
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
