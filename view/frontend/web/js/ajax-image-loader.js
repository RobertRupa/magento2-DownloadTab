define(['jquery', 'lightGallery', 'domReady!'], function($) {

    var $lg = $('.download-tab.image-container');
    return function (config) {
        //console.log(lightGallery);
        $('.download-tab.load.btn').on('click', function () {
            $(this).hide();
            loadImages(config.apiEndpoint, config.SKU, config.additionalGetParams);
        });
    }

    function loadImages(apiEndpoint, SKU, additionalGetParams){
        $.each(SKU, function(i, sku) {
            $.ajax({
                type: "GET",
                accepts: {
                    "*": 'application/json',
                },
                async: false,
                url: apiEndpoint + sku + additionalGetParams
            }).then(function (data) {
                $.each(data, function() {
                    let items = $('<a href="'+this.url+'" data-fancybox><img src="'+this.url+'" alt="'+this.alt+'"/></a>');
                    $('.download-tab.image-container').append(items);
                });
            });
        });
        $lg.lightGallery();
    }
});
