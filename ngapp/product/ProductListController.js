app.controller('ProductListController',
    ['$rootScope', '$scope', 'Upload', '$timeout', '$location', '$window', '$http', 'Base64',
        function ($rootScope, $scope, Upload, $timeout, $location, $window, $http, Base64) {

            $scope.data = [];

            $http.get('/index.php/Product_controller/getProductData', {
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

            $scope.logout = function () {
                $http.get('/index.php/Session_controller/setLoginStatus')
                    .success(function (result) {
                        $rootScope.isLoggedIn = false;
                        $window.localStorage.setItem('token', null);
                        location.href = '/#/logout'
                    });
            }

        }]);
