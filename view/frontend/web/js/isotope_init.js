define(['jquery', 'isotope', 'domReady!'], function($, isotope) {
    var isotopeObj = new isotope('.download-tab.image-container', {
        itemSelector: '.download-tab.image',
        layoutMode: 'fitRows'
    });
});