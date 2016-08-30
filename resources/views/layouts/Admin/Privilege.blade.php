@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
                <div class="filter-block pull-right">
                    <div class="form-group pull-left list-search-block">
                        <form id="search-form" method="GET">
                            <div class="pull-left text-label"><label for="role">@lang('website.role_name')：</label></div>
                            <div class="pull-left"><input type="text" id="role" name="role" class="form-control input-sm" value="{{$aGet['role']}}" maxlength="20" size="20"></div>
                            <div class="pull-left"><button type="submit" class="btn btn-default input-xs"><span class="fa fa-search"></span> @lang('website.btn_search')</button></div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="pull-right">
                        <a href="{{Request::url()}}/Add" class="btn btn-primary input-xs">
                            <i class="fa fa-plus-circle fa-lg"></i> @lang('website.btn_add')
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </header>
            <div class="main-box-body clearfix">
                <div class="table-responsive">
                    <div class="list-btn-div">
                        <input type="button" id="btn-all-delete" class="btn btn-danger input-xs" value="@lang('website.btn_delete')" />
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
                                <th>@lang('website.role_name')</th>
                                <th>@lang('website.create_date')</th>
                                <th>@lang('website.modify_date')</th>
                                <th>@lang('website.setting')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($aInfo) > 0)
                                @foreach ($aInfo as $aVal)
                                <tr>
                                    <td class="text-center">
                                         <div class="checkbox-nice">
                                            <input type="checkbox" name="chkDel" id="chk-{{$aVal['_id']}}" data-id="{{$aVal['_id']}}" class="list-checkbox">
                                            <label for="chk-{{$aVal['_id']}}"></label>
                                        </div>
                                    </td>
                                    <td class="role_name text-center">{{$aVal['role_name']}}</td>
                                    <td class="text-center">{{date('Y-m-d H:i:s', $aVal['create_date'])}}</td>
                                    <td class="text-center">{{date('Y-m-d H:i:s', $aVal['modify_date'])}}</td>
                                    <td class="text-center">
                                        <a href="{{Request::url()}}/Edit/{{$aVal['_id']}}" class="table-link" title="@lang('website.btn_edit')">
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
                                            @lang('website.role_name')：{{$aVal['role_name']}}<br />
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
{!! csrf_field() !!}
@endsection

@section('js_self')
<script>
var del_msg_multi = '@lang('website.js_del_msg_multi')', del_msg = '@lang('website.js_del_msg')', error_del = '@lang('error.select_del_empty')';
</script>
<script src="{{ asset("js/Admin/Privilege.js") }}"></script>
@endsection