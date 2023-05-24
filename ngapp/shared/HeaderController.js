app.controller('HeaderController',
    ['$rootScope','$scope', '$location','$window','$http','Base64','$route',
    function ($rootScope,$scope, $location,$window,$http,Base64,$route) {
      console.log("Inside HeaderController");
      $scope.logout = function () {
        $http.get('/index.php/Session_controller/setLoginStatus')
                .success(function(result){
                  console.log("Inside setLoginStatus of HeaderController");
                  $window.localStorage.setItem('token',null);
                  $rootScope.isLoggedIn=false;
        });
    }
}]);
