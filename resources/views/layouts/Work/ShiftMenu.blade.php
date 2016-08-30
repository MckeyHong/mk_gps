{{-- <div class="filter-block pull-right">
    @foreach(Menu::getWorkShiftMenu() as $aVal )
    @if ($aVal['url'] == Request::path())
    <a class="btn btn-success">
        <i class="fa fa-dot-circle-o fa-lg"></i> @lang('website.'.$aVal['title'])
    </a>
    @else
    <a class="btn btn-info" href="{{Request::root()}}/{{$aVal['url']}}">
        <i class="fa fa-circle-o fa-lg"></i> @lang('website.'.$aVal['title'])
    </a>
    @endif
    @endforeach
    <a class="btn btn-info" data-toggle="modal" data-target="#ExcelModal">
        <i class="fa fa-upload fa-lg"></i> @lang('website.btn_import_shift')
    </a>
</div>
<div class="clearfix"></div> --}}
{{-- 資料匯入 --}}
{{-- <div class="modal fade" id="ExcelModal">
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
                        @lang('excel.i_staff_shift')
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
<hr> --}}
<div class="row">
    <ul class="nav nav-tabs" style="margin-right: -2px; margin-left: -2px;">
    @foreach(Menu::getWorkShiftMenu() as $aVal )
        @if ($aVal['url'] == Request::path())
        <li role="presentation" class="active"><a>@lang('website.'.$aVal['title'])</a></li>
        @else
        <li role="presentation"><a href="{{Request::root()}}/{{$aVal['url']}}">@lang('website.'.$aVal['title'])</a></li>
        @endif
        @endforeach
        <li role="presentation">
            <a data-toggle="modal" data-target="#ExcelModal">
                <span class="fa fa-upload fa-lg"></span>@lang('website.btn_import_shift')
            </a>
        </li>
    </ul>
</div>
<div class="clearfix"></div>
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
                        @lang('excel.i_staff_shift')
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