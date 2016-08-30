@extends('layouts.main')

@section('css_self')
<link href="{{ asset("vendor/jquery-ui-timepicker/jquery-ui-timepicker.css") }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
                <div class="filter-block">
                    <div class="form-group pull-left list-search-block">
                        <form id="search-form" method="GET">
                            <div class="pull-left">
                                <div class="pull-left text-label"><label for="city">@lang('website.city')：</label></div>
                                <div class="pull-left">
                                    <select name="city" id="city" class="form-control input-sm">
                                        <option value="">@lang('website.all')</option>
                                        @foreach ($aCity as $sCity)
                                        <option value="{{$sCity}}" @if ($sCity == $aGet['city']) selected @endif>{{$sCity}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left">
                                <div class="pull-left text-label"><label for="car">@lang('website.car_no')：</label></div>
                                <div class="pull-left"><input type="text" id="car" name="car" class="form-control input-sm" value="{{$aGet['car']}}" maxlength="20" size="20"></div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left">
                                <div class="pull-left text-label"><label for="start">@lang('website.time')：</label></div>
                                <div class="pull-left">
                                    <input type="text" id="start" name="start" class="form-control datepicker" value="{{$aGet['start']}}" maxlength="10" size="10">
                                </div>
                                <div class="pull-left text-label">~&nbsp;</div>
                                <div class="pull-left">
                                    <input type="text" id="end" name="end" class="form-control datepicker" value="{{$aGet['end']}}" maxlength="10" size="10">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="pull-left"><button type="submit" class="btn btn-default"><span class="fa fa-search"></span> @lang('website.btn_search')</button></div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-success btn-export" download><i class="fa fa-download fa-lg"></i> @lang('website.btn_export_excel')</a>
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
                                <th>@lang('website.time')</th>
                                <th>@lang('website.city')</th>
                                <th>@lang('website.car_no')</th>
                                <th>@lang('website.staff_no')</th>
                                <th>@lang('website.carry_num')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($aInfo) > 0)
                                @foreach ($aInfo as $aVal)
                                <tr>
                                    <td class="text-center">{{$aVal['create_date']}}</td>
                                    <td class="text-center">{{$aVal['city_name']}}</td>
                                    <td class="text-center">{{$aVal['car_no']}}</td>
                                    <td class="text-center">{{$aVal['staff_info']}}</td>
                                    <td class="text-center">{{$aVal['carry_num']}}</td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="text-center">@lang('website.no_data')</td>
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
<script src="{{ asset("vendor/i18n/datepicker-".App::getLocale().".js") }}"></script>
<script src="{{ asset("js/Record/BikeCarry.js") }}"></script>
@endsection