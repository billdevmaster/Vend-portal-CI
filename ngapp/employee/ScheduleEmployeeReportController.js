app.controller('ScheduleEmployeeReportController',
  ['$rootScope', '$scope', 'Upload', '$timeout', '$location', '$window', '$http', 'Base64',
    function ($rootScope, $scope, Upload, $timeout, $location, $window, $http, Base64) {
      console.log("Inside ScheduleEmployeeReportController");

      $scope.isClient = $rootScope.isClient;
      $scope.clientId = $rootScope.clientId;
      $scope.frequencyOptions = ["Daily", "Weekly", "Monthly"];
      $scope.showTable = false;
      var prefix;
      if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
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

      $scope.apply = function () {
        var fd = new FormData();
        fd.append('type', "EMPLOYEE_REPORT");
        fd.append('email', $scope.email);
        fd.append('frequency', $scope.frequency);
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
        $http.post('/index.php/ReportEmail_controller/insertReportEmail', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        }).success(function (result) {
          if (result.code == 200) {
            console.log("Employee Report Schedule Inserted Successfully");
            $window.location.reload();
            location.href = '/#/schedule_employee_report'
          }
          else if (result.code == 401) {
            $scope.logout();
          }
        })
          .error(function () {
            console.log("Employee Report Schedule Insertion Failed");
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
        fd.append('type', 'EMPLOYEE_REPORT');
        $http.post('/index.php/ReportEmail_controller/getReportEmailByClientId', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              console.log(result);
              $scope.report_emails = result.report_emails;
              if ($scope.report_emails.length == 0) {
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
        fd.append('type', 'EMPLOYEE_REPORT');
        $http.post('/index.php/ReportEmail_controller/getReportEmail', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              console.log(result);
              $scope.report_emails = result.report_emails;
              if ($scope.report_emails.length == 0) {
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

      $scope.removeScheduleEmployeeReport = function (reportEmail) {
        console.log("Inside Remove Employee Report Email : " + reportEmail);
        $scope.report_email = reportEmail;
        var fd = new FormData();
        fd.append('id', $scope.report_email.id);
        $http.post('/index.php/ReportEmail_controller/deleteReportEmail', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $window.location.reload();
              location.href = '/#/schedule_employee_report'
            }
            else if (result.code == 401) {
              $scope.logout();
            }

          })
          .error(function () {

          });
      };
    }]);
