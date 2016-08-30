/*global jQuery, func_url, aColumn, aError, aGpsItem, title_add, title_edit, error_del, del_msg, del_msg_multi, now_url*/
/*jslint browser: true, devel: true*/
/*property
    _method, _redirect, _token, ajax_response_process, alert, append, attr,
    callback, change, city, click, confirm, cust_ajax, data, del, each, find,
    html, length, message, modal, parent, phone, prop, provider, push, ready,
    remove, result, serialize, show_loading, submit, success, text, trim, url,
    val
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
    /* 清除編輯頁內容 */
    var clear_modal = function () {
        $('#data-form input:text').val('');
        $('#data-form select').prop('selectedIndex', 0);
        $.each(aGpsItem, function (iKey) {
            $('#data-form #info_' + aGpsItem[iKey]).html('');
        });
    };

    /* 新增 */
    $('#btn-add').click(function () {
        $("#data-form #gps_id option").remove();
        $("#data-form #gps_id").append($('#data-form #gps_default').html());
        $('#data-form #_method').val('post');
        $('#modal-title').html(title_add);
        clear_modal();
        $('#DetailModal').modal();
    });

    /* 修改 */
    $('.btn-edit').click(function () {
        clear_modal();
        $('#data-form #_method').val('put');
        $('#data-form #id').val($(this).data('id'));
        var oTr = $(this).parent().parent();
        $('#modal-title').html(title_edit);
        $.each(aColumn, function (iKey) {
            $('#data-form #' + aColumn[iKey]).val(oTr.find('.' + aColumn[iKey]).html());
        });
        if (oTr.find('.gps_no').html() !== '') {
            $("#data-form #gps_id").append($("<option selected></option>").attr("value", oTr.find('.gps_no').data('id')).data({phone: oTr.find('.phone').html(), provider: oTr.find('.provider').html(), city: oTr.find('.city').html()}).text(oTr.find('.gps_no').html()));
            $.each(aGpsItem, function (iKey) {
                $('#data-form #info_' + aGpsItem[iKey]).html(oTr.find('.' + aGpsItem[iKey]).html());
            });
        }
        $('#DetailModal').modal();
    });

    /* 資料送出 */
    $('#data-form').submit(function () {
        var sErrorMsg = '';
        $.each(aColumn, function (iKey) {
            if ($.trim($('#' + aColumn[iKey]).val()) === '') {
                sErrorMsg += aError[iKey] + '<br />';
            }
        });

        if (sErrorMsg !== '') {
            $.alert({message: sErrorMsg});
            return false;
        }

        $.show_loading();
        $.cust_ajax({
            url: func_url,
            data: $('#data-form').serialize() + '&_redirect=' + now_url
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
                    data: {_method: 'delete', _token: $('#data-form input[name=_token]').val(), _redirect: now_url},
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
                    data: {_token: $('#data-form input[name=_token]').val(), _redirect: now_url, del: aDel}
                });
            }
        });

    });

    /* 選擇gps顯示對應資訊 */
    $('#gps_id').change(function () {
        var $this = $(this);
        if ($this.val() !== '') {
            $.each(aGpsItem, function (iKey) {
                $('#data-form #info_' + aGpsItem[iKey]).html($(this).find(":selected").data(aGpsItem[iKey]));
            });
        } else {
            $.each(aGpsItem, function (iKey) {
                $('#data-form  #info_' + aGpsItem[iKey]).html('');
            });
        }
    });
});