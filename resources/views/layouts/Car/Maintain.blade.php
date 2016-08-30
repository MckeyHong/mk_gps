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
                            <div class="pull-left text-label"><label for="city">@lang('website.city')：</label></div>
                            <div class="pull-left">
                                <select name="city" id="city" class="form-control input-sm">
                                    <option value="">@lang('website.all')</option>
                                    <option value="">台北市</option>
                                    <option value="">新北市</option>
                                </select>
                            </div>
                            <div class="pull-left text-label">、</div>
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
                    <div class="pull-right">
                        <a data-toggle="modal" data-target="#AddMaintain" class="btn btn-primary">
                            <i class="fa fa-plus-circle fa-lg"></i> @lang('website.btn_add_maintain')
                        </a>
                    </div>
                    <div class="pull-right">
                        <a data-toggle="modal" data-target="#AddCar" class="btn btn-primary">
                            <i class="fa fa-plus-circle fa-lg"></i> @lang('website.btn_add_car')
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
                                <th>@lang('website.car_no')</th>
                                <th>@lang('website.car_type')</th>
                                <th>@lang('website.city')</th>
                                <th>@lang('website.mileage_total')(KM)</th>
                                <th>@lang('website.top_up_total')(gal)</th>
                                <th>@lang('website.last_check')</th>
                                <th>@lang('website.buy_date')</th>
                                <th>@lang('website.open_date')</th>
                                <th>@lang('website.estimate_check')</th>
                                <th>@lang('website.production_yearly')</th>
                                <th>@lang('website.check_total_fee')</th>
                                <th>@lang('website.check_detail')</th>
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
                                <td>ABV-0001</td>
                                <td>調度車</td>
                                <td>台北市</td>
                                <td class="text-right">3200</td>
                                <td class="text-right">600</td>
                                <td class="text-center">2015-11-09</td>
                                <td class="text-center">2015-05-01</td>
                                <td class="text-center">2015-05-01</td>
                                <td class="text-center">2015-12-09</td>
                                <td class="text-center">2015</td>
                                <td class="text-right">28000</td>
                                <td class="text-center">
                                    <span class="label label-info link-pointer" onclick="document.location.href='{{Request::url()}}/Detail/5632e4762081a9e0458b4567';">@lang('website.detail')</span>
                                </td>
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
<div class="modal fade" id="AddMaintain">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="@lang('website.close')"><span>&times;</span></button>
                <h4 class="modal-title">@lang('website.detail_add')</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="car_no">@lang('website.car_no')</label>
                    <input type="text" name="car_no" id="car_no" class="form-control">
                </div>
                <div class="form-group">
                    <div class="col-md-8 pull-left">
                        <label for="parts_name">@lang('website.parts_name')</label>
                        <input type="text" name="parts_name" id="parts_name" class="form-control">
                    </div>
                    <div class="col-md-2 pull-left">
                        <label for="unit">@lang('website.unit')</label>
                        <select id="unit" name="unit" class="form-control">
                            <option value="">請選擇</option>
                            <option value="">個</option>
                            <option value="">片</option>
                        </select>
                    </div>
                    <div class="col-md-2 pull-left">
                        <label>&nbsp;</label>
                        <a id="btn-add-unit" class="btn btn-primary btn-xs">
                            <i class="fa fa-plus-circle fa-lg"></i> @lang('website.btn_add_unit')
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <div class="pull-left">
                        <label for="price">@lang('website.price')</label>
                        <input type="text" name="price" id="price" class="form-control">
                    </div>
                    <div class="pull-left add-symbol"> x </div>
                    <div class="pull-left">
                        <label for="quantity">@lang('website.quantity')</label>
                        <input type="text" name="quantity" id="quantity" class="form-control">
                    </div>
                    <div class="pull-left add-symbol"> = </div>
                    <div class="pull-left">
                        <label for="sum">@lang('website.sum')</label>
                        <div>0</div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 pull-left">
                        <label for="check_date">@lang('website.check_date')</label>
                        <input type="text" name="check_date" id="check_date" class="form-control datepicker">
                    </div>
                    <div class="col-md-6 pull-left">
                        <label for="check_staff">@lang('website.check_staff')</label>
                        <input type="text" name="check_staff" id="check_staff" class="form-control">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label for="check_mileage">@lang('website.check_mileage')</label>
                    <input type="text" name="check_mileage" id="check_mileage" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('website.colse')</button>
            </div>
        </div>
    </div>
</div>
{{-- 新增車輛資訊 --}}
<div class="modal fade" id="AddCar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="@lang('website.close')"><span>&times;</span></button>
                <h4 class="modal-title">@lang('website.detail_add')</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="car_no">@lang('website.car_no')</label>
                    <input type="text" name="car_no" id="car_no" class="form-control">
                </div>
                <div class="form-group">
                    <div class="col-md-6 pull-left">
                        <label for="mileage">@lang('website.mileage')</label>
                        <input type="text" name="mileage" id="mileage" class="form-control">
                    </div>
                    <div class="col-md-6 pull-left">
                        <label for="top_up">@lang('website.top_up')</label>
                        <input type="text" name="top_up" id="top_up" class="form-control">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 pull-left">
                        <label for="buy_date">@lang('website.buy_date')</label>
                        <input type="text" name="buy_date" id="buy_date" class="form-control datepicker">
                    </div>
                    <div class="col-md-6 pull-left">
                        <label for="open_date">@lang('website.open_date')</label>
                        <input type="text" name="open_date" id="open_date" class="form-control datepicker">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 pull-left">
                        <label for="estimate_check">@lang('website.estimate_check')</label>
                        <input type="text" name="estimate_check" id="estimate_check" class="form-control datepicker">
                    </div>
                    <div class="col-md-6 pull-left">
                        <label for="production_yearly">@lang('website.production_yearly')</label>
                        <input type="text" name="production_yearly" id="production_yearly" class="form-control">
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('website.colse')</button>
            </div>
        </div>
    </div>
</div>
{{-- 新增單位 --}}
<div id="add-unit-div" class="hidden">
    <div class="form-group">
        <label for="unit">@lang('website.unit')</label>
        <input type="text" name="unit" id="unit" class="form-control">
    </div>
</div>
@endsection

@section('js_self')
<script>
$(function () {
    $('#btn-add-unit').click(function () {
        $.confirm({
            title: '@lang('website.detail_add')',
            message : $('#add-unit-div').html()
        });
    });
});
</script>
@endsection