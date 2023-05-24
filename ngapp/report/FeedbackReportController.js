app.controller('FeedbackReportController',
    ['$rootScope', '$scope', '$http', '$window',
        function ($rootScope, $scope, $http, $window) {
            $scope.data = [];
            $scope.assignMode = false;
            $scope.filteredProductList = [];
            if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                var fd = new FormData();
                fd.append('client_id', $rootScope.clientId);
                $http.post('/index.php/Machine_controller/getDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
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
                $http.get('/index.php/Machine_controller/getData', {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.machines = result.data;
                            console.log($scope.machines);
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }

                    });
            }

            $scope.assignData = function (machine) {
                $scope.machine = machine;
                $scope.assignMode = true;
                console.log("Machine Name : " + $scope.machine.machine_name);
                console.log("Machine Address : " + $scope.machine.machine_address);
                $scope.sale_machine_name = /*"Machine Name : " + */$scope.machine.machine_name;
                $scope.sale_machine_address =/* "Machine Address : " + */ $scope.machine.machine_address;
                var fd = new FormData();
                fd.append('machine_id', $scope.machine.id);
                $http.post('/index.php/Feedback_controller/getFeedbackDataMachineWise', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.data_user = result.data;
                            console.log($scope.data_user);
                            $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                            $scope.exportData = [];
                            $scope.exportData.push(["Feedback Id", "Transaction Id", "Machine Name", "Product ID", "Product Name", "Customer Name", "Customer Phone", "Customer Email", "Complaint", "Feedback", "Timestamp"]);
                            angular.forEach($scope.data_user, function (value, key) {
                                $scope.exportData.push([value.feedback_id, value.transaction_id, value.machine_name, value.product_id, value.product_name, value.customer_name, value.customer_phone, value.customer_email, value.complaint, value.feedback, value.timestamp]);
                            });
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    })
                    .error(function () {
                    });
            };

            $scope.backToSelectMachine = function () {
                $scope.assignMode = false;
            }

            $scope.startDate = moment().subtract(60, "days");
            $scope.endDate = moment();
            $scope.date = {
                startDate: moment().subtract(60, "days"),
                endDate: moment()
            };

            //Watch for date changes
            $scope.$watch('date', function (newDate) {
                $scope.startDate = moment(newDate.startDate._d).format('YYYY-MM-DD HH:mm:ss');
                $scope.endDate = moment(newDate.endDate._d).format('YYYY-MM-DD HH:mm:ss');
            }, false);
            $scope.logout = function () {
                $http.get('/index.php/Session_controller/setLoginStatus')
                    .success(function (result) {
                        $rootScope.isLoggedIn = false;
                        $window.localStorage.setItem('token', null);
                        location.href = '/#/logout'
                    });
            }
        }]);


app.filter('dateFilter', function () {
    return function (input, startDate, endDate) {
        var result = [];
        var start = new Date(Date.parse(startDate));
        var end = new Date(Date.parse(endDate));
        if (input != null) {
            for (var i = 0; i < input.length; i++) {
                var inputDateTime = input[i].timestamp;
                var inputDate;
                inputDate = new Date(Date.parse(inputDateTime));
                if (start < inputDate && inputDate < end) {
                    result.push(input[i]);
                }
            }
        }
        return result;
    };
});
