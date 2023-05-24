app.controller('AdvertisementReportController',
    ['$rootScope', '$scope', '$http', '$window',
        function ($rootScope, $scope, $http, $window) {
            $scope.data = [];
            $scope.assignMode = false;
            $scope.filteredProductList = [];
            $http.get('/index.php/Machine_controller/getData', {
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

            $scope.assignData = function (machine) {
                $scope.machine = machine;
                $scope.assignMode = true;
                console.log("Machine Name : " + $scope.machine.machine_name);
                console.log("Machine Address : " + $scope.machine.machine_address);
                $scope.sale_machine_name = /*"Machine Name : " + */$scope.machine.machine_name;
                $scope.sale_machine_address =/* "Machine Address : " + */ $scope.machine.machine_address;
                var fd = new FormData();
                fd.append('machine_id', $scope.machine.id);
                $http.post('/index.php/Advertisement_Report_controller/getAdvertisementReportDataMachineWise', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.data_user = result.data;
                            console.log($scope.data_user);
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
                    })
                    .error(function () {
                    });
            };

            $scope.backToSelectMachine = function () {
                $scope.assignMode = false;
            }

            $scope.logout = function () {
                $http.get('/index.php/Session_controller/setLoginStatus')
                    .success(function (result) {
                        $rootScope.isLoggedIn = false;
                        $window.localStorage.setItem('token', null);
                        location.href = '/#/logout'
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
