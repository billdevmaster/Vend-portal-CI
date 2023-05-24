var app = angular.module('VendWebApp');
app.controller('AddImageAdvertisementController',
    ['$rootScope', '$scope', 'Upload', '$timeout', '$location', '$window', '$http', 'Base64',
        function ($rootScope, $scope, Upload, $timeout, $location, $window, $http, Base64) {

            $scope.isClient = $rootScope.isClient;
            $scope.clientId = $rootScope.clientId;

            if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                var fd = new FormData();
                fd.append('client_id', $rootScope.clientId);
                $http.post('/index.php/Machine_controller/getDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.machines = result.data;
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

            $scope.selectedClientChanged = function () {
                var fd = new FormData();
                fd.append('client_id', $scope.machine_client.id);

                $http.post('/index.php/Machine_controller/getDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.machines = result.data;
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }

                    });

            }

            $scope.selectedItemChanged = function () {

            }

            $scope.uploadFiles = function (file, errFiles) {
                $scope.f = file;
                $scope.errFile = errFiles && errFiles[0];
                if (file) {
                    file.upload = Upload.upload({
                        url: '/index.php/Advertisement_Image_controller/uploadFile',
                        method: 'POST',
                        file: file,
                        data: { 'targetPath': '/application/uploads/' }
                    });

                    file.upload.then(function (response) {
                        $timeout(function () {
                            file.result = response.data;
                            $scope.filePath = file.result.replace(/["]+/g, '');
                        });
                        console.log('Success ' + response.config.data.file.name + 'uploaded. Response: ' + response.data);
                        $scope.errorMsg = false;
                        $scope.btnEnabled = true;
                    }, function (response) {
                        if (response.status > 0)
                            $scope.errorMsg = response.status + ': ' + response.data;
                        if (response.data != 200) {
                            file.progress = 0.0;
                            $scope.errorMsg = 'File Upload Failed , Please try again after sometime.';
                        }

                        console.log('Error status: ' + response.status);
                    }, function (evt) {
                        file.progress = Math.min(100, parseInt(100.0 *
                            evt.loaded / evt.total));
                        var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                        console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
                    });
                }
            }

            $scope.logout = function () {
                $http.get('/index.php/Session_controller/setLoginStatus')
                    .success(function (result) {
                        $rootScope.isLoggedIn = false;
                        $window.localStorage.setItem('token', null);
                        location.href = '/#/logout'
                    });
            }

            $scope.uploadAd = function () {
                var fd = new FormData();
                if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                    fd.append('client_id', $scope.clientId);
                }
                else {
                    if ($scope.machine_client === null || $scope.machine_client === undefined) {
                        fd.append('client_id', '-1');
                    }
                    else {
                        fd.append('client_id', $scope.machine_client.id);
                    }
                }
                fd.append('machine_id', $scope.machine_name.id);
                fd.append('image_advertisement_title', $scope.image_advertisement_title);
                fd.append('image_advertisement_url', 'ngapp/assets/images/ads/original/' + $scope.filePath);
                fd.append('image_position', $scope.position);
                fd.append('start_date', $scope.start_date_time);
                fd.append('end_date', $scope.end_date_time);

                $http.post('/index.php/Advertisement_Image_controller/uploadImageAdvertisement', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            console.log('Image Advertisement Uploaded Successfully');
                            location.href = '/#/view_image_advertisement'
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }

                    })
                    .error(function () {
                        console.log('Advertisement Upload Failed');
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
