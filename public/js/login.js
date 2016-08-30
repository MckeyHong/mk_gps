/*global jQuery, error_account, error_password*/
/*jslint browser: true, devel: true*/
jQuery(document).ready(function ($) {
    'use strict';
    /* 限制輸入 */
    $('#username, #password').restrict();

    /* 登入 */
    $('#login-form').submit(function () {
        var sErrorMsg = '', sAcc = $.trim($('#username').val()), sPwd = $.trim($('#password').val());
        if ($.validate('alnum', sAcc) === false || sAcc.length < 4 || sAcc.length > 15) {
            sErrorMsg += error_account + '<br />';
        }
        if ($.validate('alnum', sPwd) === false || sPwd.length < 6 || sPwd.length > 15) {
            sErrorMsg += error_password + '<br />';
        }

        if (sErrorMsg !== '') {
            $.alert({message: sErrorMsg});
            return false;
        }
    });

});