@extends('layouts.admin.master')
@section('content')
    <form class="form-horizontal form-row-seperated" action="{{ URL::action('OrderController@update') }}"
          method="Post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id_order" value="{{ old('id_order', $dataOrderById['id'])}}">
        <input type="hidden" name="user_id" value="{{ old('user_id', $idUser)}}">
    <div class="row">
        <div class="col-md-12">
            <!-- Begin: life time stats -->
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-shopping-cart"></i>Order #<?php echo $dataOrderById['id'];?> <span class="hidden-480">
								| <?php echo $dataOrderById['created_at'];?> </span>
                    </div>
                    <div class="actions">
                        <a href="#" class="btn default yellow-stripe">
                            <i class="fa fa-angle-left"></i>
								<span class="hidden-480">
								Back </span>
                        </a>
                        <button type="submit" class="btn btn-success yellow-stripe">
                            <i class="fa fa-angle-left"></i>
								<span class="hidden-480">
								Update </span>
                        </button>
                        <div class="btn-group">
                            <a class="btn default yellow-stripe" href="#" data-toggle="dropdown">
                                <i class="fa fa-cog"></i>
									<span class="hidden-480">
									Tools </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="#">
                                        Export to Excel </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Export to CSV </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Export to XML </a>
                                </li>
                                <li class="divider">
                                </li>
                                <li>
                                    <a href="#">
                                        Print Invoice </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="tabbable">
                        <ul class="nav nav-tabs nav-tabs-lg">
                            <li class="active">
                                <a href="#tab_1" data-toggle="tab">
                                    Details </a>
                            </li>

                            <li>
                                <a href="#tab_2" data-toggle="tab">
                                    Add product </a>
                            </li>
                            <li>
                                <a href="#tab_5" data-toggle="tab">
                                    Information </a>
                            </li>
                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane active" id="tab_1">

                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="portlet yellow-crusta box">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="fa fa-cogs"></i>Order Details
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        Order #:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        <?php echo $dataOrderById['id'];?>
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        Order Date & Time:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        <?php echo $dataOrderById['created_at'];?>
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        Order Status:
                                                    </div>
                                                    <div class="col-md-7 value">
																<span class="label label-success">
																<?php echo $dataOrderById['status'];?> </span>
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                       Total cost:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        $<?php echo $dataOrderById['total_cost'];?>
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        Total price:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        $<?php echo $dataOrderById['total_price'];?>
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        Total price import:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        $<?php echo $dataOrderById['total_price_import'];?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 portlet blue-hoki box">

                                                <div class="portlet-title">
                                                    <div class="caption">
                                                        <i class="fa fa-cogs"></i>Status
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="row static-info">
                                                        <div class="col-md-12 value" >
                                                            <?php echo $getViewStatusForOrder; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="portlet blue-hoki box">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="fa fa-cogs"></i>Customer Information
                                                </div>

                                            </div>
                                            <div class="portlet-body">
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        UserName:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        <input class="form-control" type="text" name="username" value="<?php echo $mapIdUserToInfoUser[$idUser]['username'];?>">
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        Full name:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        <input class="form-control" type="text" name="yourname" value="<?php echo $mapIdUserToInfoUser[$idUser]['yourname'];?>">
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        Email:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        <input class="form-control" type="text" name="email" value="<?php echo $mapIdUserToInfoUser[$idUser]['email'];?>">
                                                    </div>
                                                </div>

                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        Phone Number:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        <input class="form-control" type="text" name="phone" value="<?php echo $mapIdUserToInfoUser[$idUser]['phone'];?>">
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        City:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        <select name="city_id" id="city_id" class="form-control">
                                                        <?php echo $getViewSelectTagCity;?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        Region:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        <select name="region_id" id="region_id" class="form-control">
                                                            <?php echo $getViewSelectTagRegion; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        Address:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        <input class="form-control" type="text" name="address" value="<?php echo $mapIdUserToInfoUser[$dataOrderById['id']]['address'];?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="portlet grey-cascade box">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="fa fa-cogs"></i>Shopping Cart
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th>
                                                                Item Status
                                                            </th>
                                                            <th>
                                                                Product
                                                            </th>
                                                            <th>
                                                                Color
                                                            </th>
                                                            <th>
                                                                Size
                                                            </th>
                                                            <th>
                                                                Quantity
                                                            </th>
                                                            <th>
                                                                Cost
                                                            </th>
                                                            <th>
                                                                Total
                                                            </th>
                                                            <th>
                                                                Action
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php echo $getViewAllDetailOrderByIdOrder; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_5">
                                <div class="table-container">
                                    <textarea name="information" id="information"><?php echo $dataOrderById['information'];?></textarea>
                                </div>

                            </div>
    </form>
                            <div class="tab-pane" id="tab_2">
                                <form class="form-horizontal form-row-seperated" action="{{ URL::action('OrderController@addproduct') }}"
                                      method="Post" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="order_id" value="{{ old('id', $dataOrderById['id'])}}">
                                    <table class="table table-striped table-bordered table-hover" id="datatable_products">
                                        <thead>
                                        <tr role="row" class="heading">
                                            <th width="15%">
                                                Product&nbsp;Name
                                            </th>
                                            <th width="15%">
                                                Color
                                            </th>
                                            <th width="10%">
                                                Size
                                            </th>
                                            <th width="10%">
                                                Quantity
                                            </th>
                                            <th width="10%">
                                                Actions
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr role="row" class="heading">
                                            <th width="15%">
                                                <select name="product_id" id="product_id">
                                                    <?php echo $getViewAllProductForSelectTag; ?>
                                                </select>
                                            </th>
                                            <th width="15%">
                                                <select name="color_id" id="color_id">

                                                </select>
                                            </th>
                                            <th width="10%">
                                                <select name="size_id" id="size_id">

                                                </select>
                                            </th>
                                            <th width="10%">
                                                <select name="number" id="number">

                                                </select>
                                            </th>
                                            <th width="10%">
                                                Actions
                                            </th>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <button type="submit" >Add product</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End: life time stats -->
        </div>
    </div>

