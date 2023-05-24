app.controller('FullAdvertisementReportController',
    ['$rootScope', '$scope', '$http', '$window',
        function ($rootScope, $scope, $http, $window) {
            $scope.data = [];
            $scope.assignMode = false;
            $scope.filteredProductList = [];

            if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                var fd = new FormData();
                fd.append('client_id', $rootScope.clientId);
                $http.post('/index.php/Advertisement_Report_controller/getAdvertisementReportDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.data_user = result.data;
                            $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                            $scope.exportData = [];
                            $scope.exportData.push(["Id", "Advertisement Name", "Machine Name", "Position", "Screen", "Timestamp"]);
                            angular.forEach($scope.data_user, function (value, key) {
                                $scope.exportData.push([value.id, value.advertisement_name, value.machine_name, value.advertisement_position, value.advertisement_screen, value.timestamp]);
                            });
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }

                    });
            }
            else {
                $http.get('/index.php/Advertisement_Report_controller/getAdvertisementReportData', {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.data_user = result.data;
                            $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                            $scope.exportData = [];
                            $scope.exportData.push(["Id", "Advertisement Name", "Machine Name", "Position", "Screen", "Timestamp"]);
                            angular.forEach($scope.data_user, function (value, key) {
                                $scope.exportData.push([value.id, value.advertisement_name, value.machine_name, value.advertisement_position, value.advertisement_screen, value.timestamp]);
                            });
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
            }, false);

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
