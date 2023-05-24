app.controller('MachineProductMapController',
  ['$rootScope', '$scope', '$http', '$window', '$location', '$anchorScroll', 'anchorSmoothScroll',
    function ($rootScope, $scope, $http, $window, $location, $anchorScroll, anchorSmoothScroll) {
      $scope.data = [];
      $scope.filteredData = [];
      $scope.selectedPosition = $rootScope.selectedPosition;
      $http.get('/index.php/Machine_controller/getMachineMapData', {
        transformRequest: angular.identity,
        headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
      })
        .success(function (result) {
          if (result.code == 200) {
            $scope.data = result.data;
            console.log($scope.data);
          }
          else if (result.code == 401) {
            $scope.logout();
          }

        });
      $scope.logout = function () {
        $http.get('/index.php/Session_controller/setLoginStatus')
          .success(function (result) {
            $rootScope.isLoggedIn = false;
            $window.localStorage.setItem('token', null);
            location.href = '/#/logout'
          });
      }
      $scope.editProductMap = function (product) {
        console.log("editProductMap clicked");
        $scope.product = product;
        $rootScope.selectedPosition = $scope.product.id;
        console.log("editProductMap clicked" + $scope.product.id);
        var fd = new FormData();
        fd.append('product_machine_map_id', $scope.product.id);
        fd.append('product_location', $scope.product.product_location);
        fd.append('product_quantity', $scope.product.product_quantity);
        fd.append('product_name', $scope.product.product_name);
        fd.append('category_id', $scope.product.category_id);
        fd.append('selected_machine_id', $scope.product.machine_id);
        $http.post('/index.php/Machine_controller/setProductMachineMapId', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId' : $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              location.href = '/#/fill_machine_product_map'
            }
            else if (result.code == 401) {
              $scope.logout();
            }

          })
          .error(function () {
          });
      };

      $scope.gotoElement = function (eID) {
        anchorSmoothScroll.scrollTo(eID);

      };


    }]);

app.service('anchorSmoothScroll', function () {

  this.scrollTo = function (eID) {

    // This scrolling function 
    // is from http://www.itnewb.com/tutorial/Creating-the-Smooth-Scroll-Effect-with-JavaScript
    var startY = currentYPosition();
    var stopY = elmYPosition(eID);
    var distance = stopY > startY ? stopY - startY : startY - stopY;
    if (distance < 100) {
      scrollTo(0, stopY); return;
    }
    var speed = Math.round(distance / 100);
    if (speed >= 20) speed = 20;
    var step = Math.round(distance / 25);
    var leapY = stopY > startY ? startY + step : startY - step;
    var timer = 0;
    if (stopY > startY) {
      for (var i = startY; i < stopY; i += step) {
        setTimeout("window.scrollTo(0, " + leapY + ")", timer * speed);
        leapY += step; if (leapY > stopY) leapY = stopY; timer++;
      } return;
    }
    for (var i = startY; i > stopY; i -= step) {
      setTimeout("window.scrollTo(0, " + leapY + ")", timer * speed);
      leapY -= step; if (leapY < stopY) leapY = stopY; timer++;
    }

    function currentYPosition() {
      // Firefox, Chrome, Opera, Safari
      if (self.pageYOffset) return self.pageYOffset;
      // Internet Explorer 6 - standards mode
      if (document.documentElement && document.documentElement.scrollTop)
        return document.documentElement.scrollTop;
      // Internet Explorer 6, 7 and 8
      if (document.body.scrollTop) return document.body.scrollTop;
      return 0;
    }

    function elmYPosition(eID) {
      var elm = document.getElementById(eID);
      var y = elm.offsetTop;
      var node = elm;
      while (node.offsetParent && node.offsetParent != document.body) {
        node = node.offsetParent;
        y += node.offsetTop;
      } return y;
    }

  };

});

app.directive('myMainDirective', function () {
  return function (scope, element, attrs) {
    setTimeout(function () {
      if (scope.selectedPosition != "_0") {
        scope.gotoElement(scope.selectedPosition);
      }
    }, 1000);
  };
});
