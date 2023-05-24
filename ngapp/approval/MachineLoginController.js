app.controller('MachineLoginController',
    ['$rootScope', '$scope', '$http', '$window', function ($rootScope, $scope, $http, $window) {
        $scope.data = [];
        $scope.isClient = $rootScope.isClient;
        $scope.clientId = $rootScope.clientId;

        $http.get('/index.php/Approval_controller/getMachineLoginList', {
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
            .success(function (result) {
                if (result.code == 200) {
                    console.log(result);
                    $scope.users = result.users;
                }
                else if (result.code == 401) {
                    $scope.logout();
                }
            });

        $scope.activateMachineLogin = function (user) {
            $scope.user = user;
            var fd = new FormData();
            fd.append('username', $scope.user.username);
            fd.append('status', "0");
            $http.post('/index.php/Approval_controller/activateMachineLogin', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $window.location.reload();
                        location.href = '/#/approval/machine_login'
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }

                })
                .error(function () {

                });
        };

        $scope.deactivateMachineLogin = function (user) {
            $scope.user = user;
            var fd = new FormData();
            fd.append('username', $scope.user.username);
            fd.append('status', "2");
            $http.post('/index.php/Approval_controller/activateMachineLogin', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $window.location.reload();
                        location.href = '/#/approval/machine_login'
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }

                })
                .error(function () {

                });
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
