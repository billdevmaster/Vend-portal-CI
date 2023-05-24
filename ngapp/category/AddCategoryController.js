app.controller('AddCategoryController',
  ['$rootScope', '$scope', 'Upload', '$timeout', '$location', '$window', '$http', 'Base64',
    function ($rootScope, $scope, Upload, $timeout, $location, $window, $http, Base64) {

      $scope.isClient = $rootScope.isClient;
      $scope.clientId = $rootScope.clientId;
      $scope.imageFileName = "";

      if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
      }
      else {

        $http.get('/index.php/Client_controller/getMachineClients', {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $scope.clients = result.data;
              console.log($scope.clients);
            }
            else if (result.code == 401) {
              $scope.logout();
            }
          });
      }

      $scope.uploadFiles = function (file, errFiles) {
        $scope.f = file;
        $scope.errFile = errFiles && errFiles[0];
        if (file) {

          file.upload = Upload.upload({
            url: '/index.php/Category_controller/uploadCategoryImage',
            method: 'POST',
            file: file,
            data: { 'targetPath': '/ngapp/assets/images/category/original/' }
          });

          file.upload.then(function (response) {
            $timeout(function () {
              file.result = response.data;

              $scope.imageFileName = file.result.replace(/["]+/g, '');
            });
            $scope.errorMsg = false;
            $scope.btnEnabled = true;
          }, function (response) {
            if (response.status > 0)
              $scope.errorMsg = response.status + ': ' + response.data;
            if (response.data != 200) {
              file.progress = 0.0;
              $scope.errorMsg = 'Category Upload Failed , Please try again after sometime.';
            }

            console.log('Error status: ' + response.status);
          }, function (evt) {
            file.progress = Math.min(100, parseInt(100.0 *
              evt.loaded / evt.total));
            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
            console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
          });
        }
      }

      $scope.logout = function () {
        $http.get('/index.php/Session_controller/setLoginStatus')
          .success(function (result) {
            $rootScope.isLoggedIn = false;
            $window.localStorage.setItem('token', null);
            location.href = '/#/logout'
          });
      }

      $scope.apply = function () {
        var fd = new FormData();
        var prefix = "";
        fd.append('category_name', $scope.category_name);
        fd.append('category_id', $scope.category_id);
        fd.append('category_image', 'ngapp/assets/images/category/original/' + $scope.imageFileName);
        fd.append('category_image_thumbnail', 'ngapp/assets/images/category/thumbnail/' + $scope.imageFileName);
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
        $http.post('/index.php/Category_controller/checkCategoryIdValidity', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        }).success(function (result) {
          $scope.data = result;
          if (result.code == 200) {
            if (result.data.isPresent === 'category_id') {
              $scope.errorMessage = 'Category Code already exist .'
            }
            else {

              $http.post('/index.php/Category_controller/addCategory', fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
              })
                .success(function (result) {

                  if (result.code == 200) {
                    $("#buttonAlertPositive").show()
                    location.href = '/#/category'
                  }
                  else if (result.code == 401) {
                    $scope.logout();
                  }
                })
                .error(function () {
                  $("#buttonAlertNegative").show()

                });
            }
          }
          else if (result.code == 401) {
            $scope.logout();
          }

        })
          .error(function () {
            console.log("Product Already Exists");
          });
      }
    }]);
