@extends('layouts.admin.master')
@section('css')
<link href="<?php echo url("/"); ?>/../theme/assets/global/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet"
      type="text/css"/>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-row-seperated" action="{{action('OrderController@analyticsView')}}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="actions btn-set">
                            <button class="btn default" type="reset">
                                <i class="fa fa-reply"></i><?php echo Lang::get('messages.reset'); ?>
                            </button>
                            <button class="btn green" type="submit">
                                <i class="fa fa-check"></i> <?php echo Lang::get('messages.ok'); ?>
                            </button>
                        </div>
                    </div>
                    <div class="portlet-body col-xs-12 col-sm-12">
                        <div class="form-group">
                            <label for="username"
                                   class="col-sm-2 control-label"><?php echo Lang::get('messages.start'); ?></label>
                            <div class="col-sm-3">
                                <input class="datetimepicker" type="text" name="start" value="{{$start}}">
                            </div>
                            <label for="username"
                                   class="col-sm-1 control-label"><?php echo Lang::get('messages.end'); ?></label>
                            <div class="col-sm-3">
                                <input class="datetimepicker" type="text" name="end" value="{{$end}}">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="portlet blue-hoki box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>Pending
                    </div>

                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-6 name">
                           Count:
                        </div>
                        <div class="col-md-6 value">
                            <?php echo $orderPending['count']; ?>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-6 name">
                            Price import:
                        </div>
                        <div class="col-md-6 value">
                            $  <?php echo $orderPending['total_price_import']; ?>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-6 name">
                            cost:
                        </div>
                        <div class="col-md-6 value">
                            $  <?php echo $orderPending['total_cost']; ?>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-6 name">
                            profit:
                        </div>
                        <div class="col-md-6 value">
                            $ <?php echo $orderPending['total_profit']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="portlet blue-hoki box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>Delevery
                    </div>

                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-6 name">
                            Count:
                        </div>
                        <div class="col-md-6 value">
                            $  <?php echo $orderDelevery['count']; ?>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-6 name">
                            Price import:
                        </div>
                        <div class="col-md-6 value">
                            $ <?php echo $orderDelevery['total_price_import']; ?>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-6 name">
                            cost:
                        </div>
                        <div class="col-md-6 value">
                            $  <?php echo $orderDelevery['total_cost']; ?>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-6 name">
                            profit:
                        </div>
                        <div class="col-md-6 value">
                            $  <?php echo $orderDelevery['total_profit']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="portlet blue-hoki box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>Successful
                    </div>

                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-6 name">
                            Count:
                        </div>
                        <div class="col-md-6 value">
                            <?php echo $orderOk['count']; ?>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-6 name">
                            Price import:
                        </div>
                        <div class="col-md-6 value">
                            $ <?php echo $orderOk['total_price_import']; ?>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-6 name">
                            cost:
                        </div>
                        <div class="col-md-6 value">
                            $ <?php echo $orderOk['total_cost']; ?>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-6 name">
                            profit:
                        </div>
                        <div class="col-md-6 value">
                            $  <?php echo $orderOk['total_profit']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="portlet blue-hoki box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>Cancel
                    </div>

                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-6 name">
                            Count:
                        </div>
                        <div class="col-md-6 value">
                            <?php echo $orderCancel['count']; ?>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-6 name">
                            Price import:
                        </div>
                        <div class="col-md-6 value">
                            $  <?php echo $orderCancel['total_price_import']; ?>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-6 name">
                            cost:
                        </div>
                        <div class="col-md-6 value">
                            $ <?php echo $orderCancel['total_cost']; ?>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-6 name">
                            profit:
                        </div>
                        <div class="col-md-6 value">
                            $ <?php echo  $orderCancel['total_profit']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-condensed table-hover">
                <thead>
                <tr>
                    <th>
                      Name Product
                    </th>
                    <th>
                       Key Product
                    </th>
                    <th>
                       Total number
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($getHotProduct as $itemProduct) : ?>
                <tr>
                    <th>
                        <?php echo $itemProduct['name_product']; ?>
                    </th>
                    <th>
                        <?php echo $itemProduct['key_product']; ?>
                    </th>
                    <th>
                        <?php echo $itemProduct['sum']; ?>
                    </th>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"
            type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('.datetimepicker').datepicker({
                mask:'9999/19/39 29:69',
            });
        })
        </script>
    <script>
        var loadFile = function (event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
@stop