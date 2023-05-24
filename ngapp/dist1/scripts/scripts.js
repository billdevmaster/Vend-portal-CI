/**
 * AngularJS Tutorial 1
 * @author Nick Kaye <nick.c.kaye@gmail.com>
 */

/**
 * Main AngularJS Web Application
 */
'use strict';

var app = angular.module('tutorialWebApp', [
  'ngRoute','ngFileUpload','ui.bootstrap','angularUtils.directives.dirPagination']).run(['$rootScope','$location',function($rootScope,$location) {
    $rootScope.location = $location; 
}]);

app.factory('Base64', function () {
    /* jshint ignore:start */

    var keyStr = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';

    return {
        encode: function (input) {
            var output = "";
            var chr1, chr2, chr3 = "";
            var enc1, enc2, enc3, enc4 = "";
            var i = 0;

            do {
                chr1 = input.charCodeAt(i++);
                chr2 = input.charCodeAt(i++);
                chr3 = input.charCodeAt(i++);

                enc1 = chr1 >> 2;
                enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                enc4 = chr3 & 63;

                if (isNaN(chr2)) {
                    enc3 = enc4 = 64;
                } else if (isNaN(chr3)) {
                    enc4 = 64;
                }

                output = output +
                    keyStr.charAt(enc1) +
                    keyStr.charAt(enc2) +
                    keyStr.charAt(enc3) +
                    keyStr.charAt(enc4);
                chr1 = chr2 = chr3 = "";
                enc1 = enc2 = enc3 = enc4 = "";
            } while (i < input.length);

            return output;
        },

        decode: function (input) {
            var output = "";
            var chr1, chr2, chr3 = "";
            var enc1, enc2, enc3, enc4 = "";
            var i = 0;

            // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
            var base64test = /[^A-Za-z0-9\+\/\=]/g;
            if (base64test.exec(input)) {
                window.alert("There were invalid base64 characters in the input text.\n" +
                    "Valid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\n" +
                    "Expect errors in decoding.");
            }
            input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

            do {
                enc1 = keyStr.indexOf(input.charAt(i++));
                enc2 = keyStr.indexOf(input.charAt(i++));
                enc3 = keyStr.indexOf(input.charAt(i++));
                enc4 = keyStr.indexOf(input.charAt(i++));

                chr1 = (enc1 << 2) | (enc2 >> 4);
                chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                chr3 = ((enc3 & 3) << 6) | enc4;

                output = output + String.fromCharCode(chr1);

                if (enc3 != 64) {
                    output = output + String.fromCharCode(chr2);
                }
                if (enc4 != 64) {
                    output = output + String.fromCharCode(chr3);
                }

                chr1 = chr2 = chr3 = "";
                enc1 = enc2 = enc3 = enc4 = "";

            } while (i < input.length);

            return output;
        }
    };

    /* jshint ignore:end */
});
/**
 * Configure the Routes
 */
