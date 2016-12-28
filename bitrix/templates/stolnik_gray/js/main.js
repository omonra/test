$(document).ready(function () {
	
	$('#mcat').click(function(){
		if($(this).attr('class')=='more-categories-hide'){
			$(this).removeClass('more-categories-hide').addClass('more-categories').html('Показать все');
			$('.b-collections-list__item_subcatalog').css('height','90px');
			return false;
		}else{
			$(this).removeClass('more-categories').addClass('more-categories-hide').html('Скрыть');
			$('.b-collections-list__item_subcatalog').css('height','auto');
			return false;
		}
	});

    $('.js-renewCaptcha').click(function () {
        var url = '/bitrix/templates/stolnik_gray/ajax_captcha.php';
        $.get(url).done(function(res){
            $('#captcha_img').attr('src', '/bitrix/tools/captcha.php?captcha_sid=' + res);
            $('#captcha_sid').val(res);
        });
        return false;
    });

    $('.b-collections-list .btn').on('click', function () {
        if (!$(this).hasClass('active')) {
            $('.b-collections-list .btn').removeClass('active');
            $(this).addClass('active');
            if ($(this).hasClass('men')) {
                $('.b-collections-list__item.men').slideDown();
                $('.b-collections-list__item.women').hide();
            }
            if ($(this).hasClass('women')) {
                $('.b-collections-list__item.men').hide();
                $('.b-collections-list__item.women').slideDown();
            }
        }
    });
    $('.b-sort__name span').on('click', function() {
        $(this).closest('.b-sort').find('.b-sort__list').toggle();
    });
	$(document).click(function(event) {
		if ($(event.target).closest(".js-filter").length) return;
		//$(".b-sort__list").hide();
		event.stopPropagation();
	});
    $('.js-filter').click(function() {
        if($(this).children().is(':visible')){
			$('.b-sort__list').hide();
			$(this).children().show();
		}else{
			$('.b-sort__list').hide();
		}
		//if ($(this).is(e.target)) {
            $(this).find('.b-sort__list').toggle();
            //$('.scroll-pane').jScrollPane();
        //}
    });
    
	$('.b-sort__list').mouseleave(function() {
        if ($(window).width()>1024) $(this).toggle();
    });
	
    $('.js-sort__list li').click(function() {
        stolnik.ChangeSort($(this).data('value'));
    });

    (function() {
        var el = $('.js-carousel');
        if (el.length > 0) {
            el.carouFredSel({
                items: {
                    visible: 1
                },
                scroll: {
                    fx: 'fade'
                }
            });
        }
    })();
    (function() {
        var el = $('.index_banners .items');
        if (el.length > 0) {
            el.carouFredSel({
                items: {
                    visible: 1
                },
                scroll: {
                    fx: 'fade',
                    items: 1,
                    pauseOnHover: true,
                    timeoutDuration: 6000,
                },
                auto: true,
                prev: {
                    button: ".index_banners__prev",
                    key: "left"
                },
                next: {
                    button: ".index_banners__next",
                    key: "right"
                }
            });
        }
    })();

    (function() {
        var el = $('.b-img-gallery');
        if (el.length > 0) {
            el.carouFredSel({
                items: 1,
                auto: false,
                scroll: {
                    items: 1,
                    fx: 'crossfade',
                    duration: 1000,
                    pauseOnHover: true
                },
                pagination: {
                    container: '.js-pager',
                    event: 'mouseover',
                    duration: 0,
                    anchorBuilder: function (nr) {
                        var src = $('.js-img-gallery a').find('img').eq(nr - 1).attr('src');
                        var url_full = $('.js-img-gallery a').eq(nr - 1).attr('href');
                        return '<a class="js-fancy" rel="gallery1" href="' + url_full + '"><img width="40"  src="' + src + '" border="0" /></a>';
                    }
                },
                onCreate: function(a) {
                    var pagerBlock = $('.b-img-pager');
                    var pager = pagerBlock.find('.js-pager');
                    var prev = pagerBlock.find('.prev');
                    var next = pagerBlock.find('.next');
                    prev.on('click', function() {
                        var length = pager.find('a').length;
                        var pos = pager.data('pos');
                        if (typeof pos === 'undefined') {
                            pos = 0;
                        }
                        if (pos < Math.ceil(length / 5) - 1) {
                            pos += 1;
                            next.removeClass('disabled');
                        }
                        if (pos >= Math.ceil(length / 5) - 1) {
                            prev.addClass('disabled');
                        }
                        pager.data('pos', pos);
                        pager.animate({'margin-top':  '-' + pos * 370 + 'px'});
                        return false;
                    });
                    next.on('click', function() {
                        var length = pager.find('a').length;
                        var pos = pager.data('pos');
                        if (typeof pos === 'undefined') {
                            pos = 0;
                        }
                        if (pos > 0) {
                            pos -= 1;
                            prev.removeClass('disabled');
                        }
                        if (pos <= 0) {
                            next.addClass('disabled');
                        }
                        pager.data('pos', pos);
                        pager.animate({'margin-top':  '-' + pos * 370 + 'px'});
                        return false;
                    });
                }
            });
        }
    })();

    $('.js-fancy').fancybox();
    $('.js-fancy-all').fancybox({autoSize:false,minWidth:400});

    $('#rating_1').rating({
        fx: 'full',
        image: '/bitrix/templates/stolnik_gray/img/stars.jpg',
        loader: '/bitrix/templates/stolnik_gray/img/ajax-loader.gif',
        width:'14',
       // callback: function(response) {
      //      this.vote_success.fadeOut(2000);
      //  },
        click: function(data) {
            $('#rating').val(data);
        }
    });

    /* from old */
    (function() {
        $('#add_url').on('click',function(){
            var rel = $(this).attr('rel')
            $.ajax({
                type: "POST",
                url: rel,
                dataType: "html",
                success: function(out){
                    console.log(out);
                }
            });
        });
    })();


    (function() {
        var el = $('.b-product-card');

        var GetItemSizes = function(el) {
            var data = el.data('sizes_calculated');
            var i, val;
            if (typeof data === 'undefined') {
                data = el.data('sizes').split(';');
                for (i = 0; i < data.length; i++) {
                    val = data[i];
                    val = val.split(':');
                    data[i] = {
                        size: val[0],
                        quantity: parseInt(val[1], 10),
                        price: parseFloat(val[2]),
                        id: parseInt(val[3], 10),
                    };
                }
                el.data('sizes_calculated', data);
            }
            return data;
        };

        var ShowStores = function (offerId) {
            var tr = $('#stores-block').find('.stores tr')
            tr.removeClass('active');
            tr.filter('[data-offer_id="' + offerId + '"]').addClass('active');
        }

        el.find('.size-line .item').on('click', function () {
            if (!$(this).hasClass('empty')) {
                $('.size-line .item.active').removeClass('active');
                $(this).addClass('active');

                var currentSize = $(this).text().trim();
                var activeFound = false;
                $(this).closest('.b-product-card__info').find('.color-line .item').removeClass('disabled').removeClass('active').each(function() {
                    var data = GetItemSizes($(this));
                    var i, val;

                    for (i = 0; i < data.length; i++) {
                        val = data[i];
                        $(this).addClass('disabled');
                        if (val.size == currentSize) {
                            if (val.quantity > 0) {
                                $(this).removeClass('disabled');
                            }
                            if (!activeFound) {
                                activeFound = true;
                                $(this).trigger('click');
                            }
                            break;
                        }
                    }
                });

                var buy_basket = $('.b-product-card__info .button-buy');

                buy_basket.css('background', '#ff9b00');
                buy_basket.text('Добавить в корзину');
                buy_basket.attr('href', '#added-to-basket');
                buy_basket.removeClass('in_basket');
            }
        });
        el.find('.color-line .item').on('click', function () {
            if (!$(this).hasClass('empty') && !$(this).hasClass('disabled')) {
                $('.color-line .item').removeClass('active');
                $(this).addClass('active');

                var data = GetItemSizes($(this));
                var currentSize = $(this).closest('.b-product-card__info').find('.size-line .active').text();
                var i, val;

                for (i = 0; i < data.length; i++) {
                    val = data[i];
                    if (val.size == currentSize && val.quantity > 0) {
                        var item = $(this).closest('.color-line').closest('.item');
                        item.find('.b-product-card__info .cost .value').text(FormatPrice(val.price));
                        item.data('offer-id', val.id);

                        ShowStores(val.id);

                        break;
                    }
                }

                var buy_basket = $('.b-product-card__info .button-buy');

                buy_basket.css('background', '#ff9b00');
                buy_basket.text('Добавить в корзину');
                buy_basket.attr('href', '#added-to-basket');
                buy_basket.removeClass('in_basket');
            }
        });

        if (el.find('.size-line').length > 0) {
            if (window.location.hash.indexOf('offer=') >= 0) {
                var offerId = parseInt(window.location.hash.split('offer=')[1], 10);
                if (offerId > 0) {
                    el.find('.color-line .item').removeClass('disabled').removeClass('active').each(function() {
                        var data = GetItemSizes($(this));
                        var i, val;

                        for (i = 0; i < data.length; i++) {
                            val = data[i];
                            if (val.id == offerId && val.quantity > 0) {
                                el.find('.size-line .item').each(function() {
                                    if ($(this).text() == val.size) {
                                        $(this).trigger('click');
                                    }
                                });
                                $(this).trigger('click');
                                break;
                            }
                        }
                    });
                }
            } else {
                $('.color-line .item.active').trigger('click');
            }
        }
    })();

    (function() {
        $('.b-product-card__info .button-buy, .b-product-card__text .button-buy').on('click', function() {
            $(this).css('background', 'green');
            $(this).text('Перейти в корзину');
            $(this).attr('href', '/personal/cart/');
            if (!$(this).hasClass('in_basket')){
                stolnik.AddToBasket(parseInt($(this).closest('.item').data('offer-id'), 10));
                $(this).addClass('in_basket');
                return false;
            }

        });
    })();

    (function() {
        if ($('#order_form_content').length > 0) {
            stolnik.initiallizeOrderPage();
        }
    })();

    (function() {
        var order_container = $('#order_form_div');
        order_container.on('click', '.item .count .minus', function () {
            var item = $(this).closest('.item');
            var id = item.findId();
            var $input = item.find('.counter input');
            var count = parseInt($input.val(), 10) - 1;
            count = count < 1 ? 1 : count;
            $input.val(count);
            _.debounce(function() {
                submitForm('N');
                stolnik.ChangeBasketCount(id, count);
            }(), 300);
            return false;
        });
        order_container.on('click', '.item .count .plus', function () {
            var item = $(this).closest('.item');
            var id = item.findId();
            var $input = item.find('.counter input');
            var count = parseInt($input.val(), 10) + 1;
            count = count < 1 ? 1 : count;
            $input.val(count);
            _.debounce(function() {
                submitForm('N');
                stolnik.ChangeBasketCount(id, count);
            }(), 300);
            return false;
        });

        order_container.on('click', '.button_clear_basket', function() {
            stolnik.ClearBasket();
        });
    })();

    (function() {
        $('.jsform').on('click', function() {
            var form_name = $(this).attr('href').split('#')[1];
            $.fancybox.open({href: '/ajax/form.php?form_name=' + form_name, type: 'ajax'});
            return false;
        });
    })();

    (function() {
        var el = $('.go_top');
        if (el.length > 0) {
            $(window).scroll(function () {
                if ($(document).scrollTop() > 200) {
                    el.show('300');
                } else {
                    el.hide('300');
                }
            });

            el.on('mouseover',function(){
                el.animate({opacity:'1.0'}, 300);
            });
            el.on('mouseout',function(){
                el.animate({opacity:'0.4'}, 300);
            });
            el.on('click', function(){
                $(window).scrollTop(0);
            });

            var $win = $(window);
            var $marker = $('footer .b-wrapper_dark-grey');
            $win.scroll(function() {
                set_top_go();
            });

            $(window).resize(function() {
                set_top_go();
            });

            function set_top_go(){
                k = $win.scrollTop() + $win.height();
                m = $marker.offset().top - 15;
                l1 = $('footer .b-wrapper_dark-grey').width() + $('.b-wrapper .b-container').offset().left - 120;
                if (k >= m) {
                    el.css("bottom", (k - m) + 'px');
                } else {
                    el.css("bottom", '0px')
                }
            }
        }
    })();

    (function() {
        $('.description .more').on('click', function(){
            $(this).next().removeClass('hidden');
            $(this).hide();
        });
    })();

    (function() {
        $('.profile_block input[name="PERSONAL_PHONE"]').mask('+7 (999) 999 9999');
    })();

    (function() {
        $('.b-carousel-novelty .scrollable').scrollable({
            circular: true,
            // speed: 300,
            size: 4,
            next: '.b-carousel-novelty .js-carousel-novelty__next',
            prev: '.b-carousel-novelty .js-carousel-novelty__prev'
        });
    })();

    (function() {
        var el = $('#reviews_form');
        if (el.length > 0) {
            el.find('.title').on('click', function() {
                el.find('.title.active').removeClass('active');
                $(this).addClass('active');
                el.find('.body').hide();
                $($(this).data('el')).show();
                return false;
            });
        }
    })();

    (function() {
        $('#added-to-basket .close').on('click', function() {
            $(this).closest('.fancybox-wrap').find('.fancybox-close').trigger('click');
            return false;
        });
    })();

    (function() {

        $('[data-toggle="modal"]').on('click',function(e) {
            e.preventDefault();

            if ($(this).hasClass('show_fast')) {
                $('.modal-body').html('Loading...');
                var id = $(this).attr('data-id');
                var url = '/ajax/popup_show_fast.php?ID=' + id;

                $.get(url, function (data) {
                    $('.modal-body').html(data);
                });
            }
        });
    })();

    $('li.item').hover(function(){
        $(this).find('.show_fast').show();
    }, function(){
        $(this).find('.show_fast').hide();
    });

});

