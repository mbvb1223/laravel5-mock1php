$(document).ready(function () {

    $("#price").keyup(function () {
        var price = $("#price").val();

        var selloff_id = $("#selloff_id").val();
        if (selloff_id == 0) {
            $("#cost").val(price);
        } else {
            var jsonDataFromIdToValueOfSelloff = $("#arrayFromIdToValueOfSelloff").val();
            var data = JSON.parse(jsonDataFromIdToValueOfSelloff);
            var selloffValue = data[selloff_id];
            var price = $("#price").val();
            var cost = price - (price * selloffValue / 100);

           
            $("#cost").val(cost);
        }
    });

    $("#selloff_id").change(function () {
        var price = $("#price").val();
        var selloff_id = $("#selloff_id").val();
        if (selloff_id == 0) {
            $("#cost").val(price);
        } else {
            var jsonDataFromIdToValueOfSelloff = $("#arrayFromIdToValueOfSelloff").val();
            var data = JSON.parse(jsonDataFromIdToValueOfSelloff);
            var selloffValue = data[selloff_id];
            var price = $("#price").val();
            var cost = price - (price * selloffValue / 100);

          
            $("#cost").val(cost);
        }


    });
    $("#price_import").number(true);
    var val = $('#price_import').val();
    $('#price_import').text( val !== '' ? val : '(empty)' );
    $("#price").number(true);
    $("#cost").number(true);



});
