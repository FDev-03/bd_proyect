var notifyApp = angular.module('notifyApp', ['angular-growl', 'ngAnimate']);

notifyApp.controller('notifyCtrl', function ($scope, growl) {

  $scope.showWarning = function () {
    growl.warning('This is a warning mesage.', { title: 'Warning!' });
  }

  $scope.showError = function () {
    growl.error('This is a error mesage.', { title: 'Error!' });
  }

  $scope.showSuccess = function () {
    growl.success('This is a success mesage.', { title: 'Success!' });
  }

  $scope.showInfo = function () {
    growl.info('This is an info mesage.', { title: 'Info!' });
  }

});
