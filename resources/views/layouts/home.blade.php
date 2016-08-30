@extends('layouts.main')

@section('content')
<style type="text/css">

#map{
    margin-top: 10px;
    width: 100%;
    min-height: 500px;
    height: 90%;
}

#alert-msg{
    position: absolute;
    top: 75px;
    right: 12px;
}

.alert-danger {
    margin-bottom: 5px;
    padding: 8px;
    border: 1px solid #CCC;
    border-radius: 8px;
}
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
            <div id="home-header-div" class="alert alert-info">
                <div class="pull-left">@lang('website.home_default')：</div>
                <div class="pull-left">
                    <select id="" name="" class="form-control">
                        <option value="">地圖狀態顯示</option>
                        <option value="">場站狀態資訊</option>
                        <option value="">車輛超速列表</option>
                    </select>
                </div>
                <div class="pull-left">
                    <button type="button" class="btn btn-primary">@lang('website.btn_set')</button>
                </div>
                <div class="clearfix"></div>
            </div>
            </header>
            <div >
                <div id="map" style="width:100%;height:450px;margin-bottom:10px"></div>
                <div class="alert alert-info alert-minpadding">
                    <div class="pull-left text-label">@lang('website.update_time')：<span id="now-time">{{ date('Y-m-d H:i:s') }}</span></div>
                    <div class="pull-right"><input type="button" class="btn btn-primary" id="btn-update" value="@lang('website.btn_map')" /></div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js_self')
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=false&libraries=places,drawing,geometry"></script>
<script src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
<script type="text/javascript">
    var img_url = 'http://localhost/gps/public/image/', update_datetime, update_datetime, update_out, initMap, flightPath, map, MarkerOptions;
    var infoWindows = [], redinfoWindows = [];

    initMap = function () {

        var secheltLoc = new google.maps.LatLng(25.023884, 121.553161);

        var myMapOptions = {
             zoom: 14
            ,center: secheltLoc
            ,mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var theMap = new google.maps.Map(document.getElementById("map"), myMapOptions);


        /* Start - 場站 */
        @foreach($aInfo as $aVal)
        @if ($aVal['station_img'] == 'rface.png')
           var marker_{{$aVal['station_no']}} = new google.maps.Marker({
                map: theMap,
                draggable: false, /* 是否可以讓使用者移動標記，true 可移動；false 則否。 */
                position: new google.maps.LatLng({{$aVal['station_lat']}}, {{$aVal['station_lng']}}), /* 使用 LatLng 類別來設定位置(必填欄位) */
                visible: true, /* 是否顯示標記，true 顯示；false隱藏。*/
                icon: img_url + 'rface.png'
            });

            var boxText = document.createElement("div");
            boxText.style.cssText = "border: 1px solid black; margin-top: 8px; background: red; padding: 5px;color:white";
            boxText.innerHTML = [
                '<b>{{$aVal['station_name']}}</b>',
                '可借數量: {{$aVal['bike_station']}}輛',
                '可停空位: {{$aVal['empty_space']}}輛',
                '綁車數: {{$aVal['bike_rope']}}輛',
                '更新時間：{{date('m/d H:i:s', $aVal['modify_date'])}}'
                ].join('<br>') + '<div id="out_time" style="position:absolute;bottom:-25px;right:10px;background-color:none;color:red;font-size:14px;font-weight:bold;">@if ($aVal['space_full_time'] != '') {{date('H\'i"',$aVal['space_full_time'])}} @endif</div>';

            var myOptions = {
                 content: boxText
                ,disableAutoPan: false
                ,maxWidth: 0
                ,pixelOffset: new google.maps.Size(-90, -135)
                ,zIndex: null
                ,boxStyle: {
                  opacity: 0.9
                  ,width: "180px"
                 }
                ,closeBoxMargin: "10px 2px 2px 2px"
                ,closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif"
                ,infoBoxClearance: new google.maps.Size(1, 1)
                ,isHidden: false
                ,pane: "floatPane"
                ,enableEventPropagation: false
            };

            google.maps.event.addListener(marker_{{$aVal['station_no']}}, "click", function (e) {
                ib_{{$aVal['station_no']}}.open(theMap, marker_{{$aVal['station_no']}});
            });
            var ib_{{$aVal['station_no']}} = new InfoBox(myOptions);
            ib_{{$aVal['station_no']}}.open(theMap, marker_{{$aVal['station_no']}});
            redinfoWindows.push(ib_{{$aVal['station_no']}});
        @else
            var marker_{{$aVal['station_no']}} = new google.maps.Marker({
                map: theMap,
                draggable: false,
                position: new google.maps.LatLng({{$aVal['station_lat']}}, {{$aVal['station_lng']}}),
                visible: true,
                icon: img_url + '{{$aVal['station_img']}}'
            });

            var boxText = document.createElement("div");
            boxText.style.cssText = "border: 1px solid black; margin-top: 8px; background: #FFF; padding: 5px;color:#000";
            boxText.innerHTML = [
                '<b>{{$aVal['station_name']}}</b>',
                '可借數量: {{$aVal['bike_station']}}輛',
                '可停空位: {{$aVal['empty_space']}}輛',
                '綁車數: {{$aVal['bike_rope']}}輛',
                '更新時間：{{date('m/d H:i:s', $aVal['modify_date'])}}'
                ].join('<br>');

            var myOptions = {
                 content: boxText
                ,disableAutoPan: false
                ,maxWidth: 0
                ,pixelOffset: new google.maps.Size(-90, -135)
                ,zIndex: null
                ,boxStyle: {
                  opacity: 1
                  ,width: "180px"
                 }
                ,closeBoxMargin: "10px 2px 2px 2px"
                ,closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif"
                ,infoBoxClearance: new google.maps.Size(1, 1)
                ,isHidden: false
                ,pane: "floatPane"
                ,enableEventPropagation: false
            };

            google.maps.event.addListener(marker_{{$aVal['station_no']}}, "click", function (e) {
                cleaerStationInfo('default');
                ib_{{$aVal['station_no']}}.open(theMap, marker_{{$aVal['station_no']}});
            });
            var ib_{{$aVal['station_no']}} = new InfoBox(myOptions);
            infoWindows.push(ib_{{$aVal['station_no']}});
        @endif
        @endforeach
        /* End - 場站 */
        var cleaerStationInfo = function (sType) {
            switch (sType) {
                case 'default':
                    for (var i = 0 ; i < infoWindows.length ; i++) {
                        infoWindows[i].close();
                    }
                break;
                case 'red':
                    for (var i = 0 ; i < redinfoWindows.length ; i++) {
                        redinfoWindows[i].close();
                    }
                break;
                case 'all':
                    for (var i = 0 ; i < infoWindows.length ; i++) {
                        infoWindows[i].close();
                    }
                    for (var i = 0 ; i < redinfoWindows.length ; i++) {
                        redinfoWindows[i].close();
                    }
                break;
            }

        };

        /* Start - 路線圖 */
        var flightPathCoordinates = [
            new google.maps.LatLng(25.023884, 121.553161),
            new google.maps.LatLng(25.0377972222, 121.565169444),
        ];

        flightPath = new google.maps.Polyline({
            path: flightPathCoordinates,
            strokeColor: '#21C2DE',
            strokeOpacity: 0.7,
            strokeWeight: 5
        });

        flightPath.setMap(theMap);

        google.maps.event.addListener(flightPath, 'click', function() {
            alert('you clicked polyline');
        });
        /* End - 路線圖 */

    };



    $(function () {
        initMap();

        /* 定時更新地圖資訊 */
        update_map = function () {
            update_datetime();
            setTimeout('update_map()', 15000);
        };

        /* 更新目前時間 */
        update_datetime = function () {
            var today = new Date(), sNowTime = '', sTemp = '';
            if (today.getYear() < 1999) {
                sNowTime = 1900 + today.getYear();
            } else {
                sNowTime = today.getYear();
            }
            sNowTime += '-' + (today.getMonth()+1);
            sNowTime += '-' + today.getDate();
            sNowTime += ' ' + (today.getHours() < 10 ? '0' + today.getHours() : today.getHours());
            sNowTime += ':' + (today.getMinutes() < 10 ? '0' + today.getMinutes() : today.getMinutes());
            sNowTime += ':' + (today.getSeconds() < 10 ? '0' + today.getSeconds() : today.getSeconds());
            $('#now-time').html(sNowTime);
        };


        update_out = function () {
            var today = new Date(), sNowTime = '', aTemp = $('#out_time').html().split(':');
            if (aTemp[1] === '59') {
                aTemp[1] = '00';
                aTemp[0] = parseInt(aTemp[0], 10) + 1;
                aTemp[0] = aTemp[0] < 10 ? '0' + aTemp[0] : aTemp[0];
            } else {
                aTemp[1] = parseInt(aTemp[1], 10) + 1;
                aTemp[1] = aTemp[1] < 10 ? '0' + aTemp[1] : aTemp[1];
            }

            $('#out_time').html(aTemp[0] + ':' + aTemp[1]);
            setTimeout('update_out()', 1000);
        };


        /* 設置每30秒更新 */
        setTimeout('update_map()', 15000);
        //setTimeout('update_out()', 1000);

        /* 功能切換 */
        $('#home-menu > li').click(function () {
            $('#home-menu > li').removeClass('active');
            $(this).addClass('active');
            $(".tab-pane").removeClass('active').addClass('hidden');
            $("#tab-" + $(this).data('id')).addClass('active').removeClass('hidden');
        });



        /* 更新地圖 */
        $('#btn-update').click(function () {
            window.location.reload();
        });


        /* 選擇車輛種類 */
        $('#type').change( function () {
            var sType = $(this).val();
            if (sType !== '') {
                $('.car-type').hide();
                $('.type-' + sType).show();
            } else {
                $('.car-type').show();
            }
        });


    });
</script>
@endsection