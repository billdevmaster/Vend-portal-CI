app.controller('AddEmployeeController',
  ['$rootScope', '$scope', 'Upload', '$timeout', '$location', '$window', '$http', 'Base64',
    function ($rootScope, $scope, Upload, $timeout, $location, $window, $http, Base64) {
      console.log("Inside AddEmployeeController");
      /*$http.get('/index.php/Session_controller/getLoginStatus')
      .success(function(result){
        console.log("Inside getLoginStatus of TransactionController");
        $scope.data=result;
          if($scope.data.loggedin==='true'){
              $rootScope.isLoggedIn=true;
          }  
      });*/
      /*$http.get('/index.php/Employee_controller/getEmployeeGroup')
        .success(function (result) {
          $scope.groups = result;
          console.log($scope.groups);
        });*/
      $scope.isClient = $rootScope.isClient;
      $scope.clientId = $rootScope.clientId;

      if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
        var fd = new FormData();
        fd.append('client_id', $rootScope.clientId);
        $http.post('/index.php/Employee_controller/getEmployeeGroup', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
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
            console.log("Employee Already Exists");
          });
      }
      else{
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
      }
      
      $scope.saveEmployee = function () {
        var fd = new FormData();
        if($scope.mobilenumber !== undefined){
          fd.append('mobilenumber', $scope.mobilenumber);
        }
        else{
          fd.append('mobilenumber', '');
        }

        if($scope.firstname !== undefined){
          fd.append('firstname', $scope.firstname);
        }
        else{
          fd.append('firstname', '');
        }

        if($scope.lastname !== undefined){
          fd.append('lastname', $scope.lastname);
        }
        else{
          fd.append('lastname', '');
        }

        if($scope.passcode !== undefined){
          fd.append('jobnumber', $scope.passcode);
        }
        else{
          fd.append('jobnumber', '');
        }

        if($scope.employeeid !== undefined){
          fd.append('employeeid', $scope.employeeid);
        }
        else{
          fd.append('employeeid', '');
        }
        
        if($scope.emp_card_no !== undefined){
          fd.append('emp_card_no', $scope.emp_card_no);
        }
        else{
          fd.append('emp_card_no', '');
        }
        
        if ($scope.group == null) {
          fd.append('group_id', "-1");
          fd.append('group_name', "");
        }
        else {
          fd.append('group_id', $scope.group.id);
          fd.append('group_name', $scope.group.group_name);
        }

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


        $http.post('/index.php/Employee_controller/checkEmployeeIdValidity', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        }).success(function (result) {

          if (result.code == 200) {
            $scope.data = result.data;
            if ($scope.data.isPresent === 'employee_id') {
              $scope.errorMessage = 'Employee Id already exist .'
            }
            else if($scope.firstname === undefined){
              $scope.errorMessage = 'First Name cannot be empty'
            }
            else if($scope.employeeid === undefined){
              $scope.errorMessage = 'Employee Id cannot be empty'
            }
            else {

              $http.post('/index.php/Employee_controller/uploadEmployee', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
              }).success(function (result) {
                if (result.code == 200) {

                  location.href = '/#/employee_detail'
                  console.log("Employee Added");
                }
                else if (result.code == 401) {
                  $scope.logout();
                }

              })
                .error(function () {
                  console.log("Employee Already Exists");
                });
            }
          }
          else if (result.code == 401) {
            $scope.logout();
          }




        })
          .error(function () {
            console.log("Employee Already Exists");
          });


      }

      $scope.selectedItemChanged = function () {
        var fd = new FormData();
        fd.append('client_id', $scope.machine_client.id);
        $http.post('/index.php/Employee_controller/getEmployeeGroup', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
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

      $scope.logout = function () {
        $http.get('/index.php/Session_controller/setLoginStatus')
          .success(function (result) {
            $rootScope.isLoggedIn = false;
            $window.localStorage.setItem('token', null);
            location.href = '/#/logout'
          });
      }

    }]);