app.config(['$routeProvider', function ($routeProvider) {
//app.config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {
  $routeProvider
    //login
    .when("", {templateUrl: "ngapp/login/login.html", controller: "LoginController"})
    .when("/", {templateUrl: "ngapp/login/login.html", controller: "LogoutCtrl"}) 
    .when("/login", {templateUrl: "ngapp/login/login.html", controller: "LoginController"})
    // Home
    .when("/home", {templateUrl: "ngapp/home/home.html", controller: "PageCtrl"})
    // Pages
    .when("/about", {templateUrl: "ngapp/about/about.html", controller: "PageCtrl"})
    .when("/faq", {templateUrl: "ngapp/faq/faq.html", controller: "PageCtrl"})
    .when("/pricing", {templateUrl: "ngapp/pricing/pricing.html", controller: "PageCtrl"})
    .when("/services", {templateUrl: "ngapp/services/services.html", controller: "PageCtrl"})
    .when("/contact", {templateUrl: "ngapp/contact/contact.html", controller: "ContactController"})
    .when("/products", {templateUrl: "ngapp/products/products.html", controller: "PageCtrl"})
    // Blog
    .when("/blog", {templateUrl: "ngapp/blog/blog.html", controller: "BlogCtrl"})
    .when("/blog/post", {templateUrl: "ngapp/blog/blog_item.html", controller: "BlogCtrl"})
    //Categories
    .when("/categories/view_categories", {templateUrl: "ngapp/categories/view_categories.html", controller: "CategoriesController"})
    .when("/categories/add_categories", {templateUrl: "ngapp/categories/add_categories.html", controller: "AddCategoriesController"})
    .when("/categories/edit_categories", {templateUrl: "ngapp/categories/edit_categories.html", controller: "EditCategoriesController"})
    //Products
    .when("/products/view_products", {templateUrl: "ngapp/products/view_products.html", controller: "ProductsController"})
    .when("/products/add_products", {templateUrl: "ngapp/products/add_products.html", controller: "AddProductsController"})
    .when("/products/edit_products", {templateUrl: "ngapp/products/edit_products.html", controller: "EditProductsController"})
    .when("/products/product_list", {templateUrl: "ngapp/products/product_list.html", controller: "ProductListController"})
    .when("/products/edit_product_list", {templateUrl: "ngapp/products/edit_product_list.html", controller: "EditProductListController"})
    //Career
    .when("/career", {templateUrl: "ngapp/career/career.html", controller: "CareerController"})
    .when("/career/careerFeedback", {templateUrl: "ngapp/career/careerFeedback.html", controller: "PageCtrl"})
    .when("/career/careerFeedbackNegative", {templateUrl: "ngapp/career/careerFeedbackNegative.html", controller: "PageCtrl"})
    //Contact
    .when("/contact/contactFeedbackPositive", {templateUrl: "ngapp/contact/contactFeedbackPositive.html", controller: "PageCtrl"})
    .when("/contact/contactFeedbackNegative", {templateUrl: "ngapp/contact/contactFeedbackNegative.html", controller: "PageCtrl"})
    //register
    .when("/register", {templateUrl: "ngapp/register/register.html", controller: "RegisterController"})
    // else 404
    .otherwise("/404", {templateUrl: "ngapp/shared/404.html", controller: "PageCtrl"});

   // $locationProvider.html5Mode(true);
}]);

/**
 * Controls the Blog
 */
app.controller('BlogCtrl', function (/* $scope, $location, $http */) {
  console.log("Blog Controller reporting for duty.");
});

/**
 * Controls all other Pages
 */
app.controller('PageCtrl',['$window', function ($window/* $scope, $location, $http */) {
  console.log("Page Controller reporting for duty.");
  console.log($window.localStorage.getItem("LoggedIn")+"main");
  if($window.localStorage.getItem("LoggedIn")!="true"){
    $window.location ='#/login'
  }

  // Activates the Carousel
  $('.carousel').carousel({
    interval: 5000
  });

  // Activates Tooltips for Social Links
  $('.tooltip-social').tooltip({
    selector: "a[data-toggle=tooltip]"
  });
  
}]);

app.controller('LogoutCtrl',['$window', function ($window/* $scope, $location, $http */) {
    console.log("Logout Controller reporting for duty.");
    $window.localStorage.setItem("LoggedIn","false");
    console.log( $window.localStorage.getItem("LoggedIn")+"Logout");
    //$window.location ='#/login'

  }]);




