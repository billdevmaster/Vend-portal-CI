app.controller('SignUpController',
  ['$rootScope', '$scope', 'Upload', '$timeout', '$location', '$window', '$http', 'Base64', '$filter',
    function ($rootScope, $scope, Upload, $timeout, $location, $window, $http, Base64, $filter) {
      console.log("Inside SignUpController");
      $scope.user_role = ["Full Access", "Ad Manager", "Machine Product Manager","Employee Manager"];
      $scope.mobilenumber_signup = $rootScope.mobilenumber_signup;
      $scope.firstname_signup = $rootScope.firstname_signup;
      $scope.lastname_signup = $rootScope.lastname_signup;
      $scope.emailid_signup = $rootScope.emailid_signup;
      $scope.organisation_signup = $rootScope.organisation_signup;
      $scope.username_signup = $rootScope.username_signup;


      $scope.callAdd = function () {
        if ($scope.password == $scope.confirmpassword) {

          $scope.formattedTime =   $filter('date')(new Date(), "HHmmss");

          $scope.organizationCode = $scope.organisation_signup.replace(' ', '');
          if($scope.organizationCode.length > 10){
            $scope.organizationCode = $scope.organizationCode.substring(0,10);
          }

          var fd = new FormData();
          fd.append('mobilenumber', $scope.mobilenumber_signup);
          fd.append('firstname', $scope.firstname_signup);
          fd.append('lastname', $scope.lastname_signup);
          fd.append('emailid', $scope.emailid_signup);
          fd.append('username', $scope.username_signup);
          fd.append('role', $scope.role);
          fd.append('password', $scope.password);
          fd.append('code', $scope.organizationCode+$scope.formattedTime);
          fd.append('address', $scope.address);
          fd.append('business_registration_number', $scope.business_registration_number);
          fd.append('organisation', $scope.organisation_signup);
          $http.post('/index.php/Signup_controller/checkExistence', fd, {
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined }
          }).success(function (result) {
            $scope.data = result;
            if ($scope.data.isPresent === 'mobile') {
              console.log("User Already Exist");
              $scope.errorMessage = 'Mobile Number already exist .'
            }
            else if ($scope.data.isPresent === 'email') {
              console.log("User Already Exist");
              $scope.errorMessage = 'Email ID already exist .'
            }
            else if ($scope.data.isPresent === 'code') {
              console.log("User Already Exist");
              $scope.errorMessage = 'Code already exist .'
            }
            else if ($scope.data.isPresent === 'username') {
              console.log("User Already Exist");
              $scope.errorMessage = 'Username already exist .'
            }
            else {

              console.log("No User With Same Credential Exist");
              $http.post('/index.php/Signup_controller/uploadAdmin', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined }
              })
                .success(function () {
                  console.log("Registered Successfully");
                  location.href = '/#/sign_up/sign_up_success'
                })
                .error(function () {
                  console.log("Sign Up Failed");
                });
            }


          })
            .error(function () {
              console.log("User Already Exists");
            });
        }
        else {
          $scope.errorMessage = 'Password does not match';
          console.log("Password doesn't match");
        }
      }


      $scope.terms = function () {
        $rootScope.mobilenumber_signup = $scope.mobilenumber_signup;
        $rootScope.firstname_signup = $scope.firstname_signup;
        $rootScope.lastname_signup = $scope.lastname_signup;
        $rootScope.emailid_signup = $scope.emailid_signup;
        $rootScope.organisation_signup = $scope.organisation_signup;
        $rootScope.username_signup = $scope.username_signup;
        location.href = '#/terms_and_conditions'
      }

      $scope.privacy = function () {
        $rootScope.mobilenumber_signup = $scope.mobilenumber_signup;
        $rootScope.firstname_signup = $scope.firstname_signup;
        $rootScope.lastname_signup = $scope.lastname_signup;
        $rootScope.emailid_signup = $scope.emailid_signup;
        $rootScope.organisation_signup = $scope.organisation_signup;
        $rootScope.username_signup = $scope.username_signup;
        location.href = '#/privacy_policy'
      }



    }]);
