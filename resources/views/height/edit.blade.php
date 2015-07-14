@extends('layouts.admin.master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal form-row-seperated" action="{{ URL::action('HeightController@update', $result->id) }}" method="Post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-shopping-cart"></i><?php echo Lang::get('messages.edit_height'); ?>
                    </div>
                    <div class="actions btn-set">
                        <a href="{{ URL::action('HeightController@index') }}" name="back" class="btn default"><i class="fa fa-angle-left"></i> <?php echo Lang::get('messages.list_heights'); ?></a>
                        <button class="btn default" type="reset"><i class="fa fa-reply"></i> <?php echo Lang::get('messages.reset'); ?></button>
                        <button class="btn green" type="submit"><i class="fa fa-check"></i>  <?php echo Lang::get('messages.update'); ?></button>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="form-group">
                        <label for=height_value" class="col-sm-2 control-label"><?php echo Lang::get('messages.height_value'); ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" required="required"  name="height_value" value="{{ old('height_value', $result['height_value'])}}" id="height_value" placeholder="<?php echo Lang::get('messages.height_value'); ?>">
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@stop
