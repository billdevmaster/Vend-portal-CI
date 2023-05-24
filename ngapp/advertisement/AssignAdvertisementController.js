app.controller('AssignAdvertisementController',
    ['$rootScope', '$scope', 'Upload', '$timeout', '$location', '$window', '$http', 'Base64',
        function ($rootScope, $scope, Upload, $timeout, $location, $window, $http, Base64) {

            $scope.isClient = $rootScope.isClient;
            $scope.clientId = $rootScope.clientId;
            var today = new Date().toISOString().split('T')[0];
            document.getElementsByName("start_date_time")[0].setAttribute('min', today);
            if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                var fd = new FormData();
                fd.append('client_id', $rootScope.clientId);
                $http.post('/index.php/Product_controller/getDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.products = result.products;
                            console.log($scope.data);
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    });

                $http.post('/index.php/Category_controller/getDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.categories = result.category;
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    });

                $http.post('/index.php/Machine_controller/getDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {

                        if (result.code == 200) {
                            console.log('getDataByClientId: ' + result);
                            $scope.machines = result.data;
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    });

                $http.post('/index.php/Advertisement_controller/getDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {

                        if (result.code == 200) {
                            $scope.advertisements = result.data;
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    });

            }
            else {


                $http.get('/index.php/Client_controller/getClients', {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.clients = result.data;
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    });



                $http.get('/index.php/Advertisement_controller/getData', {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.advertisements = result.data;
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    });
            }




            $scope.selectedClientChanged = function () {
                var fd = new FormData();
                fd.append('client_id', $scope.machine_client.id);

                $http.post('/index.php/Product_controller/getDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            $scope.products = result.products;
                            console.log($scope.data);
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    });

                $http.post('/index.php/Category_controller/getDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {
                        console.log('getDataByClientId: ' + result);
                        if (result.code == 200) {
                            $scope.categories = result.category;
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    });

                $http.post('/index.php/Machine_controller/getDataByClientId', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {

                        if (result.code == 200) {
                            console.log('getDataByClientId: ' + result);
                            $scope.machines = result.data;
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    });

            }

            $scope.assignAdvertisement = function () {
                console.log('assignAdvertisement Called');
                var fd = new FormData();
                if ($scope.position == "Category Selection") {
                    fd.append('position', "On Selection of Category - " + $scope.category_selection.category_name);
                }
                else if ($scope.position == "Product Selection") {
                    fd.append('position', "On Selection of Product - " + $scope.product_selection.product_name);
                }
                else {
                    fd.append('position', $scope.position);
                }
                fd.append('advertisement_id', $scope.advertisement_name.id);
                fd.append('machine_id', $scope.machine_name.id);
                fd.append('start_date', $scope.start_date_time);
                fd.append('end_date', $scope.end_date_time);
                if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                    fd.append('client_id', $scope.clientId);
                }
                else {
                    if ($scope.machine_client === null || $scope.machine_client === undefined) {
                        fd.append('client_id', '-1');
                    }
                    else {
                        fd.append('client_id', $scope.machine_client.id);
                    }
                }

                $http.post('/index.php/Advertisement_controller/assignAdvertisement', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                })
                    .success(function (result) {
                        if (result.code == 200) {
                            console.log('Ads Uploaded Successfully');
                            location.href = '/#/machine_advertisement'
                        }
                        else if (result.code == 401) {
                            $scope.logout();
                        }
                    })
                    .error(function () {
                        console.log('Advertisement Assign Failed');
                    });

            }

            $scope.listenStartDateChange = function () {
                document.getElementsByName("end_date_time")[0].setAttribute('min', $scope.start_date_time);
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
