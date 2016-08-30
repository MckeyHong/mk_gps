@extends('layouts.main')

@section('css_self')
<link href="{{ asset('css/Car/CheckSet.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
                <div class="filter-block pull-right">
                    <div class="form-group pull-left list-search-block">
                        <form id="search-form" method="GET">
                            <div class="pull-left text-label"><label for="brand">@lang('website.car_brand')：</label></div>
                            <div class="pull-left">
                                <select id="brand" name="brand" class="form-control">
                                    <option value="">@lang('website.all')</option>
                                    @foreach ($aBrand as $sBrand)
                                    <option value="{{$sBrand}}" @if ($sBrand == $aGet['brand']) selected @endif>{{$sBrand}}</option>
                                    @endforeach
                                </select>
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
                                <th>@lang('website.car_brand')</th>
                                <th>@lang('website.check_item')</th>
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
                                    <td class="brand_name text-center">{{$aVal['brand_name']}}</td>
                                    <td class="text-center">
                                        {{ implode(',', $aVal['check_item'])}}
                                        <div class="check_item hidden">
                                        @foreach ($aVal['check_item'] as $sItem)
                                            <div class="add-item">
                                                <div class="pull-left"><input type="text" class="form-control" name="item[]" maxlength="60" size="60" value="{{$sItem}}"></div>
                                                <div class="pull-left">&nbsp;</div>
                                                <div class="pull-left"><button type="button" class="btn btn-danger btn-xs btn-del-item" title="@lang('website.btn_delete')"><span class="fa fa-times"></span></button></div>
                                                <div class="clearfix"></div>
                                            </div>
                                        @endforeach
                                        </div>
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
                                            @lang('website.car_brand')：{{$aVal['brand_name']}}<br />
                                        </div>
                                    </td>
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
                    <label for="brand_name"><span class="text-danger">*</span>@lang('website.car_brand')</label>
                    <input type="text" class="form-control" id="brand_name" name="brand_name" maxlength="20" size="20">
                </div>
                <div class="form-group">
                    <label for="brand_name"><span class="text-danger">*</span>@lang('website.check_item')</label>
                    <button type="button" id="btn-add" class="btn btn-success btn-xs" title="@lang('website.btn_add')"><span class="fa fa-plus-circle"></span></button>
                </div>
                <div id="copy_item" class="hidden">
                    <div class="add-item">
                        <div class="pull-left"><input type="text" class="form-control" name="item[]" maxlength="60" size="60"></div>
                        <div class="pull-left">&nbsp;</div>
                        <div class="pull-left"><button type="button" class="btn btn-danger btn-xs btn-del-item" title="@lang('website.btn_delete')"><span class="fa fa-times"></span></button></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div id="item-list" class="form-group"></div>
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
var del_msg_multi = '@lang('website.js_del_msg_multi')', del_msg = '@lang('website.js_del_msg')', error_del = '@lang('error.select_del_empty')', title_add = '@lang('website.detail_add')', title_edit = '@lang('website.detail_edit')', error_brand = '@lang('error.car_brand_empty')', error_item = '@lang('error.check_item_empty')';
</script>
<script src="{{ asset('js/Car/CheckSet.js') }}"></script>
@endsection