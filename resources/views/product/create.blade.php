@extends('layouts.admin.master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal form-row-seperated" action="{{ URL::action('ProductController@index') }}"
              method="Post" enctype="multipart/form-data" accept="image/*">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-shopping-cart"></i><?php echo Lang::get('messages.create_product'); ?>
                    </div>
                    <div class="actions btn-set">
                        <a href="{{ URL::action('ProductController@index') }}" name="back" class="btn default"><i
                                class="fa fa-angle-left"></i> <?php echo Lang::get('messages.list_product'); ?></a>
                        <button class="btn default" type="reset"><i
                                class="fa fa-reply"></i><?php echo Lang::get('messages.reset'); ?></button>
                        <button class="btn green" type="submit" id="submit">
                            <i class="fa fa-check"></i> <?php echo Lang::get('messages.create'); ?></button>
                    </div>
                </div>
                <div class="portlet-body col-xs-12 col-sm-8">
                    <div class=" form-group">
                        <label for="username"
                               class="col-sm-3 control-label"><?php echo Lang::get('messages.key_product'); ?>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="key_product"
                                   value="{{ old('key_product')}}" id="key_product"
                                   placeholder="<?php echo Lang::get('messages.key_product'); ?>"
                                   required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name_product"
                               class="col-sm-3 control-label"><?php echo Lang::get('messages.name_product'); ?></label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name_product"
                                   id="name_product"
                                   placeholder="<?php echo Lang::get('messages.name_product'); ?>"
                                   required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price_import"
                               class="col-sm-3 control-label"><?php echo Lang::get('messages.price_import'); ?></label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="price_import"
                                   id="price_import"
                                   placeholder="<?php echo Lang::get('messages.price_import'); ?>"
                                   required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price"
                               class="col-sm-3 control-label"><?php echo Lang::get('messages.price'); ?></label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="price"
                                   id="price"
                                   placeholder="<?php echo Lang::get('messages.price'); ?>"
                                   required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="selloff_id" class="col-sm-3 control-label">
                            <?php echo Lang::get('messages.selloff'); ?>
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control" name="selloff_id" id="selloff_id" required="required">
                                <option value="0">None</option>
                                <?php foreach($allSelloff as $selloff) : ?>
                                <option value="{{$selloff['id']}}"> {{$selloff['selloff_value']}}</option>
                                <?php endforeach; ?>
                            </select>
                            <input hidden value="{{json_encode($arrayFromIdToValueOfSelloff)}}" id="arrayFromIdToValueOfSelloff"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cost"
                               class="col-sm-3 control-label"><?php echo Lang::get('messages.cost'); ?></label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="cost"
                                   id="cost"
                                   placeholder="<?php echo Lang::get('messages.cost'); ?>"
                                   required="required" readonly/>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image"
                               class="col-sm-3 control-label"><?php echo Lang::get('messages.image_product'); ?></label>

                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="image" id="image" required="required"
                                   onchange="loadFile(event)"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="style_id" class="col-sm-3 control-label">
                            <?php echo Lang::get('messages.category'); ?>
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control" name="category_id" id="category_id" required="required">
                            <?php echo $allOptionOfCategory; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="style_id" class="col-sm-3 control-label">
                            <?php echo Lang::get('messages.style'); ?>
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control" name="style_id" id="style_id" required="required">
                                <?php foreach($allStyle as $style) : ?>
                                    <option value="{{$style['id']}}"> {{$style['style_name']}}</option>
                                <?php endforeach; ?>
                          </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="madein_id" class="col-sm-3 control-label">
                            <?php echo Lang::get('messages.madein'); ?></label>
                        <div class="col-sm-9">
                            <select class="form-control" name="madein_id" id="madein_id" required="required">
                                <?php foreach($allMadein as $madein) : ?>
                                <option value="{{$madein['id']}}"> {{$madein['madein_name']}}</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="material_id" class="col-sm-3 control-label">
                            <?php echo Lang::get('messages.material'); ?></label>
                        <div class="col-sm-9">
                            <select class="form-control" name="material_id" id="material_id" required="required">
                                <?php foreach($allMaterial as $material) : ?>
                                    <option value="{{$material['id']}}"> {{$material['material_name']}}</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="height_id" class="col-sm-3 control-label">
                            <?php echo Lang::get('messages.height'); ?></label>
                        <div class="col-sm-9">
                            <select class="form-control" name="height_id" id="height_id" required="required">
                                <?php foreach($allHeight as $height) : ?>
                                    <option value="{{$height['id']}}"> {{$height['height_value']}}</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>


                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="information" class="col-sm-2 control-label">
                            <?php echo Lang::get('messages.information'); ?></label>
                        <div class="col-sm-10">
                            <textarea name="information" id="information"></textarea>
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
    <script src="<?php echo url("/"); ?>/../theme/assets/frontend/layout/scripts/jquery.number.js" type="text/javascript"></script>
    <script src="<?php echo url("/"); ?>/../theme/assets/frontend/layout/scripts/product.js" type="text/javascript"></script>
    <script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/ckeditor/ckeditor.js"
            type="text/javascript"></script>

<script>
    var loadFile = function (event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
    };

    CKEDITOR.replace('information', {
                toolbar: [
                    {name: 'document', items: ['Source', '-', 'NewPage', 'Preview', '-', 'Templates','Image','Flash','Table']},
                    ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', 'Bold', 'Italic'],
                    '/'// Line break - next group will be placed in new line.

                ],
                height: ['100px'],
                weight: ['100%']

            }
    );


</script>
@stop