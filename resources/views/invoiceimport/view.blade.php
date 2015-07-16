@extends('layouts.admin.master')
@section('css')
    <link href="<?php echo url("/"); ?>/../theme/assets/frontend/pages/css/style-shop-admin.css" rel="stylesheet"
          type="text/css">
@stop
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <form class="form-horizontal form-row-seperated"
                  action="{{ URL::action('InvoiceImportController@update') }}"
                  method="Post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-shopping-cart"></i><?php echo Lang::get('messages.view_cart'); ?>
                        </div>
                        <div class="actions btn-set">

                            <button class="btn default" type="reset"><i
                                        class="fa fa-reply"></i><?php echo Lang::get('messages.reset'); ?></button>
                            <a href="{{ URL::action('InvoiceImportController@import') }}" name="back"
                               class="btn default">
                                <i class="fa fa-chevron-left"></i> <?php echo Lang::get('messages.back'); ?>
                            </a>
                            <button type="submit" class="btn default"><i
                                        class="fa fa-refresh"></i> <?php echo Lang::get('messages.update'); ?>
                            </button>
                            <a href="{{ URL::action('InvoiceImportController@checkout') }}" name="back"
                               class="btn green">
                                <i class="fa fa-check"></i> <?php echo Lang::get('messages.checkout'); ?>
                            </a>

                        </div>
                    </div>

                </div>
                <div class="goods-data clearfix">
                    <div class="table-wrapper-responsive table-responsive">
                        <table summary="Shopping cart">
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
                    <div class='shopping-total'>
                        <?php echo $viewCartButton; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop


