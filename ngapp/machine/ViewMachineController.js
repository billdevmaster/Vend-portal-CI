app.controller('ViewMachineController',
  ['$rootScope', '$scope', '$http', '$window',
    function ($rootScope, $scope, $http, $window) {
      $scope.data = [];
      $scope.filteredData = [];
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

      $scope.logout = function () {
        $http.get('/index.php/Session_controller/setLoginStatus')
          .success(function (result) {
            $rootScope.isLoggedIn = false;
            $window.localStorage.setItem('token', null);
            location.href = '/#/logout'
          });
      }

      $scope.viewProductsList = function (machine) {
        console.log("viewProductsList clicked");
        $scope.machine = machine;
        console.log("viewProductsList clicked" + $scope.machine.id);
        var fd = new FormData();
        fd.append('machine_id', $scope.machine.id);
        $http.post('/index.php/Machine_controller/setMachineId', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId  }
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
          headers: { 'Content-Type': undefined , 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
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
        location.href = '/#/edit_machine'
      };


      $scope.resetPlanogram = function (machine) {
        $scope.machine = machine;
        var fd = new FormData();
        fd.append('machine_id', $scope.machine.id);
        $http.post('/index.php/Machine_controller/setMachineId', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId  }
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
          headers: { 'Content-Type': undefined ,'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
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
    }]);
