/**
 * Created by Ярослав on 14.01.2015.
 */

function orderQuantityPlus() {

    $("#modal-quick-order .quantity").css('margin-top', '14px');

    var initial=document.order_surface.quantity.value;
    initial++;
    var quantity = initial;
    //alert( $('#modal-quick-order .quantity [name="quantity"]').data('price-2-4') );
    var price = $('#modal-quick-order .quantity [name="quantity"]').attr('data-price');
    var price2_4 = $('#modal-quick-order .quantity [name="quantity"]').attr('data-price-2-4');
    var price5_9 = $('#modal-quick-order .quantity [name="quantity"]').attr('data-price-2-4');
    var price10_19 = $('#modal-quick-order .quantity [name="quantity"]').attr('data-price-2-4');
    var price20_49 = $('#modal-quick-order .quantity [name="quantity"]').attr('data-price-2-4');
    var price50 = $('#modal-quick-order .quantity [name="quantity"]').attr('data-price-2-4');

    var price = quantity*price;
    var discount_price = price;

    if(quantity >= 2 && quantity <= 4)
    {
        discount_price = quantity*35;
    }
    else if(quantity >= 5 && quantity <= 9)
    {
        discount_price = quantity*32;
    }
    else if(quantity >= 10 && quantity <= 19)
    {
        discount_price = quantity*29;
    }
    else if(quantity >= 20 && quantity <= 49)
    {
        discount_price = quantity*26;
    }
    else if(quantity >= 50)
    {
        discount_price = quantity*23;
    }

    document.order_surface.quantity.value = quantity;

    if(quantity == 1)
    {
        $('#modal-quick-order .price .value').css('display', 'block');
        $('#modal-quick-order .price .value-old-price').css('display', 'none');
        $('#modal-quick-order .price .value-new-price').css('display', 'none');

    }
    else
    {
        $('#modal-quick-order .price .value').css('display', 'none');
        $('#modal-quick-order .price .value-old-price').css('display', 'block');
        $('#modal-quick-order .price .value-new-price').css('display', 'block');
        $.ajax({
            type: "POST",
            url: "wp-content/themes/triton-lite/old-price.php",
            data: "old_price=" + price,
            success:function(html) {
                $(".value-old-price").html(html);
            }
        });
        $.ajax({
            type: "POST",
            url: "wp-content/themes/triton-lite/discount-price.php",
            data: "discount_price=" + discount_price,
            success:function(html) {
                $(".value-new-price").html(html);
            }
        });
    }

}

function orderQuantityMinus() {
    var initial=document.order_surface.quantity.value;
    if (initial > 1) {
        initial--;
        var quantity = initial;
        var price = $('#modal-quick-order .quantity [name="quantity"]').attr('data-price');
        var price2_4 = $('#modal-quick-order .quantity [name="quantity"]').attr('data-price-2-4');
        var price5_9 = $('#modal-quick-order .quantity [name="quantity"]').attr('data-price-2-4');
        var price10_19 = $('#modal-quick-order .quantity [name="quantity"]').attr('data-price-2-4');
        var price20_49 = $('#modal-quick-order .quantity [name="quantity"]').attr('data-price-2-4');
        var price50 = $('#modal-quick-order .quantity [name="quantity"]').attr('data-price-2-4');

        var price = quantity*price;
        var discount_price = price;

        if(quantity >= 2 && quantity <= 4)
        {
            discount_price = quantity*35;
        }
        else if(quantity >= 5 && quantity <= 9)
        {
            discount_price = quantity*32;
        }
        else if(quantity >= 10 && quantity <= 19)
        {
            discount_price = quantity*29;
        }
        else if(quantity >= 20 && quantity <= 49)
        {
            discount_price = quantity*26;
        }
        else if(quantity >= 50)
        {
            discount_price = quantity*23;
        }

        document.order_surface.quantity.value = quantity;

        if(quantity == 1)
        {
            $("#modal-quick-order .quantity").css('margin-top', '0px');

            $('#modal-quick-order .price .value').css('display', 'block');
            $('#modal-quick-order .price .value-old-price').css('display', 'none');
            $('#modal-quick-order .price .value-new-price').css('display', 'none');

        }
        else
        {
            $('#modal-quick-order .price .value').css('display', 'none');
            $('#modal-quick-order .price .value-old-price').css('display', 'block');
            $('#modal-quick-order .price .value-new-price').css('display', 'block');
            $.ajax({
                type: "POST",
                url: "wp-content/themes/triton-lite/old-price.php",
                data: "old_price=" + price,
                success:function(html) {
                    $(".value-old-price").html(html);
                }
            });
            $.ajax({
                type: "POST",
                url: "wp-content/themes/triton-lite/discount-price.php",
                data: "discount_price=" + discount_price,
                success:function(html) {
                    $(".value-new-price").html(html);
                }
            });
        }

    }
}

