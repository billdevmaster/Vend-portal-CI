var app = angular.module('VendWebApp');
app.controller('ResetClientPasswordController',
    ['$rootScope', '$scope', '$http', '$window', function ($rootScope, $scope, $http, $window) {
        console.log("Reset Client Password");
        $scope.reset = function () {
            if ($scope.client_password == $scope.client_confirm_password) {
                var fd = new FormData();
                fd.append('clientid', $rootScope.client.id);
                fd.append('clientpassword', $scope.client_password);
                $http.post('/index.php/Client_controller/resetPassword', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                }).success(function (result) {
                    if (result.code == 200) {
                        $scope.data = result;
                        location.href = '/#/client'
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

        $scope.logout = function () {
            $http.get('/index.php/Session_controller/setLoginStatus')
                .success(function (result) {
                    $rootScope.isLoggedIn = false;
                    $window.localStorage.setItem('token', null);
                    location.href = '/#/logout'
                });
        }
    }]);
