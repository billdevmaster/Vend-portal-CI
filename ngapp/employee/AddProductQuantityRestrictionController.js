app.controller('AddProductQuantityRestrictionController',
    ['$rootScope', '$scope', 'Upload', '$timeout', '$location', '$window', '$http', 'Base64',
        function ($rootScope, $scope, Upload, $timeout, $location, $window, $http, Base64) {
            console.log("Inside AddProductQuantityRestrictionController");
            $scope.isClient = $rootScope.isClient;
            $scope.clientId = $rootScope.clientId;
            var prefix;
            if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                var fd = new FormData();
                fd.append('client_id', $rootScope.clientId);
                $http.post('/index.php/Employee_controller/getEmployeeDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                }).success(function (result) {
                    if (result.code == 200) {
                        $scope.employees = result.data;
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }
                })

                $http.post('/index.php/Product_controller/getDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.products = result.products;
                            console.log($scope.data);
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    });

            }
            else {
                $http.get('/index.php/Client_controller/getClients', {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.clients = result.data;
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    });
            }


            $scope.apply = function () {
                var fd = new FormData();
                fd.append('employee_id', $scope.employee.employeeid);
                fd.append('product_id', $scope.product.product_id);
                fd.append('quantity', $scope.quantity);
                if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                    fd.append('client_id', $scope.clientId);
                    prefix = $scope.clientId + "_";
                    if ($scope.clientId == "-1") {
                        prefix = "";
                    }
                }
                else {
                    if ($scope.machine_client === null || $scope.machine_client === undefined) {
                        fd.append('client_id', '-1');
                        prefix = "";
                    }
                    else {
                        fd.append('client_id', $scope.machine_client.id);
                        prefix = $scope.machine_client.id + "_";
                        if ($scope.machine_client.id == "-1") {
                            prefix = "";
                        }
                    }
                }
                $http.post('/index.php/Employee_controller/insertEmployeeProductQuantityRestriction', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                }).success(function (result) {
                    if (result.code == 200) {
                        location.href = '/#/product_quantity_restriction'
                        console.log("Product Quantity Restriction Inserted Successfully");
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }

                })
                    .error(function () {
                        console.log("Product Quantity Restriction Insertion Unsuccessful");
                    });

            }

            $scope.selectedItemChanged = function () {
                var fd = new FormData();
                fd.append('client_id', $scope.machine_client.id);
                $http.post('/index.php/Employee_controller/getEmployeeDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                }).success(function (result) {
                    if (result.code == 200) {
                        $scope.employees = result.data;
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }
                })
                    .error(function () {
                        console.log("Employee Group Fetching Failed");
                    });

                $http.post('/index.php/Product_controller/getDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.products = result.products;
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
        }]);
