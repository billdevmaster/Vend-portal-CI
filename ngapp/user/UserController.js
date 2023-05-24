app.controller('UserController',
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
            $http.get('/index.php/User_controller/getUserData', {
              transformRequest: angular.identity,
              headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
              .success(function (result) {
                if (result.code == 200) {
                  $scope.data_user = result.data;

                  $scope.fileName = Math.floor(100000 + Math.random() * 900000);
                  $scope.exportData = [];
                  $scope.exportData.push(["Card No.", "First Name", "Last Name", "Email", "Account Balance"]);
                  angular.forEach($scope.data_user, function (value, key) {
                    $scope.exportData.push([value.card_no, value.firstname, value.lastname, value.emailid, value.account_balance]);
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

      $scope.set_card_no = function (user) {
        console.log(user.card_no);
        $scope.user_detail_card = user.card_no;
        myService.set(user);
        var fd = new FormData();
        console.log(user.upt_no);
        fd.append('upt_no', user.upt_no);
        $http.post('/index.php/Session_controller/setUserSearch', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined }
        })
          .success(function () {
            console.log("User Detail Saved");
            location.href = "/#/user_detail"
          })
          .error(function () {
            console.log("User Detail Save Failed");
            location.href = "/#/user_detail"
          });

      }
    }]);

app.controller('UserDetailController',
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
            $scope.userdetail = myService.get();

            $http.get('/index.php/Session_controller/getUserSearch')
              .success(function (result) {
                console.log("Inside getUserSearch of UserDetailedController");
                $scope.userdetail = result;
                $scope.user_detail_card = $scope.userdetail.card_no;
                $scope.firstname = $scope.userdetail.firstname;
                $scope.lastname = $scope.userdetail.lastname;
                $scope.emailid = $scope.userdetail.emailid;
                $scope.oldemailid = $scope.userdetail.emailid;
                $scope.mobilenumber = $scope.userdetail.mobilenumber;
                $scope.oldmobilenumber = $scope.userdetail.mobilenumber;
                $scope.upt_no = $scope.userdetail.upt_no;
                $scope.activated_on = $scope.userdetail.activated_on;
                $scope.last_updated = $scope.userdetail.last_updated;
                $scope.account_balance = $scope.userdetail.account_balance;
              });
            console.log($scope.userdetail.card_no);
            $scope.user_detail_card = $scope.userdetail.card_no;
            $scope.firstname = $scope.userdetail.firstname;
            $scope.lastname = $scope.userdetail.lastname;
            $scope.emailid = $scope.userdetail.emailid;
            $scope.oldemailid = $scope.userdetail.emailid;
            $scope.mobilenumber = $scope.userdetail.mobilenumber;
            $scope.oldmobilenumber = $scope.userdetail.mobilenumber;
            $scope.upt_no = $scope.userdetail.upt_no;
            $scope.activated_on = $scope.userdetail.activated_on;
            $scope.last_updated = $scope.userdetail.last_updated;
            $scope.account_balance = $scope.userdetail.account_balance;
          }
          else {
            location.href = '/#/'
          }


          $scope.user_transaction_details = function () {
            location.href = '/#/user_transaction'
          }

          $scope.deactivate_user = function () {
            var fd = new FormData();
            fd.append('upt_no', $scope.upt_no);
            $http.post('/index.php/User_controller/deactivateUser', fd, {
              transformRequest: angular.identity,
              headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            })
              .success(function (result) {
                if (result.code == 200) {
                  console.log("Deactivated Successfully");
                  location.href = '/#/user'
                }
                else if (result.code == 401) {
                  $scope.logout();
                }

              })
              .error(function () {
                console.log("Update Failed");
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

          $scope.update_user_detail = function () {
            var fd = new FormData();
            fd.append('mobilenumber', $scope.mobilenumber);
            fd.append('oldmobilenumber', $scope.oldmobilenumber);
            fd.append('firstname', $scope.firstname);
            fd.append('lastname', $scope.lastname);
            fd.append('emailid', $scope.emailid);
            fd.append('oldemailid', $scope.oldemailid);
            fd.append('account_balance', $scope.account_balance);
            fd.append('activated_on', $scope.activated_on);
            fd.append('last_updated', $scope.last_updated);
            fd.append('upt_no', $scope.upt_no);
            $http.post('/index.php/User_controller/checkExistence', fd, {
              transformRequest: angular.identity,
              headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
            }).success(function (result) {
              if (result.code == 200) {
                $scope.data = result;
                if ($scope.data.isPresent === 'mobile') {
                  console.log("User Already Exist");
                  $scope.errorMessage = 'Mobile Number already exist .'
                }
                else if ($scope.data.isPresent === 'email') {
                  console.log("User Already Exist");
                  $scope.errorMessage = 'Email ID already exist .'
                }
                else {
                  console.log("No User With Same Credential Exist");
                  $http.post('/index.php/User_controller/updateUserData', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
                  })
                    .success(function (result) {
                      if (result.code == 200) {
                        console.log("Changed Success");
                        location.href = '/#/user'
                      }
                      else if (result.code == 401) {
                        $scope.logout();
                      }

                    })
                    .error(function () {
                      console.log("Update Failed");
                    });
                }
              }
              else if (result.code == 401) {
                $scope.logout();
              }
            })
              .error(function () {
                console.log("User Already Exists");
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
