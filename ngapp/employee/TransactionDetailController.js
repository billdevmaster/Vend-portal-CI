app.controller('TransactionDetailController',
    ['$rootScope', '$scope', '$http', '$window',
        function ($rootScope, $scope, $http, $window) {
            console.log("TransactionDetailController");
            $scope.startDate = moment().subtract(60, "days");
            $scope.endDate = moment();

            $scope.scheduleEmployeeReport = function () {
                location.href = '/#/schedule_employee_report'
            }

            if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                var fd = new FormData();
                fd.append('client_id', $rootScope.clientId);
                $http.post('/index.php/Employee_controller/getEmployeeTransactionDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.data_user = result.data;
                            $scope.transactions = $scope.data_user;
                            $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                            $scope.exportData = [];
                            $scope.exportData.push(["Id", "Transaction Id","Job Number","Cost Center", "Client Name", "Employee Id", "Employee Full Name", "Product Id", "Product Name", "Machine Id", "Machine Name", "Timestamp"]);
                            angular.forEach($scope.data_user, function (value, key) {
                                $scope.exportData.push([value.id, value.transaction_id,value.job_number ,value.cost_center ,value.client_name, value.employee_id, value.employee_full_name, value.product_id, value.product_name, value.machine_id, value.machine_name, value.timestamp]);
                            });
                            $scope.filterReport();
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    });

            }
            else {
                $http.get('/index.php/Employee_controller/getEmployeeTransactionData', {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.data_user = result.data;
                            $scope.transactions = $scope.data_user;
                            $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                            $scope.exportData = [];
                            $scope.exportData.push(["Id", "Transaction Id","Job Number","Cost Center", "Client Name", "Employee Id", "Employee Full Name", "Product Id", "Product Name", "Machine Id", "Machine Name", "Timestamp"]);
                            angular.forEach($scope.data_user, function (value, key) {
                                $scope.exportData.push([value.id, value.transaction_id,value.job_number ,value.cost_center , value.client_name, value.employee_id, value.employee_full_name, value.product_id, value.product_name, value.machine_id, value.machine_name,value.timestamp]);
                            });
                            $scope.filterReport();
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }

                    });
            }

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
               // var start = new Date(Date.parse($scope.startDate));
                var start = moment($scope.startDate,'YYYY-MM-DD HH:mm:ss').toDate();
               // var end = new Date(Date.parse($scope.endDate));
                var end = moment($scope.endDate,'YYYY-MM-DD HH:mm:ss').toDate();
                $scope.transactions = [];
                $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                $scope.exportData = [];
                if( $scope.search_text === undefined){
                    $scope.search = "";
                }
                else{
                    $scope.search = $scope.search_text.toLowerCase();
                }
                $scope.searchList = $scope.search.split(',');
                $scope.exportData.push(["Id", "Transaction Id","Job Number","Cost Center", "Client Name", "Employee Id", "Employee Full Name", "Product Id", "Product Name", "Machine Id", "Machine Name", "Timestamp"]);
                angular.forEach($scope.data_user, function (value, key) {
                    $scope.countFilter = 0;
                  //  var inputDate = new Date(Date.parse(value.timestamp));
                    var inputDate = moment(value.timestamp,'YYYY-MM-DD HH:mm:ss').toDate();
                    for (var i = 0; i < $scope.searchList.length; i++) {
                        $scope.searchItem = $scope.searchList[i];
                        if( value.client_name === undefined){
                            $scope.valueClientName = "";
                        }
                        else{
                            $scope.valueClientName =  value.client_name.toLowerCase();
                        }
                        if (value.machine_name.toLowerCase().indexOf($scope.searchItem) > -1 || value.cost_center.toLowerCase().indexOf($scope.searchItem) > -1 || value.job_number.toLowerCase().indexOf($scope.searchItem) > -1  || value.id.toLowerCase().indexOf($scope.searchItem) > -1 || value.transaction_id.toLowerCase().indexOf($scope.searchItem) > -1 || $scope.valueClientName.indexOf($scope.searchItem) > -1 || value.employee_id.toLowerCase().indexOf($scope.searchItem) > -1 || value.employee_full_name.toLowerCase().indexOf($scope.searchItem) > -1 || value.product_id.toLowerCase().indexOf($scope.searchItem) > -1 || value.product_name.toLowerCase().indexOf($scope.searchItem) > -1 || value.machine_id.toLowerCase().indexOf($scope.searchItem) > -1 || value.timestamp.toLowerCase().indexOf($scope.searchItem) > -1) {
                            $scope.countFilter++;
                        }
                    }
                    if (start < inputDate && inputDate < end && ($scope.searchList.length == $scope.countFilter || $scope.search_text === undefined )) {
                        $scope.transactions.push(value);
                        $scope.exportData.push([value.id, value.transaction_id,value.job_number ,value.cost_center , value.client_name, value.employee_id, value.employee_full_name, value.product_id, value.product_name, value.machine_id, value.machine_name, value.timestamp]);
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

        }]);

/*
app.filter('dateFilter', function () {
    return function (input, startDate, endDate) {

            console.log("TransactionDetailController dateFilter");
        var result = [];
        //var start = new Date(Date.parse(startDate));
        var start = moment(startDate,'YYYY-MM-DD HH:mm:ss').toDate();
            console.log("TransactionDetailController dateFilter start "+ start);
        //var end = new Date(Date.parse(endDate));
        var end = moment(endDate,'YYYY-MM-DD HH:mm:ss').toDate();
            console.log("TransactionDetailController dateFilter end "+ end);
        if (input != null) {
            for (var i = 0; i < input.length; i++) {
                var inputDateTime = input[i].timestamp;
         //       var inputDate;
         //       inputDate = new Date(Date.parse(inputDateTime));
        var inputDate = moment(inputDateTime,'YYYY-MM-DD HH:mm:ss').toDate();
            console.log("TransactionDetailController dateFilter inputDate "+ inputDate);
                if (start < inputDate && inputDate < end) {
                    result.push(input[i]);
                }
            }
        }
        return result;
    };
});
*/
