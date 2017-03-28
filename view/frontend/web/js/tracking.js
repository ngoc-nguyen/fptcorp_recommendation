require([
    'jquery',
    'knowlead',
    'jquery/jquery-storageapi',
    'domReady!'
], function ($, knowlead) {
    var setCookie = function (name, value, days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime()+(days*24*60*60*1000));
            var expires = "; expires=" + date.toGMTString();
        } else {
            var expires = "";
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    };

    var setRecommendationCookie = function (cartId, productId, qty) {
        var days = 365;
        var cartName = 'undefined';
        if (typeof(cartId) != 'undefined' && cartId != null ) {
            cartName = cartId;
        }
        setCookie('cart_id_recommendation', cartName, days);
        var name = cartName + '_recommendation';
        var value = cartName + '##' + productId + '##' + qty;
        setCookie(name, value, days);
    };

    var getCartIdFromLocalStorage = function () {
        var cacheStorage = $.localStorage.get('mage-cache-storage');
        if (cacheStorage != null && typeof(cacheStorage.cart) != 'undefined') {
          return cacheStorage.cart.cart_id;
        } else {
            return 'undefined';
        }
    };

    $(document).on('click', '#fpt-recommendation-wrapper button.tocart', function (e) {
        if (data = $(this).data('post')) {
            if (typeof data['data'] != 'undefined' && typeof data['data']['product'] != 'undefined') {
                var productId = data['data']['product'];
                var qty = 1;
                var cartId = getCartIdFromLocalStorage();
                setRecommendationCookie(cartId, productId , qty);
            }
        }
    });

    $(document).on('click', 'button.tocart', function (e) {
        if (window.location.href.indexOf("_utm=recommendation") > -1) {
            var form = $(this).closest('form');
            var productId = form.find("input[name='product']").val();
            var qty = form.find("input[name='qty']").val();
            qty = qty ? qty : 1;
            var cartId = getCartIdFromLocalStorage();
            setRecommendationCookie(cartId, productId, qty);
        }
    });
});
