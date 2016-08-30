@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
                <div class="filter-block pull-right">
                    <div class="form-group pull-left list-search-block">
                        <form id="search-form" method="GET">
                            <div class="pull-left text-label"><label for="car">@lang('website.station_city')：</label></div>
                            <div class="pull-left">
                                <select name="city" id="city" class="form-control input-sm">
                                    <option value="">@lang('website.all')</option>
                                    <option value="">台北市</option>
                                    <option value="">新北市</option>
                                </select>
                            </div>
                             <div class="pull-left text-label">、</div>
                            <div class="pull-left text-label"><label for="car">@lang('website.status')：</label></div>
                            <div class="pull-left">
                                <select name="city" id="city" class="form-control input-sm">
                                    <option value="">@lang('website.all')</option>
                                    <option value="">正常</option>
                                    <option value="">爆站</option>
                                </select>
                            </div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left text-label"><label for="car">@lang('website.station_area')：</label></div>
                            <div class="pull-left">
                                <select name="city" id="city" class="form-control input-sm">
                                    <option value="">@lang('website.all')</option>
                                    <option value="">A</option>
                                    <option value="">B</option>
                                </select>
                            </div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left text-label"><label for="car">@lang('website.station_no')：</label></div>
                            <div class="pull-left"><input type="text" id="car" name="car" class="form-control input-sm" value="" maxlength="10" size="10"></div>
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
                    <table id="list-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('website.station_city')</th>
                                <th>@lang('website.station_no')</th>
                                <th>@lang('website.station_name')</th>
                                <th>@lang('website.station_area')</th>
                                <th>@lang('website.parking_space_total')</th>
                                <th>@lang('website.bike_station')</th>
                                <th>@lang('website.empty_space')</th>
                                <th>@lang('website.fault_bike')</th>
                                <th>@lang('website.bike_rope')</th>
                                <th>@lang('website.rope_suggest')</th>
                                <th>@lang('website.station_suggest')</th>
                                <th>@lang('website.status')</th>
                                <th>@lang('website.in_least')</th>
                                <th>@lang('website.out_highest')</th>
                                <th>@lang('website.car_no')</th>
                                <th>@lang('website.staff_shift')</th>
                                <th>@lang('website.staff_gps')</th>
                                <th>@lang('website.staff_add')</th>
                                <th>@lang('website.update_time')</th>
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
                                <td colspan="12" class="text-center">@lang('website.no_data')</td>
                                -->
                                <td class="text-danger">台北市</td>
                                <td class="text-danger">0005</td>
                                <td class="text-danger">國父紀念館</td>
                                <td class="text-danger">A</td>
                                <td class="text-danger">100</td>
                                <td class="text-danger">100</td>
                                <td class="text-danger">0</td>
                                <td class="text-danger">0</td>
                                <td class="text-danger">10</td>
                                <td class="text-danger">20</td>
                                <td class="text-danger">20</td>
                                <td bgcolor="red"></td>
                                <td class="text-danger">30</td>
                                <td class="text-danger">50</td>
                                <td class="text-danger">ABV-0001</td>
                                <td class="text-danger">日班</td>
                                <td class="text-danger">jeff</td>
                                <td class="text-danger">2</td>
                                <td class="text-danger text-center">2015-11-09 08:05:55</td>
                            </tr>
                            <tr>
                                <!--
                                <td colspan="12" class="text-center">@lang('website.no_data')</td>
                                -->
                                <td>台北市</td>
                                <td>0001</td>
                                <td>台北市市政府</td>
                                <td>A</td>
                                <td>100</td>
                                <td>60</td>
                                <td>40</td>
                                <td>0</td>
                                <td>4</td>
                                <td>100</td>
                                <td>20</td>
                                <td bgcolor="green"></td>
                                <td>30</td>
                                <td>50</td>
                                <td>ABV-0001</td>
                                <td>日班</td>
                                <td>jeff</td>
                                <td>2</td>
                                <td class="text-center">2015-11-09 08:05:55</td>
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