/**
######## ##     ## ##    ##  ######  ######## ####  #######  ##    ##  ######
##       ##     ## ###   ## ##    ##    ##     ##  ##     ## ###   ## ##    ##
##       ##     ## ####  ## ##          ##     ##  ##     ## ####  ## ##
######   ##     ## ## ## ## ##          ##     ##  ##     ## ## ## ##  ######
##       ##     ## ##  #### ##          ##     ##  ##     ## ##  ####       ##
##       ##     ## ##   ### ##    ##    ##     ##  ##     ## ##   ### ##    ##
##        #######  ##    ##  ######     ##    ####  #######  ##    ##  ######
 */

var stolnik = {

    RedirectUrl: function(url)
    {
        document.location.href = url;
    },

    AddToBasket: function(id) {
        var data = {id: id};
        yaCounter26116233.reachGoal('add_basket');
        this.query({
            action: 'AddToBasket',
            data: data,
            success: function(response) {
                if (response.ok) {
                    // $.fancybox.open('#added-to-basket');
                    stolnik.UpdateBasket(response);
                }
            }
        });
    },

    query: function(options) {
        var defaultOptions = {
            url: '/ajax/',
            html: false,
            error: function(error) {
                console.log(error);
            },
            data: {}
        };

        return (function(options) {
            var opt = $.extend({}, defaultOptions, options);

            if (typeof opt.action !== 'undefined') {
                opt.data['tag'] = opt.action;
            }
            $.ajax({
                type: "POST",
                url: opt.url,
                data: opt.data,
                timeout: 10000,
                dataType : opt.html ? 'html' : 'json',
                success: function(data) {
                    if (typeof data !== 'undefined' && data !== null) {
                        if (typeof data.error !== 'undefined' && typeof opt.error !== 'undefined') {
                            opt.error(data.error);
                        } else {
                            if (typeof opt.success !== 'undefined') {
                                opt.success(data);
                            }
                        }

                        if (typeof data.log !== 'undefined') {
                            console.log('log: ' + data.log);
                        }
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrow) {
                    if (textStatus == 'parsererror') {
                        console.log(XMLHttpRequest.responseText);
                    }
                    if (typeof opt.error !== 'undefined') {
                        opt.error(textStatus);
                    }
                    return true;
                }
            });
        })(options);
    },

    getTemplate: function(name) {
        if (typeof this.templates === 'undefined') {
            this.templates = [];
        }
        if (typeof this.templates[name] !== 'undefined') {
            return this.templates[name];
        }
        var el = $('#' + name + '-template');
        if (el.length <= 0) {
            console.log("can't find template html");
            return function(data) {};
        }
        this.templates[name] = Handlebars.compile(el.html());
        return this.templates[name];
    },

    CheckEmail: function(str) {
        var r1 = new RegExp("(@.*@)|(\\.\\.)|(@\\.)|(^\\.)");
        var r2 = new RegExp("^.+\\@(\\[?)[a-zA-Z0-9\\-\\.]+\\.([a-zA-Z]{2,4}|[0-9]{1,3})(\\]?)$");
        return (!r1.test(str) && r2.test(str));
    },

    initiallizeOrderPage: function() {
        var order_container = $('#order_form_div');

        BX.closeWait('order_form_content');

        order_container.find('input[type=checkbox],input[type=radio],select').styler();
        order_container.on('click', '.item .remove i', function() {
            var item = $(this).closest('.item');
            stolnik.DeleteFromBasket($(this).findId(), function() {
                item.remove();
                submitForm('N');
            });
        });

        order_container.find('.js-fancy-all').fancybox({autoSize:false, minWidth:400});

        order_container.on('click', '.bx_ordercart_coupon span', function() {
            var coupon = $(this).data('coupon');
            var form = order_container.find('form');
            if (typeof coupon === 'undefined') {
                return false;
            }
            form.append('<input name="delete_coupon" type="hidden" value="' + coupon + '" />');
            submitForm('N');
            return false;
        });



        order_container.find('select[name="DELIVERY_ID"]').on('change', function() {
            submitForm('N');
        });

        order_container.find('#ORDER_PROP_3').mask('9 (999) 999 9999');

         $('.count-input').addClass('ignore');
         $('.button_clear_basket').addClass('ignore');
         $.validator.addMethod("ruPhoneFormat", function (value, element) {
            return this.optional(element) || /^\d \(\d{3}\) \d{3}\ \d{4}( x\d{1,6})?$/.test(value);
         });
         $('#ORDER_FORM').validate({
            debug:true,
            ignore: ".ignore",
            rules:{
                ORDER_PROP_2: {
                  required: true,
                  email: true
                },ORDER_PROP_5_val: {
                  required: true,
                  minlength:2
                },ORDER_PROP_1: {
                  required: true,
                  minlength: 5
                },
                ORDER_PROP_3: {
                  required: true,
                  ruPhoneFormat: true
                }

            },
            onkeyup: function(element){
                $(element).valid()
            },
            onsubmit: false,
            errorPlacement: function(e){
                return e;  // suppresses error message text
            },invalidHandler: function(e, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = errors == 1 ? 'You missed 1 field. It has been highlighted below' : 'You missed ' + errors + ' fields.  They have been highlighted below';
                    console.log(message);
                } else {
                    $("div.error").hide();
                }
            },
        });

    },

    DeleteFromBasket: function(id, callback) {
        this.query({
            action: 'DeleteFromBasket',
            data: {id: id},
            success: function(response) {
                if (response.basket_count <= 0){
                    window.location.reload();
                }
                if (response.id == id) {
                    stolnik.UpdateBasket(response);
                    if (typeof callback !== 'undefined') {
                        callback();
                    }
                }
            }
        });
    },

    ChangeBasketCount: function(id, count) {
        data = {id: id, count: count};
        this.query({
            action: 'ChangeBasketCount',
            data: data,
            success: function(response) {
                stolnik.UpdateBasket(response);
            }
        });
    },

    UpdateBasket: function(data) {
        var template = this.getTemplate('basket');
        var basket = $('.b-header__basket');
        basket.html(template(data));
    },

    ChangeSort: function(sort) {
        var curPage = window.location.toString();
        if (typeof sort == 'string' && sort.length > 0) {
            var newUrl;
            if (curPage.indexOf('&sort=') >= 0) {
                curPage = curPage.replace(/&sort=(\w)+/gi, '');
            }
            if (curPage.indexOf('?sort=') >= 0) {
                if (curPage.indexOf('&') >= 0) {
                    curPage = curPage.replace(/sort=(\w)+/gi, '');
                    curPage = curPage.replace(/\?\&/gi, '?');
                } else {
                    curPage = curPage.replace(/\?sort=(\w)+/gi, '');
                }
            }
            if (curPage.indexOf('#') >= 0) {
                curPage = curPage.split('#')[0];
            }
            if (curPage.indexOf('?') >= 0) {
                newUrl = curPage+'&sort='+sort;
            } else {
                newUrl = curPage+'?sort='+sort;
            }
            window.location = newUrl;
        }
    },

    AjaxFormSubmit: function(form, sid) {
        if (typeof jsAjaxUtil == 'undefined') {
            BX.ajax.loadScriptAjax('/bitrix/js/main/ajax.js', function() {
                jsAjaxUtil.InsertFormDataToNode(form, sid, true);
            });
        } else {
            jsAjaxUtil.InsertFormDataToNode(form, sid, true);
        }
        return true;
    },

    ClearBasket: function() {
        this.query({
            action: 'ClearBasket',
            success: function(response) {
                if (typeof response !== 'undefined' && typeof response.ok !== 'undefined' && response.ok) {
                    window.location = '/';
                }
            }
        });
    },
};

/**
##     ## ######## ##       ########  ######## ########   ######
##     ## ##       ##       ##     ## ##       ##     ## ##    ##
##     ## ##       ##       ##     ## ##       ##     ## ##
######### ######   ##       ########  ######   ########   ######
##     ## ##       ##       ##        ##       ##   ##         ##
##     ## ##       ##       ##        ##       ##    ##  ##    ##
##     ## ######## ######## ##        ######## ##     ##  ######
 */
function FormatPrice(price) {
    return price.formatNumber(0, ',', ' ') + ' руб.';
}

/**
 *  formatNumber(2, ',', ' ') = 1 234,56
 */
Number.prototype.formatNumber = function(c0, d0, t0)
{
  var n = this, c = isNaN(c0 = Math.abs(c0)) ? 2 : c0, d = d0 === undefined ? "," : d0,
    t = t0 === undefined ? "." : t0, s = n < 0 ? "-" : "",
    i = parseInt(n = Math.abs(+n || 0).toFixed(c), 10) + "", j = (j = i.length) > 3 ? j % 3 : 0;
  return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g,
    "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

(function(jQuery) {
    jQuery.fn.findId = function() {
        return this.closest('.item').data('id');
    };
})(jQuery);
