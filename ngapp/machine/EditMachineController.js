app.controller('EditMachineController',
  ['$rootScope', '$scope', 'Upload', '$timeout', '$location', '$window', '$http', 'Base64',
    function ($rootScope, $scope, Upload, $timeout, $location, $window, $http, Base64) {
      $scope.editMode = false;

      $scope.data = [];
      $scope.imageChoosen = false;
      $scope.btnEnabled = true;

      $scope.isClient = $rootScope.isClient;
      $scope.clientId = $rootScope.clientId;
      $scope.title = 'Edit Detail';
      $scope.buttonName = 'Submit';

      $scope.isDisabled = true;

      console.log($rootScope.isClient == true || $rootScope.isClient == 'true');

      $scope.logout = function () {
        $http.get('/index.php/Session_controller/setLoginStatus')
          .success(function (result) {
            $rootScope.isLoggedIn = false;
            $window.localStorage.setItem('token', null);
            location.href = '/#/logout'
          });
      }

      if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
        var fd = new FormData();
        fd.append('client_id', $rootScope.clientId);
        $http.post('/index.php/Machine_controller/getDataByClientId', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $scope.data = result.data;
            }
            else if (result.code == 401) {
              $scope.logout();
            }
          });
      }
      else {
        $http.get('/index.php/Machine_controller/getData', {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $scope.data = result.data;
              console.log($scope.data);
            }
            else if (result.code == 401) {
              $scope.logout();
            }

          });
      }


      if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
        var fd = new FormData();
        fd.append('client_id', $rootScope.clientId);
        $http.post('/index.php/User_controller/getAllUserNameByClientId', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
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
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
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
      }

      $scope.editMachine = function (machine) {
        $scope.machine = machine;
        $scope.editMode = true;
        console.log("Button Clicked");
        $scope.machine_id = $scope.machine.machine_name;
        $scope.current_machine_name = $scope.machine.machine_name;
        $scope.machine_username = $scope.machine.machine_username;

        $scope.selected_username = { username: $scope.machine.machine_username, upt_no: $scope.machine.machine_upt_no };

        $scope.users.push($scope.selected_username);

        for (var i = 0; i < $scope.users.length; i++) {
          if ($scope.users[i].username == $scope.selected_username.username) {
            $scope.selectedIndex = i;
          }
        }
        $scope.machine_username = $scope.users[$scope.selectedIndex];
        $scope.machine_address = $scope.machine.machine_address;
        $scope.machine_latitude = $scope.machine.machine_latitude;
        $scope.machine_longitude = $scope.machine.machine_longitude;
      };

      $scope.removeMachine = function (machine) {
        $scope.machine = machine;
        $scope.removeMode = true;
        console.log("Remove Button Clicked");
        $scope.machine_id = $scope.machine.machine_name;
        $scope.machine_user_name = $scope.machine.machine_username;
        $scope.selected_username = { username: $scope.machine.machine_username, upt_no: $scope.machine.machine_upt_no };
        $scope.machine_address = $scope.machine.machine_address;
        $scope.machine_latitude = $scope.machine.machine_latitude;
        $scope.machine_longitude = $scope.machine.machine_longitude;
        $scope.isDisabled = true;

      };

      $scope.checkAvailability = function () {
        console.log('checkAvailability');

        if (!$scope.machine_id) {
          $scope.availabilityMessageError = 'Please enter Machine Name';
        }
        else if ($scope.current_machine_name === $scope.machine_id) {
          $scope.isDisabled = true;
          $scope.availabilityMessageError = '';
          $scope.availabilityMessageSuccess = '';
        }
        else {
          var fd = new FormData();
          fd.append('machine_name', $scope.machine_id);
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
            headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
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

      $scope.switchAddMachine = function () {
        location.href = '/#/add_machine'
      }

      $scope.viewProductsList = function (machine) {
        console.log("viewProductsList clicked");
        $scope.machine = machine;
        console.log("viewProductsList clicked" + $scope.machine.id);
        var fd = new FormData();
        fd.append('machine_id', $scope.machine.id);
        $http.post('/index.php/Machine_controller/setMachineId', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $rootScope.selectedPosition = '_0';
              location.href = '/#/machine_product_map'
            }
            else if (result.code == 401) {
              $scope.logout();
            }

          })
          .error(function () {
          });

      };

      $scope.configure = function (machine) {
        console.log("configure clicked");
        $scope.machine = machine;
        console.log("configure clicked" + $scope.machine.id);
        var fd = new FormData();
        fd.append('machine_id', $scope.machine.id);
        $http.post('/index.php/Machine_controller/setMachineId', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              location.href = '/#/machine_configuration'
            }
            else if (result.code == 401) {
              $scope.logout();
            }

          })
          .error(function () {
          });

      };

      $scope.cloneMachine = function (machine) {
        console.log("cloneMachine clicked");
        $rootScope.editClonedMachine = machine;
        $window.localStorage.setItem('editClonedMachine', machine);
        $rootScope.isEditClonedMachine = true;
        $window.localStorage.setItem('isEditClonedMachine', true);
        $scope.isDisabled = false;
        $rootScope.isEditClonedMachine = false;
        $window.localStorage.setItem('isEditClonedMachine', false);
        $scope.cloneMachineIndicator = true;
        console.log($rootScope.isEditClonedMachine);
        $scope.title = 'Edit and Clone Detail';
        $scope.buttonName = 'Clone';
        $scope.cloneMessage = 'Please change Machine Name and Machine Login Name';

        if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
          var fd = new FormData();
          fd.append('client_id', $rootScope.clientId);
          $http.post('/index.php/User_controller/getAllUserNameByClientId', fd, {
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
          })
            .success(function (result) {
              if (result.code == 200) {
                $scope.users = result.data;
                console.log($scope.users);
                $scope.machine = $rootScope.editClonedMachine;
                $scope.editMode = true;
                console.log("Button Clicked");
                $scope.machine_id = $scope.machine.machine_name;
                $scope.machine_address = $scope.machine.machine_address;
                $scope.machine_latitude = $scope.machine.machine_latitude;
                $scope.machine_longitude = $scope.machine.machine_longitude;
              }
              else if (result.code == 401) {
                $scope.logout();
              }
            });
        }
        else {
          $http.get('/index.php/User_controller/getAllUserName', {
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
          })
            .success(function (result) {
              if (result.code == 200) {
                $scope.users = result.data;
                console.log($scope.users);
                console.log($scope.users);
                $scope.machine = $rootScope.editClonedMachine;
                $scope.editMode = true;
                console.log("Button Clicked");
                $scope.machine_id = $scope.machine.machine_name;
                $scope.machine_address = $scope.machine.machine_address;
                $scope.machine_latitude = $scope.machine.machine_latitude;
                $scope.machine_longitude = $scope.machine.machine_longitude;
              }
              else if (result.code == 401) {
                $scope.logout();
              }
            });
        }



      };




      $scope.resetPlanogram = function (machine) {
        $scope.machine = machine;
        var fd = new FormData();
        fd.append('machine_id', $scope.machine.id);
        $http.post('/index.php/Machine_controller/setMachineId', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $rootScope.selectedPosition = '_0';
              location.href = '/#/reset_planogram'
            }
            else if (result.code == 401) {
              $scope.logout();
            }

          })
          .error(function () {
          });

      };

      $scope.uploadPlanogram = function (machine) {
        $scope.machine = machine;
        var fd = new FormData();
        fd.append('machine_id', $scope.machine.id);
        $http.post('/index.php/Machine_controller/setMachineId', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $rootScope.selectedPosition = '_0';
              location.href = '/#/upload_planogram'
            }
            else if (result.code == 401) {
              $scope.logout();
            }

          })
          .error(function () {
          });

      };


      $scope.callAdd = function () {
        if ($scope.cloneMachineIndicator) {
          console.log("cloneMachines clicked" + $scope.editClonedMachine.id);
          if (!$scope.machine_username) {
            $scope.errorMessage = 'Please select a Machine Login Name , you can request a new one if it isn\'t there in the dropdown.'
          }
          else {
            console.log('Client Up : '+$rootScope.isClient);
            var fd = new FormData();
            fd.append('machine_name', $scope.machine_id);
            if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
              console.log('Client : '+$scope.clientId);
              fd.append('machine_client_id', $scope.clientId);
            }
            else {
              if ($scope.machine_client === null || $scope.machine_client === undefined) {
                console.log('Client : -1');
                fd.append('machine_client_id', '-1');
              }
              else {
                console.log('Client : '+$scope.machine_client.id);
                fd.append('machine_client_id', $scope.machine_client.id);
              }
            }
            $http.post('/index.php/Machine_controller/checkAvailability', fd, {
              transformRequest: angular.identity,
              headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
              .success(function (result) {
                if (result.code == 200) {
                  $scope.status = result.data;
                  console.log('Status : ' + $scope.status.status);
                  $scope.isDisabled = $scope.status.status;
                  if ($scope.status.status === false) {
                    $scope.availabilityMessageError = 'Machine Name already taken';
                  }
                  else {
                    $scope.availabilityMessageSuccess = 'Machine Name Available';
                    console.log($scope.machine_username);

                    var fd = new FormData();
                    fd.append('machine_id', $rootScope.editClonedMachine.id);
                    fd.append('machine_username', $scope.machine_username.username);
                    fd.append('machine_upt_no', $scope.machine_username.upt_no);
                    fd.append('machine_name', $scope.machine_id);
                    fd.append('machine_address', $scope.machine_address);
                    fd.append('machine_latitude', $scope.machine_latitude);
                    fd.append('machine_longitude', $scope.machine_longitude);
                    $http.post('/index.php/Machine_controller/cloneMachine', fd, {
                      transformRequest: angular.identity,
                      headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                    })
                      .success(function (result) {
                        if (result.code == 200) {
                          $scope.data = result.data;
                          console.log($scope.data);
                          $window.location.reload();
                          location.href = '/#/machine'
                        }
                        else if (result.code == 401) {
                          $scope.logout();
                        }

                      })
                      .error(function () {
                      });
                  }
                }
                else if (result.code == 401) {
                  $scope.logout();
                }

              }
              )
              .error(function () {

              });
          }

        }
        else {
          console.log("editMachine clicked");
          if (!$scope.machine_username) {
            $scope.errorMessage = 'Please select a Machine Login Name , you can request a new one if it isn\'t there in the dropdown.'
          }
          else if ($scope.isDisabled === false) {
            $scope.errorMessage = 'Please Check Availibility of Machine Name'
          }
          else {
            var fd = new FormData();
            fd.append('machine_username', $scope.machine_username.username);
            fd.append('machine_upt_no', $scope.machine_username.upt_no);
            fd.append('machine_old_username', $scope.selected_username.username);
            fd.append('machine_old_upt_no', $scope.selected_username.upt_no);
            fd.append('machine_name', $scope.machine_id);
            fd.append('machine_id', $scope.machine.id);
            fd.append('machine_address', $scope.machine_address);
            fd.append('machine_latitude', $scope.machine_latitude);
            fd.append('machine_longitude', $scope.machine_longitude);
            fd.append('machine_client_id', $scope.machine.machine_client_id);

            $http.post('/index.php/Machine_controller/updateMachine', fd, {
              transformRequest: angular.identity,
              headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
              .success(function (result) {
                if (result.code == 200) {
                  $window.location.reload();
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

      }

      $scope.callRemove = function () {
        var fd = new FormData();
        console.log("Inside CallRemove");
        fd.append('machine_id', $scope.machine.id);
        fd.append('machine_name', $scope.machine.machine_name);
        fd.append('machine_username', $scope.machine.machine_username);
        fd.append('machine_upt_no', $scope.selected_username.upt_no);
        $http.post('/index.php/Machine_controller/deleteMachine', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
          .success(function (result) {
            //$("#buttonAlertPositive").show()

            if (result.code == 200) {
              $window.location.reload();
              location.href = '/#/machine'
            }
            else if (result.code == 401) {
              $scope.logout();
            }
          })
          .error(function () {
            $("#buttonAlertNegative").show()

          });
      };

      console.log($rootScope.isEditClonedMachine);
      if ($rootScope.isEditClonedMachine == true) {
        $scope.isDisabled = false;
        $rootScope.isEditClonedMachine = false;
        $window.localStorage.setItem('isEditClonedMachine', false);
        $scope.cloneMachineIndicator = true;
        console.log($rootScope.isEditClonedMachine);
        $scope.title = 'Edit and Clone Detail';
        $scope.buttonName = 'Clone';
        $scope.cloneMessage = 'Please change Machine Name and Machine Login Name';
        $http.get('/index.php/User_controller/getAllUserName', {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $scope.users = result.data;
              console.log($scope.users);
              $scope.machine = $rootScope.editClonedMachine;
              $scope.editMode = true;
              console.log("Button Clicked");
              $scope.machine_id = $scope.machine.machine_name;
              $scope.machine_address = $scope.machine.machine_address;
              $scope.machine_latitude = $scope.machine.machine_latitude;
              $scope.machine_longitude = $scope.machine.machine_longitude;
            }
            else if (result.code == 401) {
              $scope.logout();
            }

          });
      }



    }]);
