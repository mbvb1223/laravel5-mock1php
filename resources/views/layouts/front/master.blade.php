
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
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
<div id="fb-root"></div>

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

<!-- BEGIN fast view of a product -->
<div id="product-pop-up" style="display: none; width: 700px;">
    <div class="product-page product-pop-up">
        <div class="row">
            <form class="form-horizontal form-row-seperated" action="{{ URL::action('FrontendController@addorder') }}" method="Post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <input type="hidden" name="id" id="id" class="k-idProduct" value="">
                <div class="col-md-6 col-sm-6">
                    <div class="product-main-image">
                        <img id="k-imageProduct" src="" alt="Cool green dress with red bell" class="img-responsive" data-BigImgsrc="">
                    </div>
                    <div class="product-other-images">
                        <a href="../../assets/frontend/pages/img/products/model3.jpg" class="fancybox-button" rel="photos-lib"><img alt="Berry Lace Dress" src="../../assets/frontend/pages/img/products/model3.jpg"></a>
                        <a href="../../assets/frontend/pages/img/products/model4.jpg" class="fancybox-button" rel="photos-lib"><img alt="Berry Lace Dress" src="../../assets/frontend/pages/img/products/model4.jpg"></a>
                        <a href="../../assets/frontend/pages/img/products/model5.jpg" class="fancybox-button" rel="photos-lib"><img alt="Berry Lace Dress" src="../../assets/frontend/pages/img/products/model5.jpg"></a>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <h1 id="k-titleProduct"> </h1>
                    <div class="price-availability-block clearfix">
                        <div class="price">
                            <strong id="k-costProduct"></strong>
                            <span>$<em id="k-priceProduct" class="z-price"></em></span>
                        </div>
                        <div class="availability">
                            Availability: <strong style="color:red;" id="k-vailabilityProduct"></strong>
                        </div>
                    </div>

                    <div class="product-page-options">
                        <div class="pull-left">
                            <label class="control-label">Color:</label>
                            <select class="form-control input-sm k-colorProduct" id="color_id" name="color_id">

                            </select>
                        </div>
                        <div class="pull-left">
                            <label class="control-label">Size:</label>
                            <select class="form-control input-sm k-sizeProduct" id="size_id" name="size_id">

                            </select>
                        </div>
                    </div>
                    <div class="product-page-cart">
                        <div class="product-quantity">
                            <input name="number" id="product-quantity" type="text" value="1" readonly class="form-control input-sm">
                        </div>
                        <button class="btn btn-primary" type="submit">Add to cart</button>
                        <a class="btn btn-success k-linkDetailProduct" type="submit">Detail</a>
                    </div>

                    <ul class="social-icons">
                        <li><a class="facebook" data-original-title="facebook" href="#"></a></li>
                        <li><a class="twitter" data-original-title="twitter" href="#"></a></li>
                        <li><a class="googleplus" data-original-title="googleplus" href="#"></a></li>
                        <li><a class="evernote" data-original-title="evernote" href="#"></a></li>
                        <li><a class="tumblr" data-original-title="tumblr" href="#"></a></li>
                    </ul>

                </div>
            </form>
        </div>
    </div>
</div>
<!-- END fast view of a product -->

<!-- Load javascripts at bottom, this will reduce page load time -->
@include('layouts.front.footerjs')
<!-- END PAGE LEVEL JAVASCRIPTS -->
@yield('jscode')
</body>
<!-- END BODY -->
</html>