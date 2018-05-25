$(document).ready(function() {

    $('.add-cart-style-grid').click(function () {

        var tid = $(this).attr("tid");

        $.ajax({
            type: "POST",
            url: "include/addtocart.php",
            data: "id="+tid,
            cache: false,
            dataType: "html",
            error: function(){
                alert( "Сервер недоступен попробуйте позже" );
            }

        });
    });

    $('.count-minus').click(function() {

        var iid = $(this).attr("iid");

        $.ajax({
            type: "POST",
            url: "include/count-minus.php",
            data: "id="+iid,
            cache: false,
            dataType: "html",
            success: function(data){
                $("#input-id"+iid).val(data);

                var priceproduct = $("#tovar"+iid+" > p").attr("price");

                result_total = Number(priceproduct) * Number(data);

                $("#tovar"+iid+" > p").html(result_total + " грн");
                $("#tovar"+iid+" > h5 > .span-count").html(data);

                itog_price();
            }
        });

    });

    $('.count-plus').click(function () {

        var iid = $(this).attr("iid");

        $.ajax({
            type: "POST",
            url: "include/count-plus.php",
            data: "id="+iid,
            cache: false,
            dataType: "html",
            success: function(data){
                $('#input-id'+iid).val(data);

                var priceproduct = $("#tovar"+iid+" > p").attr("price");

                var result_total = Number(priceproduct) * Number(data);

                $("#tovar"+iid+" > p").html(result_total + " грн");
                $("#tovar"+iid+" > h5 > .span-count").html(data);

                itog_price();
            }
        });
    });

    $('.count-input').keypress(function (e) {
        
        if (e.keyCode == 13) {

            var iid = $(this).attr("iid");
            var incount = $('#input-id'+iid).val();

            $.ajax({
                type: "POST",
                url: "include/count-input.php",
                data: "id="+iid+"&count="+incount,
                cache: false,
                dataType: "html",
                success: function(data){
                    $('#input-id'+iid).val(data);

                    var priceproduct = $("#tovar"+iid+" > p").attr("price");

                    var result_total = Number(priceproduct) * Number(data);

                    $("#tovar"+iid+" > p").html(result_total + " грн");
                    $("#tovar"+iid+" > h5 > .span-count").html(data);

                    itog_price();
                }
            });
        }
    });

    function itog_price() {

        $.ajax({
            type: "POST",
            url: "include/itog_price.php",
            cache: false,
            dataType: "html",
            success: function(data){

                $(".itogo > .itog_price").html(data);
            }
        });
    }
});



