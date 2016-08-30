/* Chinese initialisation for the jQuery UI date picker plugin. */
/* Written by Ressol (ressol@gmail.com). */
(function (factory) {
    if (typeof define === "function" && define.amd) {
        // AMD. Register as an anonymous module.
        define(["../datepicker"], factory);
    } else {
        // Browser globals
        factory(jQuery.datepicker);
    }
}(function (datepicker) {

datepicker.regional['zh-TW'] = {
    closeText: '關閉',
    prevText: '&#x3C;上月',
    nextText: '下月&#x3E;',
    currentText: '今天',
    monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
    monthNamesShort: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
    dayNames: ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
    dayNamesShort: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],
    dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
    weekHeader: '周',
    dateFormat: 'yy/mm/dd',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: true,
    yearSuffix: '年'};
datepicker.setDefaults(datepicker.regional['zh-TW']);

return datepicker.regional['zh-TW'];

}));


/* 時間 */
if ($.fn.timepicker) {
    (function ($) {
        $.timepicker.regional['zh-TW'] = {
            timeOnlyTitle: '選擇時分秒',
            timeText: '時間',
            hourText: '時',
            minuteText: '分',
            secondText: '秒',
            millisecText: '毫秒',
            microsecText: '微秒',
            timezoneText: '時區',
            currentText: '現在時間',
            closeText: '確定',
            timeFormat: 'HH:mm',
            timeSuffix: '',
            amNames: ['上午', 'AM', 'A'],
            pmNames: ['下午', 'PM', 'P'],
            isRTL: false
        };
        $.timepicker.setDefaults($.timepicker.regional['zh-TW']);
    })(jQuery);
}
