/*global jQuery, func_url, aInfo, error_import, import_limit*/
/*jslint browser: true, devel: true*/
jQuery(document).ready(function ($) {
    'use strict';
    /* 修改 */
    $('.btn-edit').click(function () {
        var oTr = $(this).parent().parent();
        $('#DetailModal #id').val($(this).data('id'));
        $.each(aInfo, function (iKey) {
            $('#DetailModal #detail-' + aInfo[iKey]).html(oTr.find('.' + aInfo[iKey]).html());
        });
        $('#DetailModal').modal();
    });

    /* 新增場站 */
    $('.btn-area').click(function () {
        $('#copy_item').find('.item-area-word').html($('#detail-area').find(':selected').val());
        $('#detail-area').find(':selected').remove();
        if ($('#detail-area option').length === 0) {
            $('#detail-area-div').addClass('hidden');
        }
        $('#detail-item').append($('#copy_item').html());
    });

    /* 刪除檢查項目 */
    $(document).on('click', '#DetailModal .btn-del-item', function () {
        var sArea = $(this).parent().parent().find('.item-area-word').html();
        $("#detail-area").append($("<option></option>").attr("value", sArea).text(sArea));
        $('#detail-area-div').removeClass('hidden');
        $(this).parent().parent().remove();
    });

    /* 資料送出 */
    $('#data-form').submit(function () {
        var sErrorMsg = '';
        var aItem = [];
        $('#DetailModal #detail-item .add-item').each(function () {
            if ($.trim($(this).find('.item-area-word').html()) !== '') {
                aItem.push($.trim($(this).find('.item-area-word').html()));
            }
        });
        if (sErrorMsg !== '') {
            $.alert({message: sErrorMsg});
            return false;
        }
        $.show_loading();
        $.cust_ajax({
            url: func_url,
            data: $('#data-form').serialize() + '&item=' + aItem
        });
        return false;
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