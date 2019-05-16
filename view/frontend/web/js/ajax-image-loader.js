define(['jquery', 'domReady!'], function($) {
    return function (config) {

        $('.download-tab.load.btn').on('click', function () {
            console.log(config.SKU);
            console.log(config.apiEndpoint);
            console.log(config.additionalGetParams);
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
                url: apiEndpoint + "?unique_id=" + sku + additionalGetParams
            }).then(function (data) {
                $.each(data, function() {
                    console.log(this.url);
                    $('.download-tab-content').append('<div class="download-tab image"><img src="'+this.url+'" alt="'+this.alt+'"/></div>');
                });
            });
        });
    }
});
