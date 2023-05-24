app.controller('NonFunctionalLocationController',
    ['$rootScope', '$scope', '$http', '$window',
        function ($rootScope, $scope, $http, $window) {
            $scope.data = [];
            $scope.assignMode = false;
            $scope.filteredProductList = [];

            if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                var fd = new FormData();
                fd.append('client_id', $rootScope.clientId);
                $http.post('/index.php/Location_Non_Functional_controller/getLocationNonFunctionalDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.data_user = result.data;
                            $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                            $scope.exportData = [];
                            $scope.exportData.push(["Defect Id", "Machine Name", "Product Name", "Defective Location", "Error Code", "Status", "Timestamp"]);
                            angular.forEach($scope.data_user, function (value, key) {
                                $scope.exportData.push([value.defect_id, value.machine_name, value.product_name, value.defective_location,  value.error_code, value.status, value.timestamp]);
                            });
                            $scope.filterReport();
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    });

            }
            else {
                $http.get('/index.php/Location_Non_Functional_controller/getLocationNonFunctionalData',
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
                            $scope.exportData.push(["Defect Id", "Machine Name", "Product Name", "Defective Location", "Error Code", "Status", "Timestamp"]);
                            angular.forEach($scope.data_user, function (value, key) {
                                $scope.exportData.push([value.defect_id, value.machine_name, value.product_name, value.defective_location,  value.error_code, value.status, value.timestamp]);
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
                $scope.nonFunctionalLocations = []; 
                if( $scope.search_text === undefined){
                    $scope.search = "";
                }
                else{
                    $scope.search = $scope.search_text.toLowerCase();
                }
                $scope.searchList = $scope.search.split(',');
                $scope.exportData.push(["Defect Id", "Machine Name", "Product Name", "Defective Location", "Error Code", "Status", "Timestamp"]);
                angular.forEach($scope.data_user, function (value, key) {
                    $scope.countFilter = 0;
                    var inputDate = moment(value.timestamp,'YYYY-MM-DD HH:mm:ss').toDate();
                    for (var i = 0; i < $scope.searchList.length; i++) {
                        $scope.searchItem = $scope.searchList[i];
                        if (value.defect_id.toLowerCase().indexOf($scope.searchItem) > -1 || value.machine_name.toLowerCase().indexOf($scope.searchItem) > -1 || value.product_name.toLowerCase().indexOf($scope.searchItem) > -1 || 
                        value.defective_location.toLowerCase().indexOf($scope.searchItem) > -1 || value.error_code.toLowerCase().indexOf($scope.searchItem) > -1 || value.status.toLowerCase().indexOf($scope.searchItem) > -1 || 
                         value.timestamp.toLowerCase().indexOf($scope.search) > -1) {
                            $scope.countFilter++;
                        }
                    }
               if (start < inputDate && inputDate < end && ($scope.searchList.length == $scope.countFilter || $scope
.search_text === undefined )) {
                        $scope.nonFunctionalLocations.push(value);
                        $scope.exportData.push([value.defect_id, value.machine_name, value.product_name, value.defective_location,  value.error_code, value.status, value.timestamp]);
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


