@extends('layouts.front.master')

@section('content')
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.4&appId=1009813472392111";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <div class="main">
        <div class="container">

            <!-- BEGIN SIDEBAR & CONTENT -->
            <div class="row margin-bottom-40">
                <!-- BEGIN SIDEBAR -->
                <div class="sidebar col-md-3 col-sm-5">
                    <ul class="list-group margin-bottom-25 sidebar-menu">
                        <?php echo $sidebar; ?>
                    </ul>


                </div>
                <!-- END SIDEBAR -->

                <!-- BEGIN CONTENT -->
                <div class="col-md-9 col-sm-7">
                    <div class="product-page">
                        <div class="row">
                            <form class="form-horizontal form-row-seperated" action="{{ URL::action('FrontendController@addorder') }}" method="Post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <input type="hidden" name="id" id="id" value="{{ $product['id'] }}">
                            <div class="col-md-6 col-sm-6">
                                <div class="product-main-image">
                                    <img src="<?php echo url("/"); ?>/upload/product/<?php echo $product['image'];?>" alt="Cool green dress with red bell" class="img-responsive" data-BigImgsrc="<?php echo url("/"); ?>/upload/product/<?php echo $product['image'];?>">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <h1> {{ $product['name_product'] }} </h1>
                                <div class="price-availability-block clearfix">
                                    <div class="price">
                                        <strong><span>$</span>{{ number_format($product['cost'],2) }} </strong>
                                        <em>$<span>{{ $price }} </span></em>
                                    </div>
                                    <div class="availability">
                                        Availability: <strong style="color:red;"><?php echo $vailability;?></strong>
                                    </div>
                                </div>

                                <div class="product-page-options">
                                    <div class="pull-left">
                                        <label class="control-label">Color:</label>
                                        <select class="form-control input-sm" id="color_id" name="color_id">
                                           <?php echo $getViewColorForSelectTag;?>
                                        </select>
                                    </div>
                                    <div class="pull-left">
                                        <label class="control-label">Size:</label>
                                        <select class="form-control input-sm" id="size_id" name="size_id">
                                            <?php echo $getViewSizeForSelectTag;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="product-page-cart">
                                    <div class="product-quantity">
                                        <input name="number" id="product-quantity" type="text" value="1" readonly class="form-control input-sm">
                                    </div>
                                    <button class="btn btn-primary" type="submit">Add to cart</button>
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
                            <div class="product-page-content">
                                <ul id="myTab" class="nav nav-tabs">
                                    <li><a href="#Description" data-toggle="tab">Description</a></li>
                                    <li class="active"><a href="#Information" data-toggle="tab">Information</a></li>
                                    <li><a href="#Reviews" data-toggle="tab">Reviews</a></li>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div class="tab-pane fade" id="Description">
                                        <?php echo $product['information']; ?>
                                    </div>
                                    <div class="tab-pane fade in active" id="Information">
                                        <table class="datasheet">
                                            <tr>
                                                <th colspan="2">Additional features</th>
                                            </tr>
                                            <tr>
                                                <td class="datasheet-features-type">Sell Off</td>
                                                <td>{{ $product['selloff_value'] }} %</td>
                                            </tr>
                                            <tr>
                                                <td class="datasheet-features-type">Style</td>
                                                <td>{{ $product['style_name'] }}</td>
                                            </tr>
                                            <tr>
                                                <td class="datasheet-features-type">Height</td>
                                                <td>{{ $product['height_value'] }} cm</td>
                                            </tr>
                                            <tr>
                                                <td class="datasheet-features-type">Made in</td>
                                                <td>{{ $product['madein_name'] }}</td>
                                            </tr>
                                            <tr>
                                                <td class="datasheet-features-type">Material</td>
                                                <td>{{ $product['material_name'] }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="Reviews">
                                        <div class="fb-comments" data-href="{{Request::url()}}" data-numposts="7" data-width="100%"></div>
                                        <!--<p>There are no reviews for this product.</p>-->
                                        <div class="review-item clearfix">
                                            <div class="review-item-submitted">
                                                <strong>Bob</strong>
                                                <em>30/12/2013 - 07:37</em>
                                                <div class="rateit" data-rateit-value="5" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                                            </div>
                                            <div class="review-item-content">
                                                <p>Sed velit quam, auctor id semper a, hendrerit eget justo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis vel arcu pulvinar dolor tempus feugiat id in orci. Phasellus sed erat leo. Donec luctus, justo eget ultricies tristique, enim mauris bibendum orci, a sodales lectus purus ut lorem.</p>
                                            </div>
                                        </div>
                                        <!-- BEGIN FORM-->
                                        <form action="#" class="reviews-form" role="form">
                                            <h2>Write a review</h2>
                                            <div class="form-group">
                                                <label for="name">Name <span class="require">*</span></label>
                                                <input type="text" class="form-control" id="name">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" id="email">
                                            </div>
                                            <div class="form-group">
                                                <label for="review">Review <span class="require">*</span></label>
                                                <textarea class="form-control" rows="8" id="review"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Rating</label>
                                                <input type="range" value="4" step="0.25" id="backing5">
                                                <div class="rateit" data-rateit-backingfld="#backing5" data-rateit-resetable="false"  data-rateit-ispreset="true" data-rateit-min="0" data-rateit-max="5">
                                                </div>
                                            </div>
                                            <div class="padding-top-20">
                                                <button type="submit" class="btn btn-primary">Send</button>
                                            </div>
                                        </form>
                                        <!-- END FORM-->
                                    </div>
                                </div>
                            </div>
                            <?php echo $checkSale;?>
                            <?php echo $stickNew;?>
                        </div>
                    </div>
                </div>
                <!-- END CONTENT -->
            </div>
            <!-- END SIDEBAR & CONTENT -->

            <!-- BEGIN SIMILAR PRODUCTS -->
            <div class="row margin-bottom-40">
                <div class="col-md-12 col-sm-12">
                    <h2>Product relation</h2>
                    <div class="owl-carousel owl-carousel4">
                       <?php echo $getViewFiveProductRelationForPageProduct;?>
                    </div>
                </div>
            </div>
            <!-- END SIMILAR PRODUCTS -->
        </div>
    </div>
@stop

@section('jscode')
    <script>
        jQuery(document).ready(function() {
            var getSizeFromColorForThisProduct = <?php echo json_encode($getSizeFromColorForThisProduct);?>;
            var mapIdSizeToInformationSize = <?php echo json_encode($mapIdSizeToInformationSize);?>;
            if(getSizeFromColorForThisProduct != null){
                var color_id = $("#color_id").val();
                var sizes = getSizeFromColorForThisProduct[color_id];
                var option = '';
                var i = 0;
                for(; i< sizes.length;){
                    option += '<option value="' + sizes[i] +'">'+ mapIdSizeToInformationSize[sizes[i]]['size_value'] +'</option>';
                    i++;
                }
                $("#size_id").html(option);
                $("#color_id").change(function(){
                    var color_id = $("#color_id").val();
                    var sizes = getSizeFromColorForThisProduct[color_id];
                    var option = '';
                    var i = 0;
                    for(; i< sizes.length;){
                        option += '<option value="' + sizes[i] +'">'+ mapIdSizeToInformationSize[sizes[i]]['size_value'] +'</option>';
                        i++;
                    }
                    $("#size_id").html(option);
                });
            }
        })

    </script>

@stop