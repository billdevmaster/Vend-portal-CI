app.controller('ViewProductsController',
    ['$rootScope', '$scope', '$http', '$window', function ($rootScope, $scope, $http, $window) {
        $scope.data = [];
        if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
            var fd = new FormData();
            fd.append('client_id', $rootScope.clientId);
            $http.post('/index.php/Product_controller/getDataByClientId', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined , 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $scope.data = result.products;
                        console.log($scope.data);
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }
                });
        }
        else {
            $http.get('/index.php/Product_controller/getAllProductData', {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $scope.data = result.products;
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
    }]);
