<div class="row margin-bottom-40 ">
    <!-- BEGIN SIDEBAR -->
    <div class="sidebar col-md-3 col-sm-4">
        <ul class="list-group margin-bottom-25 sidebar-menu">
            <?php echo $sidebar; ?>
        </ul>
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="col-md-9">
        <div class="col-md-12 col-sm-12">
            <h2>For Men</h2>
            <div class="owl-carousel owl-carousel3">
                <?php foreach($allProductForMen as $itemProduct) :?>
                <?php $linkToProduct = change_alias($itemProduct['name_product'])."-".$itemProduct['id'];?>
                <div>
                    <div class="product-item">
                        <div class="pi-img-wrapper">
                            <img src="<?php echo url("/"); ?>/upload/product/<?php echo $itemProduct['image'] ?>" class="img-responsive" alt="<?php echo $itemProduct['image'] ?>">
                            <div>
                                <a  href="<?php echo url("/"); ?>/upload/product/<?php echo $itemProduct['image'] ?>"  class="btn btn-default fancybox-button">Zoom</a>
                                <a href="#product-pop-up" class="btn btn-default fancybox-fast-view">View</a>
                            </div>
                        </div>
                        <h3><a href="{{action('FrontendController@product',$linkToProduct)}}"><?php echo $itemProduct['name_product'] ?></a></h3>
                        <div class="pi-price">$<?php echo $itemProduct['cost'] ?> &nbsp;&nbsp; <small> <span style="text-decoration: line-through; color:rgb(187, 187, 187)">$130000 </span></small></div>
                        <a href="{{action('FrontendController@product',$linkToProduct)}}" class="btn btn-default add2cart">Detail</a>
                        <div class="sticker sticker-new"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <hr />
        <div class="col-md-12 col-sm-12">
            <h2>Three items</h2>
            <div class="owl-carousel owl-carousel3">
                <div>
                    <div class="product-item">
                        <div class="pi-img-wrapper">
                            <img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/products/k1.jpg" class="img-responsive" alt="Berry Lace Dress">
                            <div>
                                <a href="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/products/k1.jpg" class="btn btn-default fancybox-button">Zoom</a>
                                <a href="#product-pop-up" class="btn btn-default fancybox-fast-view">View</a>
                            </div>
                        </div>
                        <h3><a href="shop-item.html">ccccccccccc</a></h3>
                        <div class="pi-price">$29.00</div>
                        <a href="#" class="btn btn-default add2cart">Add to cart</a>
                        <div class="sticker sticker-new"></div>
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
                        <h3><a href="shop-item.html">Berry Lace Dress2</a></h3>
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
                        <h3><a href="shop-item.html">Berry Lace Dress3</a></h3>
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
                        <h3><a href="shop-item.html">Berry Lace Dress4</a></h3>
                        <div class="pi-price">$29.00</div>
                        <a href="#" class="btn btn-default add2cart">Add to cart</a>
                        <div class="sticker sticker-sale"></div>
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
                        <h3><a href="shop-item.html">Berry Lace Dress5</a></h3>
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
                        <h3><a href="shop-item.html">Berry Lace Dress6</a></h3>
                        <div class="pi-price">$29.00</div>
                        <a href="#" class="btn btn-default add2cart">Add to cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
</div>
