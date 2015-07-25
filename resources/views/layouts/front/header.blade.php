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
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">
                        Woman

                    </a>

                    <!-- BEGIN DROPDOWN MENU -->

                    <ul class="dropdown-menu">
                        <li class="dropdown-submenu">
                            <a href="shop-product-list.html">Hi Tops <i class="fa fa-angle-right"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="shop-product-list.html">Second Level Link</a></li>
                                <li><a href="shop-product-list.html">Second Level Link</a></li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">
                                        Second Level Link
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="shop-product-list.html">Third Level Link</a></li>
                                        <li><a href="shop-product-list.html">Third Level Link</a></li>
                                        <li><a href="shop-product-list.html">Third Level Link</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="shop-product-list.html">Running Shoes</a></li>
                        <li><a href="shop-product-list.html">Jackets and Coats</a></li>

                    </ul>

                    <!-- END DROPDOWN MENU -->
                </li>
                <?php echo $menu;?>

                <!-- BEGIN TOP SEARCH -->
                <li class="menu-search">
                    <span class="sep"></span>
                    <i class="fa fa-search search-btn"></i>
                    <div class="search-box">
                        <form action="#">
                            <div class="input-group">
                                <input type="text" placeholder="Search" class="form-control">
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