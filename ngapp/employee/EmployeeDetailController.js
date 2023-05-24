app.controller('EmployeeDetailController',
  ['$rootScope', '$scope', '$http', '$window', 'myService',
    function ($rootScope, $scope, $http, $window, myService) {
      console.log($window.localStorage.getItem("LoggedIn") + "main");
      $scope.data = [];
      $scope.filteredData = [];
      $scope.addEmployee = function () {
        location.href = '/#/add_employee'
      }

      $scope.addEmployeeGroup = function () {
        location.href = '/#/add_employee_group'
      }

      $scope.isClient = $rootScope.isClient;
      $scope.clientId = $rootScope.clientId;


      if ($rootScope.isClient == true || $rootScope.isClient == 'true') {

        $http.get('/index.php/Session_controller/getLoginStatus')
          .success(function (result) {
            console.log("Inside getLoginStatus of homeController");
            $scope.datas = result;
            if ($scope.datas.loggedin === 'true') {
              $rootScope.isLoggedIn = true;
              var fd = new FormData();
              fd.append('client_id', $rootScope.clientId);
              $http.post('/index.php/Employee_controller/getEmployeeDataByClientId', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
              })
                .success(function (result) {
                  if (result.code == 200) {
                    $scope.data_user = result.data;
                    $scope.employees = $scope.data_user;
                    $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                    $scope.exportData = [];
                    $scope.exportData.push(["First Name", "Last Name", "Employee ID", "Mobile Number", "Passcode", "Employee Card Number", "Group Name"]);
                    angular.forEach($scope.data_user, function (value, key) {
                      $scope.exportData.push([value.firstname, value.lastname, value.employeeid, value.mobilenumber, value.jobnumber, value.emp_card_no, value.groupname]);
                    });
                  }
                  else if (result.code == 401) {
                    $scope.logout();
                  }

                });
            }
            else {
              location.href = '/#/'
            }
          });
      }
      else {
        $http.get('/index.php/Session_controller/getLoginStatus')
          .success(function (result) {
            console.log("Inside getLoginStatus of homeController");
            $scope.datas = result;
            if ($scope.datas.loggedin === 'true') {
              $rootScope.isLoggedIn = true;
              $http.get('/index.php/Employee_controller/getEmployeeData', {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
              })
                .success(function (result) {
                  if (result.code == 200) {
                    $scope.data_user = result.data;
                    $scope.employees = $scope.data_user;
                    $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                    $scope.exportData = [];
                    $scope.exportData.push(["First Name", "Last Name", "Employee ID", "Mobile Number", "Job Number", "Employee Card Number", "Client Name", "Group Name"]);
                    angular.forEach($scope.data_user, function (value, key) {
                      $scope.exportData.push([value.firstname, value.lastname, value.employeeid, value.mobilenumber, value.jobnumber, value.emp_card_no, value.clientname, value.groupname]);
                    });
                  }
                  else if (result.code == 401) {
                    $scope.logout();
                  }

                });
            }
            else {
              location.href = '/#/'
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

      $scope.toggleCheckbox = function(){
        
        var toggleStatus = !$scope.check_all;
        console.log('toggleCheckbox '+toggleStatus);
        angular.forEach($scope.employees, function(itm){ itm.checked = toggleStatus; });
      }

      $scope.optionToggled = function(){
        $scope.check_all = $scope.employees.every(function(itm){ return itm.checked; })
      }

      $scope.deleteSelected = function () {

        var ar = $scope.employees.filter(
          function (value) {
            if (value.checked == 1) {
              return true;
            } else {
              return false;
            }
          }
        );
        if(ar.length>0){
        var deleteEmployee = {};
        deleteEmployee.employees = ar;
        var fd = new FormData();
        fd.append('employees',JSON.stringify(deleteEmployee))
        $http.post('/index.php/Employee_controller/deleteSelectedEmployee', fd, {
          transformRequest: angular.identity,
          headers: {'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              console.log("Deleted Successfully");
              $window.location.reload();
              location.href = '/#/employee_detail'
            }
            else if (result.code == 401) {
              $scope.logout();
            }

          })
          .error(function () {
            console.log("Update Failed");
          });
        }
      };

      $scope.filterReport = function () {
        $scope.employees = [];
        $scope.fileName = Math.floor(100000 + Math.random() * 900000);
        $scope.exportData = [];
        if ($scope.searchName === undefined) {
          $scope.search = "";
        }
        else {
          $scope.search = $scope.searchName.toLowerCase();
        }
        $scope.searchList = $scope.search.split(',');
        $scope.exportData.push(["First Name", "Last Name", "Employee ID", "Mobile Number", "Job Number", "Employee Card Number", "Client Name"]);
        angular.forEach($scope.data_user, function (value, key) {
          $scope.countFilter = 0;
          for (var i = 0; i < $scope.searchList.length; i++) {
            $scope.searchItem = $scope.searchList[i];
            console.log('Search : ' + $scope.searchItem);
            if (value.firstname.toLowerCase().indexOf($scope.searchItem) > -1 ||
              value.lastname.toLowerCase().indexOf($scope.searchItem) > -1 ||
              value.employeeid.toLowerCase().indexOf($scope.searchItem) > -1 ||
              value.mobilenumber.toLowerCase().indexOf($scope.searchItem) > -1 ||
              value.jobnumber.toLowerCase().indexOf($scope.searchItem) > -1 ||
              value.emp_card_no.indexOf($scope.searchItem) > -1 ||
              value.clientname.toLowerCase().indexOf($scope.searchItem) > -1 ||
              value.groupname.toLowerCase().indexOf($scope.searchItem) > -1) {
              $scope.countFilter++;
            }
          }
          if ($scope.searchList.length == $scope.countFilter || $scope.searchName === undefined) {
            $scope.employees.push(value);
            $scope.exportData.push([value.firstname, value.lastname, value.employeeid, value.mobilenumber, value.jobnumber, value.emp_card_no, value.clientname]);
          }
        });
      }

      $scope.set_employee_id = function (user) {
        console.log(user.employeeid);
        myService.set(user);
        var fd = new FormData();
        fd.append('employeeid', user.employeeid);
        $http.post('/index.php/Session_controller/setEmployeeSearch', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined }
        })
          .success(function () {
            console.log("Employee Detail Saved");
            location.href = "/#/edit_employee_detail"
          })
          .error(function () {
            console.log("Employee Detail Save Failed");
            location.href = "/#/edit_employee_detail"
          });

      }

    }]);

app.controller('EditEmployeeDetailController',
  ['$rootScope', '$scope', '$http', '$window', 'myService',
    function ($rootScope, $scope, $http, $window, myService) {
      console.log($window.localStorage.getItem("LoggedIn") + "main");
      $scope.data = [];
      $scope.filteredData = [];
      $http.get('/index.php/Session_controller/getLoginStatus')
        .success(function (result) {
          console.log("Inside getLoginStatus of homeController");
          $scope.datas = result;
          if ($scope.datas.loggedin === 'true') {
            $rootScope.isLoggedIn = true;
            $scope.employeedetail = myService.get();

            $http.get('/index.php/Session_controller/getEmployeeSearch')
              .success(function (result) {
                console.log("Inside getEmployeeSearch of EditEmployeeDetailController");
                console.log("Name :" + $scope.employeedetail.firstname);
                $scope.employeedetail = result;
                $scope.firstname = $scope.employeedetail.firstname;
                $scope.lastname = $scope.employeedetail.lastname;
                $scope.jobnumber = $scope.employeedetail.jobnumber;
                $scope.mobilenumber = $scope.employeedetail.mobilenumber;
                $scope.accountcreatedby = $scope.employeedetail.accountcreatedby;
                $scope.employeeid = $scope.employeedetail.employeeid;
                $scope.emp_card_no = $scope.employeedetail.emp_card_no;

              });
            console.log($scope.employeedetail.employeeid);
            $scope.firstname = $scope.employeedetail.firstname;
            $scope.lastname = $scope.employeedetail.lastname;
            $scope.jobnumber = $scope.employeedetail.jobnumber;
            $scope.mobilenumber = $scope.employeedetail.mobilenumber;
            $scope.accountcreatedby = $scope.employeedetail.accountcreatedby;
            $scope.employeeid = $scope.employeedetail.employeeid;
            $scope.emp_card_no = $scope.employeedetail.emp_card_no;
          }
          else {
            location.href = '/#/'
          }
          $scope.logout = function () {
            $http.get('/index.php/Session_controller/setLoginStatus')
              .success(function (result) {
                $rootScope.isLoggedIn = false;
                $window.localStorage.setItem('token', null);
                location.href = '/#/logout'
              });
          }
          $scope.deactivate_employee = function () {
            var fd = new FormData();
            fd.append('employeeid', $scope.employeedetail.employeeid);
            $http.post('/index.php/Employee_controller/deactivateEmployee', fd, {
              transformRequest: angular.identity,
              headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
              .success(function (result) {
                if (result.code == 200) {
                  console.log("Deactivated Successfully");
                  location.href = '/#/employee_detail'
                }
                else if (result.code == 401) {
                  $scope.logout();
                }

              })
              .error(function () {
                console.log("Update Failed");
              });
          }

          $scope.update_employee_detail = function () {
            var fd = new FormData();
            fd.append('mobilenumber', $scope.mobilenumber);
            fd.append('firstname', $scope.firstname);
            fd.append('lastname', $scope.lastname);
            fd.append('jobnumber', $scope.jobnumber);
            fd.append('employeeid', $scope.employeeid);
            fd.append('emp_card_no', $scope.emp_card_no);
            $http.post('/index.php/Employee_controller/updateEmployeeData', fd, {
              transformRequest: angular.identity,
              headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
              .success(function (result) {
                if (result.code == 200) {
                  console.log("Changed Success");
                  location.href = '/#/employee_detail'
                }
                else if (result.code == 401) {
                  $scope.logout();
                }

              })
              .error(function () {
                console.log("Update Failed");
              });
          }

        });


    }]);

app.factory('myService', function () {
  var savedData = {}
  function set(data) {
    savedData = data;
  }
  function get() {
    return savedData;
  }

  return {
    set: set,
    get: get
  }

});