$(document).ready(function(){

    $(".main-slider #bx-pager > div:first-child").addClass("active");

    $('.bxslider').bxSlider({
        pagerCustom: '#bx-pager',
        controls: false,
        auto: true,
        speed: 2000,
        pause: 8300,
        //slideWidth: 1500,
        onSlideAfter: function () {
            $(".main-slider #bx-pager > div").removeClass("active");
            $(".main-slider #bx-pager a.active").parent().addClass("active");
        }
    });


    $('#bxslider-02').bxSlider({
        mode: "fade",
        pagerCustom: '#bx-pager-02',
        controls: false
    });

    //$('.category-list .span4 .pic img').mouseenter(function(){
    //    $(this).animate({
    //        width: '360px',
            //'margin-top': '-8px',
            //'margin-left': '-10px'
        //}, 200);
    //});

    //$('.category-list .span4 .pic img').mouseleave(function(){
    //    $(this).animate({
    //        width: '300px',
    //        'margin-top': '0px',
    //        'margin-left': '0px'
    //    }, 200);
    //});

    $("#static_header .phone a").click(function() {
        //$("#callbackForm").show();
        $("#callbackForm").toggle();
        $("#callback_wrap").css("display", "block");
    });

    $("#callback_wrap").click(function() {
        //$("#callbackForm").show();
        $("#callbackForm").fadeOut();
        $(this).css("display", "none");
    });

    $("ul.dropdown-menu.inner.selectpicker li").removeClass("selected");
    $("ul.dropdown-menu.inner.selectpicker li:first-child").addClass("selected");

    $("ul.dropdown-menu.inner.selectpicker li").click(function() {
        $("ul.dropdown-menu.inner.selectpicker li.selected").removeClass("selected");
        $("ul.dropdown-menu.inner.selectpicker li").css('display', 'list-item');
        $( this ).addClass("selected");
        $( this ).css('display', 'none');
        var rel = $( this ).attr('rel');
        rel++;
        var relm = rel*2-1;

        $('#modal-quick-order form[name="order_surface"] .selectpicker option').removeAttr('selected');
        $('#modal-quick-order form[name="order_surface"] .selectpicker option:nth-child('+rel+')').attr('selected', 'selected');

        $('#modal-quick-order .cwrapper.pic img, #modal-quick-order .cwrapper.content h1, #modal-quick-order .cwrapper.content h3, #modal-quick-order .border .btn-group.bootstrap-select button, #modal-quick-order .border .price .wrp').css('display', 'none');
        $('#modal-quick-order .cwrapper.pic img:nth-child('+rel+')').css('display', 'inline');
        $('#modal-quick-order .cwrapper.content h1:nth-child('+relm+')').css('display', 'block');
        $('#modal-quick-order .cwrapper.content h3:nth-child('+rel*2+')').css('display', 'inline-block');
        $('#modal-quick-order .border .btn-group.bootstrap-select button:nth-child('+rel+')').css('display', 'inline-block');
        $('#modal-quick-order .border .price .wrp:nth-child('+rel+')').css('display', 'inline-block');
    });


    $('.row-fluid.promotional .right .btn.btn-danger').click(function(){
        var id = $(this).attr('data-target');
       $('button.closes').css('display', 'block');
        $('.modal-backdrop').css('display', 'block');
        $(".modal.hide.in[id='+id+']").css('display', 'block');
    });

    $('.modal-backdrop').click(function(){
        $('button.closes').css('display', 'none');
        $('.modal-backdrop').css('display', 'none');
        $('.modal.hide.in, #modal-quick-order').css('display', 'none');
    });

    $('.btn.btn-success.order, #static_header .order').click(function(){
        $('button.closes').css('display', 'block');
        $('.modal-backdrop').css('display', 'block');
        $('#modal-quick-order').css('display', 'block');
    });

    $('.product-list .description .detail-info').click(function(){
        var id = $(this).attr('data-href');

        $.ajax({
            type: "POST",
            url: "wp-content/themes/triton-lite/test.php",
            data: "id=" + id,
            success:function(html) {
                $("#goods-description").html(html);
            }
        });
        $('button.closes').css('display', 'block');
        $('.modal-backdrop').css('display', 'block');
    });

    $('.product-list .addToCart').click(function(){
        var id = $(this).attr('data-href');
        $.ajax({
            type: "POST",
            url: "wp-content/themes/triton-lite/basket.php",
            data: "id=" + id,
            success:function(html) {
                $("#ordered_goods").html(html);
            }
        });
        $('button.closes').css('display', 'block');
        $('.modal-backdrop').css('display', 'block');
    });


    //$(".teasers div").mouseenter(function() {
    //    $(".teasers .description").animate({top:0}, 2000);
        //$(this).find("div.description").css({top:"0px"});     css: transition !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    //});

    //$(".teasers div").hover(
    //    function() {
    //        $( this ).find("div.description").animate({top:0});
    //    }, function() {
    //        $( this ).find("div.description").animate({top:-500}, 1000);
    //    }
    //);



});