@stop
@section('js')
    <script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/ckeditor/ckeditor.js"
            type="text/javascript"></script>

    <script>

        CKEDITOR.replace('information', {
                    toolbar: [
                        {name: 'document', items: ['Source', '-', 'NewPage', 'Preview', '-', 'Templates','Image','Flash','Table']},
                        ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', 'Bold', 'Italic'],
                        '/'// Line break - next group will be placed in new line.

                    ],
                    height: ['300px'],
                    weight: ['100%']

                }
        );

    </script>
    <script>
        jQuery(document).ready(function() {
            var mapIdCityToArrayRegion = <?php echo json_encode($mapIdCityToArrayRegion);?>;
            var city_id = $("#city_id").val();
            var regions = mapIdCityToArrayRegion[city_id];
            var option = '';
            var i = 0;
            if(regions !=null) {
                for (; i < regions.length;) {
                    option += '<option value="' + regions[i]['id'] + '">' + regions[i]['name_region'] + '</option>';
                    i++;
                }
                $("#region_id").html(option);
            }

            $("#city_id").change(function(){
                var city_id = $("#city_id").val();
                var regions = mapIdCityToArrayRegion[city_id];
                var option = '';
                var i = 0;
                if(regions !=null) {
                    for (; i < regions.length;) {
                        option += '<option value="' + regions[i]['id'] + '">' + regions[i]['name_region'] + '</option>';
                        i++;
                    }
                    $("#region_id").html(option);
                }
            });
        })

    </script>

    <script>
        jQuery(document).ready(function() {
            var mapIdProductToAllColorOfThisProduct = <?php echo json_encode($mapIdProductToAllColorOfThisProduct);?>;

            $("#product_id").change(function(){
                $("#color_id").html("");
                $("#size_id").html("");
                $("#number").html("");
                var product_id = $("#product_id").val();
                var colors = mapIdProductToAllColorOfThisProduct[product_id];
                if(colors !=null){
                    var option = '';
                    var i = 0;
                    $.each( colors, function( key, value ) {
                        option += '<option value="' + key +'">'+ value.color_name +'</option>';
                    });
                    $("#color_id").html(option);
                }


                var color_id = $("#color_id").val();
                var sizes = mapIdColorToAllSizeOfThisProduct[product_id][color_id];
                if(sizes !=null){
                    var option = '';
                    var i = 0;
                    $.each( sizes, function( key, value ) {
                        option += '<option value="' + key +'">'+ value.size_value +'</option>';
                    });
                    $("#size_id").html(option);
                }

                var size_id = $("#size_id").val();
                var numbers = mapIdSizeToNumberOfThisColorAndThisProduct[product_id][color_id][size_id];
                console.log(numbers);
                if(numbers !=null){
                    var option = '';
                    var i = 0;
                    for(var i = 1;i <= numbers;i++){
                        option += '<option value="' + i +'">'+ i +'</option>';
                    }
                    $("#number").html(option);
                }


            });


            var mapIdColorToAllSizeOfThisProduct = <?php echo json_encode($mapIdColorToAllSizeOfThisProduct);?>;
            $("#color_id").change(function(){
                $("#size_id").html("");
                $("#number").html("");
                var product_id = $("#product_id").val();
                var color_id = $("#color_id").val();
                var sizes = mapIdColorToAllSizeOfThisProduct[product_id][color_id];
                if(sizes !=null){
                    var option = '';
                    var i = 0;
                    $.each( sizes, function( key, value ) {
                        option += '<option value="' + key +'">'+ value.size_value +'</option>';
                    });
                    $("#size_id").html(option);
                }

                var size_id = $("#size_id").val();
                var numbers = mapIdSizeToNumberOfThisColorAndThisProduct[product_id][color_id][size_id];
                console.log(numbers);
                if(numbers !=null){
                    var option = '';
                    var i = 0;
                    for(var i = 1;i <= numbers;i++){
                        option += '<option value="' + i +'">'+ i +'</option>';
                    }
                    $("#number").html(option);
                }
            });

            var mapIdSizeToNumberOfThisColorAndThisProduct = <?php echo json_encode($mapIdSizeToNumberOfThisColorAndThisProduct);?>;
            $("#size_id").change(function(){
                $("#number").html("");
                var product_id = $("#product_id").val();
                var color_id = $("#color_id").val();
                var size_id = $("#size_id").val();
                var numbers = mapIdSizeToNumberOfThisColorAndThisProduct[product_id][color_id][size_id];
                console.log(numbers);
                if(numbers !=null){
                    var option = '';
                    var i = 0;
                    for(var i = 1;i <= numbers;i++){
                        option += '<option value="' + i +'">'+ i +'</option>';
                    }
                    $("#number").html(option);
                }
            });

        })

    </script>


@stop
