@extends('layouts.admin.master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal form-row-seperated" action="{{ URL::action('MadeinController@index') }}"
              method="Post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-shopping-cart"></i><?php echo Lang::get('messages.create_madein'); ?>
                    </div>
                    <div class="actions btn-set">
                        <a href="{{ URL::action('MadeinController@index') }}" name="back" class="btn default"><i
                                class="fa fa-angle-left"></i> <?php echo Lang::get('messages.list_madein'); ?></a>
                        <button class="btn default" type="reset"><i
                                class="fa fa-reply"></i><?php echo Lang::get('messages.reset'); ?></button>
                        <button class="btn green" type="submit"><i
                                class="fa fa-check"></i> <?php echo Lang::get('messages.create'); ?></button>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="form-group">
                        <label for="madein_name"
                               class="col-sm-2 control-label"><?php echo Lang::get('messages.madein_name'); ?>
                        </label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="madein_name" value="{{ old('madein_name', '')}}"
                                   id="madein_name" required="required" placeholder="<?php echo Lang::get('messages.madein_name'); ?>">
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@stop

