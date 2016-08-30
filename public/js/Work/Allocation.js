/*global jQuery, aColumn, func_url, clear_msg, clear_msg_multi, now_url, error_import, error_clear, import_limit*/
/*jslint browser: true, devel: true*/
/*property
    _redirect, _token, ajax_response_process, alert, append, cache, callback,
    check_import, clear, click, confirm, contentType, cust_ajax, data,
    dataType, each, error, find, hide_loading, html, id, length, message,
    modal, name, parent, parse, processData, prop, push, ready, replace,
    serialize, show_loading, size, submit, success, url, val
*/
jQuery(document).ready(function ($) {
    'use strict';
    /* 清除資料 */
    var clearData = function (oTr) {
        oTr.find('.work_notice, .work_keynote').html('');
    };

    /* 修改 */
    $('.btn-edit').click(function () {
        var oTr = $(this).parent().parent();
        $('#DetailModal #id').val($(this).data('id'));
        $('#DetailModal #work_notice').val(oTr.find('.work_notice').html());
        $('#DetailModal #work_keynote').val(oTr.find('.work_keynote').html().replace('/', ','));
        $.each(aColumn, function (iKey) {
            $('#DetailModal #' + aColumn[iKey]).html(oTr.find('.' + aColumn[iKey]).html());
        });
        $('#DetailModal').modal();
    });

    /* 資料送出 */
    $('#data-form').submit(function () {
        $.show_loading();
        $.cust_ajax({
            url: func_url,
            data: $('#data-form').serialize()
        });
        return false;
    });

    /* 清除 */
    $('.btn-clear').click(function () {
        var id = $(this).data('id'), oTr = $(this).parent().parent();
        $.confirm({
            message: clear_msg + oTr.find('.clear_message').html(),
            callback: function () {
                $.show_loading();
                $.cust_ajax({
                    url: func_url + '/Clear',
                    data: {id: id, _token: $('#data-form input[name=_token]').val()},
                    success: function (data) {
                        $.ajax_response_process(data, clearData(oTr));
                    }
                });
            }
        });
    });

    /* 整批清除 */
    $('#btn-all-clear').click(function () {
        var aClear = [];
        $('#list-table tbody tr td:first-child input:checkbox:checked[name=chkClear]').each(function () {
            aClear.push($(this).data('id'));
        });

        if (aClear.length < 1) {
            $.alert({message: error_clear});
            return false;
        }

        $.confirm({
            message: clear_msg_multi,
            callback: function () {
                $.show_loading();
                $.cust_ajax({
                    url: func_url + '/ClearMulti',
                    data: {_token: $('#data-form input[name=_token]').val(), _redirect: now_url, clear: aClear}
                });
            }
        });
    });

    /* 資料匯入新增 */
    $('#excel-form').submit(function () {
        var filename = $('#excel-form #excel').prop('files')[0];
        if ($('#excel-form #excel').val() === '' || filename.size >= import_limit || $.check_import(filename.name) !== true) {
            $.alert({message: error_import});
            return false;
        }
        $.show_loading();
        var form = $('form')[0];
        var form_data = new FormData(form);
        form_data.append('upload_excel', filename);
        form_data.append('_token', $("#excel-form input[name='_token']").val());
        $.cust_ajax({
            url: func_url + '/Import',
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (data) {
                data = JSON.parse(data);
                $.ajax_response_process(data);
            },
            error: function () {
                $.alert({message: 'Ajax error.'});
                $.hide_loading();
            }
        });
        return false;
    });

});