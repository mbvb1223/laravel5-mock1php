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
                                <input class="datetimepicker" type="text" name="start">
                            </div>
                            <label for="username"
                                   class="col-sm-1 control-label"><?php echo Lang::get('messages.end'); ?></label>
                            <div class="col-sm-3">
                                <input class="datetimepicker" type="text" name="end">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"
            type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('.datetimepicker').datepicker({
                mask:'9999/19/39 29:59',
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