/*global jQuery, func_url, error_status, title_add, title_edit, error_del, del_msg, del_msg_multi, now_url*/
/*jslint browser: true, devel: true*/
/*property
    _method, _redirect, _token, ajax_response_process, alert, callback, click,
    confirm, cust_ajax, data, del, each, find, html, length, message, modal,
    parent, push, ready, remove, serialize, show_loading, submit, success,
    trim, url, val
*/
jQuery(document).ready(function ($) {
    'use strict';
    /* 編輯後更新頁面資料 */
    var updateInfo = function () {
        var oTr = $('#list-table').find('.tr-' + $('#data-form #id').val());
        oTr.find('.status_name, .del_status_name').html($('#data-form #status_name').val());
        $('#DetailModal').modal('hide');
    };
    /* 刪除 */
    var removeData = function (oTr) {
        $('#list-count').html(parseInt($('#list-count').html(), 10) - 1);
        oTr.remove();
    };

    /* 新增 */
    $('#btn-add').click(function () {
        $('#data-form #_method').val('post');
        $('#modal-title').html(title_add);
        $('#data-form input:text').val('');
        $('#DetailModal').modal();
    });

    /* 修改 */
    $('.btn-edit').click(function () {
        $('#data-form #_method').val('put');
        $('#data-form #id').val($(this).data('id'));
        var oTr = $(this).parent().parent();
        $('#modal-title').html(title_edit);
        $('#data-form #status_name').val(oTr.find('.status_name').html());
        $('#DetailModal').modal();
    });

    /* 資料送出 */
    $('#data-form').submit(function () {
        var sErrorMsg = '';

        if ($.trim($('#status_name').val()) === '') {
            sErrorMsg += error_status + '<br />';
        }

        if (sErrorMsg !== '') {
            $.alert({message: sErrorMsg});
            return false;
        }

        $.show_loading();
        $.cust_ajax({
            url: func_url,
            data: $('#data-form').serialize(),
            success: function (data) {
                $.ajax_response_process(data, updateInfo);
            }
        });
        return false;
    });

    /* 單筆資料刪除 */
    $('.btn-delete').click(function () {
        var id = $(this).data('id'), oTr = $(this).parent().parent();
        $.confirm({
            message: del_msg + oTr.find('.del_message').html(),
            callback: function () {
                $.show_loading();
                $.cust_ajax({
                    url: func_url + '/' + id,
                    data: {_method: 'delete', _token: $('#data-form input[name=_token]').val()},
                    success: function (data) {
                        $.ajax_response_process(data, removeData(oTr));
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
                    data: {_token: $('#data-form input[name=_token]').val(), _redirect: now_url, del: aDel}
                });
            }
        });

    });

});