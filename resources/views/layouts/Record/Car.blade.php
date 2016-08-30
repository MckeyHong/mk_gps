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
                                <div class="pull-left text-label"><label for="no">@lang('website.city')：</label></div>
                                <div class="pull-left">
                                    <select id="" name="" class="form-control">
                                        <option value="">全部</option>
                                        <option value="">台北市</option>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left">
                                <div class="pull-left text-label"><label for="no">@lang('website.staff_no')：</label></div>
                                <div class="pull-left"><input type="text" id="no" name="no" class="form-control input-sm" value="" maxlength="15" size="13"></div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left">
                                <div class="pull-left text-label"><label for="car">@lang('website.car_no')：</label></div>
                                <div class="pull-left"><input type="text" id="car" name="car" class="form-control input-sm" value="" maxlength="10" size="9"></div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left">
                                <div class="pull-left text-label"><label for="no">@lang('website.car_type')：</label></div>
                                <div class="pull-left">
                                    <select id="" name="" class="form-control">
                                        <option value="">全部</option>
                                        <option value="">調度車</option>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
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
                            <div class="pull-right">
                                <a class="btn btn-success"><i class="fa fa-download fa-lg"></i> @lang('website.btn_export_excel')</a>
                            </div>
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
                                <th>@lang('website.city')</th>
                                <th>@lang('website.car_no')</th>
                                <th>@lang('website.staff_no')</th>
                                <th>@lang('website.staff_name')</th>
                                <th>@lang('website.carry_num')</th>
                                <th>@lang('website.car_total_mileage')(KM)</th>
                                <th>@lang('website.time')</th>

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
                                <td colspan="6" class="text-center">@lang('website.no_data')</td>
                                -->
                                <td>台北市</td>
                                <td>ABV-0001</td>
                                <td>09111</td>
                                <td>jeff</td>
                                <td class="text-right">20</td>
                                <td class="text-right">100</td>
                                <td class="text-center">2015-11-05 09:55:12</td>
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