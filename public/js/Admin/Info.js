/*global jQuery, error_acc*/
/*jslint browser : true, devel: true*/
jQuery(document).ready(function ($) {
    'use strict';

    /* 限制輸入 */
    $('#acc').restrict();

    /* 表單送出 */
    $('#search-form').submit(function () {

        var sErrorMsg = '';
        var sAcc = $.trim($('#acc').val());
        if (sAcc !== '' && ($.validate('alnum', sAcc) === false || sAcc.length < 4 || sAcc.length > 15)) {
            sErrorMsg += error_acc;
        }

        if (sErrorMsg !== '') {
            //$.alert({message: sErrorMsg});
            alert(sErrorMsg);
            return false;
        }
        return true;
    });
});
