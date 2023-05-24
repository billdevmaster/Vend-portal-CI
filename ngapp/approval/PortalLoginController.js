app.controller('PortalLoginController',
    ['$rootScope', '$scope', '$http', '$window', function ($rootScope, $scope, $http, $window) {
        $scope.data = [];
        $scope.isClient = $rootScope.isClient;
        $scope.clientId = $rootScope.clientId;

        $http.get('/index.php/Approval_controller/getAdminList', {
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
            .success(function (result) {
                if (result.code == 200) {
                    console.log(result);
                    $scope.admins = result.admins;
                }
                else if (result.code == 401) {
                    $scope.logout();
                }
            });

        $scope.activateAdmin = function (admin) {
            $scope.admin = admin;
            var fd = new FormData();
            fd.append('id', $scope.admin.id);
            fd.append('is_activated', "1");
            $http.post('/index.php/Approval_controller/activateAdmin', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $window.location.reload();
                        location.href = '/#/approval/portal_login'
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }

                })
                .error(function () {

                });
        };


        $scope.deactivateAdmin = function (admin) {
            $scope.admin = admin;
            var fd = new FormData();
            fd.append('id', $scope.admin.id);
            fd.append('is_activated', "2");
            $http.post('/index.php/Approval_controller/activateAdmin', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $window.location.reload();
                        location.href = '/#/approval/portal_login'
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
