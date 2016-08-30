@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
                <div class="filter-block pull-right">
                    <div class="form-group pull-left list-search-block">
                        <form id="search-form" method="GET">
                            <div class="pull-left text-label"><label for="car">@lang('website.staff_no')：</label></div>
                            <div class="pull-left"><input type="text" id="car" name="car" class="form-control input-sm" value="" maxlength="10" size="10"></div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left text-label"><label for="car">@lang('website.car_no')：</label></div>
                            <div class="pull-left"><input type="text" id="car" name="car" class="form-control input-sm" value="" maxlength="10" size="10"></div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left text-label"><label for="car">@lang('website.belong_dept')：</label></div>
                            <div class="pull-left">
                                <select name="city" id="city" class="form-control input-sm">
                                    <option value="">@lang('website.all')</option>
                                    <option value="">台北市 > 信義區 > 維護組 > 維修工程師</option>
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
                                <th>@lang('website.belong_dept')</th>
                                <th>@lang('website.staff_no')</th>
                                <th>@lang('website.staff_name')</th>
                                <th>@lang('website.car_no')</th>
                                <th>@lang('website.staff_status')</th>
                                <th>@lang('website.station_no')</th>
                                <th>@lang('website.station_name')</th>
                                <th>@lang('website.work_status')</th>
                                <th>@lang('website.station_no')</th>
                                <th>@lang('website.station_name')</th>
                                <th>@lang('website.work_status')</th>
                                <th>@lang('website.arrive_time')</th>
                                <th>@lang('website.leave_time')</th>
                                <th>@lang('website.upload_photo')</th>
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
                                <td>台北市 > 信義區 > 維護組 > 維修工程師</td>
                                <td>09111</td>
                                <td>jeff</td>
                                <td>ABV-0001</td>
                                <td>調度</td>
                                <td>0001</td>
                                <td>台北市政府</td>
                                <td>調出</td>
                                <td>0001</td>
                                <td>台北市政府</td>
                                <td>綁車</td>
                                <td class="text-center">2015-11-09 08:05:55</td>
                                <td class="text-center">2015-11-09 08:30:22</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary btn-xs"  data-toggle="modal" data-target="#photoModal">
                                        <span class="fa fa-photo"></span>
                                    </button>
                                </td>
                                <td class="text-center">2015-11-09 08:30:22</td>
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
{{-- 新增車輛保修紀錄 --}}
<div class="modal fade" id="photoModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="@lang('website.close')"><span>&times;</span></button>
                <h4 class="modal-title">@lang('website.upload_photo')</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="pull-left">@lang('website.arrive_time')：2015-11-09 08:05:55</div>
                    <div class="pull-right">@lang('website.leave_time')：2015-11-09 08:30:22</div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <img src="http://static.ettoday.net/images/431/d431939.jpg" alt="..." class="img-responsive img-rounded" style="50%">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('website.colse')</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js_self')
@endsection