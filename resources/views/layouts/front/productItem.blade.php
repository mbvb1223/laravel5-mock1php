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
License: You must have a valid license purchased only from themeforest (the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<!-- Head BEGIN -->
<head>
    @include('layouts.front.headercss')
</head>
<!-- Head END -->

<!-- Body BEGIN -->
<body class="ecommerce">

<!-- BEGIN TOP BAR -->
@include('layouts.front.preheader')
        <!-- END TOP BAR -->

<!-- BEGIN HEADER -->
@include('layouts.front.header')
        <!-- Header END -->

<!--Content-->
@yield('content', 'chưa tạo vùng content')
<!--End Content-->


<!-- BEGIN PRE-FOOTER -->

<!-- END PRE-FOOTER -->

<!-- BEGIN FOOTER -->
@include('layouts.front.footer')
<!-- END FOOTER -->

<!-- Load javascripts at bottom, this will reduce page load time -->
@include('layouts.front.footerjs')
        <!-- END PAGE LEVEL JAVASCRIPTS -->
@yield('jscode')
</body>
<!-- END BODY -->
</html>