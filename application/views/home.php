<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
    <head>

        <!-- Meta-Information -->
        <title>Vend Portal</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="Vend Portal">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <base href="<?php echo base_url(); ?>">

 <!--  <link rel="icon" type="image/png" href="<?php echo base_url(); ?>ngapp/assets/images/icons/favicon.ico"/> -->


        <!-- Vendor: Bootstrap Stylesheets http://getbootstrap.com -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.13/daterangepicker.min.css" />
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">



        <!-- Our Website CSS Styles -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>ngapp/assets/css/main.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>ngapp/assets/css/login_user.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>ngapp/assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>ngapp/assets/css/login_admin.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>ngapp/assets/css/util.css">
        <!--<link rel=stylesheet type=text/css href="<?php echo base_url(); ?>ngapp/assets/css/app.css">
        <link rel=stylesheet type=text/css href="<?php echo base_url(); ?>ngapp/assets/css/overrides.css">-->

    </head>
    <body ng-app="VendWebApp">
        <!--[if lt IE 7]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
            your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Our Website Content Goes Here -->
        <div ng-include='"<?php echo base_url(); ?>ngapp/shared/header.html"' ng-hide="isLoggedIn"></div>
        <div ng-include='"<?php echo base_url(); ?>ngapp/shared/header_loggedin.html"' ng-show="isLoggedIn && isAdmin"></div> 
        <div ng-include='"<?php echo base_url(); ?>ngapp/shared/header_ad_manager.html"' ng-show="isLoggedIn && isAdManager"></div> 
        <div ng-include='"<?php echo base_url(); ?>ngapp/shared/header_employee_manager.html"' ng-show="isLoggedIn && isEmployeeManager"></div> 
        <div ng-include='"<?php echo base_url(); ?>ngapp/shared/header_machine_manager.html"' ng-show="isLoggedIn && isMachineManager"></div>
        <div ng-include='"<?php echo base_url(); ?>ngapp/shared/header_client.html"' ng-show="isLoggedIn && fullAccess"></div>
        <div ng-include='"<?php echo base_url(); ?>ngapp/shared/header_fnb_manager.html"' ng-show="isLoggedIn && isFnbManager"></div>
        <div ng-view ></div>
        <div ng-include='"<?php echo base_url(); ?>ngapp/shared/footer.html"'></div>
        
        <script src="https://js.braintreegateway.com/web/dropin/1.9.4/js/dropin.min.js"></script>
        
        <!-- Vendor: Javascripts -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <!-- Vendor: Angular, followed by our custom Javascripts -->
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular-route.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.20/angular-messages.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.13/daterangepicker.min.js"></script>
        <script src="https://fragaria.github.io/angular-daterangepicker/js/angular-daterangepicker.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.1/jszip.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/xlsx/0.8.1/xlsx.js"></script>
       <!-- <script src="//fastcdn.org/FileSaver.js/1.1.20151003/FileSaver.js"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/node_modules/angular-utils-pagination/dirPagination.js"></script>
        <script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
		<script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9","ee6b7db5b51705a13dc2339db3edaf6d"];</script>
        
        
        
        <!-- NPM installed for Our Website Javascripts -->
    
        <script src="<?php echo base_url(); ?>ngapp/node_modules/ng-file-upload/dist/ng-file-upload.js"></script>
        <!-- Our Website Javascripts -->

          <script src="<?php echo base_url(); ?>ngapp/main.js"></script>
       
        <script src="<?php echo base_url(); ?>ngapp/login/LoginController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/sign_up/SignUpController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/profile/ProfileController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/home/homeController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/shared/HeaderController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/transaction/TransactionController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/transaction/UserTransactionController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/user/UserController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/user/ViewUserController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/user/AddUserController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/user/ResetPasswordController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/employee/EmployeeDetailController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/employee/AddEmployeeController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/employee/AddEmployeeGroupController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/employee/AddGroupRestrictionController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/employee/AddEmployeeProductRestrictionController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/employee/ViewEmployeeProductRestrictionController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/employee/ViewProductGroupRestrictionController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/employee/TransactionDetailController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/employee/UploadEmployeeListController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/employee/AddProductQuantityRestrictionController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/employee/ProductQuantityRestrictionController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/employee/EmployeeGroupController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/employee/ScheduleEmployeeReportController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/employee/TotalQuantityRestrictionController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/dashboard/DashboardController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/advertisement/UploadAdsController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/advertisement/CurrentAdsController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/advertisement/DeleteAdsController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/advertisement/MachineAdvertisementController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/advertisement/AssignAdvertisementController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/machine/AddMachineController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/machine/ViewMachineController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/machine/FillMachineController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/machine/EditMachineController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/machine/MachineProductMapController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/machine/FillMachineProductMapController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/machine/MachineConfigurationController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/machine/ResetPlanogramController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/machine/UploadPlanogramController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/machine/ViewClientMachineController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/machine/ViewClientMachineListController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/category/ViewCategoryController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/category/AddCategoryController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/category/EditCategoryController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/category/ViewClientCategoryController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/category/ViewClientCategoryListController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/category/UploadCategoryListController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/product/ViewProductController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/product/ViewProductsController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/product/AddProductController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/product/EditProductController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/product/ProductListController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/product/EditProductListController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/product/AssignProductController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/product/ViewClientProductController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/product/ViewClientProductListController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/product/UploadProductListController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/report/AdvertisementReportController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/report/FullAdvertisementReportController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/report/SaleReportController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/report/FullSaleReportController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/report/FeedbackReportController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/report/FullFeedbackReportController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/report/ScheduleSaleReportController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/report/ScheduleFeedbackReportController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/report/NonFunctionalLocationController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/report/EReceiptController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/report/GiftReportController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/client/AddClientController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/client/ViewClientController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/client/EditClientController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/client/ResetClientPasswordController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/advertisement/AddImageAdvertisementController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/advertisement/ViewImageAdvertisementController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/approval/PortalLoginController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/approval/MachineLoginController.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/approval/ApprovalScheduleReportController.js"></script>
    </body>
</html>
