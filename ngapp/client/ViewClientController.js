app.controller('ViewClientController',
    ['$rootScope', '$scope', '$http', function ($rootScope, $scope, $http) {
        $scope.data = [];


        $http.get('/index.php/Client_controller/getClients', {
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
            .success(function (result) {
                if (result.code == 200) {
                    $scope.clients = result.data;
                }
                else if (result.code == 401) {
                    $scope.logout();
                }
            });

        $scope.resetPassword = function (client) {
            console.log("resetPassword clicked");
            $scope.client = client;
            $rootScope.client = $scope.client;
            location.href = '/#/reset_client_password'
        };

        $scope.logout = function () {
            $http.get('/index.php/Session_controller/setLoginStatus')
                .success(function (result) {
                    $rootScope.isLoggedIn = false;
                    $window.localStorage.setItem('token', null);
                    location.href = '/#/logout'
                });
        }
    }]);
