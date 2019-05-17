/**
 * Copyright © Konatsu.pl Robert Rupa.
 */

var config = {
    paths: {
        'lightGallery': 'RobertRupa_DownloadTab/js/lightgallery-all',
        'ajaxImageLoader': 'RobertRupa_DownloadTab/js/ajax-image-loader'
    },
    shim: {
        'lightGallery': {
            deps: ['jquery']
        },
        'ajaxImageLoader': {
            deps: ['jquery', 'lightGallery']
        },
    }
};