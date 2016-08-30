@extends('layouts.main')

@section('css_self')
<link href="{{ asset("css/Work/StaffArea.css") }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
                <div class="filter-block pull-right">
                    <div class="form-group pull-left list-search-block">
                        <form id="search-form" method="GET">
                            <div class="pull-left">
                                <div class="pull-left text-label"><label for="acc">@lang('website.staff_no')：</label></div>
                                <div class="pull-left">
                                    <input type="text" name="acc" id="acc" class="form-control" value="{{$aGet['acc']}}" maxlength="15" size="15" />
                                </div>
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
                    <table id="list-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>@lang('website.staff_no')</th>
                                <th>@lang('website.staff_name')</th>
                                <th>@lang('website.staff_area')</th>
                                <th>@lang('website.setting')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($aInfo) > 0)
                                @foreach ($aInfo as $aVal)
                                <tr>
                                    <td class="no text-center">{{$aVal['username']}}</td>
                                    <td class="name text-center">{{$aVal['users_name']}}</td>
                                    <td class="text-center">{{$aVal['area_name']}}</td>
                                    <td class="text-center">
                                        <a class="table-link btn-edit" title="@lang('website.btn_edit')" data-id="{{$aVal['_id']}}">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                        <div class="item hidden">
                                            @foreach ($aVal['area'] as $sArea)
                                            @if ($sArea != '')
                                            <div class="add-item pull-left">
                                                <div class="pull-left item-area-word">{{$sArea}}</div>
                                                <div class="pull-left">&nbsp;</div>
                                                <div class="pull-left"><button type="button" class="btn btn-danger btn-xs btn-del-item" title="@lang('website.btn_delete')"><span class="fa fa-times"></span></button></div>
                                                <div class="clearfix"></div>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                        <select class="area hidden">
                                            @foreach ($aArea as $sArea)
                                                @if (!in_array($sArea, $aVal['area']))
                                                <option value="{{$sArea}}">{{$sArea}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="4" class="text-center">@lang('website.no_data')</td>
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
{{-- 編輯 --}}
<div class="modal fade" id="DetailModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="data-form" id="data-form" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="@lang('website.close')"><span>&times;</span></button>
                <h4 id="info-title" class="modal-title">@lang('website.detail_edit')</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label>@lang('website.staff_no')：<span id="detail-no"></span></label>
                    </div>
                    <div class="col-md-6">
                        <label>@lang('website.staff_name')：<span id="detail-name"></span></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="detail-area">@lang('website.staff_area')</label>
                    <div id="detail-area-div">
                        <div class="pull-left">
                            <select id="detail-area" name="detail-area" class="form-control">
                                @foreach ($aArea as $sArea)
                                <option value="{{$sArea}}">{{$sArea}}</option>
                                @endforeach
                            </select>
                            <select id="default-area" name="default-area" class="hidden">
                                @foreach ($aArea as $sArea)
                                <option value="{{$sArea}}">{{$sArea}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="pull-left">&nbsp;&nbsp;&nbsp;&nbsp;</div>
                        <div class="pull-left">
                             <a class="btn btn-primary btn-area">
                                <i class="fa fa-plus-circle fa-lg"></i> @lang('website.btn_add')
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div id="copy_item" class="hidden">
                    <div class="add-item pull-left">
                        <div class="pull-left item-area-word"></div>
                        <div class="pull-left">&nbsp;</div>
                        <div class="pull-left"><button type="button" class="btn btn-danger btn-xs btn-del-item" title="@lang('website.btn_delete')"><span class="fa fa-times"></span></button></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div  id="detail-item" class="form-group"></div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                {!! csrf_field() !!}
                <input type="hidden" id="_method" name="_method" value="put">
                <input type="hidden" name="id" id="id">
                <button type="submit" class="btn btn-primary">@lang('website.btn_submit')</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">@lang('website.btn_cancel')</button>
            </div>
            </form>
        </div>
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
                    <label>@lang('website.import_data') <a class="btn btn-success btn-xs" href="{{Request::root()}}/{{Request::path()}}/Demo" download><i class="fa fa-download fa-lg"></i> @lang('website.btn_import_demo')</a></label>
                    <div>
                        @lang('excel.i_staff_area_data')
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
var aInfo = ['no', 'name', 'area', 'item'], error_import = '@lang('error.import_excel')', import_limit = {{Config::get('website.import_limit')}};
</script>
<script src="{{ asset('js/Work/StaffArea.js') }}"></script>
@endsection