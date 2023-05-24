app.controller('UploadProductListController',
    ['$scope', 'Upload', '$timeout',
        function ($scope, Upload, $timeout) {
        
            $scope.uploadFiles = function (file, errFiles) {
                $scope.f = file;
                $scope.errFile = errFiles && errFiles[0];
            }

            $scope.product_error=false;
            $scope.product_success=false;
            $scope.file_upload_success=false;

            $scope.goToViewProduct = function () {
                location.href="/#/product"
            }

            $scope.apply = function () {
                if ($scope.f) {
                    $scope.f.upload = Upload.upload({
                        url: '/index.php/Product_controller/uploadProductList',
                        method: 'POST',
                        file: $scope.f,
                        data: { 'targetPath': '/ngapp/assets/csv/product/' }
                    }).success(function (result) {
                        $scope.data = result;
                        console.log($scope.data);
                        
                        if($scope.data['no_of_error']>0){
                            $scope.product_error=true;
                            var errorArray = $scope.data['error'].split(';');
                            $scope.productErrors=errorArray;
                        }
                        if($scope.data['no_of_product_updated']>0){
                            $scope.product_success=true;
                            $scope.productSuccess=$scope.data['success'];
                        }

                        $scope.file_upload_success=true;
                    });

                    $scope.f.upload.then(function (response) {
                        $scope.product_image_placeholder = 'ngapp/assets/csv/product/' + $scope.f.name;
                        $timeout(function () {
                            $scope.f.result = response.data;
                        });
                        console.log('Success ' + response.config.data.file.name + 'uploaded. Response: ' + response.data);
                        $scope.errorMsg = false;
                    }, function (response) {
                        if (response.status > 0)
                            $scope.errorMsg = response.status + ': ' + response.data;
                        if (response.data != 200) {
                            $scope.f.progress = 0.0;
                            $scope.errorMsg = 'Product List Upload Failed , Please try again after sometime.';
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