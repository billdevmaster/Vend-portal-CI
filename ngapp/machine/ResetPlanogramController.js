app.controller('ResetPlanogramController',
    ['$rootScope', '$scope', '$http', '$window', function ($rootScope, $scope, $http, $window) {

        $scope.resetMachineMapByMachineId = function () {
            console.log('resetMachineMapByMachineId Called');
            var fd = new FormData();
            $http.post('/index.php/Machine_controller/resetMachineMapByMachineId', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        console.log('Machine Reset Successfully');
                        location.href = '/#/machine_product_map'
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }


                })
                .error(function () {
                    console.log('Machine Reset Failed');
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
    }]);
