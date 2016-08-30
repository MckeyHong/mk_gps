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
                                <div class="pull-left text-label"><label for="rope">@lang('website.rope_no')：</label></div>
                                <div class="pull-left">
                                    <input type="text" id="rope" name="rope" class="form-control" value="{{$aGet['rope']}}" maxlength="20" size="20">
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
                        <input type="button" id="btn-all-return" class="btn btn-warning input-sm" value="@lang('website.btn_rope_back')" />
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
                                <th>@lang('website.city')</th>
                                <th>@lang('website.rope_no')</th>
                                <th>@lang('website.status')</th>
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
                                    <td class="city_name text-center">{{$aVal['city_name']}}<span class="city hidden">{{$aVal['city']}}</span></td>
                                    <td class="rope_no text-center">{{$aVal['rope_no']}}</td>
                                    <td class="text-center" title="{{$aVal['staff_info']}}">{{$aVal['status_name']}}</td>
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
                                            @lang('website.city')：{{$aVal['city_name']}}<br />
                                            @lang('website.rope_no')：{{$aVal['rope_no']}}<br />
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
                    <label for="city"><span class="text-danger">*</span>@lang('website.city')</label>
                    <select id="city" name="city" class="form-control">
                        <option value="">@lang('website.pls_select')</option>
                        @foreach ($aCity as $sCity)
                        <option value="{{$sCity}}">@lang('website.city_'.$sCity)</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="rope_no"><span class="text-danger">*</span>@lang('website.rope_no')</label>
                    <input type="text" class="form-control" id="rope_no" name="rope_no" maxlength="20" size="20">
                </div>
            </div>
            <div class="modal-footer">
                {!! csrf_field() !!}
                <input type="hidden" id="_method" name="_method" value="">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="city_name" id="city_name">
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
var return_msg_multi = '@lang('website.js_return_msg_multi')', del_msg_multi = '@lang('website.js_del_msg_multi')', del_msg = '@lang('website.js_del_msg')', error_del = '@lang('error.select_del_empty')', title_add = '@lang('website.detail_add')', title_edit = '@lang('website.detail_edit')', error_return = '@lang('error.select_return_empty')';
var aColumn = ['city', 'rope_no'], aError = ['@lang('error.city_name_empty')', '@lang('error.rope_no_empty')'];
var default_city = '{{$aGet['c']}}';
</script>
<script src="{{ asset('js/Work/Rope.js') }}"></script>
@endsection