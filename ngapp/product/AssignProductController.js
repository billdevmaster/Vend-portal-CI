app.controller('AssignProductController',
    ['$rootScope', '$scope', '$http', '$window',
        function ($rootScope, $scope, $http, $window) {
            $scope.data = [];
            $scope.filteredProductList = [];

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

            $http.get('/index.php/Product_controller/getAllProductData', {
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

            $scope.assignProductToCategory = function () {
                console.log('assignProductToCategory Called');
                console.log($scope.product.product_id);
                console.log($scope.category.category_id);
                var fd = new FormData();
                fd.append('product_id', $scope.product.product_id);
                fd.append('category_id', $scope.category.category_id);

                $http.post('/index.php/Product_controller/assignProductToCategory', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                })
                    .success(function () {
                        if (result.code == 200) {
                            console.log('Product assigned to Category Successfully');
                            location.href = '/#/product'
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
