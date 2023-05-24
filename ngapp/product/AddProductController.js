app.controller('AddProductController',
    ['$rootScope', '$scope', 'Upload', '$timeout', '$location', '$window', '$http', 'Base64',
        function ($rootScope, $scope, Upload, $timeout, $location, $window, $http, Base64) {

            $scope.data = [];
            $scope.imageChoosen = false;
            $scope.imageFileName = "";
            $scope.imageMoreInfoFileName = "";

            $scope.isClient = $rootScope.isClient;
            $scope.clientId = $rootScope.clientId;
            if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
            }
            else {
                $http.get('/index.php/Client_controller/getMachineClients', {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.clients = result.data;
                            console.log($scope.clients);
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    });
            }

            $scope.uploadFiles = function (file, errFiles) {
                $scope.f = file;
                $scope.errFile = errFiles && errFiles[0];
                if (file) {
                    file.upload = Upload.upload({
                        url: '/index.php/Product_controller/uploadProductImage',
                        method: 'POST',
                        file: file,
                        data: { 'targetPath': '/ngapp/assets/images/product/original/' }
                    });

                    file.upload.then(function (response) {

                        $timeout(function () {
                            file.result = response.data;
                            $scope.imageFileName = file.result.replace(/["]+/g, '');
                            $scope.product_image_placeholder = 'ngapp/assets/images/product/original/' + $scope.imageFileName;
                        });
                        console.log('Success ' + response.config.data.file.name + 'uploaded. Response: ' + response.data);
                        $scope.errorMsg = false;
                        $scope.imageChoosen = true;
                    }, function (response) {
                        if (response.status > 0)
                            $scope.errorMsg = response.status + ': ' + response.data;
                        if (response.data != 200) {
                            file.progress = 0.0;
                            $scope.errorMsg = 'Product Upload Failed , Please try again after sometime.';
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



            $scope.uploadFilesMoreInfo = function (file, errFiles) {
                $scope.fi = file;
                $scope.errFile = errFiles && errFiles[0];
                if (file) {
                    file.upload = Upload.upload({
                        url: '/index.php/Product_controller/uploadProductImage',
                        method: 'POST',
                        file: file,
                        data: { 'targetPath': '/ngapp/assets/images/product/original/' }
                    });

                    file.upload.then(function (response) {

                        $timeout(function () {
                            file.result = response.data;
                            $scope.imageMoreInfoFileName = file.result.replace(/["]+/g, '');
                            $scope.product_more_info_image_placeholder = 'ngapp/assets/images/product/original/' + $scope.imageMoreInfoFileName;
                        });
                        console.log('Success ' + response.config.data.file.name + 'uploaded. Response: ' + response.data);
                        $scope.errorMsg = false;
                        $scope.imageChoosen = true;
                    }, function (response) {
                        if (response.status > 0)
                            $scope.errorMsg = response.status + ': ' + response.data;
                        if (response.data != 200) {
                            file.progress = 0.0;
                            $scope.errorMsg = 'Product Upload Failed , Please try again after sometime.';
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


            $scope.apply = function () {
                var fd = new FormData();
                var prefix = "";

                fd.append('product_name', $scope.product_name);
                fd.append('product_id', $scope.product_id);
                fd.append('product_price', $scope.product_price);
                fd.append('product_image_thumbnail', 'ngapp/assets/images/product/thumbnail/' + $scope.imageFileName);
                fd.append('product_image', 'ngapp/assets/images/product/original/' + $scope.imageFileName);
                if ($scope.imageMoreInfoFileName != "") {
                    console.log('Name : ' + $scope.fi.name);
                    fd.append('product_more_info_image', 'ngapp/assets/images/product/original/' + $scope.imageMoreInfoFileName);
                    fd.append('product_more_info_image_thumbnail', 'ngapp/assets/images/product/thumbnail/' + $scope.imageMoreInfoFileName);
                }
                else {
                    console.log('Name : ' + $scope.f.name);
                    fd.append('product_more_info_image', 'ngapp/assets/images/product/original/' + $scope.imageFileName);
                    fd.append('product_more_info_image_thumbnail', 'ngapp/assets/images/product/thumbnail/' + $scope.imageFileName);
                }
                fd.append('product_description', $scope.product_description);
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
                $http.post('/index.php/Product_controller/checkProductIdValidity', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                }).success(function (result) {
                    if (result.code == 200) {
                        $scope.data = result.data;
                        if ($scope.data.isPresent === 'product_id') {
                            $scope.errorMessage = 'Product Code already exist .'
                        }
                        else {

                            $http.post('/index.php/Product_controller/uploadProduct', fd, {
                                transformRequest: angular.identity,
                                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                            })
                                .success(function (result) {

                                    if (result.code == 200) {
                                        $("#buttonAlertPositive").show()
                                        location.href = '/#/product'
                                    }
                                    else if (result.code == 401) {
                                        $scope.logout();
                                    }

                                })
                                .error(function () {
                                    $("#buttonAlertNegative").show()

                                });
                        }
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }



                })
                    .error(function () {
                        console.log("Product Already Exists");
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
