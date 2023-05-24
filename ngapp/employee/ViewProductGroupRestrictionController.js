app.controller('ViewProductGroupRestrictionController',
    ['$rootScope', '$scope', '$http', '$window', function ($rootScope, $scope, $http, $window) {
        $scope.data = [];
        $scope.addRestriction = function () {
            location.href = '/#/add_product_restriction'
        }

        $scope.isClient = $rootScope.isClient;
        $scope.clientId = $rootScope.clientId;

        if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
            var fd = new FormData();
            fd.append('client_id', $rootScope.clientId);
            $http.post('/index.php/Employee_controller/getViewEmployeeGroupProductRestrictionByClientId', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        console.log(result.data);
                        $scope.data = result.data;
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }

                });

        }
        else {
            $http.get('/index.php/Employee_controller/getViewEmployeeGroupProductRestriction', {
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




        $scope.callRemove = function (group) {
            console.log("Inside Remove Product Group");
            $scope.group = group;
            var fd = new FormData();
            fd.append('group_name', $scope.group.group_name);
            fd.append('product_name', $scope.group.product_name);
            console.log($scope.group);
            $http.post('/index.php/Employee_controller/deleteEmployeeGroup', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined , 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $window.location.reload();
                        location.href = '/#/view_product_group_restriction'
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
