@extends('layouts.main')

@section('css_self')
<link href="{{ asset('css/Admin/Dept.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
                <div class="filter-block pull-right">
                    <div class="pull-right">
                        <a class="btn btn-success" data-toggle="modal" data-target="#ExcelModal">
                            <i class="fa fa-upload fa-lg"></i> @lang('website.btn_import_excel')
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </header>
            <div class="main-box-body clearfix">
                <div class="table-responsive">
                    <table id="list-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>@lang('website.dept_head')</th>
                                <th width="20%">@lang('website.setting')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aInfo as $aVal1)
                            <tr>
                                <td>
                                    <div>{{$aVal1['dept_name']}}</div>
                                </td>
                                <td class="text-center">
                                    <a class="table-link btn-add" data-level="2" data-parent_id="{{$aVal1['_id']}}" data-parent_arr="{{$aVal1['_id']}}" data-city="{{$aVal1['city']}}" title="@lang('website.btn_add_child')">
                                        <span class="fa-stack">
                                            <i class="fa fa-square fa-stack-2x"></i>
                                            <i class="fa fa-plus-circle fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </a>
                                    <span class="dept_parent hidden">{{$aVal1['dept_name']}}</span>
                                </td>
                            </tr>
                            @foreach($aVal1['child'] as $aVal2)
                            <tr>
                                <td>
                                    <div class="dept_2">∟{{$aVal2['dept_name']}}</div>
                                </td>
                                <td class="text-center">
                                    <a class="table-link btn-add" data-level="3" data-parent_id="{{$aVal2['_id']}}" data-parent_arr="{{$aVal1['_id']}},{{$aVal2['_id']}}" data-city="{{$aVal1['city']}}" title="@lang('website.btn_add_child')">
                                        <span class="fa-stack">
                                            <i class="fa fa-square fa-stack-2x"></i>
                                            <i class="fa fa-plus-circle fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </a>
                                    <a class="table-link btn-edit" data-id="{{$aVal2['_id']}}" data-parent_id="{{$aVal1['_id']}}" data-name="{{$aVal2['dept_name']}}"  title="@lang('website.btn_edit')">
                                        <span class="fa-stack">
                                            <i class="fa fa-square fa-stack-2x"></i>
                                            <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </a>
                                    <a class="table-link btn-delete danger" data-id="{{$aVal2['_id']}}" title="@lang('website.btn_delete')">
                                        <span class="fa-stack">
                                            <i class="fa fa-square fa-stack-2x"></i>
                                            <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </a>
                                    <span class="dept_parent hidden">{{$aVal1['dept_name']}} - {{$aVal2['dept_name']}}</span>
                                </td>
                            </tr>
                            @foreach($aVal2['child'] as $aVal3)
                            <tr>
                                <td>
                                    <div class="dept_3">∟{{$aVal3['dept_name']}}</div>
                                </td>
                                <td class="text-center">
                                    <a class="table-link btn-add" data-level="4" data-parent_id="{{$aVal3['_id']}}" data-parent_arr="{{$aVal1['_id']}},{{$aVal2['_id']}},{{$aVal3['_id']}}" data-city="{{$aVal1['city']}}" title="@lang('website.btn_add_child')">
                                        <span class="fa-stack">
                                            <i class="fa fa-square fa-stack-2x"></i>
                                            <i class="fa fa-plus-circle fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </a>
                                    <a class="table-link btn-edit" data-id="{{$aVal3['_id']}}" data-parent_id="{{$aVal2['_id']}}" data-name="{{$aVal3['dept_name']}}" title="@lang('website.btn_edit')">
                                        <span class="fa-stack">
                                            <i class="fa fa-square fa-stack-2x"></i>
                                            <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </a>
                                    <a class="table-link btn-delete danger" data-id="{{$aVal3['_id']}}" title="@lang('website.btn_delete')">
                                        <span class="fa-stack">
                                            <i class="fa fa-square fa-stack-2x"></i>
                                            <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </a>
                                    <span class="dept_parent hidden">{{$aVal1['dept_name']}} - {{$aVal2['dept_name']}} - {{$aVal3['dept_name']}}</span>
                                </td>
                            </tr>
                            @foreach($aVal3['child'] as $aVal4)
                            <tr>
                                <td>
                                    <div class="dept_4">∟{{$aVal4['dept_name']}}</div>
                                </td>
                                <td class="text-center">
                                    <a class="table-link btn-edit" data-id="{{$aVal4['_id']}}" data-parent_id="{{$aVal3['_id']}}" data-name="{{$aVal4['dept_name']}}" title="@lang('website.btn_edit')">
                                        <span class="fa-stack">
                                            <i class="fa fa-square fa-stack-2x"></i>
                                            <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </a>
                                    <a class="table-link btn-delete danger" data-id="{{$aVal4['_id']}}" title="@lang('website.btn_delete')">
                                        <span class="fa-stack">
                                            <i class="fa fa-square fa-stack-2x"></i>
                                            <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </a>
                                    <span class="dept_parent hidden">{{$aVal1['dept_name']}} - {{$aVal2['dept_name']}} - {{$aVal3['dept_name']}}</span>
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
                    <label for="car_type"><span class="text-danger">*</span>@lang('website.dept_parent')</label>
                    <div id="dept_parent"></div>
                </div>
                <div class="form-group">
                    <label for="dept_name"><span class="text-danger">*</span>@lang('website.title')</label>
                    <input type="text" class="form-control" id="dept_name" name="dept_name" maxlength="20" size="20">
                </div>
            </div>
            <div class="modal-footer">
                {!! csrf_field() !!}
                <input type="hidden" id="_method" name="_method" value="">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="parent_id" id="parent_id">
                <input type="hidden" name="city" id="city">
                <input type="hidden" name="level" id="level">
                <input type="hidden" name="parent_arr" id="parent_arr">
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
var del_msg_multi = '@lang('website.js_del_msg_multi')', del_msg = '@lang('website.js_del_msg')', error_del = '@lang('error.select_del_empty')', title_add = '@lang('website.detail_add')', title_edit = '@lang('website.detail_edit')', error_title = '@lang('error.title_empty')';
</script>
<script src="{{ asset('js/Admin/Dept.js') }}"></script>
@endsection