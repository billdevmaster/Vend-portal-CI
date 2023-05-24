var app = angular.module('VendWebApp');
app.controller('AddMachineController',
  ['$rootScope', '$scope', 'Upload', '$timeout', '$location', '$window', '$http', 'Base64',
    function ($rootScope, $scope, Upload, $timeout, $location, $window, $http, Base64) {
      $scope.machineCategoryTypeOptions = ["Single Category", "Multiple Categories"];
      $scope.isDisabled = false;
      $scope.isClient = $rootScope.isClient;
      $scope.clientId = $rootScope.clientId;
      $scope.machine_category_type = $scope.machineCategoryTypeOptions[0];
      if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
        var fd = new FormData();
        fd.append('client_id', $rootScope.clientId);
        $http.post('/index.php/User_controller/getAllUserNameByClientId', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $scope.users = result.data;
            }
            else if (result.code == 401) {
              $scope.logout();
            }
          });
      }
      else {
        $http.get('/index.php/User_controller/getAllUserName', {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $scope.users = result.data;
              console.log($scope.users);
            }
            else if (result.code == 401) {
              $scope.logout();
            }
          });
        $http.get('/index.php/Client_controller/getMachineClients', {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $scope.clients = result.data;
              console.log($scope.clients);
            }
            else if (result.code == 401) {
              $scope.logout();
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



      $scope.checkAvailability = function () {
        console.log('checkAvailability');

        if (!$scope.machine_name) {
          $scope.availabilityMessageError = 'Please enter Machine Name';
        }
        else {
          var fd = new FormData();
          fd.append('machine_name', $scope.machine_name);
          if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
            fd.append('machine_client_id', $scope.clientId);
          }
          else {
            if ($scope.machine_client === null || $scope.machine_client === undefined) {
              fd.append('machine_client_id', '-1');
            }
            else {
              fd.append('machine_client_id', $scope.machine_client.id);
            }
          }
          $http.post('/index.php/Machine_controller/checkAvailability', fd, {
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
          })
            .success(function (result) {
              if (result.code == 200) {
                $scope.status = result.data;
                console.log($scope.status);
                if ($scope.status.status === false) {
                  $scope.availabilityMessageError = 'Machine Name already taken';
                }
                else {
                  $scope.availabilityMessageSuccess = 'Machine Name Available';
                }

                $scope.isDisabled = $scope.status.status;
              }
              else if (result.code == 401) {
                $scope.logout();
              }

            })
            .error(function () {

            });
        }
      }

      $scope.editMachineName = function () {
        console.log('editMachineName');
        $scope.isDisabled = false;
        $scope.availabilityMessageError = '';
      }

      $scope.addMachine = function () {

        if (!$scope.machine_name) {
          $scope.availabilityMessageError = 'Please enter Machine Name';
        }
        else {
          var fd = new FormData();
          fd.append('machine_name', $scope.machine_name);
          if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
            fd.append('machine_client_id', $scope.clientId);
          }
          else {
            if ($scope.machine_client === null || $scope.machine_client === undefined) {
              fd.append('machine_client_id', '-1');
            }
            else {
              fd.append('machine_client_id', $scope.machine_client.id);
            }
          }
          $http.post('/index.php/Machine_controller/checkAvailability', fd, {
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
          })
            .success(function (result) {
              if (result.code == 200) {
                $scope.status = result.data;
                console.log($scope.status);
                if ($scope.status.status === false) {
                  $scope.availabilityMessageError = 'Machine Name already taken';
                }
                else {
                  $scope.availabilityMessageSuccess = 'Machine Name Available';
                  console.log($scope.machine_username);
                  if ($scope.machine_row > 10 || $scope.machine_column > 10) {
                    $scope.errorMessage = 'Maximum no. of row and column allowed is 10.'
                  }
                  else if (!$scope.machine_username) {
                    $scope.errorMessage = 'Please select a Machine Login Name , you can request a new one if it isn\'t there in the dropdown.'
                  }
                  else {
                    $scope.errorMessage = '';
                    console.log('addMachine Called');
                    var fd = new FormData();
                    fd.append('machine_username', $scope.machine_username.username);
                    fd.append('machine_upt_no', $scope.machine_username.upt_no);
                    fd.append('machine_name', $scope.machine_name);
                    if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
                      fd.append('machine_client_id', $scope.clientId);
                    }
                    else {
                      if ($scope.machine_client === null || $scope.machine_client === undefined) {
                        fd.append('machine_client_id', '-1');
                      }
                      else {
                        fd.append('machine_client_id', $scope.machine_client.id);
                      }
                    }
                    fd.append('machine_row', $scope.machine_row);
                    fd.append('machine_column', $scope.machine_column);
                    fd.append('machine_address', $scope.machine_address);
                    fd.append('machine_latitude', $scope.machine_latitude);
                    fd.append('machine_longitude', $scope.machine_longitude);

                    if ($scope.machine_category_type == $scope.machineCategoryTypeOptions[0]) {
                      $scope.machineCategoryTypeIndex = 1;
                    }
                    else if ($scope.machine_category_type == $scope.machineCategoryTypeOptions[1]) {
                      $scope.machineCategoryTypeIndex = 0;
                    }

                    fd.append('machine_is_single_category', $scope.machineCategoryTypeIndex);

                    $http.post('/index.php/Machine_controller/addMachine', fd, {
                      transformRequest: angular.identity,
                      headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
                    })
                      .success(function (result) {
                        if (result.code == 200) {
                          console.log('Machine Added to list Successfully');

                          location.href = '/#/machine'

                        }
                        else if (result.code == 401) {
                          $scope.logout();
                        }



                      })
                      .error(function () {
                        console.log('Machine Add Failed');
                      });

                  }
                }

                $scope.isDisabled = $scope.status.status;
              }
              else if (result.code == 401) {
                $scope.logout();
              }
            })
            .error(function () {

            });
        }
      }
    }]);
