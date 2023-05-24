app.controller('EditClientController',
    ['$rootScope', '$scope', '$http', '$window', function ($rootScope, $scope, $http, $window) {
        $scope.data = [];
        $scope.editMode = false;
        $scope.user_role = ["Full Access","Ad Manager", "Machine Product Manager","Employee Manager","FnB Manager"];
        $http.get('/index.php/Client_controller/getClients', {
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
            .success(function (result) {
                if (result.code == 200) {
                    $scope.clients = result.data;
                }
                else if (result.code == 401) {
                    $scope.logout();
                }
            });

        $scope.removeClient = function (client) {
            console.log("removeClient");
            $scope.client = client;
            var fd = new FormData();
            fd.append('clientid', $scope.client.id);
            $http.post('/index.php/Client_controller/removeClient', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
                .success(function (result) {
                    if (result.code == 200) {
                        $window.location.reload();
                    }
                    else if (result.code == 401) {
                        $scope.logout();
                    }
                })
                .error(function () {
                });

        };

        $scope.switchAddClient = function () {
            location.href = '/#/add_client'
        }

        $scope.resetPassword = function (client) {
            console.log("resetPassword clicked");
            $scope.client = client;
            $rootScope.client = $scope.client;
            location.href = '/#/reset_client_password'
        };

        $scope.editClient = function (client) {
            $scope.client = client;
            $scope.editMode = true;
            $scope.client_name = $scope.client.clientname;
            $scope.client_code = $scope.client.clientcode;
            $scope.business_registration_number = $scope.client.business_registration_number;
            $scope.client_address = $scope.client.clientaddress;
            $scope.client_email = $scope.client.clientemail;
            $scope.client_phone = $scope.client.clientphone;
            $scope.role = $scope.client.role;
            $scope.username = $scope.client.username;
        };


        $scope.edit_client_detail = function () {
            console.log('edit_client_detail Called');
            var fd = new FormData();
            fd.append('clientname', $scope.client_name);
            fd.append('clientcode', $scope.client_code);
            fd.append('business_registration_number', $scope.business_registration_number);
            fd.append('username', $scope.username);
            fd.append('clientemail', $scope.client_email);
            fd.append('clientaddress', $scope.client_address);
            fd.append('clientphone', $scope.client_phone);
            fd.append('role', $scope.role);
            $http.post('/index.php/Client_controller/checkUpdateExistence', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            }).success(function (result) {
                if (result.code == 200) {
                    $scope.data = result.data;
                    if ($scope.data.isPresent === 'mobile') {
                        console.log("Client Already Exist");
                        $scope.errorMessage = 'Mobile Number already exist .'
                    }
                    else if ($scope.data.isPresent === 'email') {
                        console.log("Client Already Exist");
                        $scope.errorMessage = 'Email ID already exist .'
                    }
                    else if ($scope.data.isPresent === 'code') {
                        console.log("Client Already Exist");
                        $scope.errorMessage = 'Client Code already exist .'
                    }
                    else if ($scope.data.isPresent === 'username') {
                        console.log("Client Already Exist");
                        $scope.errorMessage = 'Client Username already exist .'
                    }
                    else {

                        console.log("No Client With Same Credential Exist");
                        $http.post('/index.php/Client_controller/editClient', fd, {
                            transformRequest: angular.identity,
                            headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                        })
                            .success(function (result) {
                                if (result.code == 200) {
                                    console.log("Registered Successfully");
                                    $window.location.reload();
                                    location.href = '/#/client'
                                }
                                else if (result.code == 401) {
                                    $scope.logout();
                                }
                            })
                            .error(function () {
                                console.log("Registration Failed");
                            });
                    }
                }
                else if (result.code == 401) {
                    $scope.logout();
                }
            })
                .error(function () {
                    console.log("Client Detail Already Exists");
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
