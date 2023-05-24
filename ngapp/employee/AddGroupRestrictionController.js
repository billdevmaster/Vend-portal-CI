app.controller('AddGroupRestrictionController',
  ['$rootScope', '$scope', 'Upload', '$timeout', '$location', '$window', '$http', 'Base64',
    function ($rootScope, $scope, Upload, $timeout, $location, $window, $http, Base64) {
      console.log("Inside AddGroupRestrictionController");

      $scope.isClient = $rootScope.isClient;
      $scope.clientId = $rootScope.clientId;
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
            console.log("Employee Group Fetching Failed");
          });

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
            console.log("Employee Group Fetching Failed");
          });

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

      }

      /*$http.get('/index.php/Product_controller/getAllProductData')
        .success(function (result) {
          $scope.products = result;
          console.log($scope.products);
        });*/
      $scope.apply = function () {
        var fd = new FormData();
        fd.append('group_id', $scope.group.id);
        fd.append('group_name', $scope.group.group_name);
        fd.append('product_id', $scope.product.product_id);
        fd.append('product_name', $scope.product.product_name);
        fd.append('product_image', $scope.product.product_image);
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
        $http.post('/index.php/Employee_controller/insertEmployeeGroupRestriction', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        }).success(function (result) {
          if (result.code == 200) {
            location.href = '/#/view_product_group_restriction'
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