(function ($) {
    "use strict";


    /*==================================================================
    [ Focus input ]*/
    $('.input100').each(function(){
        $(this).on('blur', function(){
            if($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }
            else {
                $(this).removeClass('has-val');
            }
        })    
    })
  
  
    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        return check;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    
    /*==================================================================
    [ Show pass ]*/
    var showPass = 0;
    $('.btn-show-pass').on('click', function(){
        if(showPass == 0) {
            $(this).next('input').attr('type','text');
            $(this).addClass('active');
            showPass = 1;
        }
        else {
            $(this).next('input').attr('type','password');
            $(this).removeClass('active');
            showPass = 0;
        }
        
    });


})(jQuery);
app.controller('CareerController',
    ['$scope', 'Upload', '$timeout','$location','$window','$http','Base64',
    function ($scope,Upload, $timeout, $location,$window,$http,Base64) {
        console.log($window.localStorage.getItem("LoggedIn")+"main");
        if($window.localStorage.getItem("LoggedIn")!="true"){
          $window.location ='#/login'
        }
   $scope.uploadFiles = function(file, errFiles) {
        $scope.f = file;
        $scope.errFile = errFiles && errFiles[0];
        if (file) {
            
            file.upload = Upload.upload({
                url: '/qorderadmin/index.php/Career_controller/uploadDocuments',
                method: 'POST',
                file: file,
                data: {'targetPath' : '/qorderadmin/application/uploads/'}
            });

            file.upload.then(function (response) {
                $timeout(function () {
                    file.result = response.data;
                });
                console.log('Success ' + response.config.data.file.name + 'uploaded. Response: ' + response.data);
                $scope.errorMsg=false;
                $scope.btnEnabled=true;
            }, function (response) {
                if (response.status > 0)
                    $scope.errorMsg = response.status + ': ' + response.data;
                  if(response.data!=200){
                    file.progress=0.0;
                    $scope.errorMsg='File Upload Failed , Please try again after sometime.';
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

        $scope.apply = function () {
          var fd = new FormData();
          fd.append('file', $scope.candidate_cv);
          fd.append('name',$scope.candidate_name);
          fd.append('email',$scope.candidate_email);
          fd.append('phone',$scope.candidate_phone);
          fd.append('message',$scope.candidate_message);
          fd.append('file_name',$scope.f.name);
          $http.post('/qorderadmin/index.php/Career_controller/uploadCandidate', fd, {
             transformRequest: angular.identity,
             headers: {'Content-Type': undefined}
          })
          .success(function(){
            
                location.href='/qorderadmin/#/career/careerFeedback'
                $http.post('/qorderadmin/index.php/Career_controller/sendMail', fd, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined}
                })
                .success(function(){
                   console.log("done");
                })
                .error(function(){
                   console.log("not done");
                });
          })
          .error(function(){
            location.href='/qorderadmin/#/career/careerFeedbackNegative'
          });
          
        }
        }]);

app.controller('AddCategoriesController',
    ['$scope', 'Upload', '$timeout','$location','$window','$http','Base64',
    function ($scope,Upload, $timeout, $location,$window,$http,Base64) {
        console.log($window.localStorage.getItem("LoggedIn")+"main");
        if($window.localStorage.getItem("LoggedIn")!="true"){
          $window.location ='#/login'
        }
   $scope.uploadFiles = function(file, errFiles) {
        $scope.f = file;
        $scope.errFile = errFiles && errFiles[0];
        if (file) {
            
            file.upload = Upload.upload({
                url: '/qorderadmin/index.php/Categories_controller/uploadCategoryImage',
                method: 'POST',
                file: file,
                data: {'targetPath' : '/qorderadmin/ngapp/assets/img/category'}
            });

            file.upload.then(function (response) {
                $timeout(function () {
                    file.result = response.data;
                });
                console.log('Success ' + response.config.data.file.name + 'uploaded. Response: ' + response.data);
                $scope.errorMsg=false;
                $scope.btnEnabled=true;
            }, function (response) {
                if (response.status > 0)
                    $scope.errorMsg = response.status + ': ' + response.data;
                  if(response.data!=200){
                    file.progress=0.0;
                    $scope.errorMsg='Category Upload Failed , Please try again after sometime.';
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

        $scope.apply = function () {
          var fd = new FormData();
          fd.append('cat_image_file', $scope.cat_image_file);
          fd.append('cat_title',$scope.cat_title);
          fd.append('cat_description',$scope.cat_description);
          fd.append('cat_id',$scope.cat_id);
          fd.append('cat_image','ngapp/assets/img/category/thumbnail/'+$scope.f.name);
          fd.append('del_image','ngapp/assets/img/category/'+$scope.f.name);
          $http.post('/qorderadmin/index.php/Categories_controller/uploadCategories', fd, {
             transformRequest: angular.identity,
             headers: {'Content-Type': undefined}
          })
          .success(function(){
            $("#buttonAlertPositive").show()
            location.href='/qorderadmin/#/categories/view_categories'
            toastr["success"]("Category Updated Successfully .", "Success")

                        toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": true,
                        "progressBar": false,
                        "positionClass": "toast-bottom-right",
                        "preventDuplicates": true,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "1000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                        }
          })
          .error(function(){
            $("#buttonAlertNegative").show()
            toastr["error"]("Failed to add category. Please try again.", "Failure")

            toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "1000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
            }
          });
          
        }
        }]);

app.controller('CategoriesController',
    ['$scope','$http','$window',
    function ($scope,$http,$window) {
        console.log($window.localStorage.getItem("LoggedIn")+"main");
        if($window.localStorage.getItem("LoggedIn")!="true"){
          $window.location ='#/login'
        }
        $scope.data=[];
        $scope.filteredData=[];
        $http.get('/qorderadmin/index.php/Categories_controller/getData')
            .success(function(result){
                $scope.data=result;
            });
    }]);
app.controller('EditCategoriesController',
['$scope', 'Upload', '$timeout','$location','$window','$http','Base64',
function ($scope,Upload, $timeout, $location,$window,$http,Base64)  {
        $scope.editMode=false;
        console.log($window.localStorage.getItem("LoggedIn")+"main");
        if($window.localStorage.getItem("LoggedIn")!="true"){
          $window.location ='#/login'
        }
        $scope.data=[];
        $scope.imageChoosen=false;

        $http.get('/qorderadmin/index.php/Categories_controller/getData')
            .success(function(result){
                $scope.data=result;
            });
            $scope.editCategory = function(category) {
                $scope.category=category;
               $scope.editMode=true;
               console.log("Button Clicked");
               $scope.cat_id=$scope.category.cat_id;
               $scope.cat_title=$scope.category.cat_title;
               $scope.cat_description=$scope.category.cat_description;
               $scope.category_image_placeholder=$scope.category.cat_image;
               $scope.cat_image=$scope.category.cat_image.name;
               $scope.category_original_image=$scope.category.category_original_image;
               $scope.category_thumbnail_image=$scope.category.cat_image;
              };

              $scope.removeCategory = function(category) {
                $scope.category=category;
               $scope.removeMode=true;
               console.log("Remove Button Clicked");
               $scope.cat_id=$scope.category.cat_id;
               $scope.cat_title=$scope.category.cat_title;
               $scope.cat_description=$scope.category.cat_description;
               $scope.category_image_placeholder=$scope.category.cat_image;
               $scope.cat_image=$scope.category.cat_image.name;
               $scope.category_original_image=$scope.category.category_original_image;
               $scope.category_thumbnail_image=$scope.category.cat_image;
               $scope.model = {
                isDisabled: true
            };
              };

              $scope.uploadFiles = function(file, errFiles) {
                $scope.f = file;
                $scope.errFile = errFiles && errFiles[0];
                if (file) {
                    file.upload = Upload.upload({
                        url: '/qorderadmin/index.php/Categories_controller/uploadCategoryImage',
                        method: 'POST',
                        file: file,
                        data: {'targetPath' : '/qorderadmin/ngapp/assets/img/category'}
                    });
        
                    file.upload.then(function (response) {
                        $scope.category_image_placeholder='ngapp/assets/img/category/'+$scope.f.name;
                        $timeout(function () {
                            file.result = response.data;
                        });
                        console.log('Success ' + response.config.data.file.name + 'uploaded. Response: ' + response.data);
                        $scope.errorMsg=false;
                        $scope.imageChoosen=true;
                    }, function (response) {
                        if (response.status > 0)
                            $scope.errorMsg = response.status + ': ' + response.data;
                          if(response.data!=200){
                            file.progress=0.0;
                            $scope.errorMsg='Category Upload Failed , Please try again after sometime.';
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
        
                $scope.callAdd = function () {
                    console.log("Inside Apply EditCategoriesController");
                  var fd = new FormData();
                  fd.append('cat_image_file', $scope.cat_image_file);
                  fd.append('cat_title',$scope.cat_title);
                  fd.append('cat_description',$scope.cat_description);
                  fd.append('cat_id',$scope.cat_id);
                  
                  if($scope.imageChoosen){
                    fd.append('cat_image','ngapp/assets/img/category/thumbnail/'+$scope.f.name);
                    fd.append('del_image','ngapp/assets/img/category/'+$scope.f.name);
                    var fd2=new FormData();
                    fd2.append('category_original_image',$scope.category_original_image);
                    fd2.append('cat_image',$scope.category_thumbnail_image);
                    $http.post('/qorderadmin/index.php/Categories_controller/deleteImage', fd2, {
                        transformRequest: angular.identity,
                        headers: {'Content-Type': undefined}
                    });
                  }
                  else{
                    fd.append('del_image',$scope.category_original_image);
                    fd.append('cat_image',$scope.category.cat_image);
                  }
                  $http.post('/qorderadmin/index.php/Categories_controller/uploadCategories', fd, {
                     transformRequest: angular.identity,
                     headers: {'Content-Type': undefined}
                  })
                  .success(function(){
                    location.href='/qorderadmin/#/categories/view_categories'
                    $("#buttonAlertPositive").show()
                    toastr["success"]("Category Updated Successfully .", "Success")

                        toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": true,
                        "progressBar": false,
                        "positionClass": "toast-bottom-right",
                        "preventDuplicates": true,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "1000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                        }
                  })
                  .error(function(){
                    $("#buttonAlertNegative").show()
                    toastr["error"]("Edit failed. Please try again.", "Failure")

                    toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": false,
                    "positionClass": "toast-bottom-right",
                    "preventDuplicates": true,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "1000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                    }
                  });
                  
                }

                $scope.callRemove = function(){
                    console.log("Inside CallRemove");
                    console.log($scope.cat_id);
                    var fd = new FormData();
                  fd.append('cat_id',$scope.cat_id);
                  fd.append('category_original_image',$scope.category_original_image);
                  fd.append('cat_image',$scope.category_thumbnail_image);
                  console.log($scope.category_thumbnail_image);
                    $http.post('/qorderadmin/index.php/Categories_controller/deleteCategoryController',fd , {
                        transformRequest: angular.identity,
                        headers: {'Content-Type': undefined}
                     })
                     .success(function(){
                       $("#buttonAlertPositive").show()
                       toastr["success"]("Category deleted successfully .", "Success")

                        toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": true,
                        "progressBar": false,
                        "positionClass": "toast-bottom-right",
                        "preventDuplicates": true,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "1000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                        }
                       location.href='/qorderadmin/#/categories/view_categories'
                     })
                     .error(function(){
                       $("#buttonAlertNegative").show()
                       toastr["error"]("Deletion failed. Please try again.", "Failure")

                        toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": true,
                        "progressBar": false,
                        "positionClass": "toast-bottom-right",
                        "preventDuplicates": true,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "1000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                        }
                     });
                }; 


        
    }]);
app.controller('ContactController',
    ['$scope', '$location','$window','$http','Base64',
    function ($scope, $location,$window,$http,Base64) {
      console.log($window.localStorage.getItem("LoggedIn")+"main");
      if($window.localStorage.getItem("LoggedIn")!="true"){
        $window.location ='#/login'
      }

    
        $scope.apply = function () {
          var fd = new FormData();
          var timeStampInMs = window.performance && window.performance.now && window.performance.timing && window.performance.timing.navigationStart ? window.performance.now() + window.performance.timing.navigationStart : Date.now();
          console.log(timeStampInMs);
          fd.append('name',$scope.contact_name);
          fd.append('email',$scope.contact_email);
          fd.append('phone',$scope.contact_phone);
          fd.append('message',$scope.contact_message);
          fd.append('timestamp',timeStampInMs);
          $http.post('/CI_final/index.php/Contact_controller/uploadContact', fd, {
             transformRequest: angular.identity,
             headers: {'Content-Type': undefined}
          })
          .success(function(){
                    location.href='/CI_final/#/contact/contactFeedbackPositive'
                    $http.post('/CI_final/index.php/Contact_controller/sendMail', fd, {
                    transformRequest: angular.identity,
                    headers: {'Content-Type': undefined}
                    })
                    .success(function(){
                        console.log("done");
                    })
                   .error(function(){
                       console.log("not done");
                    });
          })
          .error(function(){
            location.href='/CI_final/#/contact/contactFeedbackNegative'
          });
        }
}]);

app.controller('LoginController',
    ['$scope', '$location','$window','$http','Base64',
    function ($scope, $location,$window,$http,Base64) {

        $scope.login = function () {
        var fd = new FormData();
        fd.append('login_name',$scope.login_name);
        fd.append('password',Base64.encode($scope.password));
          $http.post('/qorderadmin/index.php/User_controller/authenticateUser',fd,
            {
              transformRequest: angular.identity,
              headers: {'Content-Type': undefined}
           }
          ).then(function (response) {
            
            if (response.data.code == 200) { 
              location.href='/qorderadmin/#/home'
              $window.localStorage.setItem("LoggedIn","true");
            } else {
              $scope.errorMessage = 'Authentication failed'
            }
          }, function (response) {
          });
        }
}]);

app.controller('AddProductsController',
['$scope', 'Upload', '$timeout','$location','$window','$http','Base64',
function ($scope,Upload, $timeout, $location,$window,$http,Base64)  {
        $scope.editMode=false;
        console.log($window.localStorage.getItem("LoggedIn")+"main");
        if($window.localStorage.getItem("LoggedIn")!="true"){
          $window.location ='#/login'
        }
        $scope.data=[];
        $scope.imageChoosen=false;

        $http.get('/qorderadmin/index.php/Categories_controller/getData')
            .success(function(result){
                $scope.data=result;
            });
            $scope.editCategory = function(category) {
                $scope.category=category;
               $scope.editMode=true;
               console.log("Button Clicked");
               $scope.cat_id=$scope.category.cat_id;
               $scope.cat_title=$scope.category.cat_title;
               $scope.cat_description=$scope.category.cat_description;
               $scope.cat_image=$scope.category.cat_image.name;
               $scope.category_original_image=$scope.category.category_original_image;
               $scope.category_thumbnail_image=$scope.category.cat_image;
              };

              $scope.uploadFiles = function(file, errFiles) {
                $scope.f = file;
                $scope.errFile = errFiles && errFiles[0];
                if (file) {
                    file.upload = Upload.upload({
                        url: '/qorderadmin/index.php/Product_controller/uploadProductImage',
                        method: 'POST',
                        file: file,
                        data: {'targetPath' : '/qorderadmin/ngapp/assets/img/product/original/'}
                    });
        
                    file.upload.then(function (response) {
                        $scope.category_image_placeholder='ngapp/assets/img/product/original/'+$scope.f.name;
                        $timeout(function () {
                            file.result = response.data;
                        });
                        console.log('Success ' + response.config.data.file.name + 'uploaded. Response: ' + response.data);
                        $scope.errorMsg=false;
                        $scope.imageChoosen=true;
                    }, function (response) {
                        if (response.status > 0)
                            $scope.errorMsg = response.status + ': ' + response.data;
                          if(response.data!=200){
                            file.progress=0.0;
                            $scope.errorMsg='Product Upload Failed , Please try again after sometime.';
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

            $scope.apply = function () {
                var fd = new FormData();

                fd.append('product_id',$scope.product_id);
                fd.append('product_category_id',$scope.cat_id);
                fd.append('product_category_name',$scope.cat_title);
                fd.append('product_name',$scope.product_name);
                fd.append('product_price',$scope.product_price);
                fd.append('product_thumbnail_image','ngapp/assets/img/product/thumbnail/'+$scope.f.name);
                fd.append('product_original_image','ngapp/assets/img/product/original/'+$scope.f.name);
                fd.append('product_description',$scope.product_description);
                $http.post('/qorderadmin/index.php/Product_controller/uploadProduct', fd, {
                   transformRequest: angular.identity,
                   headers: {'Content-Type': undefined}
                })
                .success(function(){
                  $("#buttonAlertPositive").show()
                  location.href='/qorderadmin/#/products/view_products'
                  toastr["success"]("Product Updated Successfully .", "Success")
      
                              toastr.options = {
                              "closeButton": true,
                              "debug": false,
                              "newestOnTop": true,
                              "progressBar": false,
                              "positionClass": "toast-bottom-right",
                              "preventDuplicates": true,
                              "onclick": null,
                              "showDuration": "300",
                              "hideDuration": "1000",
                              "timeOut": "1000",
                              "extendedTimeOut": "1000",
                              "showEasing": "swing",
                              "hideEasing": "linear",
                              "showMethod": "fadeIn",
                              "hideMethod": "fadeOut"
                              }
                })
                .error(function(){
                  $("#buttonAlertNegative").show()
                  toastr["error"]("Failed to add product. Please try again.", "Failure")
      
                  toastr.options = {
                  "closeButton": true,
                  "debug": false,
                  "newestOnTop": true,
                  "progressBar": false,
                  "positionClass": "toast-bottom-right",
                  "preventDuplicates": true,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "1000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                  }
                });
                
              }






        
    }]);
app.controller('EditProductListController',
['$scope', 'Upload', '$timeout','$location','$window','$http','Base64',
function ($scope,Upload, $timeout, $location,$window,$http,Base64)  {
        $scope.editMode=false;
        console.log($window.localStorage.getItem("LoggedIn")+"main");
        if($window.localStorage.getItem("LoggedIn")!="true"){
          $window.location ='#/login'
        }
        $scope.data=[];
        $scope.imageChoosen=false;

        $http.get('/qorderadmin/index.php/Product_controller/getProductData')
            .success(function(result){
                $scope.data=result;
            });
            $scope.editCategory = function(product) {
                $scope.product=product;
               $scope.editMode=true;
               console.log("Button Clicked");
               $scope.cat_id=$scope.product.product_category_id;
               $scope.cat_title=$scope.product.product_category_name;
               $scope.product_id=$scope.product.product_id;
               $scope.product_name=$scope.product.product_name;
               $scope.product_price=$scope.product.product_price;
               $scope.product_description=$scope.product.product_description;
               $scope.category_image_placeholder=$scope.product.product_thumbnail_image;
               $scope.product_thumbnail_image=$scope.product.product_thumbnail_image;
               $scope.product_priority=$scope.product.product_priority;
               $scope.product_original_image=$scope.product.product_original_image;     
              };

              $scope.removeCategory = function(product) {
                $scope.product=product;
               $scope.removeMode=true;
               console.log("Remove Button Clicked");
               $scope.cat_id=$scope.product.product_category_id;
               $scope.cat_title=$scope.product.product_category_name;
               $scope.product_id=$scope.product.product_id;
               $scope.product_name=$scope.product.product_name;
               $scope.product_price=$scope.product.product_price;
               $scope.product_description=$scope.product.product_description;
               $scope.category_image_placeholder=$scope.product.product_thumbnail_image;
               $scope.product_thumbnail_image=$scope.product.product_thumbnail_image;
               $scope.product_priority=$scope.product.product_priority;
               $scope.product_original_image=$scope.product.product_original_image; 
               $scope.model = {
                isDisabled: true
            };
              };

              $scope.uploadFiles = function(file, errFiles) {
                $scope.f = file;
                $scope.errFile = errFiles && errFiles[0];
                if (file) {
                    file.upload = Upload.upload({
                        url: '/qorderadmin/index.php/Product_controller/uploadProductImage',
                        method: 'POST',
                        file: file,
                        data: {'targetPath' : '/qorderadmin/ngapp/assets/img/product/original/'}
                    });
        
                    file.upload.then(function (response) {
                        $scope.category_image_placeholder='ngapp/assets/img/product/original/'+$scope.f.name;
                        $timeout(function () {
                            file.result = response.data;
                        });
                        console.log('Success ' + response.config.data.file.name + 'uploaded. Response: ' + response.data);
                        $scope.errorMsg=false;
                        $scope.imageChoosen=true;
                    }, function (response) {
                        if (response.status > 0)
                            $scope.errorMsg = response.status + ': ' + response.data;
                          if(response.data!=200){
                            file.progress=0.0;
                            $scope.errorMsg='Product Upload Failed , Please try again after sometime.';
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
        
                $scope.callAdd = function () {
                    console.log("Inside Apply EditCategoriesController");
                  var fd = new FormData();

                  fd.append('product_id',$scope.product_id);
                  fd.append('product_category_id',$scope.cat_id);
                  fd.append('product_category_name',$scope.cat_title);
                  fd.append('product_name',$scope.product_name);
                  fd.append('product_price',$scope.product_price);
                  fd.append('product_description',$scope.product_description);
                  
                  if($scope.imageChoosen){
                    fd.append('product_thumbnail_image','ngapp/assets/img/product/thumbnail/'+$scope.f.name);
                    fd.append('product_original_image','ngapp/assets/img/product/original/'+$scope.f.name);
                    var fd2=new FormData();
                    fd2.append('product_thumbnail_image',$scope.product_thumbnail_image);
                    fd2.append('product_original_image',$scope.product_original_image);
                    $http.post('/qorderadmin/index.php/Product_controller/deleteImage', fd2, {
                        transformRequest: angular.identity,
                        headers: {'Content-Type': undefined}
                    });
                  }
                  else{
                    fd.append('product_thumbnail_image',$scope.product_thumbnail_image);
                    fd.append('product_original_image',$scope.product_original_image);
                  }
                  $http.post('/qorderadmin/index.php/Product_controller/uploadProduct', fd, {
                     transformRequest: angular.identity,
                     headers: {'Content-Type': undefined}
                  })
                  .success(function(){
                    location.href='/qorderadmin/#/products/edit_products'
                    $("#buttonAlertPositive").show()
                    toastr["success"]("Product Updated Successfully .", "Success")

                        toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": true,
                        "progressBar": false,
                        "positionClass": "toast-bottom-right",
                        "preventDuplicates": true,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "1000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                        }
                  })
                  .error(function(){
                    $("#buttonAlertNegative").show()
                    toastr["error"]("Edit failed. Please try again.", "Failure")

                    toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": false,
                    "positionClass": "toast-bottom-right",
                    "preventDuplicates": true,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "1000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                    }
                  });
                  
                }

                $scope.callRemove = function(){
                    console.log("Inside CallRemove");
                    console.log($scope.product_id);
                    var fd = new FormData();
                  fd.append('product_id',$scope.product_id);
                  fd.append('product_original_image',$scope.product_original_image);
                  fd.append('product_thumbnail_image',$scope.product_thumbnail_image);
                    $http.post('/qorderadmin/index.php/Product_controller/deleteProductController',fd , {
                        transformRequest: angular.identity,
                        headers: {'Content-Type': undefined}
                     })
                     .success(function(){
                       $("#buttonAlertPositive").show()
                       toastr["success"]("Product deleted successfully .", "Success")

                        toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": true,
                        "progressBar": false,
                        "positionClass": "toast-bottom-right",
                        "preventDuplicates": true,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "1000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                        }
                       location.href='/qorderadmin/#/products/edit_products'
                     })
                     .error(function(){
                       $("#buttonAlertNegative").show()
                       toastr["error"]("Deletion failed. Please try again.", "Failure")

                        toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": true,
                        "progressBar": false,
                        "positionClass": "toast-bottom-right",
                        "preventDuplicates": true,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "1000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                        }
                     });
                }; 


        
    }]);
app.controller('EditProductsController',
['$scope', 'Upload', '$timeout','$location','$window','$http','Base64',
function ($scope,Upload, $timeout, $location,$window,$http,Base64)  {
        console.log($window.localStorage.getItem("LoggedIn")+" main");
        if($window.localStorage.getItem("LoggedIn")!="true"){
          $window.location ='#/login'
        }
        $scope.data=[];

        $http.get('/qorderadmin/index.php/Categories_controller/getData')
            .success(function(result){
                $scope.data=result;
            });

            $scope.callProduct = function (category) {
                console.log("callProduct clicked");
                $scope.category=category;
                var fd = new FormData();
                fd.append('product_category_id', $scope.category.cat_id);
                $http.post('/qorderadmin/index.php/Product_controller/sendCategoryId', fd, {
                   transformRequest: angular.identity,
                   headers: {'Content-Type': undefined}
                })
                .success(function(){
                  location.href='/qorderadmin/#/products/edit_product_list'
                })
                .error(function(){
                });
                
              };
           

    }]);
app.controller('ProductListController',
['$scope', 'Upload', '$timeout','$location','$window','$http','Base64',
function ($scope,Upload, $timeout, $location,$window,$http,Base64)  {
        console.log($window.localStorage.getItem("LoggedIn")+" main");
        if($window.localStorage.getItem("LoggedIn")!="true"){
          $window.location ='#/login'
        }
        $scope.data=[];

        $http.get('/qorderadmin/index.php/Product_controller/getProductData')
            .success(function(result){
                $scope.data=result;
            });

    }]);
app.controller('ProductsController',
['$scope', 'Upload', '$timeout','$location','$window','$http','Base64',
function ($scope,Upload, $timeout, $location,$window,$http,Base64)  {
        console.log($window.localStorage.getItem("LoggedIn")+" main");
        if($window.localStorage.getItem("LoggedIn")!="true"){
          $window.location ='#/login'
        }
        $scope.data=[];

        $http.get('/qorderadmin/index.php/Categories_controller/getData')
            .success(function(result){
                $scope.data=result;
            });

            $scope.callProduct = function (category) {
                console.log("callProduct clicked");
                $scope.category=category;
                var fd = new FormData();
                fd.append('product_category_id', $scope.category.cat_id);
                $http.post('/qorderadmin/index.php/Product_controller/sendCategoryId', fd, {
                   transformRequest: angular.identity,
                   headers: {'Content-Type': undefined}
                })
                .success(function(){
                  location.href='/qorderadmin/#/products/product_list'
                })
                .error(function(){
                });
                
              };
           

    }]);
app.controller('RegisterController',
    ['$scope', '$location','$window','$http','Base64',
    function ($scope, $location,$window,$http,Base64) {
        // reset login status
        // AuthenticationService.ClearCredentials();

        $scope.register = function () {
          $http.post('/CI_final/index.php/User_controller/registerUser',
            { 'login_name': $scope.login_name, 'password': Base64.encode($scope.password), 'email':$scope.email,'first_name':$scope.first_name,'last_name':$scope.last_name }
          ).then(function (response) {
            console.log(response)
            $window.location ='#/login'
          }, function (response) {
            // alert('error: '+eval(error));
            console.log(response);
          });
        }
}]);
