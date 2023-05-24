var app = angular.module('VendWebApp');
app.filter('trustUrl', ['$sce', function ($sce) {
    return function (val) {
        return $sce.trustAsHtml(val);
    };
}]);
app.controller('CurrentAdsController',
    ['$rootScope', '$scope', '$http', '$window',
        function ($rootScope, $scope, $http, $window) {

            console.log($window.localStorage.getItem("LoggedIn") + "main");

            $scope.data = [];
            $scope.filteredData = [];
            $http.get('/index.php/Advertisement_controller/getData', {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
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

            $scope.logout = function () {
                $http.get('/index.php/Session_controller/setLoginStatus')
                    .success(function (result) {
                        $rootScope.isLoggedIn = false;
                        location.href = '/#/logout'
                    });
            }
        }]);


