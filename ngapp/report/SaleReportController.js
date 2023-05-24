app.controller('SaleReportController',
    ['$rootScope', '$scope', '$http', '$window',
        function ($rootScope, $scope, $http, $window) {
            console.log('SaleReportController');
            $scope.data = [];
            $scope.assignMode = false;
            $scope.reportMode = false;
            $scope.filteredProductList = [];
            $scope.lastDayProducts = [];
            $scope.lastWeekProducts = [];
            $scope.lastMonthProducts = [];
            $scope.lastMonthProductsGroup = [];
            $scope.lastWeekProductsGroup = [];
            $scope.lastDayProductsGroup = [];

            $scope.logout = function () {
                $http.get('/index.php/Session_controller/setLoginStatus')
                    .success(function (result) {
                        $rootScope.isLoggedIn = false;
                        location.href = '/#/logout'
                    });
            }

            if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                var fd = new FormData();
                fd.append('client_id', $rootScope.clientId);
                $http.post('/index.php/Machine_controller/getDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined , 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId  }
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
                $http.get('/index.php/Machine_controller/getData',{
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
                $scope.sale_machine_name = /*"Machine Name : " + */$scope.machine.machine_name;
                $scope.sale_machine_address =/* "Machine Address : " + */ $scope.machine.machine_address;
                var fd = new FormData();
                fd.append('machine_id', $scope.machine.id);
                $http.post('/index.php/Sale_Report_controller/getSaleReportDataMachineWise', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.data_user = result.data;
                            $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                            $scope.exportData = [];
                            $scope.exportData.push(["Id", "Transaction Id", "Product Id", "Product Name", "Product Price", "Machine Id", "Machine Name", "Timestamp"]);
                            angular.forEach($scope.data_user, function (value, key) {
                                $scope.exportData.push([value.id, value.transaction_id, value.product_id, value.product_name, value.product_price, value.machine_id, value.machine_name, value.timestamp]);
                            });
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }

                    });
            };

            $scope.reportData = function (machine) {
                $scope.machine = machine;
                $scope.sale_machine_name =/* "Machine Name : " + */$scope.machine.machine_name;
                $scope.sale_machine_address =/* "Machine Address : " + */$scope.machine.machine_address;
                $scope.reportMode = true;
                console.log("Machine ID : " + $scope.machine.id);

                var fd = new FormData();
                fd.append('machine_id', $scope.machine.id);
                $http.post('/index.php/Sale_Report_controller/getSaleReportDataMachineWise', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {


                            console.log(result);
                            $scope.data_user = result;
                            $scope.lastWeek = 0;
                            $scope.lastMonth = 0;
                            $scope.lastDay = 0;

                            var lastWeekDate = new Date();
                            lastWeekDate.setDate(lastWeekDate.getDate() - 7);
                            console.log(lastWeekDate.toString());

                            var lastMonthDate = new Date();
                            lastMonthDate.setDate(lastMonthDate.getDate() - 30);
                            console.log(lastMonthDate.toString());

                            var lastDayDate = new Date();
                            lastDayDate.setDate(lastDayDate.getDate() - 1);
                            console.log(lastDayDate.toString());


                            angular.forEach($scope.data_user, function (value, key) {

                                var date = new Date(value.timestamp);

                                if (date >= lastMonthDate) {
                                    $scope.lastMonth = $scope.lastMonth + parseInt(value.product_price);
                                    $scope.lastMonthProducts.push(value);
                                }

                                if (date >= lastWeekDate) {
                                    $scope.lastWeek = $scope.lastWeek + parseInt(value.product_price);
                                    $scope.lastWeekProducts.push(value);
                                }

                                if (date >= lastDayDate) {
                                    $scope.lastDay = $scope.lastDay + parseInt(value.product_price);
                                    $scope.lastDayProducts.push(value);
                                }

                            });
                            console.log($scope.lastMonth);
                            console.log($scope.lastWeek);
                            console.log($scope.lastDay);
                            console.log($scope.lastMonthProducts);
                            console.log($scope.lastWeekProducts);
                            console.log($scope.lastDayProducts);
                            $scope.last_month = "Total Sale this month [Last 30 days]  :  $ " + $scope.lastMonth;
                            $scope.last_week = "Total Sale this week  [Last 7 days ]  :  $ " + $scope.lastWeek;
                            $scope.last_day = "Total Sale today                      :  $ " + $scope.lastDay;

                            var lastMonthProductsGroupObject = {}

                            /*for (let { product_price, product_name } of $scope.lastMonthProducts)
                                lastMonthProductsGroupObject[product_name] = {
                                    product_name,
                                    product_price: lastMonthProductsGroupObject[product_name] ? lastMonthProductsGroupObject[product_name].product_price + parseInt(product_price) : parseInt(product_price),
                                    count: lastMonthProductsGroupObject[product_name] ? lastMonthProductsGroupObject[product_name].count + 1 : 1
                                }*/

                            $scope.lastMonthProductsGroup = Object.values(lastMonthProductsGroupObject)
                            console.log($scope.lastMonthProductsGroup)

                            var lastWeekProductsGroupObject = {}

                            /*for (let { product_price, product_name } of $scope.lastWeekProducts)
                                lastWeekProductsGroupObject[product_name] = {
                                    product_name,
                                    product_price: lastWeekProductsGroupObject[product_name] ? lastWeekProductsGroupObject[product_name].product_price + parseInt(product_price) : parseInt(product_price),
                                    count: lastWeekProductsGroupObject[product_name] ? lastWeekProductsGroupObject[product_name].count + 1 : 1
                                }*/

                            $scope.lastWeekProductsGroup = Object.values(lastWeekProductsGroupObject)

                            console.log($scope.lastWeekProductsGroup)


                            var lastDayProductsGroupObject = {}

                            /*for (let { product_price, product_name } of $scope.lastDayProducts)
                                lastDayProductsGroupObject[product_name] = {
                                    product_name,
                                    product_price: lastDayProductsGroupObject[product_name] ? lastDayProductsGroupObject[product_name].product_price + parseInt(product_price) : parseInt(product_price),
                                    count: lastDayProductsGroupObject[product_name] ? lastDayProductsGroupObject[product_name].count + 1 : 1
                                }*/

                            $scope.lastDayProductsGroup = Object.values(lastDayProductsGroupObject)

                            console.log($scope.lastDayProductsGroup)
                            $scope.sale_product_wise = "Last Month";
                            $scope.currentGroup = $scope.lastMonthProductsGroup;
                            $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                            $scope.exportData = [];
                            $scope.exportData.push(["Product Name", "Quantity", "Product Price"]);
                            angular.forEach($scope.lastMonthProductsGroup, function (value, key) {
                                $scope.exportData.push([value.product_name, value.count, value.product_price]);
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
                $scope.reportMode = false;
                $scope.data_user = [];
                $scope.filteredProductList = [];
                $scope.lastDayProducts = [];
                $scope.lastWeekProducts = [];
                $scope.lastMonthProducts = [];
                $scope.lastMonthProductsGroup = [];
                $scope.lastWeekProductsGroup = [];
                $scope.lastDayProductsGroup = [];
            }


            $scope.saleTimeline = function () {
                console.log($scope.sale_product_wise);
                if ($scope.sale_product_wise === "Last Month") {
                    $scope.currentGroup = $scope.lastMonthProductsGroup;
                }
                else if ($scope.sale_product_wise === "Last Week") {
                    $scope.currentGroup = $scope.lastWeekProductsGroup;
                }
                else if ($scope.sale_product_wise === "Last Day") {
                    $scope.currentGroup = $scope.lastDayProductsGroup;
                }
                $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                $scope.exportData = [];
                $scope.exportData.push(["Product Name", "Quantity", "Product Price"]);
                angular.forEach($scope.currentGroup, function (value, key) {
                    $scope.exportData.push([value.product_name, value.count, value.product_price]);
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
