<div class="header">
    <div class="container">
        <a class="site-logo" href="<?php echo url("/"); ?>"><img src="<?php echo url("/"); ?>/../theme/assets/frontend/layout/img/logos/logo-shop-red.png" alt="Metronic Shop UI"></a>

        <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>
        <!-- BEGIN CART -->
        <div class="top-cart-block">
            <div class="top-cart-info">
                <a href="javascript:void(0);" class="top-cart-info-count"><?php echo $countSessionCart; ?> items</a>
                <a href="javascript:void(0);" class="top-cart-info-value">$<?php echo $totalCost; ?></a>
            </div>
            <i class="fa fa-shopping-cart"></i>

            <div class="top-cart-content-wrapper">
                <div class="top-cart-content">
                    <ul class="scroller" style="height: 250px;">
                        <?php echo $getViewCartInIndexFrontEnd; ?>
                    </ul>
                    <div class="text-right">
                        <a href="{{action('FrontendController@vieworder')}}" class="btn btn-default">View Cart</a>
                        <a href="{{action('FrontendController@checkout')}}" class="btn btn-primary">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
        <!--END CART -->

        <!-- BEGIN NAVIGATION -->
        <div class="header-navigation">
            <ul>
                <?php echo $menu;?>
                 <li> <a href="{{action('FrontendController@contact')}}">Contact</a></li>
                    <!-- BEGIN TOP SEARCH -->
                <li class="menu-search">
                    <span class="sep"></span>
                    <i class="fa fa-search search-btn"></i>
                    <div class="search-box">
                        <form action="{{action('FrontendController@searchProduct')}}" method="GET">
                            <div class="input-group">
                                <input name="key" type="text" placeholder="Search" class="form-control">
                    <span class="input-group-btn">
                      <button class="btn btn-primary" type="submit">Search</button>
                    </span>
                            </div>
                        </form>
                    </div>
                </li>
                <!-- END TOP SEARCH -->
            </ul>
        </div>
        @include('layouts.front.notification')
        <!-- END NAVIGATION -->
    </div>
</div>