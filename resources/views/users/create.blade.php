@extends('layouts.admin.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-row-seperated" action="{{ URL::action('UsersController@index') }}"
                  method="Post" enctype="multipart/form-data" accept="image/*">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-shopping-cart"></i><?php echo Lang::get('messages.create_user'); ?>
                        </div>
                        <div class="actions btn-set">
                            <a href="{{ URL::action('UsersController@index') }}" name="back" class="btn default">
                                <i class="fa fa-angle-left"></i> <?php echo Lang::get('messages.list_users'); ?>
                            </a>
                            <button class="btn default" type="reset">
                                <i class="fa fa-reply"></i><?php echo Lang::get('messages.reset'); ?>
                            </button>
                            <button class="btn green" type="submit">
                                <i class="fa fa-check"></i> <?php echo Lang::get('messages.create'); ?>
                            </button>
                        </div>
                    </div>
                    <div class="portlet-body col-xs-12 col-sm-8">
                        <div class="form-group">
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
                            <label for="username"
                                   class="col-sm-2 control-label"><?php echo Lang::get('messages.users_fullname'); ?></label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="yourname"
                                       value="{{ old('yourname')}}" id="yourname"
                                       placeholder="<?php echo Lang::get('messages.users_fullname'); ?>"
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
                        <div class="form-group">
                            <label for="status"
                                   class="col-sm-2 control-label"><?php echo Lang::get('messages.users_status'); ?></label>

                            <div class="col-sm-10">
                                <select class="form-control" name="status" id="status" required="required">
                                <option value="<?php echo $status['active']; ?> ">Active</option>
                                <option value="<?php echo $status['inactive']; ?>">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role_id"
                                   class="col-sm-2 control-label"><?php echo Lang::get('messages.users_rolename'); ?></label>

                            <div class="col-sm-10">
                                <select class="form-control" name="role_id" id="role_id" required="required">
                                <?php foreach ($roles as $role) :  ?>
                                <option value="<?php echo $role['id']; ?>"><?php echo $role['rolename']; ?></option>
                                <?php endforeach; ?>
                                 </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city_id"
                                   class="col-sm-2 control-label"><?php echo Lang::get('messages.users_city'); ?></label>

                            <div class="col-sm-10">
                                <select class="form-control" name="city_id" id="city_id" required="required">
                                <?php echo $getViewSelectTagCity; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="region_id"
                                   class="col-sm-2 control-label"><?php echo Lang::get('messages.users_region'); ?> </label>

                            <div class="col-sm-10">
                                <select class="form-control" name="region_id" id="region_id" required="required"/>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address"
                                   class="col-sm-2 control-label"><?php echo Lang::get('messages.users_address'); ?></label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="address"
                                       value="{{ old('phone', '')}}" id="address"
                                       placeholder="<?php echo Lang::get('messages.users_address'); ?> "
                                       required="required"/>
                            </div>

                        </div>
                    </div>
                    <div class="porlet-body-right col-xs-12 col-sm-3">
                        <img id="output" class="img-responsive"/>
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
    <script>
        jQuery(document).ready(function() {
            var mapIdCityToArrayRegion = <?php echo json_encode($mapIdCityToArrayRegion);?>;
            var city_id = $("#city_id").val();
            var regions = mapIdCityToArrayRegion[city_id];
            var option = '';
            var i = 0;
            for(; i< regions.length;){
                option += '<option value="' + regions[i]['id'] +'">'+ regions[i]['name_region'] +'</option>';
                i++;
            }
            $("#region_id").html(option);
            $("#city_id").change(function(){
                var city_id = $("#city_id").val();
                var regions = mapIdCityToArrayRegion[city_id];
                var option = '';
                var i = 0;
                for(; i< regions.length;){
                    option += '<option value="' + regions[i]['id'] +'">'+ regions[i]['name_region'] +'</option>';
                    i++;
                }
                $("#region_id").html(option);
            });
        })

    </script>
@stop