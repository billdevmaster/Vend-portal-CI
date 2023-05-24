app.controller('FullFeedbackReportController',
    ['$rootScope', '$scope', '$http', '$window',
        function ($rootScope, $scope, $http, $window) {
            $scope.data = [];
            $scope.assignMode = false;
            $scope.filteredProductList = [];

            if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                var fd = new FormData();
                fd.append('client_id', $rootScope.clientId);
                $http.post('/index.php/Feedback_controller/getFeedbackDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.data_user = result.data;
                            $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                            $scope.exportData = [];
                            $scope.exportData.push(["Feedback Id", "Transaction Id", "Machine Name", "Product ID", "Product Name", "Customer Name", "Customer Phone", "Customer Email", "Complaint", "Feedback", "Timestamp"]);
                            angular.forEach($scope.data_user, function (value, key) {
                                $scope.exportData.push([value.feedback_id, value.transaction_id, value.machine_name, value.product_id, value.product_name, value.customer_name, value.customer_phone, value.customer_email, value.complaint, value.feedback, value.timestamp]);
                            });
                            $scope.filterReport();
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    });

            }
            else {
                $http.get('/index.php/Feedback_controller/getFeedbackData',
                    {
                        transformRequest: angular.identity,
                        headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                    })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.clients = result.data;
                            $scope.data_user = result.data;
                            $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                            $scope.exportData = [];
                            $scope.exportData.push(["Feedback Id", "Transaction Id", "Machine Name", "Product ID", "Product Name", "Customer Name", "Customer Phone", "Customer Email", "Complaint", "Feedback", "Timestamp"]);
                            angular.forEach($scope.data_user, function (value, key) {
                                $scope.exportData.push([value.feedback_id, value.transaction_id, value.machine_name, value.product_id, value.product_name, value.customer_name, value.customer_phone, value.customer_email, value.complaint, value.feedback, value.timestamp]);
                            });
                           $scope.filterReport();
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }

                    });
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
                $scope.filterReport();
            }, false);


            $scope.filterReport = function () {
                var start = moment($scope.startDate,'YYYY-MM-DD HH:mm:ss').toDate();
                var end = moment($scope.endDate,'YYYY-MM-DD HH:mm:ss').toDate();
                $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                $scope.exportData = [];
                $scope.feedbacks = [];
                if( $scope.search_text === undefined){
                    $scope.search = "";
                }
                else{
                    $scope.search = $scope.search_text.toLowerCase();
                }
                $scope.searchList = $scope.search.split(',');
                $scope.exportData.push(["Feedback Id", "Transaction Id", "Machine Name", "Product ID", "Product Name", "Customer Name", "Customer Phone", "Customer Email", "Complaint", "Feedback", "Timestamp"]);
                angular.forEach($scope.data_user, function (value, key) {
                    $scope.countFilter = 0;
                    var inputDate = moment(value.timestamp,'YYYY-MM-DD HH:mm:ss').toDate();
                    for (var i = 0; i < $scope.searchList.length; i++) {
                        $scope.searchItem = $scope.searchList[i];
                        if (value.feedback_id.toLowerCase().indexOf($scope.searchItem) > -1 || value.transaction_id.toLowerCase().indexOf($scope.searchItem) > -1 || value.machine_name.toLowerCase().indexOf($scope.searchItem) > -1 || value.product_id.toLowerCase().indexOf($scope.searchItem) > -1 || value.product_name.toLowerCase().indexOf($scope.searchItem) > -1 || value.customer_name.toLowerCase().indexOf($scope.searchItem) > -1 || value.customer_phone.toLowerCase().indexOf($scope.searchItem) > -1 || value.customer_email.toLowerCase().indexOf($scope.searchItem) > -1 || value.complaint.toLowerCase().indexOf($scope.search) > -1 || value.feedback.toLowerCase().indexOf($scope.search) > -1 || value.timestamp.toLowerCase().indexOf($scope.search) > -1) {
                            $scope.countFilter++;
                        }
                    }
                   if (start < inputDate && inputDate < end && ($scope.searchList.length == $scope.countFilter || $scope.search_text === undefined )) {
                        $scope.feedbacks.push(value);
                        $scope.exportData.push([value.feedback_id, value.transaction_id, value.machine_name, value.product_id, value.product_name, value.customer_name, value.customer_phone, value.customer_email, value.complaint, value.feedback, value.timestamp]);
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

            $scope.scheduleFeedbackReport = function () {
                location.href = '/#/schedule_feedback_report'
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
