@extends('layouts.admin.master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal form-row-seperated" action="{{ URL::action('CategoryController@index') }}"
              method="Post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-shopping-cart"></i><?php echo Lang::get('messages.create_category'); ?>
                    </div>
                    <div class="actions btn-set">
                        <a href="{{ URL::action('CategoryController@index') }}" name="back" class="btn default"><i
                                class="fa fa-angle-left"></i> <?php echo Lang::get('messages.list_category'); ?></a>
                        <button class="btn default" type="reset"><i
                                class="fa fa-reply"></i><?php echo Lang::get('messages.reset'); ?></button>
                        <button class="btn green" type="submit"><i
                                class="fa fa-check"></i> <?php echo Lang::get('messages.create'); ?></button>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="form-group">
                        <label for="category_name"
                               class="col-sm-2 control-label"><?php echo Lang::get('messages.category_name'); ?>
                        </label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="category_name" value="{{ old('category_name', '')}}"
                                   id="category_name" placeholder="<?php echo Lang::get('messages.category_name'); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="parent"
                               class="col-sm-2 control-label"><?php echo Lang::get('messages.category_parent'); ?>
                        </label>

                        <div class="col-sm-8">

                        <select class="form-control" name="parent" >
                            <option value="0">Root</option>
                            <?php echo $categories; ?>
                        </select>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@stop

@section('js')

<script>
    var loadFile = function (event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
@stop