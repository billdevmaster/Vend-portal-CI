app.controller('homeController',
    ['$rootScope','$scope', 'Upload', '$timeout','$location','$window','$http','Base64',
    function ($rootScope,$scope,Upload, $timeout, $location,$window,$http,Base64) {
        console.log("Inside homeController");
        $http.get('/loyaltyuser/index.php/Session_controller/getUserName')
            .success(function(result){
              console.log("Inside getData of homeController");
                $scope.data=result;
                console.log($scope.data.firstname);
                $scope.TextName=$scope.data.firstname; 
                $http.get('/loyaltyuser/index.php/Session_controller/getLoginStatus')
                .success(function(result){
                  console.log("Inside getLoginStatus of homeController");
                  $scope.data=result;
                    if($scope.data.loggedin==='true'){
                        $rootScope.isLoggedIn=true;
                    }  
                }); 
            });
          
        }]);
