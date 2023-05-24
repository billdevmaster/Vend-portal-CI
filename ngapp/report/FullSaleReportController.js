app.controller('FullSaleReportController',
    ['$rootScope', '$scope', '$http', '$window',
        function ($rootScope, $scope, $http, $window) {
            $scope.data = [];
            $scope.assignMode = false;
            $scope.filteredProductList = [];

            if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                var fd = new FormData();
                fd.append('client_id', $rootScope.clientId);
                $http.post('/index.php/Sale_Report_controller/getSaleReportDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.data_user = result.data;
                            $scope.reports = $scope.data_user;
                            $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                            $scope.exportData = [];
                            $scope.exportData.push(["Id", "Transaction Id", "Product Id", "Product Name", "Product Price", "Machine Id", "Machine Name", "Timestamp"]);
                            angular.forEach($scope.data_user, function (value, key) {
                                $scope.exportData.push([value.id, value.transaction_id, value.product_id, value.product_name, value.product_price, value.machine_id, value.machine_name, value.timestamp]);
                            });
                          $scope.filterReport();
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                        
                    });
            }
            else {
                $http.get('/index.php/Sale_Report_controller/getSaleReportData',{
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                  })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.data_user = result.data;
                            $scope.reports = $scope.data_user;
                            $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                            $scope.exportData = [];
                            $scope.exportData.push(["Id", "Transaction Id", "Product Id", "Product Name", "Product Price", "Machine Id", "Machine Name", "Timestamp"]);
                            angular.forEach($scope.data_user, function (value, key) {
                                $scope.exportData.push([value.id, value.transaction_id, value.product_id, value.product_name, value.product_price, value.machine_id, value.machine_name, value.timestamp]);
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

            $scope.scheduleSaleReport = function () {
                location.href = '/#/schedule_sale_report'
            }

            $scope.filterReport = function () {
                //var start = new Date(Date.parse($scope.startDate));
                var start = moment($scope.startDate,'YYYY-MM-DD HH:mm:ss').toDate();
                //var end = new Date(Date.parse($scope.endDate));
                var end = moment($scope.endDate,'YYYY-MM-DD HH:mm:ss').toDate();
                $scope.reports = [];
                $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                $scope.exportData = [];
                if( $scope.search_text === undefined){
                    $scope.search = "";
                }
                else{
                    $scope.search = $scope.search_text.toLowerCase();
                }
                $scope.searchList = $scope.search.split(',');
                $scope.exportData.push(["Id", "Transaction Id", "Product Id", "Product Name", "Product Price", "Machine Id", "Machine Name", "Timestamp"]);
                angular.forEach($scope.data_user, function (value, key) {
                    $scope.countFilter = 0;
                   // var inputDate;
                   // inputDate = new Date(Date.parse(value.timestamp));
                    var inputDate = moment(value.timestamp,'YYYY-MM-DD HH:mm:ss').toDate();
                    for (var i = 0; i < $scope.searchList.length; i++) {
                        $scope.searchItem = $scope.searchList[i];
                        if (value.id.toLowerCase().indexOf($scope.searchItem) > -1 || value.transaction_id.toLowerCase().indexOf($scope.searchItem) > -1 || value.product_id.toLowerCase().indexOf($scope.searchItem) > -1 || value.product_name.toLowerCase().indexOf($scope.searchItem) > -1 || value.product_price.toLowerCase().indexOf($scope.searchItem) > -1 || value.machine_id.toLowerCase().indexOf($scope.searchItem) > -1 || value.machine_name.toLowerCase().indexOf($scope.searchItem) > -1 || value.timestamp.toLowerCase().indexOf($scope.searchItem) > -1) {
                            $scope.countFilter++;
                        }
                    }
                    if (start < inputDate && inputDate < end && ($scope.searchList.length == $scope.countFilter || $scope.search_text === undefined )) {
                        $scope.reports.push(value);
                        $scope.exportData.push([value.id, value.transaction_id, value.product_id, value.product_name, value.product_price, value.machine_id, value.machine_name,value.timestamp]);
                    }
                });
            }

            //Watch for date changes
            $scope.$watch('date', function (newDate) {
                $scope.startDate = moment(newDate.startDate._d).format('YYYY-MM-DD HH:mm:ss');
                $scope.endDate = moment(newDate.endDate._d).format('YYYY-MM-DD HH:mm:ss');
                $scope.filterReport();
            }, false);

        }]);
