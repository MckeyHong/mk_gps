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
                <div>
                    <div class="pull-left">
                        <h4>車輛號碼：ABV-0001 (調度車 - 台北市)</h4>
                    </div>
                    <div class="filter-block pull-right">
                        <a href="{{Request::root()}}/Car/Maintain" class="btn btn-warning">
                            <i class="fa fa-arrow-circle-left fa-lg"></i> @lang('website.btn_back')
                        </a>
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
                                <th>@lang('website.item')</th>
                                <th>@lang('website.unit')</th>
                                <th>@lang('website.parts_name')</th>
                                <th>@lang('website.quantity')</th>
                                <th>@lang('website.price')</th>
                                <th>@lang('website.sum')</th>
                                <th>@lang('website.check_date')</th>
                                <th>@lang('website.check_staff')</th>
                                <th>@lang('website.check_mileage')(KM)</th>
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
                                <td colspan="8" class="text-center">@lang('website.no_data')</td>
                                -->
                                <td>1</td>
                                <td>罐</td>
                                <td>機油5W30</td>
                                <td class="text-right">4</td>
                                <td class="text-right">200</td>
                                <td class="text-right">800</td>
                                <td>2015-05-11</td>
                                <td>jeff</td>
                                <td>4000</td>
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