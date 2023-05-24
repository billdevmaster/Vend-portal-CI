app.controller('UploadEmployeeListController',
    ['$scope', 'Upload', '$timeout',
        function ($scope, Upload, $timeout) {
        
            $scope.uploadFiles = function (file, errFiles) {
                $scope.f = file;
                $scope.errFile = errFiles && errFiles[0];
            }

            $scope.employee_error=false;
            $scope.employee_success=false;
            $scope.file_upload_success=false;

            $scope.goToViewEmployee = function () {
                location.href="/#/employee_detail"
            }

            $scope.apply = function () {
                if ($scope.f) {
                    $scope.f.upload = Upload.upload({
                        url: '/index.php/Employee_controller/uploadEmployeeList',
                        method: 'POST',
                        file: $scope.f,
                        data: { 'targetPath': '/ngapp/assets/csv/employee/' }
                    }).success(function (result) {
                        $scope.data = result;
                        console.log($scope.data);
                        
                        if($scope.data['no_of_error']>0){
                            $scope.employee_error=true;
                            var errorArray = $scope.data['error'].split(';');
                            $scope.employeeErrors=errorArray;
                        }
                        if($scope.data['no_of_employee_updated']>0){
                            $scope.employee_success=true;
                            $scope.employeeSuccess=$scope.data['success'];
                        }

                        $scope.file_upload_success=true;
                    });

                    $scope.f.upload.then(function (response) {
                        $scope.product_image_placeholder = 'ngapp/assets/csv/employee/' + $scope.f.name;
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
                            $scope.errorMsg = 'Employee List Upload Failed , Please try again after sometime.';
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