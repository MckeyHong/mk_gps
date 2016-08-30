/*global jQuery, func_url, error_min, error_max*/
/*jslint browser: true, devel: true*/
jQuery(document).ready(function ($) {
    'use strict';
    /* 輸入限制 */
    $('#speed_min, #speed_max').restrict({reg: /^[0-9]+$/});
    /* 資料送出 */
    $('#data-form').submit(function () {
        var sErrorMsg = '';
        if ($.validate('digit', $.trim($('#speed_min').val())) === false || $.trim($('#speed_min').val()).length > 3) {
            sErrorMsg += error_min + '<br />';
        }
        if ($.validate('digit', $.trim($('#speed_max').val())) === false || $.trim($('#speed_max').val()).length > 3) {
            sErrorMsg += error_max + '<br />';
        }
        if (sErrorMsg !== '') {
            $.alert({message: sErrorMsg});
            return false;
        }
        $.show_loading();
        $.cust_ajax({
            url: func_url,
            data: $('#data-form').serialize()
        });
        return false;
    });
});