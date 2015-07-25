@extends('layouts.front.master')

@section('content')
<div class="container">
    <!-- BEGIN SIDEBAR & CONTENT -->
    <div class="row margin-bottom-40">
        <!-- BEGIN CONTENT -->
        <div class="col-md-12 col-sm-12">
            <h1>Shopping cart</h1>
            <?php echo $getViewForCartInFrontEnd; ?>
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END SIDEBAR & CONTENT -->

</div>

@stop