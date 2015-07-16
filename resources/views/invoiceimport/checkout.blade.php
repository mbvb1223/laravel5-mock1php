@extends('layouts.admin.master')
@section('css')
    <link href="<?php echo url("/"); ?>/../theme/assets/frontend/pages/css/style-shop-admin.css" rel="stylesheet"
          type="text/css">
    @stop
@section('content')
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-shopping-cart"></i><?php echo Lang::get('messages.confirm_invoice'); ?>
            </div>
            <div class="actions btn-set">
                <a href="{{ URL::action('InvoiceImportController@view') }}" name="back" class="btn default">
                    <i class="fa fa-chevron-left"></i> <?php echo Lang::get('messages.back'); ?>
                </a>
            </div>
        </div>
    </div>
        <!-- BEGIN SIDEBAR & CONTENT -->
<div class="row">
    <div class="row margin-bottom-40">
    <!-- BEGIN CONTENT -->
        <form class="form-horizontal form-row-seperated" action="{{ URL::action('InvoiceImportController@checkoutpost') }}" method="Post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-12 col-sm-12">
        <!-- BEGIN CHECKOUT PAGE -->
        <div class="panel-group checkout-page accordion scrollable" id="checkout-page">

            <!-- BEGIN INFORMATION -->
            <div id="information" class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">
                        <a data-toggle="collapse" data-parent="#checkout-page" href="#shipping-method-content" class="accordion-toggle">
                            Step 1: Information
                        </a>
                    </h2>
                </div>
                <div id="shipping-method-content" class="panel-collapse collapse">
                    <div class="panel-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="delivery-comments">Add Comments About Your Order</label>
                                <textarea id="delivery-comments" rows="8" class="form-control" name="information"></textarea>
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
                            Step 2: Confirm
                        </a>
                    </h2>
                </div>
                <div id="confirm-content" class="panel-collapse collapse">
                    <div class="panel-body row">
                        <div class="col-md-12 clearfix">
                            <div class="table-wrapper-responsive table-responsive">
                                <table>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Color - Size</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Item price</th>
                                        <th>Del</th>
                                    </tr>
                                    <?php echo $viewCart; ?>
                                </table>
                            </div>
                            <div class="checkout-total-block">
                                <?php echo $viewCartButton; ?>
                            </div>
                            <div class="clearfix"></div>
                            <button class="btn btn-primary pull-right" type="submit" id="button-confirm">Confirm Order</button>

                        </div>
                    </div>
                </div>
            </div>
            <!-- END CONFIRM -->
        </div>
        <!-- END CHECKOUT PAGE -->
    </div>
        </form>
    <!-- END CONTENT -->
</div>
</div>
<!-- END SIDEBAR & CONTENT -->
@stop
@section('jscode')
    <script>
        jQuery(document).ready(function() {

            $("#number").attr("readonly", "true");
        })

    </script>

@stop
