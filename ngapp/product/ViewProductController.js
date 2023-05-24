app.controller('ViewProductController',
  ['$rootScope', '$scope', '$http', '$window',
    function ($rootScope, $scope, $http, $window) {
      $scope.data = [];
      $scope.filteredData = [];

      $scope.callProduct = function (category) {
        console.log("callProduct clicked");
        $scope.category = category;
        var fd = new FormData();
        fd.append('product_category_id', $scope.category.category_id);
        $http.post('/index.php/Product_controller/sendCategoryId', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              location.href = '/#/product_list'
            }
            else if (result.code == 401) {
              $scope.logout();
            }
          })
          .error(function () {
          });

      };

      $scope.logout = function () {
        $http.get('/index.php/Session_controller/setLoginStatus')
          .success(function (result) {
            $rootScope.isLoggedIn = false;
            $window.localStorage.setItem('token',null);
            location.href = '/#/logout'
          });
      }

    }]);
