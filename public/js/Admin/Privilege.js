/*global jQuery, func_url, error_del, del_msg, del_msg_multi, now_url*/
/*jslint browser: true, devel: true*/
/*property
    _method, _redirect, _token, ajax_response_process, alert, callback, click,
    confirm, cust_ajax, data, del, each, find, html, length, message, parent,
    push, ready, remove, show_loading, success, url, val, result
*/
jQuery(document).ready(function ($) {
    'use strict';
    /* 刪除 */
    var removeData = function (bResult, oTr) {
        if (bResult === true) {
            $('#list-count').html(parseInt($('#list-count').html(), 10) - 1);
            oTr.remove();
        }
    };

    /* 單筆資料刪除 */
    $('.btn-delete').click(function () {
        var id = $(this).data('id'), oTr = $(this).parent().parent();
        $.confirm({
            message: del_msg + oTr.find('.del_message').html(),
            callback: function () {
                $.show_loading();
                $.cust_ajax({
                    url: func_url + '/' + id,
                    data: {_method: 'delete', _token: $('input[name=_token]').val()},
                    success: function (data) {
                        $.ajax_response_process(data, removeData(data.result, oTr));
                    }
                });
            }
        });
    });

    /* 整批刪除 */
    $('#btn-all-delete').click(function () {
        var aDel = [];
        $('#list-table tbody tr td:first-child input:checkbox:checked[name=chkDel]').each(function () {
            aDel.push($(this).data('id'));
        });
        if (aDel.length < 1) {
            $.alert({message: error_del});
            return false;
        }
        $.confirm({
            message: del_msg_multi,
            callback: function () {
                $.show_loading();
                $.cust_ajax({
                    url: func_url + '/DeleteMulti',
                    data: {_token: $('input[name=_token]').val(), _redirect: now_url, del: aDel}
                });
            }
        });

    });

});