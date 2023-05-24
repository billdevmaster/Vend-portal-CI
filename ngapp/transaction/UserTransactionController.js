app.controller('UserTransactionController',
    ['$rootScope','$scope','$http','$window',
    function ($rootScope,$scope,$http,$window) {
        console.log($window.localStorage.getItem("LoggedIn")+"main");
        $scope.data=[];
        $scope.filteredData=[];
        $http.get('/index.php/Session_controller/getLoginStatus')
                .success(function(result){
                  console.log("Inside getLoginStatus of UserTransactionController");
                  $scope.datas=result;
                    if($scope.datas.loggedin==='true'){
                        $rootScope.isLoggedIn=true;
                        $http.get('/index.php/Transaction_controller/getUserTransactionData')
                        .success(function(result){
                            $scope.datas=result;
                            $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                            $scope.exportData = [];
                            $scope.exportData.push(["Date", "Time", "Store","Amount","Debit","Credit"]);
                            angular.forEach($scope.datas, function(value, key) {
                                $scope.exportData.push([value.date,value.time, value.store,value.amount,value.amount_debit,value.amount_credit]);
                            });   
                        });
                    }
                    else{
                        location.href='/#/'
                    }  
                }); 
    }]);