app.controller('LoginController',
    ['$rootScope','$scope', '$location','$window','$http','Base64','$route',
    function ($rootScope,$scope, $location,$window,$http,Base64,$route) {
      console.log("Inside LoginController");
      $scope.mobilenumber_login=$rootScope.mobilenumber_login;
      $scope.password_login=$rootScope.password_login;
      console.log($rootScope.mobilenumber_login);
        $scope.login = function () {
          console.log("Inside Login");
        var fd = new FormData();
        fd.append('mobilenumber',$scope.mobilenumber_login);
        fd.append('password',Base64.encode($scope.password_login));
        $http.post('/index.php/User_controller/authenticateAdmin',fd,
            {
              transformRequest: angular.identity,
              headers: {'Content-Type': undefined}
           }
          ).then(function (response) {
            console.log(response.data);
            if (response.data.code == 200) { 
              console.log("Login Successful");
              location.href='/#/dashboard'
              $rootScope.isLoggedIn = true;
              $window.localStorage.setItem('isLoggedIn',true);
              $rootScope.token=response.data.token;
              $window.localStorage.setItem('token',response.data.token);
              $route.reload();
              $rootScope.isMachineManager=false;
              $window.localStorage.setItem('isMachineManager',false);
              $rootScope.isFnbManager=false;
              $window.localStorage.setItem('isFnbManager',false);
              $rootScope.isAdmin=false;
              $window.localStorage.setItem('isAdmin',false);
              $rootScope.isAdManager=false;
              $window.localStorage.setItem('isAdManager',false);
              $rootScope.isEmployeeManager=false;
              $window.localStorage.setItem('isEmployeeManager',false);
              $rootScope.isClient=false;
              $window.localStorage.setItem('isClient',false);
              $rootScope.clientId="-1";
              $window.localStorage.setItem('clientId',"-1");
              if(response.data.role=="Machine Product Manager"){
                $rootScope.isMachineManager=true;
                $window.localStorage.setItem('isMachineManager',true);
                $rootScope.isClient=true;
                $window.localStorage.setItem('isClient',true);
                $rootScope.clientId=response.data.client_id;
                $window.localStorage.setItem('clientId',response.data.client_id);
              }
              else if(response.data.role=="FnB Manager"){
                $rootScope.isFnbManager=true;
                $window.localStorage.setItem('isFnbManager',true);
                $rootScope.isClient=true;
                $window.localStorage.setItem('isClient',true);
                $rootScope.clientId=response.data.client_id;
                $window.localStorage.setItem('clientId',response.data.client_id);
              }
              else if(response.data.role=="Ad Manager"){
                $rootScope.isAdManager=true;
                $window.localStorage.setItem('isAdManager',true);
                $rootScope.isClient=true;
                $window.localStorage.setItem('isClient',true);
                $rootScope.clientId=response.data.client_id;
                $window.localStorage.setItem('clientId',response.data.client_id);
              }
              else if(response.data.role=="Employee Manager"){
                $rootScope.isEmployeeManager=true;
                $window.localStorage.setItem('isEmployeeManager',true);
                $rootScope.isClient=true;
                $window.localStorage.setItem('isClient',true);
                $rootScope.clientId=response.data.client_id;
                $window.localStorage.setItem('clientId',response.data.client_id);
              }
              else if(response.data.role=="Full Access"){
                $rootScope.fullAccess=true;
                $window.localStorage.setItem('fullAccess',true);
                $rootScope.isClient=true;
                $window.localStorage.setItem('isClient',true);
                $rootScope.clientId=response.data.client_id;
                $window.localStorage.setItem('clientId',response.data.client_id);
                console.log($rootScope.clientId);
              }
              else if(response.data.role=="Super Admin"){
                $rootScope.isAdmin=true;
                $window.localStorage.setItem('isAdmin',true);
              }
              
            }
            else if(response.data.code == 401) {
              console.log("Login Failed");
              $scope.errorMessage = 'Your Account is not Activated. Please reach out to support for more information'
            }  
            else {
              console.log("Login Failed");
              $scope.errorMessage = 'Authentication failed'
            }
          }, function (response) {
          });
        }


        $scope.terms = function(){
          $rootScope.mobilenumber_login=$scope.mobilenumber_login;
          $rootScope.password_login=$scope.password_login;
          location.href='#/terms_and_conditions'
        }

        $scope.privacy = function(){
          $rootScope.mobilenumber_login=$scope.mobilenumber_login;
          $rootScope.password_login=$scope.password_login;
          location.href='#/privacy_policy'
        }
}]);
