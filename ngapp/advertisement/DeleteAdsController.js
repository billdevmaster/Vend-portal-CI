var app = angular.module('VendWebApp');

app.filter('trustUrl', ['$sce', function ($sce) {
  return function (val) {
    return $sce.trustAsHtml(val);
  };
}]);

app.controller('DeleteAdsController',
  ['$rootScope', '$scope', '$http', '$window',
    function ($rootScope, $scope, $http, $window) {
      $scope.data = [];
      $scope.filteredData = [];
      $scope.switchUploadAdvertisement = function () {
        location.href = '/#/upload_ads'
      }
      $scope.isClient = $rootScope.isClient;
      $scope.clientId = $rootScope.clientId;


      if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
        var fd = new FormData();
        fd.append('client_id', $rootScope.clientId);
        $http.post('/index.php/Advertisement_controller/getDataByClientId', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              console.log(result.data);
              $scope.data = result.data;
            }
            else if (result.code == 401) {
              $scope.logout();
            }

          });
      }
      else {
        $http.get('/index.php/Advertisement_controller/getData', {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $scope.data = result.data;
              console.log($scope.data);
            }
            else if (result.code == 401) {
              $scope.logout();
            }
          });
      }

      $scope.logout = function () {
        $http.get('/index.php/Session_controller/setLoginStatus')
          .success(function (result) {
            $rootScope.isLoggedIn = false;
            location.href = '/#/logout'
          }
          );
      }

      $scope.callRemove = function (advertisement) {
        console.log("Inside CallRemove");
        $scope.advertisement = advertisement;
        var fd = new FormData();
        fd.append('id', $scope.advertisement.id);
        fd.append('ads_path', $scope.advertisement.ads_path);
        console.log($scope.id);
        $http.post('/index.php/Advertisement_controller/deleteAdvertisementController', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $window.location.reload();
              location.href = '/#/advertisement'
            }
            else if (result.code == 401) {
              $scope.logout();
            }

          })
          .error(function () {

          });
      };
    }]);



