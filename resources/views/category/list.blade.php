@extends('layouts.admin.master')
@section('css')
<link href="<?php echo url("/"); ?>/../theme/assets/global/css/jstreestyle.css" rel="stylesheet" type="text/css"/>
@stop


@section('content')
<div class="row">
    <div id="jstree">

    </div>
    <form class="form-horizontal form-row-seperated" action="{{ URL::action('CategoryController@store') }}"
          method="Post" enctype="multipart/form-data" accept="image/*">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button id="jstree2" type="submit">ok</button>
        <input type="text" name="data" id="data" hidden/>
        </form>

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
            async : true,
            type : "GET",
            url : "{{action('CategoryController@getJsonData')}}",
            dataType : "json",

            success : function(json) {
                createJSTrees(json);
            },

            error : function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }

        });


        // 6 create an instance when the DOM is ready


        function createJSTrees(jsonData) {

            $('#jstree').jstree({
                'core' : {
                "animation" : 0,
                "check_callback" : true,
                "themes" : { "stripes" : true },
                'data' : jsonData
                },
                "plugins" : [
                    "contextmenu", "dnd", "search","json_data",
                    "state", "types", "wholerow"
                ]

             });

        }
        $( "#jstree2" ).click(function() {
            var v =$('#jstree').jstree(true).get_json();
            var mytext = JSON.stringify(v);
            $('#data').val(mytext);
        });
    });

</script>

    @stop

