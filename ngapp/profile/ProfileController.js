app.controller('ProfileController',
    ['$rootScope','$scope', 'Upload', '$timeout','$location','$window','$http','Base64',
    function ($rootScope,$scope,Upload, $timeout, $location,$window,$http,Base64) {
        console.log("Inside ProfileController");
        $http.get('/loyaltyuser/index.php/Session_controller/getLoginStatus')
        .success(function(result){
          console.log("Inside getLoginStatus of TransactionController");
          $scope.data=result;
            if($scope.data.loggedin==='true'){
                $rootScope.isLoggedIn=true;
            }  
        });
        $http.get('/loyaltyuser/index.php/User_controller/getData')
            .success(function(result){
              console.log("Inside getData of ProfileController");
                $scope.data=result;
                console.log($scope.data.mobilenumber);
                $scope.mobilenumber=$scope.data.mobilenumber;
                $scope.firstname=$scope.data.firstname;
                $scope.lastname=$scope.data.lastname;
                $scope.emailid=$scope.data.emailid;
            });


            $scope.callAdd = function () {
              var fd = new FormData();
              fd.append('mobilenumber', $scope.mobilenumber);
              fd.append('firstname',$scope.firstname);
              fd.append('lastname',$scope.lastname);
              fd.append('emailid',$scope.emailid);
              fd.append('upt_no',$scope.data.upt_no);
              $http.post('/loyaltyuser/index.php/User_controller/updateData', fd, {
                 transformRequest: angular.identity,
                 headers: {'Content-Type': undefined}
              })
              .success(function(){
                console.log("Changed Success");
                location.href='/loyaltyuser/#/'
              })
              .error(function(){
                console.log("Update Failed");
              });
            }
        }]);
