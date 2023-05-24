app.controller('EditCategoryController',
  ['$rootScope', '$scope', 'Upload', '$timeout', '$location', '$window', '$http', 'Base64',
    function ($rootScope, $scope, Upload, $timeout, $location, $window, $http, Base64) {
      $scope.editMode = false;

      $scope.data = [];
      $scope.imageChoosen = false;
      $scope.btnEnabled = true;
      $scope.imageFileName = "";



      if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
        var fd = new FormData();
        fd.append('client_id', $rootScope.clientId);
        $http.post('/index.php/Category_controller/getDataByClientId', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $scope.data = result.category;
            }
            else if (result.code == 401) {
              $scope.logout();
            }
          });
      }
      else {
        $http.get('/index.php/Category_controller/getData', {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $scope.data = result.category;
            }
            else if (result.code == 401) {
              $scope.logout();
            }
          });

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
      $scope.editCategory = function (category) {
        $scope.category = category;
        $scope.editMode = true;
        console.log("Button Clicked");
        $scope.category_id = $scope.category.category_id;
        $scope.category_name = $scope.category.category_name;
        $scope.category_image = $scope.category.category_image;
        $scope.category_image_thumbnail = $scope.category.category_image_thumbnail;
        $scope.category_image_placeholder = $scope.category.category_image;
        for (var i = 0; i < $scope.clients.length; i++) {
          console.log($scope.clients[i].id + " " + $scope.category.client_id);
          if ($scope.clients[i].id == $scope.category.client_id) {
            console.log('Match');
            $scope.machine_client = $scope.clients[i];
          }
        }
      };

      $scope.removeCategory = function (category) {
        $scope.category = category;
        $scope.removeMode = true;
        console.log("Remove Button Clicked");
        $scope.category_id = $scope.category.category_id;
        $scope.category_name = $scope.category.category_name;
        $scope.category_image = $scope.category.category_image;
        $scope.category_image_thumbnail = $scope.category.category_image_thumbnail;
        $scope.category_image_placeholder = $scope.category.category_image;
        $scope.model = {
          isDisabled: true
        };
        for (var i = 0; i < $scope.clients.length; i++) {
          console.log($scope.clients[i].id + " " + $scope.category.client_id);
          if ($scope.clients[i].id == $scope.category.client_id) {
            console.log('Match');
            $scope.machine_client = $scope.clients[i];
          }
        }
      };

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
            $scope.category_image_placeholder = 'ngapp/assets/images/category/original/' + $scope.f.name;
            $timeout(function () {
              file.result = response.data;
              $scope.imageFileName = file.result.replace(/["]+/g, '');
            });
            console.log('Success ' + response.config.data.file.name + 'uploaded. Response: ' + response.data);
            $scope.errorMsg = false;
            $scope.imageChoosen = true;
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

      $scope.switchAddCategory = function () {
        location.href = '/#/add_category'
      }

      $scope.switchUploadCategoryList = function () {
        location.href = '/#/upload_category_list'
      }

      $scope.callAdd = function () {
        var fd = new FormData();
        fd.append('category_id', $scope.category_id);
        fd.append('category_name', $scope.category_name);
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
        if ($scope.imageChoosen) {
          fd.append('category_image', 'ngapp/assets/images/category/original/' + $scope.imageFileName);
          fd.append('category_image_thumbnail', 'ngapp/assets/images/category/thumbnail/' + $scope.imageFileName);
          if ('ngapp/assets/img/default_category.png' !== $scope.category.category_image) {
            var fd2 = new FormData();
            fd2.append('category_image', $scope.category.category_image);
            fd2.append('category_image_thumbnail', $scope.category.category_image_thumbnail);
            $http.post('/index.php/Category_controller/deleteImage', fd2, {
              transformRequest: angular.identity,
              headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
            });
          }
        }
        else {
          fd.append('category_image', $scope.category.category_image);
          fd.append('category_image_thumbnail', $scope.category.category_image_thumbnail);
        }

        $http.post('/index.php/Category_controller/addCategory', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $("#buttonAlertPositive").show()
              $window.location.reload();
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

      $scope.callRemove = function () {
        var fd = new FormData();
        console.log("Inside CallRemove");
        fd.append('category_id', $scope.category_id);
        fd.append('category_name', $scope.category_name);
        fd.append('category_image', $scope.category_image);
        fd.append('category_image_thumbnail', $scope.category_image_thumbnail);
        console.log($scope.category_thumbnail_image);
        $http.post('/index.php/Category_controller/deleteCategory', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {

            if (result.code == 200) {
              $("#buttonAlertPositive").show()
              $window.location.reload();
              location.href = '/#/category'
            }
            else if (result.code == 401) {
              $scope.logout();
            }
          })
          .error(function () {
            $("#buttonAlertNegative").show()

          });
      };

      $scope.logout = function () {
        $http.get('/index.php/Session_controller/setLoginStatus')
          .success(function (result) {
            $rootScope.isLoggedIn = false;
            $window.localStorage.setItem('token', null);
            location.href = '/#/logout'
          });
      }



    }]);
