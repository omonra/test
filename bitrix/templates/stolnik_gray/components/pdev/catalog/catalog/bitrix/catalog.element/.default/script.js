function getColorItems(obj) {
    obj = (obj) || [];
    var tpl = $('<div data-type="color" class="item"></div>'), html = $("<div></dvi>"), counter = 0;
    $.each(obj, function(index, value) {
        var row = tpl.clone();
        row.css('background-image', 'url(' + value['COLOR_PICTURE'] + ')');
        row.attr({
            'data-value': value['COLOR'],
            'title': value['COLOR'],
        });

        if (obj[window.currentColor] == undefined && counter == 0) {
            row.addClass('active');
            window.currentColor = value['COLOR'];
        }

        if (window.currentColor == value['COLOR']) {
            row.addClass('active');
        }

        html.append(row);

        counter++;
    });

    return html.html();
}

$(document).ready(function() {
    
    $("body").on('click', '.sizes .item, .colors .item', function() {
        $(this).parent().find(">div").removeClass('active');
        $(this).addClass('active');
        if ($(this).data('type') == "size")
            window.currentSize = $(this).data('value');

        if ($(this).data('type') == "color")
            window.currentColor = $(this).data('value');

        $(".colors").html(getColorItems(window.offersList['SIZE'][window.currentSize]));

        var offer = window.offersList['SIZE'][window.currentSize][window.currentColor];
        if (offer !== undefined) {
            window.currentOffer = offer['ID'];
            $(".offer-qty").text(offer['QTY']);
        }

        $("a.btn-buy").removeClass('in_basket').text('Добавить в корзину');


        console.log(window.currentOffer);
    });

    $("body").on('click', 'a.btn-buy', function(event) {


        $(this).text('Перейти в корзину');
        $(this).attr('href', '/personal/order/make/');
        if (!$(this).hasClass('in_basket')) {
            event.preventDefault();
            stolnik.AddToBasket(window.currentOffer);
            $(this).addClass('in_basket');
            return false;
        }

    });
    
    $("body").on('click', '.size-ruler', function() {
        $('#size-ruler-base-in').load('/articles/' + $(this).data('code') + '/ .news-detail');
        $('#size-ruler-base').show();
        return false;
    });
    
    $("body").on('click', '#size-ruler-base .close', function() {
        $('#size-ruler-base').hide();
        return false;
    });

});