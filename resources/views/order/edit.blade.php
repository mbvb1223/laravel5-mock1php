@extends('layouts.admin.master')
@section('content')
    <form class="form-horizontal form-row-seperated" action="{{ URL::action('OrderController@update') }}"
          method="Post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value="{{ old('id', $dataOrderById['id'])}}">
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
                                                        <?php echo $mapIdUserToInfoUser[$dataOrderById['id']]['username'];?>
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        Full name:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        <?php echo $mapIdUserToInfoUser[$dataOrderById['id']]['yourname'];?>
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        Email:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        <?php echo $mapIdUserToInfoUser[$dataOrderById['id']]['email'];?>
                                                    </div>
                                                </div>

                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        Phone Number:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        <?php echo $mapIdUserToInfoUser[$dataOrderById['id']]['phone'];?>
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        City:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        <?php echo $mapIdUserToInfoUser[$dataOrderById['id']]['city_id'];?>
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        Region:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        <?php echo $mapIdUserToInfoUser[$dataOrderById['id']]['region_id'];?>
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        Address:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        <?php echo $mapIdUserToInfoUser[$dataOrderById['id']]['address'];?>
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
                                                                Price
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
                        </div>
                    </div>
                </div>
            </div>
            <!-- End: life time stats -->
        </div>
    </div>
    </form>
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
    @stop