'use strict';

var app = angular.module('VendWebApp', [
  'ngRoute','ngFileUpload','angularUtils.directives.dirPagination','ngMessages', 'daterangepicker']).run(['$rootScope','$location','$window',function($rootScope,$location,$window) {
    $rootScope.location = $location; 
    $rootScope.mobilenumber_login='';
    if(!$rootScope.isLoggedIn){
        console.log("Set to false isLoggedIn");
        $rootScope.isLoggedIn=false;
    }
    else{
        console.log("LoggedIn "+$rootScope.isLoggedIn);
    }

    var path = function() { return $location.path();};
    $rootScope.$watch(path, function(newVal, oldVal){
        $rootScope.activetab = newVal;
    });

    $rootScope.isLoggedIn=$window.localStorage.getItem('isLoggedIn');
    $rootScope.isMachineManager=$window.localStorage.getItem('isMachineManager');
    $rootScope.isFnbManager=$window.localStorage.getItem('isFnbManager');
    $rootScope.isAdmin=$window.localStorage.getItem('isAdmin');
    $rootScope.isAdManager=$window.localStorage.getItem('isAdManager');
    $rootScope.isEmployeeManager=$window.localStorage.getItem('isEmployeeManager');
    $rootScope.fullAccess=$window.localStorage.getItem('fullAccess');
    $rootScope.isClient=$window.localStorage.getItem('isClient');
    $rootScope.clientId=$window.localStorage.getItem('clientId');
    $rootScope.editClonedMachine=$window.localStorage.getItem('editClonedMachine');
    $rootScope.isEditClonedMachine=$window.localStorage.getItem('isEditClonedMachine');
    $rootScope.token=$window.localStorage.getItem('token');
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
    //Login
    .when("/", {templateUrl: "ngapp/home/home.html", controller: "PageCtrl"}) 
    .when("/login", {templateUrl: "ngapp/login/login.html", controller: "LoginController"})
    .when("/logout", {templateUrl: "ngapp/home/home.html", controller: "LogoutCtrl"})
    // Home
    .when("/home", {templateUrl: "ngapp/home/home.html", controller: "PageCtrl"})
    .when("/home2", {templateUrl: "ngapp/home/home2.html", controller: "homeController"})
    //Profile
    .when("/profile", {templateUrl: "ngapp/profile/profile.html", controller: "ProfileController"})
    // Sign Up
    .when("/sign_up", {templateUrl: "ngapp/sign_up/sign_up.html", controller: "SignUpController"})
    .when("/sign_up/sign_up_success", {templateUrl: "ngapp/sign_up/sign_up_success.html", controller: "PageCtrl"})
    //Transaction
    .when("/transaction", {templateUrl: "ngapp/transaction/transaction.html", controller: "TransactionController"})
    .when("/user_transaction", {templateUrl: "ngapp/transaction/user_transaction.html", controller: "UserTransactionController"})
    //User
    .when("/user", {templateUrl: "ngapp/user/user.html", controller: "UserController"})
    .when("/user_detail", {templateUrl: "ngapp/user/user_detail.html", controller: "UserDetailController"})
    .when("/add_user", {templateUrl: "ngapp/user/add_user.html", controller: "AddUserController"})
    .when("/view_user", {templateUrl: "ngapp/user/view_user.html", controller: "ViewUserController"})
    .when("/reset_password", {templateUrl: "ngapp/user/reset_password.html", controller: "ResetPasswordController"})
    .when("/user/add_user_success", {templateUrl: "ngapp/user/add_user_success.html", controller: "PageCtrl"})
    //Employee
    .when("/employee_detail", {templateUrl: "ngapp/employee/employee_detail.html", controller: "EmployeeDetailController"})
    .when("/edit_employee_detail", {templateUrl: "ngapp/employee/edit_employee_detail.html", controller: "EditEmployeeDetailController"})
    .when("/add_employee", {templateUrl: "ngapp/employee/add_employee.html", controller: "AddEmployeeController"})
    //Privacy Policy
    .when("/privacy_policy", {templateUrl: "ngapp/privacy_policy/privacy_policy.html", controller: "PageCtrl"})
    //Terms and Conditions
    .when("/terms_and_conditions", {templateUrl: "ngapp/terms_and_conditions/terms_and_conditions.html", controller: "PageCtrl"})
    //Dashboard
    .when("/dashboard", {templateUrl: "ngapp/dashboard/dashboard.html", controller: "DashboardController"})
    //Advertisement
    .when("/upload_ads", {templateUrl: "ngapp/advertisement/upload_ads.html", controller: "UploadAdsController"})
    .when("/current_ads", {templateUrl: "ngapp/advertisement/current_ads.html", controller: "CurrentAdsController"})
    .when("/advertisement", {templateUrl: "ngapp/advertisement/advertisement.html", controller: "DeleteAdsController"})
    .when("/machine_advertisement", {templateUrl: "ngapp/advertisement/machine_advertisement.html", controller: "MachineAdvertisementController"})
    .when("/assign_advertisement", {templateUrl: "ngapp/advertisement/assign_advertisement.html", controller: "AssignAdvertisementController"})
    //Machine
    .when("/add_machine", {templateUrl: "ngapp/machine/add_machine.html", controller: "AddMachineController"})
    .when("/view_machine", {templateUrl: "ngapp/machine/view_machine.html", controller: "ViewMachineController"})
    .when("/machine", {templateUrl: "ngapp/machine/machine.html", controller: "EditMachineController"})
    .when("/fill_machine", {templateUrl: "ngapp/machine/fill_machine.html", controller: "FillMachineController"})
    .when("/machine_product_map", {templateUrl: "ngapp/machine/machine_product_map.html", controller: "MachineProductMapController"})
    .when("/fill_machine_product_map", {templateUrl: "ngapp/machine/fill_machine_product_map.html", controller: "FillMachineProductMapController"})
    .when("/machine_configuration", {templateUrl: "ngapp/machine/machine_configuration.html", controller: "MachineConfigurationController"})
    .when("/reset_planogram", {templateUrl: "ngapp/machine/reset_planogram.html", controller: "ResetPlanogramController"})
    .when("/upload_planogram", {templateUrl: "ngapp/machine/upload_planogram.html", controller: "UploadPlanogramController"})
    .when("/view_client_machine", {templateUrl: "ngapp/machine/view_client_machine.html", controller: "ViewClientMachineController"})
    .when("/view_client_machine_list", {templateUrl: "ngapp/machine/view_client_machine_list.html", controller: "ViewClientMachineListController"})
    //Category
    .when("/add_category", {templateUrl: "ngapp/category/add_category.html", controller: "AddCategoryController"})
    .when("/category", {templateUrl: "ngapp/category/category.html", controller: "EditCategoryController"})
    .when("/view_category", {templateUrl: "ngapp/category/view_category.html", controller: "ViewCategoryController"})
    .when("/view_client_category", {templateUrl: "ngapp/category/view_client_category.html", controller: "ViewClientCategoryController"})
    .when("/view_client_category_list", {templateUrl: "ngapp/category/view_client_category_list.html", controller: "ViewClientCategoryListController"})
    .when("/upload_category_list", {templateUrl: "ngapp/category/upload_category_list.html", controller: "UploadCategoryListController"})
    //Product
    .when("/add_product", {templateUrl: "ngapp/product/add_product.html", controller: "AddProductController"})
    .when("/edit_product", {templateUrl: "ngapp/product/edit_product.html", controller: "EditProductController"})
    .when("/view_product", {templateUrl: "ngapp/product/view_product.html", controller: "ViewProductController"})
    .when("/view_products", {templateUrl: "ngapp/product/view_products.html", controller: "ViewProductsController"})
    .when("/product_list", {templateUrl: "ngapp/product/product_list.html", controller: "ProductListController"})
    .when("/product", {templateUrl: "ngapp/product/product.html", controller: "EditProductListController"})
    .when("/assign_product", {templateUrl: "ngapp/product/assign_product.html", controller: "AssignProductController"})
    .when("/view_client_product", {templateUrl: "ngapp/product/view_client_product.html", controller: "ViewClientProductController"})
    .when("/view_client_product_list", {templateUrl: "ngapp/product/view_client_product_list.html", controller: "ViewClientProductListController"})
    .when("/upload_product_list", {templateUrl: "ngapp/product/upload_product_list.html", controller: "UploadProductListController"})
    //Employee
    .when("/employee_detail", {templateUrl: "ngapp/employee/employee_detail.html", controller: "EmployeeDetailController"})
    .when("/edit_employee_detail", {templateUrl: "ngapp/employee/edit_employee_detail.html", controller: "EditEmployeeDetailController"})
    .when("/add_employee", {templateUrl: "ngapp/employee/add_employee.html", controller: "AddEmployeeController"})
    .when("/add_employee_group", {templateUrl: "ngapp/employee/add_employee_group.html", controller: "AddEmployeeGroupController"})
    .when("/add_product_restriction", {templateUrl: "ngapp/employee/add_product_restriction.html", controller: "AddGroupRestrictionController"})
    .when("/view_product_group_restriction", {templateUrl: "ngapp/employee/view_product_group_restriction.html", controller: "ViewProductGroupRestrictionController"})
    .when("/employee_reports", {templateUrl: "ngapp/employee/employee_reports.html", controller: "TransactionDetailController"})
    .when("/upload_employee_list", {templateUrl: "ngapp/employee/upload_employee_list.html", controller: "UploadEmployeeListController"})
    .when("/add_employee_product_restriction", {templateUrl: "ngapp/employee/add_employee_product_restriction.html", controller: "AddEmployeeProductRestrictionController"})
    .when("/view_employee_product_restriction", {templateUrl: "ngapp/employee/view_employee_product_restriction.html", controller: "ViewEmployeeProductRestrictionController"})
    .when("/add_product_quantity_restriction", {templateUrl: "ngapp/employee/add_product_quantity_restriction.html", controller: "AddProductQuantityRestrictionController"})
    .when("/product_quantity_restriction", {templateUrl: "ngapp/employee/product_quantity_restriction.html", controller: "ProductQuantityRestrictionController"})
    .when("/employee_group", {templateUrl: "ngapp/employee/employee_group.html", controller: "EmployeeGroupController"})
    .when("/schedule_employee_report", {templateUrl: "ngapp/employee/schedule_employee_report.html", controller: "ScheduleEmployeeReportController"})
    .when("/total_quantity_restriction", {templateUrl: "ngapp/employee/total_quantity_restriction.html", controller: "TotalQuantityRestrictionController"})
    //Report
    .when("/advertisement_report", {templateUrl: "ngapp/report/advertisement_report.html", controller: "AdvertisementReportController"})
    .when("/full_advertisement_report", {templateUrl: "ngapp/report/full_advertisement_report.html", controller: "FullAdvertisementReportController"})
    .when("/sale_report", {templateUrl: "ngapp/report/sale_report.html", controller: "SaleReportController"})
    .when("/full_sale_report", {templateUrl: "ngapp/report/full_sale_report.html", controller: "FullSaleReportController"})
    .when("/feedback_report", {templateUrl: "ngapp/report/feedback_report.html", controller: "FeedbackReportController"})
    .when("/full_feedback_report", {templateUrl: "ngapp/report/full_feedback_report.html", controller: "FullFeedbackReportController"})
    .when("/schedule_sale_report", {templateUrl: "ngapp/report/schedule_sale_report.html", controller: "ScheduleSaleReportController"})
    .when("/schedule_feedback_report", {templateUrl: "ngapp/report/schedule_feedback_report.html", controller: "ScheduleFeedbackReportController"})
    .when("/non_functional_location", {templateUrl: "ngapp/report/non_functional_location.html", controller: "NonFunctionalLocationController"})
    .when("/e_receipt", {templateUrl: "ngapp/report/e_receipt.html", controller: "EReceiptController"})
    .when("/gift_report", {templateUrl: "ngapp/report/gift_report.html", controller: "GiftReportController"})
    //Client
    .when("/add_client", {templateUrl: "ngapp/client/add_client.html", controller: "AddClientController"})
    .when("/client", {templateUrl: "ngapp/client/client.html", controller: "EditClientController"})
    .when("/view_client", {templateUrl: "ngapp/client/view_client.html", controller: "ViewClientController"})
    .when("/reset_client_password", {templateUrl: "ngapp/client/reset_client_password.html", controller: "ResetClientPasswordController"})
    //Image Advertisement
    .when("/add_image_advertisement", {templateUrl: "ngapp/advertisement/add_image_advertisement.html", controller: "AddImageAdvertisementController"})
    .when("/view_image_advertisement", {templateUrl: "ngapp/advertisement/view_image_advertisement.html", controller: "ViewImageAdvertisementController"})
    //Approval
    .when("/approval/portal_login", {templateUrl: "ngapp/approval/portal_login.html", controller: "PortalLoginController"})
    .when("/approval/machine_login", {templateUrl: "ngapp/approval/machine_login.html", controller: "MachineLoginController"})
    .when("/approval/schedule_report", {templateUrl: "ngapp/approval/schedule_report.html", controller: "ApprovalScheduleReportController"})
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
app.controller('PageCtrl',['$rootScope','$window', function ($rootScope,$window/* $scope, $location, $http */) {
  console.log("Page Controller reporting for duty.");
  console.log($rootScope.isLoggedIn);
  $('.carousel').carousel({
    interval: 5000
  });

  // Activates Tooltips for Social Links
  $('.tooltip-social').tooltip({
    selector: "a[data-toggle=tooltip]"
  });
  
}]);

app.controller('LogoutCtrl',['$rootScope','$window','$http', function ($rootScope,$window,$http/* $scope, $location, $http */) {
    $window.localStorage.setItem('isLoggedIn',false);
    $window.localStorage.setItem('isMachineManager',false);
    $window.localStorage.setItem('isFnbManager',false);
    $window.localStorage.setItem('isAdmin',false);
    $window.localStorage.setItem('isAdManager',false);
    $window.localStorage.setItem('isEmployeeManager',false);
    $window.localStorage.setItem('isClient',false);
    $window.localStorage.setItem('fullAccess',false);
    $rootScope.isLoggedIn=$window.localStorage.getItem('isLoggedIn');
    $rootScope.isMachineManager=$window.localStorage.getItem('isMachineManager');
    $rootScope.isFnbManager=$window.localStorage.getItem('isFnbManager');
    $rootScope.isClient=$window.localStorage.getItem('isClient');
    $rootScope.isAdmin=$window.localStorage.getItem('isAdmin');
    $rootScope.isAdManager=$window.localStorage.getItem('isAdManager');
    $rootScope.isEmployeeManager=$window.localStorage.getItem('isEmployeeManager');
    $rootScope.fullAccess=$window.localStorage.getItem('fullAccess');
  }]);

  app.controller('RedirectCtrl',['$window', function ($window/* $scope, $location, $http */) {

  }]);


