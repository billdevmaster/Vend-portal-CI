app.controller('EditProductListController',
  ['$rootScope', '$scope', 'Upload', '$timeout', '$location', '$window', '$http', 'Base64',
    function ($rootScope, $scope, Upload, $timeout, $location, $window, $http, Base64) {
      $scope.editMode = false;
      $scope.imageFileName = "";
      $scope.imageMoreInfoFileName = "";

      $scope.data = [];
      $scope.imageChoosen = false;
      $scope.imageChoosenMoreInfo = false;

      $scope.isClient = $rootScope.isClient;
      $scope.clientId = $rootScope.clientId;

      if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
        var fd = new FormData();
        fd.append('client_id', $rootScope.clientId);
        $http.post('/index.php/Product_controller/getAllProductDataEditClient', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              $scope.data = result.products;
              $scope.fileName = Math.floor(100000 + Math.random() * 900000);
              $scope.exportData = [];
              $scope.exportData.push(["Product Code", "Product Name", "Product Price", "Product Description"]);
              angular.forEach($scope.data, function (value, key) {
                $scope.exportData.push([value.product_id, value.product_name, value.product_price, value.product_description]);
              });
            }
            else if (result.code == 401) {
              $scope.logout();
            }
          });
      }
      else {
        $http.get('/index.php/Product_controller/getAllProductDataEdit',
          {
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
          })
          .success(function (result) {
            if (result.code == 200) {
              $scope.data = result.products;
              $scope.fileName = Math.floor(100000 + Math.random() * 900000);
              $scope.exportData = [];
              $scope.exportData.push(["Product Code", "Product Name", "Product Price", "Product Description"]);
              angular.forEach($scope.data, function (value, key) {
                $scope.exportData.push([value.product_id, value.product_name, value.product_price, value.product_description]);
              });
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

      $scope.logout = function () {
        $http.get('/index.php/Session_controller/setLoginStatus')
          .success(function (result) {
            $rootScope.isLoggedIn = false;
            $window.localStorage.setItem('token', null);
            location.href = '/#/logout'
          });
      }


      $scope.editCategory = function (product) {
        $scope.product = product;
        $scope.editMode = true;
        console.log("Button Clicked");
        $scope.id = $scope.product.id;
        $scope.product_id = $scope.product.product_id;
        $scope.product_name = $scope.product.product_name;
        $scope.product_client_id = $scope.product.client_id;
        $scope.product_price = $scope.product.product_price;
        $scope.product_description = $scope.product.product_description;
        $scope.product_image_placeholder = $scope.product.product_image_thumbnail;
        $scope.product_image_thumbnail = $scope.product.product_image_thumbnail;
        $scope.product_original_image = $scope.product.product_image;
        $scope.product_more_info_image = $scope.product.product_more_info_image;
        $scope.product_more_info_image_placeholder = $scope.product.product_more_info_image_thumbnail;
        $scope.product_more_info_image_thumbnail = $scope.product.product_more_info_image_thumbnail;
        if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
          $scope.machine_client = $scope.clientId;
        }
        else {
          for (var i = 0; i < $scope.clients.length; i++) {
            if ($scope.clients[i].id == $scope.product.client_id) {
              $scope.selectedIndex = i;
            }
          }
          $scope.machine_client = $scope.clients[$scope.selectedIndex];
        }
      };

      $scope.removeCategory = function (product) {
        $scope.product = product;
        $scope.removeMode = true;
        console.log("Remove Button Clicked");
        $scope.id = $scope.product.id;
        $scope.product_id = $scope.product.product_id;
        $scope.product_name = $scope.product.product_name;
        $scope.product_client_id = $scope.product.client_id;
        $scope.product_price = $scope.product.product_price;
        $scope.product_description = $scope.product.product_description;
        $scope.product_image_placeholder = $scope.product.product_image_thumbnail;
        $scope.product_image_thumbnail = $scope.product.product_image_thumbnail;
        $scope.product_original_image = $scope.product.product_image;
        $scope.product_more_info_image = $scope.product.product_more_info_image;
        $scope.product_more_info_image_placeholder = $scope.product.product_more_info_image_thumbnail;
        $scope.product_more_info_image_thumbnail = $scope.product.product_more_info_image_thumbnail;
        $scope.model = {
          isDisabled: true
        };
        if ($rootScope.isClient == true || $rootScope.isClient == 'true') {
          $scope.machine_client = $scope.clientId;
        }
        else {
          for (var i = 0; i < $scope.clients.length; i++) {
            if ($scope.clients[i].id == $scope.product.client_id) {
              $scope.selectedIndex = i;
            }
          }
          $scope.machine_client = $scope.clients[$scope.selectedIndex];
        }
      };

      $scope.uploadFiles = function (file, errFiles) {
        $scope.f = file;
        $scope.errFile = errFiles && errFiles[0];
        if (file) {
          file.upload = Upload.upload({
            url: '/index.php/Product_controller/uploadProductImage',
            method: 'POST',
            file: file,
            data: { 'targetPath': '/ngapp/assets/images/product/original/' }
          });

          file.upload.then(function (response) {
            $timeout(function () {
              file.result = response.data;
              $scope.imageFileName = file.result.replace(/["]+/g, '');
              $scope.product_image_placeholder = 'ngapp/assets/images/product/thumbnail/' + $scope.imageFileName;
            });
            console.log('Success ' + response.config.data.file.name + 'uploaded. Response: ' + response.data);
            $scope.errorMsg = false;
            $scope.imageChoosen = true;
          }, function (response) {
            if (response.status > 0)
              $scope.errorMsg = response.status + ': ' + response.data;
            if (response.data != 200) {
              file.progress = 0.0;
              $scope.errorMsg = 'Product Upload Failed , Please try again after sometime.';
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






      $scope.uploadFilesMoreInfo = function (file, errFiles) {
        $scope.fi = file;
        $scope.errFile = errFiles && errFiles[0];
        if (file) {
          file.upload = Upload.upload({
            url: '/index.php/Product_controller/uploadProductImage',
            method: 'POST',
            file: file,
            data: { 'targetPath': '/ngapp/assets/images/product/original/' }
          });

          file.upload.then(function (response) {
            $timeout(function () {
              file.result = response.data;
              $scope.imageMoreInfoFileName = file.result.replace(/["]+/g, '');
              $scope.product_more_info_image_placeholder = 'ngapp/assets/images/product/thumbnail/' + $scope.imageMoreInfoFileName;
            });
            console.log('Success ' + response.config.data.file.name + 'uploaded. Response: ' + response.data);
            $scope.errorMsg = false;
            $scope.imageChoosenMoreInfo = true;
          }, function (response) {
            if (response.status > 0)
              $scope.errorMsg = response.status + ': ' + response.data;
            if (response.data != 200) {
              file.progress = 0.0;
              $scope.errorMsg = 'Product Upload Failed , Please try again after sometime.';
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

      $scope.switchAddProduct = function () {
        location.href = '/#/add_product'
      }

      $scope.switchUploadProductList = function () {
        location.href = '/#/upload_product_list'
      }

      $scope.callAdd = function () {
        console.log("Inside Apply EditCategoriesController");
        var fd = new FormData();
        fd.append('id', $scope.id);
        fd.append('product_id', $scope.product_id);
        fd.append('product_name', $scope.product_name);
        fd.append('product_price', $scope.product_price);
        fd.append('product_description', $scope.product_description);
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

        if ($scope.editCategoryName) {
          var fd1 = new FormData();
          fd1.append('id', $scope.id);
          fd1.append('product_id', $scope.product_id);
          fd1.append('category_id', $scope.category.category_id);

          $http.post('/index.php/Product_controller/assignProductToCategory', fd1, {
            transformRequest: angular.identity,
            headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
          })
            .success(function (result) {
              if (result.code == 200) {
                console.log('Product assigned to Category Successfully');
                location.href = '/#/product'
              }
              else if (result.code == 401) {
                $scope.logout();
              }
            })
            .error(function () {
              console.log('Product Assignment Failed');
            });
        }

        if ($scope.imageChoosen) {
          fd.append('product_image_thumbnail', 'ngapp/assets/images/product/thumbnail/' + $scope.imageFileName);
          fd.append('product_image', 'ngapp/assets/images/product/original/' + $scope.imageFileName);
          if ('ngapp/assets/img/default_category.png' !== $scope.product_original_image) {
            var fd2 = new FormData();
            fd2.append('product_image_thumbnail', $scope.product_image_thumbnail);
            fd2.append('product_image', $scope.product_original_image);
            $http.post('/index.php/Product_controller/deleteImage', fd2, {
              transformRequest: angular.identity,
              headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
            }).success(function (result) {
              if (result.code == 200) {

              }
              else if (result.code == 401) {
                $scope.logout();
              }

            });
          }



        }
        else {
          fd.append('product_image_thumbnail', $scope.product_image_thumbnail);
          fd.append('product_image', $scope.product_original_image);
        }


        if ($scope.imageChoosenMoreInfo) {
          fd.append('product_more_info_image', 'ngapp/assets/images/product/original/' + $scope.imageMoreInfoFileName);
          fd.append('product_more_info_image_thumbnail', 'ngapp/assets/images/product/thumbnail/' + $scope.imageMoreInfoFileName);
          if ('ngapp/assets/img/default_category.png' !== $scope.product_more_info_image) {
            var fd2 = new FormData();
            fd2.append('product_more_info_image', $scope.product_more_info_image);
            fd2.append('product_more_info_image_thumbnail', $scope.product_more_info_image_thumbnail);
            $http.post('/index.php/Product_controller/deleteImageMoreInfo', fd2, {
              transformRequest: angular.identity,
              headers: { 'Content-Type': undefined }
            });
          }
        }
        else {
          if (('ngapp/assets/img/default_category.png' === $scope.product_more_info_image )&& $scope.imageChoosen == true) {
            fd.append('product_more_info_image', 'ngapp/assets/images/product/original/' + $scope.imageFileName);
            fd.append('product_more_info_image_thumbnail', 'ngapp/assets/images/product/thumbnail/' + $scope.imageFileName);
          }
          else {
            fd.append('product_more_info_image', $scope.product_more_info_image);
            fd.append('product_more_info_image_thumbnail', $scope.product_more_info_image_thumbnail);
          }
        }
       
        $http.post('/index.php/Product_controller/updateMachineProductMap', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        }).success(function (result) {
          if (result.code == 200) {

          }
          else if (result.code == 401) {
            $scope.logout();
          }

        })
          .error(function () {

          });


        $http.post('/index.php/Product_controller/uploadProduct', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              location.href = '/#/product'
              $window.location.reload();
              $("#buttonAlertPositive").show()
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
        console.log("Inside CallRemove");
        console.log($scope.product_id);
        var fd1 = new FormData();
        fd1.append('id', $scope.id);
        fd1.append('product_id', $scope.product_id);

        $http.post('/index.php/Product_controller/deleteAssignProductToCategory', fd1, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {
            if (result.code == 200) {
              console.log('Product Assignment Delete Successfully');
              location.href = '/#/product'
            }
            else if (result.code == 401) {
              $scope.logout();
            }


          })
          .error(function () {
            console.log('Product Assignment Delete Failed');
          });
        var fd = new FormData();
        fd.append('id', $scope.id);
        fd.append('product_id', $scope.product_id);
        fd.append('client_id', $scope.product_client_id);
        fd.append('product_image_thumbnail', $scope.product_image_thumbnail);
        fd.append('product_image', $scope.product_original_image);
        fd.append('product_more_info_image', $scope.product_more_info_image);
        fd.append('product_more_info_image_thumbnail', $scope.product_more_info_image_thumbnail);
        $http.post('/index.php/Product_controller/deleteProductController', fd, {
          transformRequest: angular.identity,
          headers: { 'Content-Type': undefined, 'Authorization': $rootScope.token, 'ClientId': $rootScope.clientId }
        })
          .success(function (result) {

            if (result.code == 200) {
              $("#buttonAlertPositive").show()
              $window.location.reload();
              location.href = '/#/product'
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
