var app = angular.module('VendWebApp');
app.controller('ResetPasswordController',
  ['$rootScope', '$scope', '$http', '$window', function ($rootScope, $scope, $http, $window) {
    console.log("Reset Password");
    console.log($rootScope.user.username);
    $scope.logout = function () {
      $http.get('/index.php/Session_controller/setLoginStatus')
        .success(function (result) {
          $rootScope.isLoggedIn = false;
          $window.localStorage.setItem('token', null);
          location.href = '/#/logout'
        });
    }
    $scope.reset = function () {
      if ($scope.add_user_password == $scope.add_user_confirm_password) {
        var fd = new FormData();
        fd.append('username', $rootScope.user.username);
        fd.append('password', $scope.add_user_password);
        $http.post('/index.php/User_controller/resetPassword', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        }).success(function (result) {
          if (result.code == 200) {
            location.href = '/#/view_user'
          }
          else if (result.code == 401) {
            $scope.logout();
          }
        })
          .error(function () {
            console.log("Password Change Failed");
          });
      }
      else {
        $scope.errorMessage = 'Password does not match';
        console.log("Password doesn't match");
      }
    }
  }]);
