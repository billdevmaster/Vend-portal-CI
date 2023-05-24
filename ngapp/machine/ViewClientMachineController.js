app.controller('ViewClientMachineController',
    ['$rootScope', '$scope', '$http', '$window', function ($rootScope, $scope, $http, $window) {
        $scope.data = [];

        $scope.viewMachine = function (client) {
            console.log(client);
            $rootScope.selectedClientId = client.id;
            $window.localStorage.setItem('selectedClientId', client.id);
            location.href = '/#/view_client_machine_list'
        };

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

        $scope.logout = function () {
            $http.get('/index.php/Session_controller/setLoginStatus')
                .success(function (result) {
                    $rootScope.isLoggedIn = false;
                    $window.localStorage.setItem('token', null);
                    location.href = '/#/logout'
                });
        }
    }]);
