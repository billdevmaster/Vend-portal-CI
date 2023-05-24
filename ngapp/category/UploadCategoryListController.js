app.controller('UploadCategoryListController',
    ['$scope', 'Upload', '$timeout',
        function ($scope, Upload, $timeout) {
        
            $scope.uploadFiles = function (file, errFiles) {
                $scope.f = file;
                $scope.errFile = errFiles && errFiles[0];
            }

            $scope.category_error=false;
            $scope.category_success=false;
            $scope.file_upload_success=false;

            $scope.goToViewCategory = function () {
                location.href="/#/category"
            }

            $scope.apply = function () {
                if ($scope.f) {
                    $scope.f.upload = Upload.upload({
                        url: '/index.php/Category_controller/uploadCategoryList',
                        method: 'POST',
                        file: $scope.f,
                        data: { 'targetPath': '/ngapp/assets/csv/category/' }
                    }).success(function (result) {
                        $scope.data = result;
                        console.log($scope.data);
                        
                        if($scope.data['no_of_error']>0){
                            $scope.category_error=true;
                            var errorArray = $scope.data['error'].split(';');
                            $scope.categoryErrors=errorArray;
                        }
                        if($scope.data['no_of_category_updated']>0){
                            $scope.category_success=true;
                            $scope.categorySuccess=$scope.data['success'];
                        }

                        $scope.file_upload_success=true;
                    });

                    $scope.f.upload.then(function (response) {
                        $scope.product_image_placeholder = 'ngapp/assets/csv/category/' + $scope.f.name;
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
                            $scope.errorMsg = 'Category List Upload Failed , Please try again after sometime.';
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