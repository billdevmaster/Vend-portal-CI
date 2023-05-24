var app = angular.module('VendWebApp');
app.controller('AddClientController',
    ['$rootScope', '$scope', '$http', '$window', function ($rootScope, $scope, $http, $window) {
        $scope.user_role = ["Full Access","Ad Manager", "Machine Product Manager","Employee Manager","FnB Manager"];
        $scope.add_client = function () {
            console.log('add_client Called');
            if ($scope.client_password == $scope.client_confirm_password) {
                var fd = new FormData();
                fd.append('clientname', $scope.client_name);
                fd.append('clientcode', $scope.client_code);
                fd.append('business_registration_number', $scope.business_registration_number);
                fd.append('username', $scope.username);
                fd.append('clientemail', $scope.client_email);
                fd.append('clientaddress', $scope.client_address);
                fd.append('clientphone', $scope.client_phone);
                fd.append('clientpassword', $scope.client_password);
                fd.append('role',$scope.role);
                $http.post('/index.php/Client_controller/checkExistence', fd, {
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
                            $http.post('/index.php/Client_controller/insertClient', fd, {
                                transformRequest: angular.identity,
                                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                            })
                                .success(function (result) {
                                    if (result.code == 200) {
                                        console.log("Registered Successfully");
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
            else {
                $scope.errorMessage = 'Password does not match';
                console.log("Password doesn't match");
            }
        }
        $scope.logout = function () {
            $http.get('/index.php/Session_controller/setLoginStatus')
                .success(function (result) {
                    $rootScope.isLoggedIn = false;
                    $window.localStorage.setItem('token', null);
                    location.href = '/#/logout'
                });
        }
    }
    ]);
