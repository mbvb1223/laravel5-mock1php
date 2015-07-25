@extends('layouts.admin.master')
@section('css')
<link href="<?php echo url("/"); ?>/../theme/assets/global/css/jquery.bootgird.min.css" rel="stylesheet" type="text/css"/>
@stop


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-shopping-cart"></i><?php echo Lang::get('messages.invoice_import'); ?>
                </div>
                <div class="actions">
                    <a href="{{ URL::action('InvoiceImportController@import') }}" class="btn default yellow-stripe">
                        <i class="fa fa-plus"></i>
                         <span class="hidden-480">
                         <?php echo Lang::get('messages.create_new'); ?>
                         </span>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <table id="grid-data-api" class="table table-condensed table-hover table-striped">
                    <thead>
                    <tr>
                        <th data-column-id="id"><?php echo Lang::get('messages.id'); ?></th>
                        <th data-column-id="username"><?php echo Lang::get('messages.users_username'); ?></th>
                        <th data-column-id="total_price"><?php echo Lang::get('messages.total_price'); ?></th>
                        <th data-column-id="created_at"><?php echo Lang::get('messages.created_at'); ?></th>
                        <th data-column-id="action"><?php echo Lang::get('messages.action'); ?></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.2.0/jquery.bootgrid.fa.min.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bootgrid/1.2.0/jquery.bootgrid.min.js"></script>
@stop
    @section('jscode')
    <script>
        jQuery(document).ready(function() {
            $("#grid-data-api").bootgrid({
                ajax: true,
                post: function ()
                {
                    /* To accumulate custom parameter with the request object */
                    return {
                        _token: "{{csrf_token()}}"
                    };
                },
                url: "{{url('admin/invoiceimport/getDataAjax')}}"
            });
        })
    </script>
@stop

