var app = angular.module('VendWebApp');
app.controller('ViewImageAdvertisementController',
    ['$rootScope', '$scope', '$http', '$window',
        function ($rootScope, $scope, $http, $window) {

            $scope.data = [];
            $scope.filteredData = [];
            $scope.isClient = $rootScope.isClient;
            $scope.clientId = $rootScope.clientId;

            $scope.switchUploadImageAdvertisement = function () {
                location.href = '/#/add_image_advertisement'
            }

            if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                var fd = new FormData();
                fd.append('client_id', $rootScope.clientId);
                $http.post('/index.php/Advertisement_Image_controller/getDataByClientId', fd, {
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
            else {
                $http.get('/index.php/Advertisement_Image_controller/getData', {
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

            $scope.callRemove = function (advertisement) {
                $scope.advertisement = advertisement;
                var fd = new FormData();
                fd.append('id', $scope.advertisement.id);
                fd.append('image_advertisement_relative_url', $scope.advertisement.image_advertisement_relative_url);
                $http.post('/index.php/Advertisement_Image_controller/deleteImageAdvertisementController', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $window.location.reload();
                            location.href = '/#/view_image_advertisement'
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }

                    })
                    .error(function () {

                    });
            };
        }]);



app.filter("trustUrl", function ($sce) {
    return function (Url) {
        console.log(Url);
        return $sce.trustAsResourceUrl(Url);
    };
});
