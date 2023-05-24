app.controller('ViewClientProductListController',
    ['$rootScope', '$scope', '$http','$window', function ($rootScope, $scope, $http,$window) {
        $scope.data = [];
        var fd = new FormData();
        fd.append('client_id', $rootScope.selectedClientId);
        $http.post('/index.php/Product_controller/getDataByClientId', fd, {
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
