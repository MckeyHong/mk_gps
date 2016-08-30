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
                                <div class="pull-left text-label"><label for="no">@lang('website.gps_no')：</label></div>
                                <div class="pull-left">
                                    <input type="text" id="no" name="no" class="form-control" value="{{$aGet['no']}}" maxlength="20" size="20">
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
                                    <td class="gps_no text-center">{{$aVal['gps_no']}}</td>
                                    <td class="cellphone text-center">{{$aVal['cellphone']}}</td>
                                    <td class="cellphone_provider text-center">{{$aVal['cellphone_provider']}}</td>
                                    <td class="text-center">
                                        <span class="city_name">@lang('website.city_'.$aVal['city'])</span>
                                        <span class="city hidden">{{$aVal['city']}}</span>
                                        </td>
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
                                            @lang('website.gps_no')：<span class="del_gps_no">{{$aVal['gps_no']}}</span><br />
                                            @lang('website.gps_phone')：<span class="del_cellphone">{{$aVal['cellphone']}}</span><br />
                                            @lang('website.gps_phone_provider')：<span class="del_cellphone_provider">{{$aVal['cellphone_provider']}}</span>
                                        </div>
                                    </td>
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
                    <label for="gps_no"><span class="text-danger">*</span>@lang('website.gps_no')</label>
                    <input type="text" class="form-control" id="gps_no" name="gps_no" maxlength="20" size="20">
                </div>
                <div class="form-group">
                    <label for="cellphone"><span class="text-danger">*</span>@lang('website.gps_phone')</label>
                    <input type="text" class="form-control" id="cellphone" name="cellphone" maxlength="20" size="20">
                </div>
                <div class="form-group">
                    <label for="cellphone_provider"><span class="text-danger">*</span>@lang('website.gps_phone_provider')</label>
                    <input type="text" class="form-control" id="cellphone_provider" name="cellphone_provider" maxlength="20" size="20">
                </div>
                <div class="form-group">
                    <label for="city"><span class="text-danger">*</span>@lang('website.city')</label>
                    <select id="city" name="city" class="form-control">
                        <option value="">@lang('website.pls_select')</option>
                        @foreach ($aCity as $sCity)
                        <option value="{{$sCity}}">@lang('website.city_'.$sCity)</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                {!! csrf_field() !!}
                <input type="hidden" id="_method" name="_method" value="">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="_redirect" id="_redirect" value="{!!Request::fullUrl()!!}">
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
var aColumn = ['gps_no', 'cellphone', 'cellphone_provider', 'city'], aError = ['@lang('error.gps_no_empty')', '@lang('error.gps_phone_empty')', '@lang('error.phone_provider_empty')', '@lang('error.city_name_empty')'];
var default_city = '{{$aGet['c']}}';
</script>
<script src="{{ asset('js/Gps/Set.js') }}"></script>
@endsection