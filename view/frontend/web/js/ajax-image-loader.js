define(['jquery', 'lightGallery', 'domReady!'], function($) {

    var $lg = $('.download-tab.image-container');
    return function(config) {
        if (config.uniqueID.length <= 0) {
            $('#tab-label-download.tab').parent().hide();
        }
        $('.download-tab.load.btn').on('click', function() {
            $(this).hide();
            loadImages(config.apiEndpoint, config.uniqueID, config.additionalGetParams);
        });
    }

    function loadImages(apiEndpoint, uniqueID, additionalGetParams) {
        $.each(uniqueID, function(i, uID) {
            $.ajax({
                type: "GET",
                accepts: {
                    "*": 'application/json',
                },
                async: false,
                url: apiEndpoint + uID + additionalGetParams
            }).then(function(data) {
                $.each(data, function() {
                    let items = $('<a href="' + this[5] + '" data-fancybox><img src="' + this[5] + '" alt="' + this[3] + '"/></a>');
                    $('.download-tab.image-container').append(items);
                });
            });
        });
        $lg.lightGallery();
    }
});