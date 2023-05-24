app.controller('EmployeeGroupController',
    ['$rootScope', '$scope', '$http', '$window', function ($rootScope, $scope, $http, $window) {
        $scope.data = [];
        $scope.addEmployeeGroup = function () {
            location.href = '/#/add_employee_group'
        }

        $scope.isClient = $rootScope.isClient;
        $scope.clientId = $rootScope.clientId;

        if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
            var fd = new FormData();
            fd.append('client_id', $rootScope.clientId);
            $http.post('/index.php/Employee_controller/getEmployeeGroupDataByClientId', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
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

        }
        else {
            $http.get('/index.php/Employee_controller/getEmployeeGroupSorted', {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
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
        }

        $scope.callRemove = function (group) {
            console.log("Inside Remove Employee Group");
            $scope.group = group;
            var fd = new FormData();
            fd.append('id', $scope.group.id);
            $http.post('/index.php/Employee_controller/deleteEmployeeGroupById', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $window.location.reload();
                        location.href = '/#/employee_group'
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
