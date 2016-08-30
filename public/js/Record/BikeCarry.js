/*global jQuery, func_url*/
/*jslint browser: true, devel: true*/
jQuery(document).ready(function ($) {
    'use strict';
    $('#start, #end').restrict({reg: /^[0-9\-]+$/});
    $('.btn-export').click(function () {
        document.location.href = func_url + '/Export?' + $('#search-form').serialize();
    });
});