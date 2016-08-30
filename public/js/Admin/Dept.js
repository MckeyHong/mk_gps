/*global jQuery, now_url, func_url, del_msg, del_msg_multi, error_del, title_add, title_edit, error_title*/
/*jslint browser : true, devel: true*/
jQuery(document).ready(function ($) {
    var aParam = ['parent_id', 'city', 'level', 'parent_arr'];
    'use strict';
    /* 新增 */
    $('#list-table .btn-add').click(function () {
        $('#DetailModal #modal-title').html(title_add);
        $('#DetailModal #_method').val('post');
        $('#DetailModal #dept_name').val('');
        $('#DetailModal #dept_parent').html($(this).parent().find('.dept_parent').html());
        for (key in aParam) {
            $('#DetailModal #' + aParam[key]).val($(this).data(aParam[key]));
        }
        $('#DetailModal').modal();
    });

    /* 修改 */
    $('#list-table .btn-edit').click(function () {
        $('#DetailModal #modal-title').html(title_edit);
        $('#DetailModal #_method').val('put');
        $('#DetailModal #id').val($(this).data('id'));
        $('#DetailModal #dept_name').val($(this).data('name'));
        $('#DetailModal #parent_id').val($(this).data('parent_id'));
        $('#DetailModal #dept_parent').html($(this).parent().find('.dept_parent').html());
        $('#DetailModal').modal();
    });

    /* 資料送出 */
    $('#data-form').submit(function () {
        var sErrorMsg = '';

        if ($.trim($('#dept_name').val()) === '') {
            sErrorMsg += error_title + '<br />';
        }

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
    $('#list-table .btn-delete').click(function () {
        var id = $(this).data('id');
        $.confirm({
            message: del_msg,
            callback: function () {
                $.show_loading();
                $.cust_ajax({
                    url: func_url + '/' + id,
                    data: { _method: 'delete', _token: $('#data-form input[name=_token]').val(), _redirect: now_url}
                });
            }
        });
    });

});
