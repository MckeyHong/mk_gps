@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
                <div class="filter-block pull-right">
                    <div class="form-group pull-left list-search-block">
                        <form id="search-form" method="GET">
                            <div class="pull-left text-label"><label for="acc">@lang('website.account')：</label></div>
                            <div class="pull-left"><input type="text" id="acc" name="acc" class="form-control input-sm" value="{{$aGet['acc']}}" maxlength="15" size="15"></div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left text-label"><label for="acc">@lang('website.belong_dept')：</label></div>
                            <div class="pull-left">
                                <select name="dept" id="dept" class="form-control input-sm">
                                    <option value="">@lang('website.all')</option>
                                </select>
                            </div>
                            <div class="pull-left"><button type="submit" class="btn btn-default"><span class="fa fa-search"></span> @lang('website.btn_search')</button></div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="pull-right">
                        <a  data-toggle="modal" data-target="#ImportExcel" class="btn btn-success">
                            <i class="fa fa-upload fa-lg"></i> @lang('website.btn_import_excel')
                        </a>
                    </div>
                    <div class="pull-right">
                        <a href="{{Request::url()}}/Add" class="btn btn-primary">
                            <i class="fa fa-plus-circle fa-lg"></i> @lang('website.btn_add')
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </header>
            <div class="main-box-body clearfix">
                <div class="table-responsive">
                    <div class="list-btn-div">
                        <input type="button" id="btn-delete" class="btn btn-danger input-sm" value="@lang('website.btn_delete')" />
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
                                <th>@lang('website.staff_no')</th>
                                <th>@lang('website.users_name')</th>
                                <th>@lang('website.belong_dept')</th>
                                <th>@lang('website.account_status')</th>
                                <th>@lang('website.setting')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($aInfo) > 0)
                                @foreach ($aInfo as $aVal)
                                <tr>
                                    <td class="text-center">
                                         <div class="checkbox-nice">
                                            <input type="checkbox" id="chk-{{$aVal['_id']}}" data-id="{{$aVal['_id']}}" class="list-checkbox">
                                            <label for="chk-{{$aVal['_id']}}"></label>
                                        </div>
                                    </td>
                                    <td>{{$aVal['username']}}</td>
                                    <td>{{$aVal['users_name']}}</td>
                                    <td>{{$aVal['dept_info']}}</td>
                                    <td class="text-center">
                                        @if ($aVal['enable_type'] == 1)
                                            <span class="label label-success">@lang('website.status_open')</span>
                                        @else
                                            <span class="label label-danger">@lang('website.status_stop')</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{Request::url()}}/Edit/{{$aVal['_id']}}" class="table-link" title="@lang('website.btn_edit')">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                        <a href="#" class="table-link danger" title="@lang('website.btn_delete')" data-id="{{$aVal['_id']}}">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
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
                <div>
                    <div class="pagination-count pull-left">
                        @lang('website.data_count')：{{$aInfo->total()}}
                    </div>
                    <ul class="pagination pull-right">
                        {!!str_replace('/?', '?', $aInfo->appends($aGet)->render()) !!}
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--資料匯入-->
<div class="modal fade" id="ImportExcel">
    <div class="modal-dialog">
        <form name="import-form" id="import-form" method="post" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="@lang('website.close')"><span>&times;</span></button>
                <h4 class="modal-title">@lang('website.btn_import_excel')</h4>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="form-group">
                        <label for="exampleInputEmail1">@lang('website.explanation')</label>
                        <br />@lang('explanation.admin_users')
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">@lang('website.import_demo')</label>
                        <input type="button" class="btn btn-success" value="@lang('website.btn_download')" />
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">@lang('website.file_upload')</label>
                        <input type="file" class="form-control" id="file_upload" name="file_upload">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('website.btn_submit')</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">@lang('website.btn_cancel')</button>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection

@section('js_self')
<script>
    var error_acc = '@lang('error.account_length')';
</script>
<script src="{{ asset("js/Admin/Info.js") }}"></script>
@endsection