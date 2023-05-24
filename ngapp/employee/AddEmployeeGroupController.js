app.controller('AddEmployeeGroupController',
  ['$rootScope', '$scope', 'Upload', '$timeout', '$location', '$window', '$http', 'Base64',
    function ($rootScope, $scope, Upload, $timeout, $location, $window, $http, Base64) {
      console.log("Inside AddEmployeeGroupController");
      $scope.isClient = $rootScope.isClient;
      $scope.clientId = $rootScope.clientId;
      var prefix;
      if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
      }
      else {
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
      $scope.apply = function () {
        var fd = new FormData();
        fd.append('groupname', $scope.groupname);
        if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
          fd.append('client_id', $scope.clientId);
          prefix = $scope.clientId + "_";
          if ($scope.clientId == "-1") {
            prefix = "";
          }
        }
        else {
          if ($scope.machine_client === null || $scope.machine_client === undefined) {
            fd.append('client_id', '-1');
            prefix = "";
          }
          else {
            fd.append('client_id', $scope.machine_client.id);
            prefix = $scope.machine_client.id + "_";
            if ($scope.machine_client.id == "-1") {
              prefix = "";
            }
          }
        }
        $http.post('/index.php/Employee_controller/insertEmployeeGroupName', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        }).success(function (result) {
          if (result.code == 200) {
            location.href = '/#/employee_group'
            console.log("Employee Group Inserted Successfully");
          }
          else if (result.code == 401) {
            $scope.logout();
          }

        })
          .error(function () {
            console.log("Employee Already Exists");
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
