app.controller('UploadPlanogramController',
    ['$rootScope', '$http', '$scope', 'Upload', '$timeout',
        function ($rootScope, $http, $scope, Upload, $timeout) {

            $http.get('/index.php/Machine_controller/getCurrentData', {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $scope.machines = result.data;
                        console.log($scope.machines);
                        if ($scope.machines.machine_is_single_category == "1") {
                            $scope.no_category = true;
                        }
                        else {
                            $scope.no_category = false;
                        }
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }
                });

            $scope.uploadFiles = function (file, errFiles) {
                $scope.f = file;
                $scope.errFile = errFiles && errFiles[0];
            }
            
            $scope.logout = function () {
                $http.get('/index.php/Session_controller/setLoginStatus')
                    .success(function (result) {
                        $rootScope.isLoggedIn = false;
                        $window.localStorage.setItem('token', null);
                        location.href = '/#/logout'
                    });
            }

            $scope.product_error = false;
            $scope.product_success = false;
            $scope.file_upload_success = false;

            $scope.goToViewPlanogram = function () {
                location.href = "/#/machine_product_map"
            }

            $scope.apply = function () {
                if ($scope.f) {
                    $scope.f.upload = Upload.upload({
                        url: '/index.php/Machine_controller/uploadProductPlanogram',
                        method: 'POST',
                        file: $scope.f,
                        data: { 'targetPath': '/ngapp/assets/csv/planogram/' }
                    }).success(function (result) {
                        $scope.data = result;
                        console.log($scope.data);

                        if ($scope.data['no_of_error'] > 0) {
                            $scope.product_error = true;
                            var errorArray = $scope.data['error'].split(';');
                            $scope.productErrors = errorArray;
                        }
                        if ($scope.data['no_of_product_updated'] > 0) {
                            $scope.product_success = true;
                            $scope.productSuccess = $scope.data['success'];
                        }

                        $scope.file_upload_success = true;
                    });

                    $scope.f.upload.then(function (response) {
                        $scope.product_image_placeholder = 'ngapp/assets/csv/planogram/' + $scope.f.name;
                        $timeout(function () {
                            $scope.f.result = response.data;
                        });
                        console.log('Success ' + response.config.data.file.name + 'uploaded. Response: ' + response);
                        $scope.errorMsg = false;
                    }, function (response) {
                        if (response.status > 0)
                            $scope.errorMsg = response.status + ': ' + response.data;
                        if (response.data != 200) {
                            $scope.f.progress = 0.0;
                            $scope.errorMsg = 'Planogram Upload Failed , Please try again after sometime.';
                        }
                        console.log('Error status: ' + response.status);
                    }, function (evt) {
                        $scope.f.progress = Math.min(100, parseInt(100.0 *
                            evt.loaded / evt.total));
                        var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                        console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
                    });
                }
            }
        }]);
