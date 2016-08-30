/*global jQuery, aInfo*/
jQuery(document).ready(function ($) {
    'use strict';
    /* 開啟異常照片 */
    $('.btn-photo').click(function () {
        var oTr = $(this).parent().parent();
        for (var key in aInfo) {
            $('#DetailModal #info-' + aInfo[key]).html(oTr.find('.' + aInfo[key]).html());
        }
        $('#DetailModal').modal();
    });
});