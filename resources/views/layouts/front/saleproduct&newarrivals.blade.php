<div class="row margin-bottom-40">
    <!-- BEGIN SALE PRODUCT -->
    <div class="col-md-12 sale-product">
        <h2>New Arrivals</h2>
        <div class="owl-carousel owl-carousel5">

           <?php foreach($products as $product): ?>
               <div>
                   <div class="product-item">
                       <div class="pi-img-wrapper">
                           <img src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/products/model1.jpg" class="img-responsive" alt="Berry Lace Dress">
                           <div>
                               <a href="<?php echo url("/"); ?>/../theme/assets/frontend/pages/img/products/model1.jpg" class="btn btn-default fancybox-button">Zoom</a>
                               <a href="#product-pop-up" class="btn btn-default fancybox-fast-view">View</a>
                           </div>
                       </div>
                       <h3><a href="shop-item.html"><?php echo $product['name_product'] ?></a></h3>
                       <div class="pi-price"><?php echo $product['price'] ?></div>
                       <a href="<?php echo url("cart")."/update/". $product['id'];?>" class="btn btn-default add2cart">Add to cart</a>
                       <div class="sticker sticker-sale"></div>
                   </div>
               </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- END SALE PRODUCT -->
</div>