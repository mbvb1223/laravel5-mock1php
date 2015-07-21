@extends('layouts.front.master')

@section('content')
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="index.html">Home</a></li>
            <li><a href="">Store</a></li>
            <li class="active">Checkout</li>
        </ul>
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
            <!-- BEGIN CONTENT -->
            <div class="col-md-12 col-sm-12">
                <h1>Checkout</h1>
                <!-- BEGIN CHECKOUT PAGE -->
                <div class="panel-group checkout-page accordion scrollable" id="checkout-page">

                    <!-- BEGIN CHECKOUT -->
                    <?php echo $getViewFormLoginForCheckout; ?>
                    <!-- END CHECKOUT -->
                        <form method="post" action="{{action('FrontendController@submitcheckout')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <!-- BEGIN PAYMENT ADDRESS -->
                        <?php echo $getViewInfoUserAndAddressForCheckout; ?>
                        <!-- END PAYMENT ADDRESS -->


                        <!-- BEGIN INFORMATION -->
                        <div id="information" class="panel panel-default">
                            <div class="panel-heading">
                                <h2 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#checkout-page" href="#information-content" class="accordion-toggle">
                                        Step 3: Information
                                    </a>
                                </h2>
                            </div>
                            <div id="information-content" class="panel-collapse collapse">
                                <div class="panel-body row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="delivery-comments">Add Comments About Your Order</label>
                                            <textarea id="delivery-comments" name="information" rows="8" class="form-control"></textarea>
                                        </div>
                                        <button class="btn btn-primary  pull-right" type="button" id="button-shipping-method" data-toggle="collapse" data-parent="#checkout-page" data-target="#confirm-content">Continue</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END INFORMATION -->

                        <!-- BEGIN CONFIRM -->
                        <div id="confirm" class="panel panel-default">
                            <div class="panel-heading">
                                <h2 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#checkout-page" href="#confirm-content" class="accordion-toggle">
                                        Step 4: Confirm Order
                                    </a>
                                </h2>
                            </div>
                            <div id="confirm-content" class="panel-collapse collapse">
                              <?php echo $getViewCartForSubmitCheckout;?>
                            </div>
                        </div>
                        </form>
                        <!-- END CONFIRM -->
                </div>
                <!-- END CHECKOUT PAGE -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END SIDEBAR & CONTENT -->
    </div>

@stop
@section('jscode')
    <script>
        jQuery(document).ready(function() {
            var mapIdCityToArrayRegion = <?php echo json_encode($mapIdCityToArrayRegion);?>;
            var city_id = $("#city_id").val();
            var regions = mapIdCityToArrayRegion[city_id];
            console.log(regions);
            var option = '';
            var i = 0;
            var idRegionSelect =  $("#region_id_selected").val();
            console.log(idRegionSelect);
            for(; i< regions.length;){
                if(idRegionSelect == regions[i]['id']){
                    option += '<option selected="selected" value="' + regions[i]['id'] +'">'+ regions[i]['name_region'] +'</option>';
                }else {
                    option += '<option value="' + regions[i]['id'] +'">'+ regions[i]['name_region'] +'</option>';
                }

                i++;
            }
            $("#region_id").html(option);
            $("#city_id").change(function(){
                var city_id = $("#city_id").val();
                var regions = mapIdCityToArrayRegion[city_id];
                var option = '';
                var i = 0;
                for(; i< regions.length;){
                    option += '<option value="' + regions[i]['id'] +'">'+ regions[i]['name_region'] +'</option>';
                    i++;
                }
                $("#region_id").html(option);
            });
        })

    </script>
@stop