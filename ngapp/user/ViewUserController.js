app.controller('ViewUserController',
  ['$rootScope', '$scope', 'Upload', '$timeout', '$location', '$window', '$http', 'Base64',
    function ($rootScope, $scope, Upload, $timeout, $location, $window, $http, Base64) {

      $scope.data = [];

      if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
        var fd = new FormData();
        fd.append('client_id', $rootScope.clientId);
        $http.post('/index.php/User_controller/getUserListByClientId', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $scope.data = result.data;
            }
            else if (result.code == 401) {
              $scope.logout();
            }

          });
      }
      else {
        $http.get('/index.php/User_controller/getUserList', {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
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
            $window.localStorage.setItem('token', null);
            location.href = '/#/logout'
          });
      }

      $scope.deactivateUser = function (user) {
        console.log("deactivateUser clicked");
        $scope.user = user;
        console.log("deactivateUser clicked" + $scope.user.mobilenumber);
        var fd = new FormData();
        fd.append('mobilenumber', $scope.user.mobilenumber);
        $http.post('/index.php/User_controller/deactivateUserByMobileNumber', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $window.location.reload();
            }
            else if (result.code == 401) {
              $scope.logout();
            }

          })
          .error(function () {
          });

      };

      $scope.activateUser = function (user) {
        console.log("activateUser clicked");
        $scope.user = user;
        console.log("activateUser clicked" + $scope.user.mobilenumber);
        var fd = new FormData();
        fd.append('mobilenumber', $scope.user.mobilenumber);
        $http.post('/index.php/User_controller/activateUserByMobileNumber', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $window.location.reload();
            }
            else if (result.code == 401) {
              $scope.logout();
            }
          })
          .error(function () {
          });

      };

      $scope.resetPassword = function (user) {
        console.log("resetPassword clicked");
        $scope.user = user;
        $rootScope.user = $scope.user;
        location.href = '/#/reset_password'
      };

    }]);
