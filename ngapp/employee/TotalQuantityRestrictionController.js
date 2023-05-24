app.controller('TotalQuantityRestrictionController',
  ['$rootScope', '$scope', '$window', '$http',
    function ($rootScope, $scope, $window, $http) {
      console.log("Inside TotalQuantityRestrictionController");

      $scope.isClient = $rootScope.isClient;
      $scope.clientId = $rootScope.clientId;
      $scope.showTable = false;
      var prefix;
      if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
        var fd = new FormData();
        fd.append('client_id', $rootScope.clientId);
        $http.post('/index.php/Employee_controller/getEmployeeGroupDataByClientId', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        }).success(function (result) {
          if (result.code == 200) {
            $scope.groups = result.data;
            console.log($scope.groups);
          }
          else if (result.code == 401) {
            $scope.logout();
          }
        })
          .error(function () {
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
              console.log($scope.clients);
            }
            else if (result.code == 401) {
              $scope.logout();
            }
          });
      }

      $scope.selectedItemChanged = function () {
        var fd = new FormData();
        fd.append('client_id', $scope.machine_client.id);
        $http.post('/index.php/Employee_controller/getEmployeeGroupDataByClientId', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        }).success(function (result) {
          if (result.code == 200) {
            $scope.groups = result.data;
            console.log($scope.groups);
          }
          else if (result.code == 401) {
            $scope.logout();
          }

        })
          .error(function () {
          });

      }



      $scope.apply = function () {
        var fd = new FormData();
        fd.append('quantity', $scope.quantity);
        fd.append('group_id', $scope.group.id);
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
        $http.post('/index.php/ProductRestriction_controller/insertTotalQuantityRestriction', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        }).success(function (result) {
          if (result.code == 200) {
            console.log("Total Quantity Restriction Inserted Successfully");
            $window.location.reload();
            location.href = '/#/total_quantity_restriction'
          }
          else if (result.code == 401) {
            $scope.logout();
          }
        })
          .error(function () {
            console.log("Total Quantity Restriction Insertion Failed");
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

      if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
        var fd = new FormData();
        fd.append('client_id', $rootScope.clientId);
        $http.post('/index.php/ProductRestriction_controller/getProductRestrictionByClientId', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              console.log(result);
              $scope.total_quantity_restrictions = result.total_quantity_restrictions;
              if ($scope.total_quantity_restrictions.length == 0) {
                $scope.showTable = true;
              }
              else {
                $scope.showTable = false;
              }
            }
            else if (result.code == 401) {
              $scope.logout();
            }
          });

      }
      else {
        var fd = new FormData();
        fd.append('type', 'SALE_REPORT');
        $http.post('/index.php/ProductRestriction_controller/getProductRestriction', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              console.log(result);
              $scope.total_quantity_restrictions = result.total_quantity_restrictions;
              if ($scope.total_quantity_restrictions.length == 0) {
                $scope.showTable = true;
              }
              else {
                $scope.showTable = false;
              }
            }
            else if (result.code == 401) {
              $scope.logout();
            }

          });
      }

      $scope.removeProductQuantity = function (total_quantity_restriction) {
        $scope.total_quantity_restriction = total_quantity_restriction;
        var fd = new FormData();
        fd.append('id', $scope.total_quantity_restriction.id);
        $http.post('/index.php/ProductRestriction_controller/deleteProductRestriction', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $window.location.reload();
              location.href = '/#/total_quantity_restriction'
            }
            else if (result.code == 401) {
              $scope.logout();
            }

          })
          .error(function () {

          });
      };
    }]);
