app.controller('FillMachineProductMapController',
    ['$rootScope', '$scope', '$http', '$window',
        function ($rootScope, $scope, $http, $window) {
            $scope.data = [];
            $scope.assignMode = false;
            $scope.filteredProductList = [];
            $scope.isClient = $rootScope.isClient;
            $scope.clientId = $rootScope.clientId;




            $http.get('/index.php/Machine_controller/getCurrentData', {
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



            if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                console.log('Is a Client');
                var fd = new FormData();
                fd.append('client_id', $rootScope.clientId);
                $http.post('/index.php/Category_controller/getDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.categories = result.category;
                            console.log($scope.categories);
                            var fd = new FormData();
                            fd.append('client_id', $rootScope.clientId);
                            $http.post('/index.php/Product_controller/getAllProductDataEditClient', fd, {
                                transformRequest: angular.identity,
                                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                            })
                                .success(function (result) {
                                    if (result.code == 200) {
                                        $scope.products = result.products;
                                        console.log($scope.products);
                                        $http.get('/index.php/Machine_controller/getProductMachineMapLocation', {
                                            transformRequest: angular.identity,
                                            headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                                        })
                                            .success(function (result) {
                                                if (result.code == 200) {
                                                    $scope.product_location = result.data;
                                                    $scope.product_position = $scope.product_location.product_location;
                                                    $scope.product_quantity = $scope.product_location.product_quantity;
                                                    console.log($scope.product_location);
                                                    if ($scope.product_location.machine_is_single_category == "1") {
                                                        $scope.no_category = true;
                                                    }
                                                    else {
                                                        $scope.no_category = false;
                                                    }

                                                    for (var i = 0; i < $scope.categories.length; i++) {
                                                        if ($scope.categories[i].category_id == $scope.product_location.category_id) {
                                                            $scope.category = $scope.categories[i];
                                                        }
                                                    }

                                                    for (var i = 0; i < $scope.products.length; i++) {
                                                        if ($scope.products[i].product_name == $scope.product_location.product_name) {
                                                            $scope.product = $scope.products[i];
                                                        }
                                                    }
                                                }
                                                else if (result.code == 401) {
                                                    $scope.logout();
                                                }

                                            });
                                    }
                                    else if (result.code == 401) {
                                        $scope.logout();
                                    }
                                });
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    });
            }

            else {
                $http.get('/index.php/Category_controller/getData', {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.categories = result.category;
                            console.log($scope.categories);
                            $http.get('/index.php/Product_controller/getAllProductDataEdit', {
                                transformRequest: angular.identity,
                                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                            })
                                .success(function (result) {
                                    if (result.code == 200) {
                                        $scope.products = result.products;
                                        console.log($scope.products);
                                        $http.get('/index.php/Machine_controller/getProductMachineMapLocation', {
                                            transformRequest: angular.identity,
                                            headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                                        })
                                            .success(function (result) {
                                                if (result.code == 200) {
                                                    $scope.product_location = result.data;
                                                    $scope.product_position = $scope.product_location.product_location;
                                                    $scope.product_quantity = $scope.product_location.product_quantity;
                                                    console.log($scope.product_location);
                                                    if ($scope.product_location.machine_is_single_category == "1") {
                                                        $scope.no_category = true;
                                                    }
                                                    else {
                                                        $scope.no_category = false;
                                                    }

                                                    for (var i = 0; i < $scope.categories.length; i++) {
                                                        if ($scope.categories[i].category_id == $scope.product_location.category_id) {
                                                            $scope.category = $scope.categories[i];
                                                        }
                                                    }

                                                    for (var i = 0; i < $scope.products.length; i++) {
                                                        if ($scope.products[i].product_name == $scope.product_location.product_name) {
                                                            $scope.product = $scope.products[i];
                                                        }
                                                    }
                                                }
                                                else if (result.code == 401) {
                                                    $scope.logout();
                                                }

                                            });
                                    }
                                    else if (result.code == 401) {
                                        $scope.logout();
                                    }
                                });
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    });

            }






            $scope.assignProductToMachineMap = function () {
                console.log('assignProductToMachineMap Called');
                var fd = new FormData();
                fd.append('id', $scope.product_location.product_machine_map_id);
                fd.append('machine_id', $scope.machines.id);
                if ($scope.product_location.machine_is_single_category == "1") {
                    fd.append('category_id', "no_category");
                }
                else {
                    fd.append('category_id', $scope.category.category_id);
                }
                fd.append('product_id', $scope.product.product_id);
                fd.append('product_name', $scope.product.product_name);
                fd.append('product_image', $scope.product.product_image_thumbnail);
                fd.append('product_location', $scope.product_position);
                fd.append('product_quantity', $scope.product_quantity);

                $http.post('/index.php/Machine_controller/assignProductToMachineMap', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            console.log('Product assigned to Machine Successfully');
                            location.href = '/#/machine_product_map'
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }


                    })
                    .error(function () {
                        console.log('Product Assignment Failed');
                    });

            }

            $scope.resetMachineMapByLocation = function () {
                console.log('resetMachineMapByLocation Called');
                var fd = new FormData();
                fd.append('id', $scope.product_location.product_machine_map_id);
                fd.append('machine_id', $scope.machines.id);
                fd.append('product_location', $scope.product_position);
                $http.post('/index.php/Machine_controller/resetMachineMapByLocation', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            console.log('Product Reset Successfully');
                            location.href = '/#/machine_product_map'
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }


                    })
                    .error(function () {
                        console.log('Product Reset Failed');
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
