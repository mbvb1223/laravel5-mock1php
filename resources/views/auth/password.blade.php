@extends('auth.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal form-row-seperated" action="{{ url('/auth/login') }}"
              method="Post" enctype="multipart/form-data" accept="image/*">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-shopping-cart"></i><?php echo Lang::get('messages.create_user'); ?>
                    </div>
                    <div class="actions btn-set">
                        <a href="{{ URL::action('UsersController@index') }}" name="back" class="btn default"><i
                                class="fa fa-angle-left"></i> <?php echo Lang::get('messages.list_users'); ?></a>
                        <button class="btn default" type="reset"><i
                                class="fa fa-reply"></i><?php echo Lang::get('messages.reset'); ?></button>
                        <button class="btn green" type="submit"><i
                                class="fa fa-check"></i> <?php echo Lang::get('messages.create'); ?></button>
                    </div>
                </div>
                <div class="portlet-body col-xs-12 col-sm-8">
                    <div class=" form-group">
                        <label for="username"
                               class="col-sm-2 control-label"><?php echo Lang::get('messages.users_email'); ?></label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username"
                                   value="{{ old('username')}}" id="username"
                                   placeholder="<?php echo Lang::get('messages.users_username'); ?>"
                                   required="required"/>
                        </div>
                    </div>


                </div>
                <div class="porlet-body-right col-xs-12 col-sm-3">
                    <img id="output" class="img-responsive"/>
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