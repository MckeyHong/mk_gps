/*global jQuery, window, root_url, aPwdError*/
jQuery(document).ready(function ($) {
    'use strict';
    /* 限制輸入 */
    $('#self_pwd_old, #self_pwd, #self_pwd_chk').restrict();

    /* 列表頁全選/全選取消 */
    $('#list-table #chk-all').click(function () {
        if ($(this).prop('checked')) {
            $('#list-table .list-checkbox').prop("checked", true);
        } else {
            $('#list-table .list-checkbox').prop("checked", false);
        }
    });

    /* 回頂層 */
    $("#gotop").click(function () {
        $('html, body').animate({scrollTop: 0}, 500, 'linear');
    });

    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('#gotop').fadeIn("fast");
        } else {
            $('#gotop').stop().fadeOut("fast");
        }
    });

    /* 修改個人密碼 */
    var clearPwd = function () {
        $('#pwd-form input:password').val('');
        $.hide_loading();
        $('#SelfProfile').modal('hide');
    };
    $('#pwd-form').submit(function () {
        var sErrorMsg = '', aPwd = ['self_pwd_old', 'self_pwd', 'self_pwd_chk'];
        $.each(aPwd, function (iKey) {
            var sPwd = $.trim($('#' + aPwd[iKey]).val());
            if ($.validate('alnum', sPwd) === false || sPwd.length < 6 || sPwd.length > 15) {
                sErrorMsg += aPwdError[iKey] + '<br />';
            }
        });

        if (sErrorMsg !== '') {
            $.alert({message: sErrorMsg});
            return false;
        }

        $.show_loading();
        $.cust_ajax({
            url: root_url + 'Admin/Info/ChangePwd',
            data: $('#pwd-form').serialize() + '&_token=' + $('#pwd-form #self_token').val(),
            success: function (data) {
                $.ajax_response_process(data, clearPwd);
            }
        });
        return false;
    });
    $('#open_self_profile').click(function () {
        $('#pwd-form input:password').val('');
        $('#SelfProfile').modal();
    });
});
