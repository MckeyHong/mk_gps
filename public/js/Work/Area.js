/*global jQuery, func_url, error_area, now_url*/
/*jslint browser: true, devel: true*/
jQuery(document).ready(function ($) {
    'use strict';
    /* 限制輸入 */
    $("input[name='rope[]']").restrict({reg: /^[0-9]+$/});
    $('#data-form #area_name').restrict();

    /* 修改工作區域 - 表單送出 */
    $('#list-form').submit(function () {
        var aInfo = {};
        $('#list-table tbody tr').each(function () {
            var id = $(this).data('id');
            aInfo[id] = {rope: $('#rope_' + id).val(), area: $(this).find('select#area_' + id).val()};
        });

        $.show_loading();
        $.cust_ajax({
            url: func_url,
            data: $('#list-form').serialize() + '&item=' + JSON.stringify(aInfo)
        });
        return false;
    });

    /* 新增場站區域 */
    $('#btn-add-area').click(function () {
        $('#DetailModal #area_name').val('');
        $('#DetailModal').modal();
    });

    /* 新增堨站區域 - 表單送出 */
    $('#data-form').submit(function () {
        if ($.trim($('#data-form #area_name').val()) === '') {
            $.alert({message: error_area});
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