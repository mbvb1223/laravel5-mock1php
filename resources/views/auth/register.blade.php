@extends('layouts.front.master')
@section('content')
    <div class="main">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="index.html">Home</a></li>
                <li><a href="#">Pages</a></li>
                <li class="active">Create new account</li>
            </ul>
            <!-- BEGIN SIDEBAR & CONTENT -->
            <div class="row margin-bottom-40">
                <!-- BEGIN SIDEBAR -->
                <div class="sidebar col-md-3 col-sm-3">
                    <ul class="list-group margin-bottom-25 sidebar-menu">
                        <li class="list-group-item clearfix"><a href="#"><i class="fa fa-angle-right"></i>
                                Login/Register</a></li>
                        <li class="list-group-item clearfix"><a href="#"><i class="fa fa-angle-right"></i> Restore
                                Password</a></li>
                        <li class="list-group-item clearfix"><a href="#"><i class="fa fa-angle-right"></i> My
                                account</a></li>
                        <li class="list-group-item clearfix"><a href="#"><i class="fa fa-angle-right"></i> Address book</a>
                        </li>
                        <li class="list-group-item clearfix"><a href="#"><i class="fa fa-angle-right"></i> Wish list</a>
                        </li>
                        <li class="list-group-item clearfix"><a href="#"><i class="fa fa-angle-right"></i> Returns</a>
                        </li>
                        <li class="list-group-item clearfix"><a href="#"><i class="fa fa-angle-right"></i>
                                Newsletter</a></li>
                    </ul>
                </div>
                <!-- END SIDEBAR -->

                <!-- BEGIN CONTENT -->
                <div class="col-md-9 col-sm-9">
                    <h1>Create an account</h1>

                    <div class="content-form-page">
                        <div class="row">
                            <div class="col-md-8 col-sm-8">
                                <form class="form-horizontal form-row-seperated" action="{{ url('/auth/register') }}"
                                      method="Post" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <fieldset>
                                        <legend>Your personal details</legend>
                                        <div class=" form-group">
                                            <label for="username"
                                                   class="col-lg-4 control-label"><?php echo Lang::get('messages.users_username'); ?></label>

                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="username"
                                                       value="{{ old('username')}}" id="username"
                                                       placeholder="<?php echo Lang::get('messages.users_username'); ?>"
                                                       required="required"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password"
                                                   class="col-lg-4 control-label"><?php echo Lang::get('messages.users_password'); ?></label>

                                            <div class="col-lg-8">
                                                <input type="password" class="form-control" name="password"
                                                       id="password"
                                                       placeholder="<?php echo Lang::get('messages.users_password'); ?>"
                                                       required="required"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="repassword"
                                                   class="col-lg-4 control-label"><?php echo Lang::get('messages.users_repassword'); ?></label>

                                            <div class="col-lg-8">
                                                <input type="password" class="form-control" name="repassword"
                                                       id="repassword"
                                                       placeholder="<?php echo Lang::get('messages.users_repassword'); ?>"
                                                       required="required"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email"
                                                   class="col-lg-4 control-label"><?php echo Lang::get('messages.users_email'); ?></label>

                                            <div class="col-lg-8">
                                                <input type="email" class="form-control" name="email"
                                                       value="{{ old('email', '')}}" id="email"
                                                       placeholder="<?php echo Lang::get('messages.users_email'); ?>"
                                                       required="required"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone" class="col-lg-4 control-label">
                                                <?php echo Lang::get('messages.users_phone'); ?>
                                            </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="phone"
                                                       value="{{ old('phone', '')}}" id="phone"
                                                       placeholder="<?php echo Lang::get('messages.users_phone'); ?>"
                                                       required="required"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="avatar"
                                                   class="col-lg-4 control-label"><?php echo Lang::get('messages.users_avatar'); ?></label>

                                            <div class="col-lg-8">
                                                <input type="file" class="form-control" name="avatar" id="avatar"
                                                       required="required"
                                                       onchange="loadFile(event)"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="address" class="col-lg-4 control-label">
                                                <?php echo Lang::get('messages.users_address'); ?>
                                            </label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="address"
                                                       value="{{ old('address', '')}}" id="address"
                                                       placeholder="<?php echo Lang::get('messages.users_address'); ?>"
                                                       required="required"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="city_id" class="col-lg-4 control-label">
                                                <?php echo Lang::get('messages.users_city'); ?>
                                            </label>
                                            <div class="col-lg-8">
                                                <select name="city_id" class="form-control" id='city_id'>
                                                    <?php echo $getViewSelectTagCity; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="region_id" class="col-lg-4 control-label">
                                                <?php echo Lang::get('messages.users_region'); ?>
                                            </label>
                                            <div class="col-lg-8">
                                                <select name="region_id" id='region_id' class="form-control">

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-8 col-lg-offset-4 g-recaptcha"
                                                 data-sitekey="6LcrigkTAAAAAABb8PmhEcXmF-mAH4DI9td5P4HY">

                                            </div>
                                        </div>

                                    </fieldset>

                                    <div class="row">
                                        <div class="col-lg-8 col-md-offset-4 padding-left-0 padding-top-20">
                                            <button type="submit" class="btn btn-primary">Create an account</button>
                                            <button type="button" class="btn btn-default">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4 col-sm-4 pull-right">
                                <img id="output" class="img-responsive"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END SIDEBAR & CONTENT -->
    </div>
    </div>

@stop

@section('jscode')
    <script src='https://www.google.com/recaptcha/api.js'></script>

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