@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
                <div class="filter-block pull-right">
                    <div class="form-group pull-left list-search-block">
                        <form id="search-form" method="GET">
                            <div class="pull-left">
                                <div class="pull-left text-label"><label for="date">@lang('website.date')：</label></div>
                                <div class="pull-left">
                                    <input type="text" name="date" id="date" class="form-control datepicker" value="{{$aGet['date']}}" maxlength="10" size="10" />
                                </div>
                            </div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left">
                                <div class="pull-left text-label"><label for="car">@lang('website.car_no')：</label></div>
                                <div class="pull-left">
                                    <input type="text" name="car" id="car" class="form-control" value="{{$aGet['car']}}" maxlength="20" size="20" />
                                </div>
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
                    <table id="list-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>@lang('website.abnormal_time')</th>
                                <th>@lang('website.car_no')</th>
                                <th>@lang('website.car_brand')</th>
                                <th>@lang('website.abnormal_item')</th>
                                <th>@lang('website.abnormal_photo')</th>
                                <th>@lang('website.staff_no')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($aInfo) > 0)
                                @foreach ($aInfo as $aVal)
                                <tr>
                                    <td class="time text-center">{{ date('Y-m-d H:i:s', $aVal['create_date'])}}</td>
                                    <td class="car_no text-center">{{$aVal['car_no']}}</td>
                                    <td class="text-center">{{$aVal['brand_name']}}</td>
                                    <td class="item text-center">{{$aVal['check_item']}}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-xs btn-photo" title="@lang('website.abnormal_photo')">
                                            <span class="fa fa-photo"></span>
                                        </button>
                                        <div class="photo hidden"><img src="{{$aVal['check_img']}}" class="img-responsive img-thumbnail" alt="{{$aVal['check_item']}}"></div>
                                        <div class="title hidden">@lang('website.car_no')：{{$aVal['car_no']}}</div>
                                        <div class="remark hidden">{{$aVal['check_remark']}}</div>
                                    </td>
                                    <td class="text-center">{{$aVal['create_user_no']}}</td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="6" class="text-center">@lang('website.no_data')</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @if (count($aInfo) > 0)
                <div>
                    <div class="pagination-count pull-left">
                        @lang('website.data_count')：<span id="list-count">{{$aInfo->total()}}</span>
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
{{-- 異常照片 --}}
<div class="modal fade" id="DetailModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="@lang('website.close')"><span>&times;</span></button>
                <h4 id="info-title" class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>@lang('website.abnormal_time')：<span id="info-time"></span></label>
                </div>
                <div class="form-group">
                    <label>@lang('website.abnormal_item')</label>
                    <div id="info-item"></div>
                </div>
                <div class="form-group">
                    <label>@lang('website.abnormal_photo')</label>
                    <div id="info-photo" class="text-center"></div>
                </div>
                <div class="form-group">
                    <label>@lang('website.remark')</label>
                    <div id="info-remark"></div>
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
<script src="{{ asset("vendor/i18n/datepicker-".App::getLocale().".js") }}"></script>
<script>
var aInfo = ['title', 'time', 'photo', 'item', 'remark'];
</script>
<script src="{{ asset('js/Car/CheckAbnormal.js') }}"></script>
@endsection