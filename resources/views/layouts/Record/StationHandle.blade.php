@extends('layouts.main')

@section('css_self')
<link href="{{ asset("vendor/jquery-ui-timepicker/jquery-ui-timepicker.css") }}" rel="stylesheet">
@endsection

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
                            <div class="pull-left text-label"><label for="car">@lang('website.station_no')：</label></div>
                            <div class="pull-left"><input type="text" id="car" name="car" class="form-control input-sm" value="" maxlength="10" size="8"></div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left">
                                <div class="pull-left text-label"><label for="type">@lang('website.time')：</label></div>
                                <div class="pull-left">
                                    <input type="text" id="start_time" class="form-control" maxlength="19" size="14">
                                </div>
                                <div class="pull-left text-label"> ~ </div>
                                <div class="pull-left">
                                    <input type="text" id="end_time" class="form-control" maxlength="19" size="14">
                                </div>
                            </div>
                            <div class="pull-left"><button type="submit" class="btn btn-default"><span class="fa fa-search"></span> @lang('website.btn_search')</button></div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-success"><i class="fa fa-download fa-lg"></i> @lang('website.btn_export_excel')</a>
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
                                <th>@lang('website.handle_staff')</th>
                                <th>@lang('website.notified_staff')</th>
                                <th>@lang('website.empty_full_time')</th>
                                <th>@lang('website.accumulate_time')</th>
                                <th>@lang('website.notice_time')</th>
                                <th>@lang('website.read_time')</th>
                                <th>@lang('website.estimate_time')</th>
                                <th>@lang('website.handle_time')</th>
                                <th>@lang('website.stop_time')</th>
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
                                <td>台北市</td>
                                <td>0001</td>
                                <td>台北市市政府</td>
                                <td>A</td>
                                <td>jeff</td>
                                <td>Luke</td>
                                <td>2015-11-09 08:05:55</td>
                                <td>2'15"</td>
                                <td>2015-11-09 08:05:55</td>
                                <td>2015-11-09 08:05:55</td>
                                <td>10</td>
                                <td>2015-11-09 08:05:55</td>
                                <td>2015-11-09 08:05:55</td>
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
<script src="{{ asset("vendor/jquery-ui-timepicker/jquery-ui-timepicker.js") }}"></script>
<script src="{{ asset("vendor/i18n/datepicker-".App::getLocale().".js") }}"></script>
<script>
jQuery(document).ready(function ($) {

    $('#start_time, #end_time').restrict({reg: /^[0-9\-:\s]+$/}).datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm:ss',
        beforeShow: function () {
            setTimeout(function () {
                $('.ui-datepicker').css('z-index', 100);
            }, 0);
        }
    });
});
</script>
@endsection