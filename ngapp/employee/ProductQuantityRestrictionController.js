app.controller('ProductQuantityRestrictionController',
    ['$rootScope', '$scope', '$http', '$window', function ($rootScope, $scope, $http, $window) {
        $scope.data = [];
        console.log('ProductQuantityRestrictionController');
        $scope.addRestriction = function () {
            location.href = '/#/add_product_quantity_restriction'
        }

        if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
            var fd = new FormData();
            fd.append('client_id', $rootScope.clientId);
            $http.post('/index.php/Employee_controller/getEmployeeProductQuantityRestrictionByClientId', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId  }
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
            $http.get('/index.php/Employee_controller/getEmployeeProductQuantityRestriction', {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $scope.data = result.data;
                        console.log($scope.data);
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }

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


        $scope.callRemove = function (employee_product_quantity) {
            $scope.employee_product_quantity = employee_product_quantity;
            var fd = new FormData();
            fd.append('employee_id', $scope.employee_product_quantity.employee_id);
            fd.append('product_id', $scope.employee_product_quantity.product_id);
            console.log($scope.employee_product_quantity);
            $http.post('/index.php/Employee_controller/deleteEmployeeProductQuantityRestriction', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $window.location.reload();
                        location.href = '/#/product_quantity_restriction'
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }

                })
                .error(function () {

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
