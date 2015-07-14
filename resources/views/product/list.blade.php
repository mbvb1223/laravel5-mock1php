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
                    <i class="fa fa-shopping-cart"></i><?php echo Lang::get('messages.list_users'); ?>
                </div>
                <div class="actions">
                    <a href="{{ URL::action('ProductController@create') }}" class="btn default yellow-stripe">
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
                        <th data-column-id="key_product"><?php echo Lang::get('messages.key_product'); ?></th>
                        <th data-column-id="name_product"><?php echo Lang::get('messages.name_product'); ?></th>
                        <th data-column-id="style_id"><?php echo Lang::get('messages.style'); ?></th>
                        <th data-column-id="madein_id"><?php echo Lang::get('messages.madein'); ?></th>
                        <th data-column-id="material_id"><?php echo Lang::get('messages.material'); ?></th>
                        <th data-column-id="height_id"><?php echo Lang::get('messages.height'); ?></th>
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
            url: "{{url('admin/product/getDataAjax')}}"


        });

    })

</script>

@stop

