@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
                <div class="filter-block pull-right">
                    <div class="form-group pull-left list-search-block">
                        <form id="search-form" method="GET">
                            <div class="pull-left text-label"><label for="car">@lang('website.car_no')：</label></div>
                            <div class="pull-left"><input type="text" id="car" name="car" class="form-control input-sm" value="" maxlength="10" size="10"></div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left text-label"><label for="type">@lang('website.car_type')：</label></div>
                            <div class="pull-left">
                                <select name="type" id="type" class="form-control input-sm">
                                    <option value="">@lang('website.all')</option>
                                    <option value="">調度車</option>
                                    <option value="">機車</option>
                                </select>
                            </div>
                            <div class="pull-left"><button type="submit" class="btn btn-default"><span class="fa fa-search"></span> @lang('website.btn_search')</button></div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </header>
            <div class="main-box-body clearfix">
                <div class="table-responsive">
                    <div class="list-btn-div"></div>
                    <table id="list-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>@lang('website.car_no')</th>
                                <th>@lang('website.car_type')</th>
                                <th>@lang('website.now_status')</th>
                                <th>@lang('website.locate_time')</th>
                                <th>@lang('website.gps_lat')</th>
                                <th>@lang('website.gps_lon')</th>
                                <th>@lang('website.gps_height')</th>
                                <th>@lang('website.battery_capacity')(mv)</th>
                                <th>@lang('website.speed')(Km/h)</th>
                                <th>@lang('website.direction')</th>
                                <th>@lang('website.now_locate')</th>
                                <th>@lang('website.satellite_num')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($aInfo) > 0)
                                @foreach ($aInfo as $aVal)
                                <tr>
                                    <td>{{$aVal['']}}</td>
                                    <td>{{$aVal['']}}</td>
                                    <td>{{$aVal['']}}</td>
                                    <td>{{$aVal['']}}</td>
                                    <td>{{$aVal['']}}</td>
                                    <td>{{$aVal['']}}</td>
                                    <td>{{$aVal['']}}</td>
                                    <td>{{$aVal['']}}</td>
                                    <td>{{$aVal['']}}</td>
                                    <td>{{$aVal['']}}</td>
                                    <td>{{$aVal['']}}</td>
                                    <td>{{$aVal['']}}</td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <!--
                                <td colspan="12" class="text-center">@lang('website.no_data')</td>
                                -->
                                <td>ABV-0001</td>
                                <td>調度車</td>
                                <td class="text-center text-danger">靜止</td>
                                <td class="text-center">2015-11-09 08:05:55</td>
                                <td class="text-right">25.06844</td>
                                <td class="text-right">121.537461</td>
                                <td class="text-right">34</td>
                                <td class="text-right">28490</td>
                                <td class="text-right">1.0556</td>
                                <td>194(N)</td>
                                <td>3D定位</td>
                                <td class="text-right">8</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
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
@endsection