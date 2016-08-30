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
                                <div class="pull-left text-label"><label for="gps">@lang('website.gps_no')：</label></div>
                                <div class="pull-left">
                                    <input type="text" id="gps" name="gps" class="form-control" value="{{$aGet['gps']}}" maxlength="20" size="20">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left">
                                <div class="pull-left text-label"><label for="">@lang('website.city')：</label></div>
                                <div class="pull-left">
                                    <select name="c" id="c" class="form-control input-sm">
                                        <option value="">@lang('website.all')</option>
                                        @foreach ($aCity as $sCity)
                                        <option value="{{$sCity}}" @if ($sCity == $aGet['c']) selected @endif>@lang('website.city_'.$sCity)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left">
                                <div class="pull-left text-label"><label for="car">@lang('website.car_no')：</label></div>
                                <div class="pull-left">
                                    <input type="text" id="car" name="car" class="form-control" value="{{$aGet['car']}}" maxlength="20" size="20">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left">
                                <div class="pull-left text-label"><label for="type">@lang('website.car_type')：</label></div>
                                <div class="pull-left">
                                    <select id="type" name="type" class="form-control">
                                        <option value="">@lang('website.all')</option>
                                        @foreach ($aCarType as $iKey => $sVal)
                                            <option value="{{$iKey}}" @if ($iKey == $aGet['type']) selected @endif>{{$sVal}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="pull-left"><button type="submit" class="btn btn-default"><span class="fa fa-search"></span> @lang('website.btn_search')</button></div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="pull-right">
                        <a  id="btn-add" class="btn btn-primary">
                            <i class="fa fa-plus-circle fa-lg"></i> @lang('website.btn_add')
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </header>
            <div class="main-box-body clearfix">
                <div class="table-responsive">
                    <div class="list-btn-div">
                        <input type="button" id="btn-all-delete" class="btn btn-danger input-sm" value="@lang('website.btn_delete')" />
                    </div>
                    <table id="list-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <div class="checkbox-nice">
                                        <input type="checkbox" id="chk-all">
                                        <label for="chk-all"></label>
                                    </div>
                                </th>
                                <th>@lang('website.gps_no')</th>
                                <th>@lang('website.gps_phone')</th>
                                <th>@lang('website.gps_phone_provider')</th>
                                <th>@lang('website.city')</th>
                                <th>@lang('website.car_no')</th>
                                <th>@lang('website.car_type')</th>
                                <th>@lang('website.setting')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($aInfo) > 0)
                                @foreach ($aInfo as $aVal)
                                <tr class="tr-{{$aVal['_id']}}">
                                    <td class="text-center">
                                         <div class="checkbox-nice">
                                            <input type="checkbox" name="chkDel" id="chk-{{$aVal['_id']}}" data-id="{{$aVal['_id']}}" class="list-checkbox">
                                            <label for="chk-{{$aVal['_id']}}"></label>
                                        </div>
                                    </td>
                                    <td class="gps_no text-center" data-id="{{$aVal['gps_id']}}">{{$aVal['gps_no']}}</td>
                                    <td class="phone text-center">{{$aVal['cellphone']}}</td>
                                    <td class="provider text-center">{{$aVal['cellphone_provider']}}</td>
                                    <td class="city text-center">@lang('website.city_'.$aVal['city'])</td>
                                    <td class="car_no text-center">{{$aVal['car_no']}}</td>
                                    <td class="text-center">{{$aVal['car_type']}}</td>
                                    <td class="text-center">
                                        <a class="table-link btn-edit" data-id="{{$aVal['_id']}}" title="@lang('website.btn_edit')">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                        <a class="table-link btn-delete danger"  data-id="{{$aVal['_id']}}" title="@lang('website.btn_delete')">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                        <div class="hidden del_message">
                                            <br />
                                            @lang('website.gps_no')：{{$aVal['gps_no']}}<br />
                                            @lang('website.car_no')：{{$aVal['car_no']}}<br />
                                        </div>
                                        <span class="car_type_id hidden">{{$aVal['car_type_id']}}</span>
                                        <span class="car_brand_id hidden">{{$aVal['car_brand_id']}}</span>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="8" class="text-center">@lang('website.no_data')</td>
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
{{-- 資料新增/編輯 --}}
<div class="modal fade" id="DetailModal">
    <div class="modal-dialog">
        <form name="data-form" id="data-form" method="post">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="@lang('website.close')"><span>&times;</span></button>
                <h4 id="modal-title" class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="car_no"><span class="text-danger">*</span>@lang('website.car_no')</label>
                    <input type="text" class="form-control" id="car_no" name="car_no" maxlength="20" size="20">
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="car_type_id"><span class="text-danger">*</span>@lang('website.car_type')</label>
                        <select id="car_type_id" name="car_type_id" class="form-control">
                            <option value="">@lang('website.pls_select')</option>
                            @foreach ($aCarType as $iKey => $sVal)
                            <option value="{{$iKey}}">{{$sVal}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="car_brand_id"><span class="text-danger">*</span>@lang('website.car_brand')</label>
                        <select id="car_brand_id" name="car_brand_id" class="form-control">
                            <option value="">@lang('website.pls_select')</option>
                            @foreach ($aCarBrand as $iKey => $sVal)
                            <option value="{{$iKey}}">{{$sVal}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label for="gps_id"><span class="text-danger">*</span>@lang('website.gps_no')</label>
                    <select id="gps_id" name="gps_id" class="form-control">
                        <option value="">@lang('website.pls_select')</option>
                        @foreach ($aGPS as $aVal)
                        <option value="{{$aVal['_id']}}" data-phone="{{$aVal['cellphone']}}" data-provider="{{$aVal['cellphone_provider']}}" data-city="@lang('website.city_'.$aVal['city'])">{{$aVal['gps_no']}}</option>
                        @endforeach
                    </select>
                    <select id="gps_default" name="gps_default" class="form-control hidden">
                        <option value="">@lang('website.pls_select')</option>
                        @foreach ($aGPS as $aVal)
                        <option value="{{$aVal['_id']}}" data-phone="{{$aVal['cellphone']}}" data-provider="{{$aVal['cellphone_provider']}}" data-city="@lang('website.city_'.$aVal['city'])">{{$aVal['gps_no']}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="14%">@lang('website.gps_phone')</th>
                                <td><span id="info_phone"></span></td>
                                <th width="14%">@lang('website.gps_phone_provider')</th>
                                <td><span id="info_provider"></span></td>
                                <th width="8%">@lang('website.city')</th>
                                <td><span id="info_city"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                {!! csrf_field() !!}
                <input type="hidden" id="_method" name="_method" value="">
                <input type="hidden" name="id" id="id">
                <button type="submit" class="btn btn-primary">@lang('website.btn_submit')</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">@lang('website.btn_cancel')</button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection

@section('js_self')
<script>
var del_msg_multi = '@lang('website.js_del_msg_multi')', del_msg = '@lang('website.js_del_msg')', error_del = '@lang('error.select_del_empty')', title_add = '@lang('website.detail_add')', title_edit = '@lang('website.detail_edit')';
var aColumn = ['car_no', 'car_type_id', 'car_brand_id', 'gps_id'], aGpsItem = ['phone', 'provider', 'city'];
var aError = ['@lang('error.car_no_empty')', '@lang('error.car_type_empty')', '@lang('error.car_brand_empty')', '@lang('error.gps_no_empty')'];
</script>
<script src="{{ asset('js/Gps/Car.js') }}"></script>
@endsection