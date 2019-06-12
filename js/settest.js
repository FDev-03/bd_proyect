var app = angular.module('GetApp', ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);

app.controller('GetCtrl', function($scope, $http, $httpParamSerializerJQLike, $uibModal, $log) {

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

	$scope.updateRow = function(row_id){
    var modalInstance = $uibModal.open({
      animation: true,
      ariaLabelledBy: 'modal-title',
      ariaDescribedBy: 'modal-body',
      templateUrl: 'http://localhost/bd_proyect/view/GetTest/modal.html',
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