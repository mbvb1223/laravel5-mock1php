@extends('layouts.front.master')

@section('content')

<div class="main">
    <div class="container">
        <!-- BEGIN SALE PRODUCT & NEW ARRIVALS -->
        @include('layouts.front.saleproduct&newarrivals')
        <!-- END SALE PRODUCT & NEW ARRIVALS -->

        <!-- BEGIN SIDEBAR & CONTENT -->
        @include('layouts.front.sidebarAndContent')
        <!-- END SIDEBAR & CONTENT -->

        <!-- BEGIN TWO PRODUCTS  -->
        <div class="row margin-bottom-35 ">
            <!-- BEGIN TWO PRODUCTS -->
            <div class="col-md-12 two-items-bottom-items">
                <h2>hot Shoes</h2>
                <div class="owl-carousel owl-carousel4">
                    <div>
                        <div class="product-item">
                            <div class="pi-img-wrapper">
                                <img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/products/k4.jpg" class="img-responsive" alt="Berry Lace Dress">
                                <div>
                                    <a href="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/products/k4.jpg" class="btn btn-default fancybox-button">Zoom</a>
                                    <a href="#product-pop-up" class="btn btn-default fancybox-fast-view k-view" data-id="48">View</a>
                                </div>
                            </div>
                            <h3><a href="shop-item.html">xxxxxxxxxxx</a></h3>
                            <div class="pi-price">$29.00</div>
                            <a href="#" class="btn btn-default add2cart">Add to cart</a>
                        </div>
                    </div>
                    <div>
                        <div class="product-item">
                            <div class="pi-img-wrapper">
                                <img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/products/k2.jpg" class="img-responsive" alt="Berry Lace Dress">
                                <div>
                                    <a href="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/products/k2.jpg" class="btn btn-default fancybox-button">Zoom</a>
                                    <a href="#product-pop-up" class="btn btn-default fancybox-fast-view">View</a>
                                </div>
                            </div>
                            <h3><a href="shop-item.html">Berry Lace Dress</a></h3>
                            <div class="pi-price">$29.00</div>
                            <a href="#" class="btn btn-default add2cart">Add to cart</a>
                        </div>
                    </div>
                    <div>
                        <div class="product-item">
                            <div class="pi-img-wrapper">
                                <img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/products/k3.jpg" class="img-responsive" alt="Berry Lace Dress">
                                <div>
                                    <a href="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/products/k3.jpg" class="btn btn-default fancybox-button">Zoom</a>
                                    <a href="#product-pop-up" class="btn btn-default fancybox-fast-view">View</a>
                                </div>
                            </div>
                            <h3><a href="shop-item.html">Berry Lace Dress</a></h3>
                            <div class="pi-price">$29.00</div>
                            <a href="#" class="btn btn-default add2cart">Add to cart</a>
                        </div>
                    </div>
                    <div>
                        <div class="product-item">
                            <div class="pi-img-wrapper">
                                <img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/products/k1.jpg" class="img-responsive" alt="Berry Lace Dress">
                                <div>
                                    <a href="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/products/k1.jpg" class="btn btn-default fancybox-button">Zoom</a>
                                    <a href="#product-pop-up" class="btn btn-default fancybox-fast-view">View</a>
                                </div>
                            </div>
                            <h3><a href="shop-item.html">Berry Lace Dress</a></h3>
                            <div class="pi-price">$29.00</div>
                            <a href="#" class="btn btn-default add2cart">Add to cart</a>
                        </div>
                    </div>
                    <div>
                        <div class="product-item">
                            <div class="pi-img-wrapper">
                                <img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/products/k4.jpg" class="img-responsive" alt="Berry Lace Dress">
                                <div>
                                    <a href="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/products/k4.jpg" class="btn btn-default fancybox-button">Zoom</a>
                                    <a href="#product-pop-up" class="btn btn-default fancybox-fast-view">View</a>
                                </div>
                            </div>
                            <h3><a href="shop-item.html">Berry Lace Dress</a></h3>
                            <div class="pi-price">$29.00</div>
                            <a href="#" class="btn btn-default add2cart">Add to cart</a>
                        </div>
                    </div>
                    <div>
                        <div class="product-item">
                            <div class="pi-img-wrapper">
                                <img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/products/k3.jpg" class="img-responsive" alt="Berry Lace Dress">
                                <div>
                                    <a href="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/products/k3.jpg" class="btn btn-default fancybox-button">Zoom</a>
                                    <a href="#product-pop-up" class="btn btn-default fancybox-fast-view">View</a>
                                </div>
                            </div>
                            <h3><a href="shop-item.html">Berry Lace Dress</a></h3>
                            <div class="pi-price">$29.00</div>
                            <a href="#" class="btn btn-default add2cart">Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END TWO PRODUCTS -->

        </div>
        <!-- END TWO PRODUCTS -->
    </div>
</div>

<!-- BEGIN BRANDS -->
<div class="brands">
    <div class="container">
        <div class="owl-carousel owl-carousel6-brands">
            <a href="shop-product-list.html"><img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/brands/canon.jpg" alt="canon" title="canon"></a>
            <a href="shop-product-list.html"><img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/brands/esprit.jpg" alt="esprit" title="esprit"></a>
            <a href="shop-product-list.html"><img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/brands/gap.jpg" alt="gap" title="gap"></a>
            <a href="shop-product-list.html"><img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/brands/next.jpg" alt="next" title="next"></a>
            <a href="shop-product-list.html"><img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/brands/puma.jpg" alt="puma" title="puma"></a>
            <a href="shop-product-list.html"><img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/brands/zara.jpg" alt="zara" title="zara"></a>
            <a href="shop-product-list.html"><img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/brands/canon.jpg" alt="canon" title="canon"></a>
            <a href="shop-product-list.html"><img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/brands/esprit.jpg" alt="esprit" title="esprit"></a>
            <a href="shop-product-list.html"><img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/brands/gap.jpg" alt="gap" title="gap"></a>
            <a href="shop-product-list.html"><img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/brands/next.jpg" alt="next" title="next"></a>
            <a href="shop-product-list.html"><img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/brands/puma.jpg" alt="puma" title="puma"></a>
            <a href="shop-product-list.html"><img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/brands/zara.jpg" alt="zara" title="zara"></a>
        </div>
    </div>
</div>
<!-- END BRANDS -->

<!-- BEGIN STEPS -->
<div class="steps-block steps-block-red">
    <div class="container">
        <div class="row">
            <div class="col-md-4 steps-block-col">
                <i class="fa fa-truck"></i>
                <div>
                    <h2>Free shipping</h2>
                    <em>Express delivery withing 3 days</em>
                </div>
                <span>&nbsp;</span>
            </div>
            <div class="col-md-4 steps-block-col">
                <i class="fa fa-gift"></i>
                <div>
                    <h2>Daily Gifts</h2>
                    <em>3 Gifts daily for lucky customers</em>
                </div>
                <span>&nbsp;</span>
            </div>
            <div class="col-md-4 steps-block-col">
                <i class="fa fa-phone"></i>
                <div>
                    <h2>477 505 8877</h2>
                    <em>24/7 customer care available</em>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END STEPS -->

@stop