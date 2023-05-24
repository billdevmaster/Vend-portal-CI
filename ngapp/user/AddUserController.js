var app = angular.module('VendWebApp');
app.controller('AddUserController',
  ['$rootScope', '$scope', 'Upload', '$timeout', '$location', '$window', '$http', 'Base64',
    function ($rootScope, $scope, Upload, $timeout, $location, $window, $http, Base64) {


      $scope.isClient = $rootScope.isClient;
      $scope.clientId = $rootScope.clientId;
      $scope.imageFileName = "";
      $scope.disableButton = false;

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

      $scope.add_user_detail = function () {
        console.log('add_user_detail Called');


        if ($scope.add_user_password == $scope.add_user_confirm_password) {
          $scope.disableButton = true;
          var fd = new FormData();
          fd.append('mobilenumber', $scope.add_user_mobile_number);
          fd.append('firstname', $scope.add_user_first_name);
          fd.append('lastname', $scope.add_user_last_name);
          fd.append('username', $scope.add_user_name);
          fd.append('emailid', $scope.add_user_email_id);
          fd.append('password', $scope.add_user_password);
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
          $http.post('/index.php/User_controller/checkUserNameExistence', fd, {
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
          }).success(function (result) {
            if (result.code == 200) {
              $scope.data = result.data;
              if ($scope.data.isPresent === 'mobile') {
                console.log("User Already Exist");
                $scope.errorMessage = 'Mobile Number already exist .'
                $scope.disableButton = false;
              }
              else if ($scope.data.isPresent === 'email') {
                console.log("User Already Exist");
                $scope.errorMessage = 'Email ID already exist .'
                $scope.disableButton = false;
              }
              else if ($scope.data.isPresent === 'username') {
                console.log("User Already Exist");
                $scope.errorMessage = 'Username already exist .'
                $scope.disableButton = false;
              }
              else {

                console.log("No User With Same Credential Exist");
                $http.post('/index.php/Signup_controller/uploadUser', fd, {
                  transformRequest: angular.identity,
                  headers: { 'Content-Type': undefined }
                })
                  .success(function () {
                    console.log("Registered Successfully");
                    location.href = '/#/user/add_user_success'
                  })
                  .error(function () {
                    console.log("Sign Up Failed");
                  });
              }
            }
            else if (result.code == 401) {
              $scope.logout();
            }

          })
            .error(function () {
              console.log("User Already Exists");
              $scope.disableButton = false;
            });
        }
        else {
          $scope.errorMessage = 'Password does not match';
          console.log("Password doesn't match");
          $scope.disableButton = false;
        }




      }
    }]);
