/*global jQuery, js_confirm_title, js_confirm_ok, js_confirm_cancel, js_alert_title, js_alert_ok*/
/*jslint browser : true, devel: true, regexp: true, plusplus: true */
jQuery(document).ready(function ($) {
    'use strict';
    var body = $('body'),
        btn,
        bstooltip,
        loading_obj = {},
        getTopZindex;


    //偵測 ie < 11
    $.msie = /*@cc_on!@*/0;

    // 使用別名 - button 被bootstrap蓋掉了
    if ($.fn.button) {
        if ($.fn.button.noConflict) {
            btn = $.fn.button.noConflict();
            $.fn.btn = btn;
        }
    }

    // 使用別名 - tooltip 被bootstrap蓋掉了
    if ($.fn.tooltip) {
        if ($.fn.tooltip.noConflict) {
            bstooltip = $.fn.tooltip.noConflict();
            $.fn.bstooltip = bstooltip;
        }
    }

    // ajax回傳處理
    $.ajax_response_process = function (data, callback, failcallback) {
        var $data,
            sucessCall;

        $data = data;
        // 成功
        if ($data.result) {
            // 顯示訊息
            if ($data.message) {
                if ($data.redirect) {
                    $.alert({
                        message: $data.message,
                        callback: function () {
                            location.href = $data.redirect;
                        }
                    });
                } else {
                    $.alert({message: $data.message});
                }
                $.hide_loading();
            }

            sucessCall = function () {
                // 網頁導轉
                if ($data.redirect) {
                    location.href = $data.redirect;
                } else {
                    // 不導轉時解鎖submit
                    $(':submit').prop({disabled: false});
                }

                // callback
                if (callback) {
                    callback($data);
                }
            };

            // 顯示訊息
            if ($data.noty) {
                $.cust_noty({type: 'success', message: $data.noty, callback: sucessCall});
            } else {
                sucessCall();
            }

        // 失敗
        } else {
            // 顯示錯誤訊息
            if ($data.message) {
                $.alert({message: $data.message});
                $.hide_loading();
            }

            // 解除submit lock
            $(':submit').prop({disabled: false});

            // focus指定欄位
            if ($data.field) {
                $('#' + $data.field).focus();
            }

            // 顯示訊息
            if ($data.noty) {
                $.cust_noty({type: 'danger', message: $data.noty, callback: failcallback});
            } else {
                if (failcallback) {
                    failcallback($data);
                }
            }
        }
    };

    // 自訂ajax
    $.cust_ajax = function (op) {
        var settings = {
            dataType: 'json',
            type: 'POST',
            success: function (data) {
                $.ajax_response_process(data);
            },
            error: function () {
                $.alert({message: 'Ajax error.'});
                // 解除submit lock
                $(':submit').prop({disabled: false});
                $.hide_loading();
            }
        };

        $.extend(settings, op);

        // 未設定url
        if (!settings.url || settings.url === '') {
            settings.url = location.href;
        }

        $.ajax(settings);
    };

    // 顯示modal
    $.show_modal = function (url, id) {
        var options = {},
            modal_obj = $(id);

        if (modal_obj.length === 0) {
            $.get(url, {id: id}, function (data) {
                body.append(data);
                modal_obj = $(id);
                modal_obj.modal(options);
            });
        }
    };

    // 顯示按鈕說明
    $('.show_modal').click(function (event) {
        event.preventDefault();
        var $this = $(this);

        $.show_modal($this.attr('href'), $this.data('target'));
    });

    // 套用placeholder plugin
    if ($.fn.placeholder) {
        $(":input[placeholder]").placeholder();
    }

    // 套用日期選擇器
    if ($.fn.datepicker) {
        $('.datepicker').datepicker({
            dateFormat: "yy-mm-dd"
        });
    }

    // 輸入限制plugin
    $.fn.restrict = function (options) {
        var defaults = {
                reg: /^[a-zA-Z0-9]+$/
            };

        options = $.extend({}, defaults, options);

        return this.each(function () {
            var elem = $(this),
                reg = options.reg,
                flag = false,
                validation = function () {
                    var str = '', i, val = elem.val(), bReset = false;
                    for (i = 0; i < val.length; i++) {
                        if (reg.test(str + val.charAt(i))) {
                            str += val.charAt(i);
                        } else {
                            // 有非法字元
                            bReset = true;
                        }
                    }
                    // 有非法字元 - 重設輸入字串
                    if (bReset) {
                        elem.val(str);
                    }
                };

            elem.off('input').on('input', validation);

            if ($.msie) {
                elem.off('propertychange').on('propertychange', function () {
                    // !flag 避免重複觸發
                    if (!flag && window.event.propertyName.toLowerCase() === "value") {
                        flag = true;
                        validation();
                    }
                    flag = false;
                });
            }

        });
    };

    // 顯示確認訊息
    $.confirm = function (options) {
        var defaults = {
                title: js_confirm_title,
                message: '',
                btn_ok_text: js_confirm_ok,
                btn_cancel_text: js_confirm_cancel
            },
            settings,
            div = $('<div>'),
            topZ = 1;

        settings = $.extend({}, defaults, options);

        div.attr({title: settings.title}).html(settings.message);

        body.append(div);

        // 取得最高z-index
        topZ = getTopZindex();

        div.dialog({
            buttons: [
                {
                    text: settings.btn_ok_text,
                    click: function () {
                        if (settings.callback) {
                            settings.callback();
                        }
                        $(this).dialog("close");
                    }
                },
                {
                    text: settings.btn_cancel_text,
                    click: function () {
                        $(this).dialog("close");
                    }
                }
            ],
            modal: true,
            close: function () {
                div.dialog('destroy');
                div.remove();
            },
            create: function () {
                var dialog = div.closest('.ui-dialog');
                // 比目前最高層數再高20
                dialog.css('z-index', topZ + 20);
                dialog.find('.ui-dialog-titlebar-close').remove();
                dialog.find('button:first').off('focus mouseover mouseenter').attr({'class': 'btn btn-primary'});
                dialog.find('button:last').off('focus mouseover mouseenter').attr({'class': 'btn btn-warning'});
            },
            open: function () {
                var dialog = div.closest('.ui-dialog');
                if (dialog.next().hasClass('ui-widget-overlay')) {
                    // 遮罩 - 比目前最高層數再高10
                    dialog.next().css('z-index', topZ + 10);
                }
            }
        });
    };

    //顯示提示訊息
    $.alert = function (options) {
        var defaults = {
                title: js_alert_title,
                message: '',
                btn_ok_text: js_alert_ok
            },
            settings,
            div = $('<div>'),
            topZ = 1;

        settings = $.extend({}, defaults, options);

        div.attr({title: settings.title}).html(settings.message);

        body.append(div);

        // 取得最高z-index
        topZ = getTopZindex();

        div.dialog({
            buttons: [
                {
                    text: settings.btn_ok_text,
                    click: function () {
                        if (settings.callback) {
                            setTimeout(function () {
                                settings.callback();
                            }, 1);
                        }
                        $(this).dialog("close");
                    }
                }
            ],
            modal: true,
            close: function () {
                div.dialog('destroy');
                div.remove();
            },
            create: function () {
                var dialog = div.closest('.ui-dialog');
                // 比目前最高層數再高20
                dialog.css('z-index', topZ + 20);
                dialog.find('.ui-dialog-titlebar-close').remove();
                dialog.find('button:first').off('focus mouseover mouseenter').attr({'class': 'btn btn-primary'});
            },
            open: function () {
                var dialog = div.closest('.ui-dialog');
                if (dialog.next().hasClass('ui-widget-overlay')) {
                    // 遮罩 - 比目前最高層數再高10
                    dialog.next().css('z-index', topZ + 10);
                }
            }
        });
    };

    // 顯示提示訊息
    $.cust_noty = function (options) {
        var defaults = {
                type: 'info', // success、info、warning、danger
                message: '',
                delay: 2000
            },
            settings,
            div = $('<div>'),
            topZ = 1;

        settings = $.extend({}, defaults, options);

        div.attr({role: 'alert'}).addClass('alert').addClass('alert-' + settings.type).html(settings.message);

        div.css({position: 'fixed', top: '-9999em', width: '100%', textAlign: 'center', marginBottom: 0});
        body.append(div);

        // 取得最高z-index
        topZ = getTopZindex();

        div.css({display: 'none', top: 'auto', bottom: 0, 'z-index': topZ + 20});
        div.slideDown();

        // callback往前移，顯示noty就執行
        if (settings.callback) {
            // noty完成彈出再執行callback
            setTimeout(function () {
                settings.callback();
            }, 500);
        }

        setTimeout(function () {
            div.slideUp(400, function () {
                div.remove();
                if (settings.redirect) {
                    document.location.href = settings.redirect;
                }
            });
        }, settings.delay);
    };

    // 顯示loading
    $.show_loading = function () {
        var overlay = $('<div>'),
            icon = $('<div>'),
            topZ = 1;

        overlay.addClass('loading_overlay');

        body.append(overlay);
        loading_obj.overlay = overlay;

        icon.addClass('loading_icon');

        body.append(icon);
        loading_obj.icon = icon;

        // 取得最高z-index
        topZ = getTopZindex();

        // 遮罩 z-index + 10
        overlay.css('z-index', topZ + 10);
        // loading圖 z-index + 20
        icon.css('z-index', topZ + 20);
    };

    // 移除loading
    $.hide_loading = function () {
        if (loading_obj.overlay.length > 0 || loading_obj.icon.length > 0) {
            loading_obj.overlay.remove();
            loading_obj.icon.remove();
        }
    };

    // 驗證函數
    $.validate = function (type, value) {
        var DOMAIN = '[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+',
            PORT = '(6553[0-5]|655[0-2][0-9]|65[0-4][0-9]{2}|6[0-4][0-9]{3}|[1-5][0-9]{4}|[1-9][0-9]{0,3}|0)',
            IPv4 = '(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])\\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])\\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])\\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9]?[0-9])',
            DATE = '([0-9]{4})-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])',
            EPOCHDATE = '(19[7-9][0-9]|2[0-9]{3})-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])',
            TIME = '([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])',
            FLOAT = '(\\-|\\+)?([0-9]+\\.?[0-9]*|\\.[0-9]+)',
            valid = {
                // 驗證 英文
                'alpha': /^[A-Za-z]+$/,

                // 驗證 英文+數字
                'alnum': /^[A-Za-z0-9]+$/,

                // 驗證 純數字
                'digit': /^\d+$/,

                // 驗證 浮點數
                'float': new RegExp('^' + FLOAT + '$'),

                // 驗證數字+小數點5位
                'double': /^[0-9]+(\.[0-9]{1,10})?$/,

                // 驗證 大寫英文
                'upper': /^[A-Z]+$/,

                // 驗證 小寫英文
                'lower': /^[a-z]+$/,

                // 驗證 小寫英文+數字
                'loweralnum': /^[a-z0-9]+$/,

                // 驗證 英文+數字+底線
                'word': /^\w+$/,

                // 驗證 繁簡中文
                'ch': /^[\u4e00-\u9fa5]+$/,

                // 驗證空值
                'empty': /\S/,

                // 驗證 日期 (yyyy-mm-dd)
                'date': new RegExp('^' + DATE + '$'),
                // 驗證 unix日期 (yyyy-mm-dd)

                // 年份必須為 1970 ~ 2999
                'epochdate': new RegExp('^' + EPOCHDATE + '$'),

                // 驗證 日期時間 (yyyy-mm-dd hh-ii-ss)
                'datetime': new RegExp('^' + DATE + ' ' + TIME + '$'),

                // 驗證 時間 (hh-ii-ss)
                'time': new RegExp('^' + TIME + '$'),

                // 驗證 信箱
                'email': new RegExp('^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@' + DOMAIN + '$'),

                // 驗證 網域
                'domain': new RegExp('^' + DOMAIN + '$'),

                // 驗證 端口 (0~65535)
                'port': new RegExp('^' + PORT + '$'),

                // 驗證 ip
                'ip': new RegExp('^' + IPv4 + '$')
            };

        return valid.hasOwnProperty(type) ? valid[type].test(value) : false;
    };

    // 取得目前最高的Z-index
    getTopZindex = function () {
        var topZ = 1,
            tmpZ = 0;

        // 取得最高z-index
        body.children().each(function () {
            tmpZ = parseInt($(this).css('z-index'), 10);
            if (tmpZ > topZ) {
                topZ = tmpZ;
            }
        });

        return topZ;
    };


    /* 檢查匯入格式 */
    $.check_import = function (check_file) {
        switch (check_file.split('.').pop().toLowerCase()) {
            case 'xls':
            case 'xlsx':
                return true;
        }
        return false;
    };

});
