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
        <title>QuickOrder</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="QuickOrder">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <base href="<?php echo base_url(); ?>">
        <link rel="icon" href="<?php echo base_url(); ?>ngapp/assets/images/icons/quickOrder.ico" type="image/ico">
 <!--  <link rel="icon" type="image/png" href="<?php echo base_url(); ?>ngapp/assets/images/icons/favicon.ico"/> -->


        <!-- Vendor: Bootstrap Stylesheets http://getbootstrap.com -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
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


    </head>
    <body ng-app="tutorialWebApp">
        <!--[if lt IE 7]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
            your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Our Website Content Goes Here -->
        <div ng-include='"<?php echo base_url(); ?>ngapp/shared/header.html"' ng-hide="location.path()==='' || location.path()==='/' || location.path()==='/login'"></div>  
        <div ng-view></div>
        <div ng-include='"<?php echo base_url(); ?>ngapp/shared/footer.html"' ng-hide="location.path()==='' || location.path()==='/' || location.path()==='/login'"></div>
        
        
        
        <!-- Vendor: Javascripts -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <!-- Vendor: Angular, followed by our custom Javascripts -->
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular-route.min.js"></script>

        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <!-- NPM installed for Our Website Javascripts -->
    
        <script src="<?php echo base_url(); ?>ngapp/node_modules/ng-file-upload/dist/ng-file-upload.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/node_modules/angular-ui-bootstrap/dist/ui-bootstrap.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/node_modules/angular-ui-bootstrap/dist/ui-bootstrap-tpls.js"></script>
        <script src="<?php echo base_url(); ?>ngapp/node_modules/angular-utils-pagination/dirPagination.js"></script>
        <!-- Our Website Javascripts -->
        <script>
            var base_url = '<?php echo base_url(); ?>'
        </script>

        <script src="<?php echo base_url(); ?>ngapp/dist/scripts/scripts.min.js"></script>
      

    </body>
</html>
