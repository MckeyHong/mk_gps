@extends('layouts.main')

@section('content')
<style>
.add-symbol {
    margin: 0 20px 0 20px;
    line-height: 80px;
}
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
                <div class="filter-block pull-right">
                    <div class="form-group pull-left list-search-block">
                        <form id="search-form" method="GET">
                            <div class="pull-left text-label"><label for="type">@lang('website.car_type')：</label></div>
                            <div class="pull-left">
                                <select name="type" id="type" class="form-control input-sm">
                                    <option value="">@lang('website.all')</option>
                                    <option value="">調度車</option>
                                    <option value="">機車</option>
                                </select>
                            </div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left text-label"><label for="car">@lang('website.car_no')：</label></div>
                            <div class="pull-left"><input type="text" id="car" name="car" class="form-control input-sm" value="" maxlength="10" size="10"></div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left text-label"><label for="staff">@lang('website.staff_no')(@lang('website.account'))：</label></div>
                            <div class="pull-left"><input type="text" id="staff" name="staff" class="form-control input-sm" value="" maxlength="15" size="12"></div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left text-label"><label for="date">@lang('website.date')：</label></div>
                            <div class="pull-left"><input type="text" id="date" name="date" class="form-control input-sm datepicker" value="" maxlength="10" size="9"></div>
                            <div class="pull-left"><button type="submit" class="btn btn-default"><span class="fa fa-search"></span> @lang('website.btn_search')</button></div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </header>
            <div class="main-box-body clearfix">
                <div class="table-responsive row list-margin">
                    <div class="col-xs-6">
                        <div id="map" style="border:1px solid #CCC;border-radius:5px;width:100%; height: 400px"></div>
                    </div>
                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>@lang('website.time')</th>
                                    <th>@lang('website.status')</th>
                                    <th>@lang('website.rope_num')</th>
                                    <th>@lang('website.speed_hour')(KM)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($aInfo) > 0)
                                    @foreach ($aInfo as $aVal)
                                    <tr>
                                        <td>{{$aVal['']}}</td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <!--
                                    <td colspan="4" class="text-center">@lang('website.no_data')</td>
                                    -->
                                    <td class="text-center">2015-07-29 11:00:05</td>
                                    <td class="text-center">靜止</td>
                                    <td class="text-right">10</td>
                                    <td class="text-right">0</td>
                                </tr>
                                <tr>
                                    <!--
                                    <td colspan="4" class="text-center">@lang('website.no_data')</td>
                                    -->
                                    <td class="text-center">2015-07-29 10:59:20</td>
                                    <td class="text-center text-danger">移動中</td>
                                    <td class="text-right">10</td>
                                    <td class="text-right">20</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
                @if (count($aInfo) > 0)
                <div>
                    <div class="pagination-count pull-left">
                        @lang('website.data_count')：{{$aInfo->total()}}
                    </div>
                    <ul class="pagination pull-right">
                        {!!str_replace('/?', '?', $aInfo->appends($aGet)->render()) !!}
                    </ul>
                    <div class="clearfix"></div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('js_self')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&language=zh-TW"></script>
<script>
$(function(){
        var myLatlng = new google.maps.LatLng(25.0239966, 121.5530201);
        var mapOptions = {
          zoom: 15,
          center: myLatlng,
          scrollwheel: false, //we disable de scroll over the map, it is a really annoing when you scroll through page
          styles: [{"featureType":"water","stylers":[{"saturation":43},{"lightness":-11},{"hue":"#0088ff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":99}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#808080"},{"lightness":54}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ece2d9"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#ccdca1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#767676"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#b8cb93"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"simplified"}]}]

        }
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);

        var marker = new google.maps.Marker({
            position: myLatlng,
            title:"中心點"
        });

        // To add the marker to the map, call setMap();
        marker.setMap(map);
});
</script>
@endsection