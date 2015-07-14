@extends('layouts.admin.master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal form-row-seperated" action="{{ URL::action('RolesController@update', $result->id) }}" method="Post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-shopping-cart"></i><?php echo Lang::get('messages.edit_role'); ?>
                    </div>
                    <div class="actions btn-set">
                        <a href="{{ URL::action('RolesController@index') }}" name="back" class="btn default"><i class="fa fa-angle-left"></i> <?php echo Lang::get('messages.list_roles'); ?></a>
                        <button class="btn default" type="reset"><i class="fa fa-reply"></i> <?php echo Lang::get('messages.reset'); ?></button>
                        <button class="btn green" type="submit"><i class="fa fa-check"></i>  <?php echo Lang::get('messages.update'); ?></button>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="form-group">
                        <label for=rolename" class="col-sm-2 control-label"><?php echo Lang::get('messages.roles_rolename'); ?></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" required="required"  name="rolename" value="{{ old('rolename', $result['rolename'])}}" id="rolename" placeholder="<?php echo Lang::get('messages.roles_rolename'); ?>">
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@stop
