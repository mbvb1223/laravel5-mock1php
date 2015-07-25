@extends('layouts.admin.master')
@section('css')
    <link href="<?php echo url("/"); ?>/../theme/assets/frontend/pages/css/style-shop-admin.css" rel="stylesheet"
          type="text/css">
@stop
@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- Begin: life time stats -->
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-shopping-cart"></i>Invoice # <?php echo $getDataInvoiceImportById['id']; ?><span class="hidden-480"></span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="tabbable">
                        <ul class="nav nav-tabs nav-tabs-lg">
                            <li class="active">
                                <a href="#tab_1" data-toggle="tab">
                                    Details </a>
                            </li>
                            <li>
                                <a href="#tab_5" data-toggle="tab">
                                    Information </a>
                            </li>
                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane active" id="tab_1">

                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="portlet blue-hoki box">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="fa fa-cogs"></i>Info
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        Invoice #:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        <?php echo $getDataInvoiceImportById['id']; ?>
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        UserName:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        <?php echo $getDataInvoiceImportById['username']; ?>
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        Invoice Date & Time:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        <?php echo $getDataInvoiceImportById['created_at']; ?>
                                                    </div>
                                                </div>
                                                <div class="row static-info">
                                                    <div class="col-md-5 name">
                                                        Total price:
                                                    </div>
                                                    <div class="col-md-7 value">
                                                        $<?php echo $getDataInvoiceImportById['total_price']; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="portlet grey-cascade box">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="fa fa-cogs"></i>Detail
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th>
                                                                Product
                                                            </th>
                                                            <th>
                                                                Color
                                                            </th>
                                                            <th>
                                                                Size
                                                            </th>
                                                            <th>
                                                                Quantity
                                                            </th>
                                                            <th>
                                                                Price_import
                                                            </th>
                                                            <th>
                                                                Total
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php echo $getViewAllDetailInvoiceImportByIdInvoiceImport; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_5">
                                <div class="table-container">
                                    <textarea name="information"
                                              id="information">  <?php echo $getDataInvoiceImportById['information']; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End: life time stats -->
        </div>
    </div>
@stop

@section('js')
    <script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/ckeditor/ckeditor.js"
            type="text/javascript"></script>

    <script>

        CKEDITOR.replace('information', {
                    toolbar: [
                        {name: 'document', items: ['Source', '-', 'NewPage', 'Preview', '-', 'Templates','Image','Flash','Table']},
                        ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', 'Bold', 'Italic'],
                        '/'// Line break - next group will be placed in new line.

                    ],
                    height: ['300px'],
                    weight: ['100%']

                }
        );

    </script>
@stop
