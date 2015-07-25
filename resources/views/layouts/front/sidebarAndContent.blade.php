<div class="row margin-bottom-40 ">
    <!-- BEGIN SIDEBAR -->
    <div class="sidebar col-md-3 col-sm-4">
        <ul class="list-group margin-bottom-25 sidebar-menu">
            <?php echo $sidebar; ?>
        </ul>
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="col-md-9">
        <div class="col-md-12 col-sm-12">
            <h2>For Men</h2>
            <div class="owl-carousel owl-carousel3">
                <?php echo $getViewProductMen; ?>
            </div>
        </div>
        <hr />
        <div class="col-md-12 col-sm-12 padding-top-30">
            <h2>For Women</h2>
            <div class="owl-carousel owl-carousel3">
               <?php echo $getViewProductWomen; ?>
            </div>
        </div>
        <hr />
    </div>
    <!-- END CONTENT -->
</div>
