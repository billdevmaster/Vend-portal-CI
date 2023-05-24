app.controller('FillMachineController',
    ['$rootScope', '$scope', '$http', '$window',
        function ($rootScope, $scope, $http, $window) {
            $scope.data = [];
            $scope.assignMode = false;
            $scope.filteredProductList = [];
            $http.get('/index.php/Machine_controller/getData', {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $scope.machines = result.data;
                        console.log($scope.machines);
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }

                });

            $http.get('/index.php/Category_controller/getData', {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $scope.categories = result.category;
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }
                });
            $http.get('/index.php/Product_controller/getAllProductDataEdit', {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $scope.products = result.products;
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }
                });

            $scope.filterProductList = function (product) {
                if ($scope.machine == null || $scope.machine.machine_is_single_category == "1") {
                    return true;
                }
                else {
                    return product.product_category_id === $scope.category.category_id;
                }
            }

            $scope.assignProducts = function (machine) {
                $scope.machine = machine;
                $scope.assignMode = true;
                console.log($scope.machine.machine_is_single_category);
                if ($scope.machine.machine_is_single_category == "1") {
                    $scope.no_category = true;
                    $scope.category.category_id = "no_category";
                }
                else {
                    $scope.no_category = false;
                }


            };

            $scope.backToSelectMachine = function () {
                $scope.assignMode = false;
            }

            $scope.assignProductToMachine = function () {
                console.log('assignProductToMachine Called');
                var fd = new FormData();
                fd.append('machine_id', $scope.machine.id);
                if ($scope.machine.machine_is_single_category == "1") {
                    fd.append('category_id', "no_category");
                }
                else {
                    fd.append('category_id', $scope.category.category_id);
                }
                fd.append('product_id', $scope.product.product_id);
                fd.append('product_name', $scope.product.product_name);
                fd.append('product_image', $scope.product.product_image);
                fd.append('product_location', $scope.product_position);
                fd.append('product_quantity', $scope.product_quantity);

                $http.post('/index.php/Machine_controller/assignProductToMachine', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            console.log('Product assigned to Machine Successfully');
                            location.href = '/#/fill_machine'
                            $scope.product_position = "";
                            $scope.product_quantity = "";
                            //$scope.category="";
                            //$scope.product="";
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }

                    })
                    .error(function () {
                        console.log('Product Assignment Failed');
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
