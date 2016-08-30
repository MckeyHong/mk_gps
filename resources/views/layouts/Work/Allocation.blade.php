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
                                <div class="pull-left text-label"><label for="no">@lang('website.staff_no')：</label></div>
                                <div class="pull-left">
                                    <input type="text" id="no" name="no" class="form-control" value="{{$aGet['no']}}" maxlength="15" size="15">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left">
                                <div class="pull-left text-label"><label for="no">@lang('website.belong_dept')：</label></div>
                                <div class="pull-left">
                                    <select id="dept" name="dept" class="form-control">
                                        <option value="">@lang('website.all')</option>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="pull-left"><button type="submit" class="btn btn-default"><span class="fa fa-search"></span> @lang('website.btn_search')</button></div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
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
                    <div class="list-btn-div">
                        <input type="button" id="btn-all-clear" class="btn btn-danger input-sm" value="@lang('website.btn_clear')" />
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
                                <th>@lang('website.belong_dept')</th>
                                <th>@lang('website.staff_no')</th>
                                <th>@lang('website.staff_name')</th>
                                <th>@lang('website.work_notice')</th>
                                <th>@lang('website.work_keynote')</th>
                                <th>@lang('website.setting')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($aInfo) > 0)
                                @foreach ($aInfo as $aVal)
                                <tr class="tr-{{$aVal['_id']}}">
                                    <td class="text-center">
                                         <div class="checkbox-nice">
                                            <input type="checkbox" name="chkClear" id="chk-{{$aVal['_id']}}" data-id="{{$aVal['_id']}}" class="list-checkbox">
                                            <label for="chk-{{$aVal['_id']}}"></label>
                                        </div>
                                    </td>
                                    <td class="staff_dept text-center">{{$aVal['dept_info']}}</td>
                                    <td class="staff_no text-center">{{$aVal['username']}}</td>
                                    <td class="staff_name text-center">{{$aVal['users_name']}}</td>
                                    <td class="work_notice text-center">{{$aVal['work_notice']}}</td>
                                    <td class="work_keynote text-center">{{$aVal['work_keynote']}}</td>
                                    <td class="text-center">
                                        <a class="table-link btn-edit" data-id="{{$aVal['_id']}}" title="@lang('website.btn_edit')">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                        <a class="table-link btn-clear danger"  data-id="{{$aVal['_id']}}" title="@lang('website.btn_clear')">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-pencil-square-o fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                        <div class="hidden clear_message">
                                            <br />
                                            @lang('website.staff_no')：{{$aVal['username']}}<br />
                                            @lang('website.staff_name')：{{$aVal['users_name']}}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="7" class="text-center">@lang('website.no_data')</td>
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
{{-- 設定派工 --}}
<div class="modal fade" id="DetailModal">
    <div class="modal-dialog">
        <form name="data-form" id="data-form" method="post">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="@lang('website.close')"><span>&times;</span></button>
                <h4 id="modal-title" class="modal-title">@lang('website.detail_add')</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="work_notice">@lang('website.staff_info')</label>
                    <div>
                        <div class="pull-left"><span id="staff_no"></span> - <span id="staff_name"></span></div>
                        <div id="staff_dept" class="pull-right"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="work_notice">@lang('website.work_notice')</label>
                    <input type="text" name="work_notice" id="work_notice" class="form-control" maxlength="100" size="100" />
                </div>
                <div class="form-group">
                    <label for="work_keynote">@lang('website.work_keynote')</label>
                    <input type="text" name="work_keynote" id="work_keynote" class="form-control" />
                    <div class="text-muted">@lang('website.help_work_keynote')</div>
                </div>
            </div>
            <div class="modal-footer">
                {!! csrf_field() !!}
                <input type="hidden" name="id" id="id" />
                <input type="hidden" name="_method" id="_method" value="put" />
                <input type="hidden" name="_redirect" id="_redirect" value="{!!Request::fullUrl()!!}" />
                <button type="submit" class="btn btn-primary">@lang('website.btn_submit')</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">@lang('website.btn_cancel')</button>
            </div>
        </div>
        </form>
    </div>
</div>
{{-- 資料匯入 --}}
<div class="modal fade" id="ExcelModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="excel-form" id="excel-form" method="post" enctype="multipart/form-data">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="@lang('website.close')"><span>&times;</span></button>
                <h4 id="info-title" class="modal-title">@lang('website.btn_import_excel')</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>@lang('website.import_notice')</label>
                    <div>
                        1. @lang('excel.i_notice_common_1')<br />
                        2. @lang('excel.i_notice_common_2')<br />
                        3. @lang('excel.i_notice_common_3')<br />
                    </div>
                </div>
                <div class="form-group">
                    <label>
                        @lang('website.import_data')
                        <a class="btn btn-success btn-xs" href="{{Request::root()}}/{{Request::path()}}/Demo" download>
                            <i class="fa fa-download fa-lg"></i> @lang('website.btn_import_demo')
                        </a>
                    </label>
                    <div>
                        @lang('excel.i_staff_allocation')
                    </div>
                </div>
                <div class="form-group">
                    <label>@lang('website.import_upload')</label>
                    <input type="file" name="excel" id="excel" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                {!! csrf_field() !!}
                <button type="submit" class="btn btn-primary">@lang('website.btn_submit')</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">@lang('website.btn_cancel')</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js_self')
<script>
var clear_msg_multi = '@lang('website.js_clear_msg_multi')', clear_msg = '@lang('website.js_clear_msg')', error_clear = '@lang('error.select_clear_empty')', error_import = '@lang('error.import_excel')', import_limit = {{Config::get('website.import_limit')}};
var aColumn = ['staff_no', 'staff_name', 'staff_dept'];
</script>
<script src="{{ asset('js/Work/Allocation.js') }}"></script>
@endsection