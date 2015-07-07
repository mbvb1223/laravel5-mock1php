@extends('layouts.admin.master')
@section('css')
<link href="<?php echo url("/"); ?>/../theme/assets/global/css/jstreestyle.css" rel="stylesheet" type="text/css"/>
@stop


@section('content')
<div class="row">
    <div class="col-xs-12" style="padding-bottom: 5px;">
        <form class="form-horizontal form-row-seperated" action="{{ URL::action('CategoryController@delete') }}"
              method="Post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input  type="hidden" name="id" id="id_delete">
            <input  type="submit" value="Delete" class="btn btn-default">

        </form>
    </div>

    <div class="col-xs-12 col-md-6">
        <div id="jstree">

        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="col-xs-12">
            <form class="form-horizontal form-row-seperated" action="{{ URL::action('CategoryController@index') }}"
                  method="Post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-shopping-cart"></i><?php echo Lang::get('messages.create_category'); ?>
                        </div>
                        <div class="actions btn-set">
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
                                <input type="text" class="form-control" name="category_name"
                                       value="{{ old('category_name', '')}}"
                                       id="category_name"
                                       placeholder="<?php echo Lang::get('messages.category_name'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="parent"
                                   class="col-sm-2 control-label"><?php echo Lang::get('messages.category_parent'); ?>
                            </label>

                            <div class="col-sm-8">

                                <select class="form-control" name="parent" id="parent">
                                    <option value="0">Root</option>
                                    <?php getAllCategory($categories) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
        <hr style="border: 2px solid" />
        <div class="col-xs-12">
            <form class="form-horizontal form-row-seperated" action="{{ URL::action('CategoryController@update') }}"
                  method="Post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input  type="hidden" name="id" id="id_edit">
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-shopping-cart"></i><?php echo Lang::get('messages.edit_category'); ?>
                        </div>
                        <div class="actions btn-set">
                            <button class="btn default" type="reset"><i
                                    class="fa fa-reply"></i><?php echo Lang::get('messages.reset'); ?></button>
                            <button class="btn green" type="submit"><i
                                    class="fa fa-check"></i> <?php echo Lang::get('messages.update'); ?></button>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="form-group">
                            <label for="category_name"
                                   class="col-sm-2 control-label"><?php echo Lang::get('messages.category_name'); ?>
                            </label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="category_name"
                                       value="{{ old('category_name', '')}}"
                                       id="category_name_edit"
                                       placeholder="<?php echo Lang::get('messages.category_name'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="parent"
                                   class="col-sm-2 control-label"><?php echo Lang::get('messages.category_parent'); ?>
                            </label>

                            <div class="col-sm-8">

                                <select class="form-control" name="parent" id="parent_edit">
                                    <option value="0">Root</option>
                                    <?php getAllCategory($categories) ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!--    <form class="form-horizontal form-row-seperated" action="{{ URL::action('CategoryController@store') }}"-->
    <!--          method="Post" enctype="multipart/form-data" accept="image/*">-->
    <!--        <input type="hidden" name="_token" value="{{ csrf_token() }}">-->
    <!--        <button id="jstree2" type="submit">ok</button>-->
    <!--        <input type="text" name="data" id="data" hidden/>-->
    <!--    </form>-->

</div>

@stop
@section('js')


<script src="<?php echo url("/"); ?>/../theme/assets/global/js/jstree.js" type="text/javascript"></script>
@stop
@section('jscode')
<script>
    $(function () {
        var test;
        $.ajax({
            async: true,
            type: "GET",
            url: "{{action('CategoryController@getJsonData')}}",
            dataType: "json",

            success: function (json) {
                createJSTrees(json);
            },

            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }

        });


        // 6 create an instance when the DOM is ready


        function createJSTrees(jsonData) {

            $('#jstree').jstree({
                'core': {
                    "animation": 0,
                    "check_callback": true,
                    "themes": { "stripes": true },
                    'data': jsonData
                },
                "plugins": [
                     "search", "json_data",
                    "state", "types", "wholerow"
                ]

            });


        }

        $("#jstree2").click(function () {
            var v = $('#jstree').jstree(true).get_json();
            var mytext = JSON.stringify(v);
            $('#data').val(mytext);
        });
        $('#jstree').on('changed.jstree', function (e, data) {
            var id, name, parent, i, j, r = [];
            for (i = 0, j = data.selected.length; i < j; i++) {
                r.push(data.instance.get_node(data.selected[i]).id,
                    data.instance.get_node(data.selected[i]).text,
                    data.instance.get_node(data.selected[i]).parent

                );

            }
            //console.log(r);
           // $('#category_name').val(r[1]);
            //$('#event-change').html('Selected: ' + r[0]);

            var optionValue = r[0];
            $("#parent").val(optionValue)
                .find("option[value=" + optionValue + "]").attr('selected', true);

            //for form edit
            $('#category_name_edit').val(r[1]);
            var optionValue = r[2];
            $("#parent_edit").val(optionValue)
                .find("option[value=" + optionValue + "]").attr('selected', true);
            $('#id_edit').val(r[0]);

            //for form delete
            $('#id_delete').val(r[0]);
        });


    });

</script>

@stop

