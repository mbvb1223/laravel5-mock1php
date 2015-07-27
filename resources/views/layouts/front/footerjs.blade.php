<!-- BEGIN CORE PLUGINS (REQUIRED FOR ALL PAGES) -->
<!--[if lt IE 9]>
<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/respond.min.js"></script>
<![endif]-->
<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo url("/"); ?>/../theme/assets/frontend/layout/scripts/back-to-top.js" type="text/javascript"></script>
<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script><!-- pop up -->
<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/carousel-owl-carousel/owl-carousel/owl.carousel.min.js" type="text/javascript"></script><!-- slider for products -->
<script src='<?php echo url("/"); ?>/../theme/assets/global/plugins/zoom/jquery.zoom.min.js' type="text/javascript"></script><!-- product zoom -->
<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script><!-- Quantity -->

<!-- BEGIN LayerSlider -->
<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/slider-layer-slider/js/greensock.js" type="text/javascript"></script><!-- External libraries: GreenSock -->
<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/slider-layer-slider/js/layerslider.transitions.js" type="text/javascript"></script><!-- LayerSlider script files -->
<script src="<?php echo url("/"); ?>/../theme/assets/global/plugins/slider-layer-slider/js/layerslider.kreaturamedia.jquery.js" type="text/javascript"></script><!-- LayerSlider script files -->
<script src="<?php echo url("/"); ?>/../theme/assets/frontend/pages/scripts/layerslider-init.js" type="text/javascript"></script>
<!-- END LayerSlider -->

<script src="<?php echo url("/"); ?>/../theme/assets/frontend/layout/scripts/layout.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        Layout.init();
        Layout.initOWL();
        LayersliderInit.initLayerSlider();
        Layout.initImageZoom();
        Layout.initTouchspin();
        $(".k-view").click(function(){
            var idProduct = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: "{{action('FrontendController@getProductForFastView')}}" ,
                data: {'id': idProduct, '_token': "{{csrf_token()}}"},
                success: function(data){
                    for (i = 0; i < data.length; i++) {
                        var linkImage = "<?php echo url("/")."/upload/product/";?>" + data[i].product.image;
                        $nameProduct = data[i].product.name_product;
                        $("#k-titleProduct").text(data[i].product.name_product);
                        $(".k-idProduct").attr('value',data[i].product.id);
                        $('#k-imageProduct').attr('src',linkImage);
                        $('#k-imageProduct').attr('data-BigImgsrc',linkImage);
                        $("#k-costProduct").text("$" + data[i].product.cost);
                        $("#k-priceProduct").text(data[i].product.price);
                        $("#k-vailabilityProduct").text(data[i].vailability);
                        $(".k-colorProduct").append(data[i].getViewColorForSelectTag);
                        $(".k-sizeProduct").append(data[i].getViewSizeForSelectTag);
                        $('.k-linkDetailProduct').attr('href',data[i].linkDetailProduct);


                    }

                },
                dataType: 'json',
            });
        });


    });
</script>