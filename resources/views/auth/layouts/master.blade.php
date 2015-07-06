<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.2.0
Version: 3.4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>{{ $title or 'Admin Dashboard' }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="<?php echo url("/"); ?>/../theme/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo url("/"); ?>/../theme/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo url("/"); ?>/../theme/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo url("/"); ?>/../theme/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo url("/"); ?>/../theme/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="<?php echo url("/"); ?>/../theme/assets/global/css/components.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo url("/"); ?>/../theme/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo url("/"); ?>/../theme/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
    <link id="style_color" href="<?php echo url("/"); ?>/../theme/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo url("/"); ?>/../theme/assets/admin/pages/css/login.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo url("/"); ?>/../theme/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    @yield('css')
    <script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo url("/"); ?>/../theme/assets/global/js/my.js" type="text/javascript"></script>
    <link rel="shortcut icon" href="favicon.ico"/>
</head>

<body class="login">
@include("auth.layouts.header")
@include('layouts.admin.notification')
<div class="content">
@yield('content', 'chưa tạo vùng content')
</div>
<script src=" <?php echo url('/'); ?>/../theme/assets/global/plugins/respond.min.js"></script>
<script src=" <?php echo url('/'); ?>/../theme/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->

<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<script src="<?php echo url("/"); ?>/../theme/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo url("/"); ?>/../theme/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo url("/"); ?>/../theme/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo url("/"); ?>/../theme/assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
@yield('js')
<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        QuickSidebar.init(); // init quick sidebar
        Demo.init(); // init demo features
    });
</script>
<!-- END JAVASCRIPTS -->
@yield('jscode')
</body>
<!-- END BODY -->
</html>