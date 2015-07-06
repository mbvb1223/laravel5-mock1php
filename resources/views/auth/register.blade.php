@extends('auth.layouts.master')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-row-seperated" action="{{ url('/auth/register') }}"
                  method="Post" enctype="multipart/form-data" accept="image/*">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-shopping-cart"></i><?php echo Lang::get('messages.create_user'); ?>
                        </div>
                        <div class="actions btn-set">

                            <button class="btn default" type="reset"><i
                                    class="fa fa-reply"></i><?php echo Lang::get('messages.reset'); ?></button>
                            <button class="btn green" type="submit"><i
                                    class="fa fa-check"></i> <?php echo Lang::get('messages.create'); ?></button>
                        </div>
                    </div>
                    <div class="portlet-body col-xs-12 col-sm-12">
                        <div class=" form-group">
                            <label for="username"
                                   class="col-sm-2 control-label"><?php echo Lang::get('messages.users_username'); ?></label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="username"
                                       value="{{ old('username')}}" id="username"
                                       placeholder="<?php echo Lang::get('messages.users_username'); ?>"
                                       required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password"
                                   class="col-sm-2 control-label"><?php echo Lang::get('messages.users_password'); ?></label>

                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password"
                                       id="password"
                                       placeholder="<?php echo Lang::get('messages.users_password'); ?>"
                                       required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="repassword"
                                   class="col-sm-2 control-label"><?php echo Lang::get('messages.users_repassword'); ?></label>

                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="repassword"
                                       id="repassword"
                                       placeholder="<?php echo Lang::get('messages.users_repassword'); ?>"
                                       required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email"
                                   class="col-sm-2 control-label"><?php echo Lang::get('messages.users_email'); ?></label>

                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="email"
                                       value="{{ old('email', '')}}" id="email"
                                       placeholder="<?php echo Lang::get('messages.users_email'); ?>"
                                       required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone"
                                   class="col-sm-2 control-label"><?php echo Lang::get('messages.users_phone'); ?></label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="phone"
                                       value="{{ old('phone', '')}}" id="phone"
                                       placeholder="<?php echo Lang::get('messages.users_phone'); ?>"
                                       required="required"/>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="avatar"
                                   class="col-sm-2 control-label"><?php echo Lang::get('messages.users_avatar'); ?></label>

                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="avatar" id="avatar" required="required"
                                       onchange="loadFile(event)"/>
                            </div>
                        </div>

                    </div>
                    <div class="porlet-body-right col-xs-12 col-md-6 col-md-offset-3">
                        <img id="output" class="img-responsive"/>
                    </div>
            </form>
        </div>
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