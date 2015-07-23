@extends('layouts.front.master')

@section('content')
    <div class="container">
        <div class="row margin-bottom-40 ">
            <!-- BEGIN SIDEBAR -->
            <div class="sidebar col-md-3 col-sm-4">
                <ul class="list-group margin-bottom-25 sidebar-menu">
                    <?php echo $sidebar; ?>
                </ul>
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="col-md-9 col-sm-8">
                <?php foreach($dataProductByIdCategory as $itemProduct) :?>
                <?php $linkToProduct = change_alias($itemProduct['name_product'])."-".$itemProduct['id'];?>
                    <div class="col-md-4 col-sm-4 margin-top-10">
                       <div class="product-item">
                           <div class="pi-img-wrapper">
                               <img src="<?php echo url("/"); ?>/upload/product/<?php echo $itemProduct['image'] ?>" class="img-responsive" alt="<?php echo $itemProduct['image'] ?>">
                               <div>
                                   <a href="<?php echo url("/"); ?>/upload/product/<?php echo $itemProduct['image'] ?>" class="btn btn-default fancybox-button">Zoom</a>
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
            <div class="pull-right margin-top-20">
                <?php echo $dataProductByIdCategory->render();?>
            </div>
      

            <!-- END CONTENT -->
        </div>
</div>
@stop