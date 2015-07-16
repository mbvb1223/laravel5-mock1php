@extends('layouts.admin.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-row-seperated" action="{{ URL::action('InvoiceImportController@index') }}"
                  method="Post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-shopping-cart"></i><?php echo Lang::get('messages.import_product'); ?>
                        </div>
                        <div class="actions btn-set">
                            <button class="btn default" type="reset"><i
                                        class="fa fa-reply"></i><?php echo Lang::get('messages.reset'); ?></button>
                            <a href="{{ URL::action('InvoiceImportController@view') }}" name="back" class="btn default"><i
                                        class="fa fa-eye"></i> <?php echo Lang::get('messages.view_cart'); ?>
                            </a>
                            <button class="btn green" type="submit"><i
                                        class="fa fa-check"></i> <?php echo Lang::get('messages.import'); ?></button>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="form-group">
                            <label for="product_id" class="col-sm-2 control-label">
                                <strong> <?php echo Lang::get('messages.name_product'); ?> </strong>
                            </label>
                            <div class="col-sm-4">
                                <select name="product_id" id="product_id" class="form-control">
                                    <?php echo $allProductForOptionInSelectTagHTML;?>
                                </select>
                            </div>
                            <label for="color_id" class="col-sm-1 control-label">
                                <strong> <?php echo Lang::get('messages.color'); ?> </strong>
                            </label>
                            <div class="col-sm-4">
                                <select name="color_id" id="color_id" class="form-control">
                                    <?php echo $allColorForOptionInSelectTagHTML; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <table class="table table-hover">
                                <tr>
                                    <td class="text-center"><strong>Size</strong></td>
                                    <td class="text-center"><strong>Number</strong></td>
                                    <td class="text-center"><strong>Size</strong></td>
                                    <td class="text-center"><strong>Number</strong></td>
                                </tr>
                                <?php echo $allAllSizeAndInputTagNumber; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

