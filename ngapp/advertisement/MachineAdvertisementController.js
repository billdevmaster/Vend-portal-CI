app.controller('MachineAdvertisementController',
    ['$rootScope', '$scope', '$http', '$window', function ($rootScope, $scope, $http, $window) {
        $scope.data = [];
        console.log('MachineAdvertisementController');
        $scope.assign = function () {
            location.href = '/#/assign_advertisement'
        }

        $scope.client_id = null;
        if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
            $scope.client_id = $rootScope.clientId;
        }
        var fd = new FormData();
        fd.append('client_id', $rootScope.clientId);
        $http.post('/index.php/Advertisement_controller/getMachineAdvertisement', fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined,  'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
            .success(function (result) {
                if (result.code == 200) {
                    console.log(result);
                    $scope.data = result.data;
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

        $scope.remove = function (assign_advertisement) {
            $scope.assign_advertisement = assign_advertisement;
            var fd = new FormData();
            fd.append('id', $scope.assign_advertisement.id);
            $http.post('/index.php/Advertisement_controller/deleteMachineAdvertisement', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $window.location.reload();
                        location.href = '/#/machine_advertisement'
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }

                })
                .error(function () {

                });
        }
    }]);
