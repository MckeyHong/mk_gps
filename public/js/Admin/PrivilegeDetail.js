/*global jQuery, func_url, error_role*/
/*jslint browser : true, devel: true*/
jQuery(document).ready(function ($) {
    'use strict';
    /* 表單送出 */
    $('#data-form').submit(function () {
        if ($.trim($('#role_name').val()) === '') {
            $.alert({message: error_role});
            return false;
        }
        $.show_loading();
        $.cust_ajax({
            url: func_url,
            data: $('#data-form').serialize()
        });
        return false;
    });
    $('#chk_all').click(function () {
        if ($(this).prop('checked')) {
            $('.chk_main, .chk_child').prop("checked", true);
        } else {
            $('.chk_main, .chk_child').prop("checked", false);
        }
    });
    $('.chk_main').click(function () {
        if ($(this).prop('checked')) {
            $('.main_' + $(this).data('id')).prop("checked", true);
        } else {
            $('.main_' + $(this).data('id')).prop("checked", false);
        }
    });
    $('.chk_child').click(function () {
        if (!$(this).prop('checked')) {
            $('#chk_all, #' + $(this).data('parent')).prop("checked", false);
        }
    });

});
