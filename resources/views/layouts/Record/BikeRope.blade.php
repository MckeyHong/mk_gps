@extends('layouts.main')

@section('css_self')
<link href="{{ asset("vendor/jquery-ui-timepicker/jquery-ui-timepicker.css") }}" rel="stylesheet">
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
                                <div class="pull-left text-label"><label for="no">@lang('website.city')：</label></div>
                                <div class="pull-left">
                                    <select id="" name="" class="form-control">
                                        <option value="">全部</option>
                                        <option value="">台北市</option>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left">
                                <div class="pull-left text-label"><label for="no">@lang('website.station_no')：</label></div>
                                <div class="pull-left"><input type="text" id="no" name="no" class="form-control input-sm" value="" maxlength="15" size="8"></div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left text-label"><label for="car">@lang('website.minute_interval')：</label></div>
                            <div class="pull-left">
                                <select id="" name="" class="form-control">
                                    <option value="">10</option>
                                    <option value="">30</option>
                                    <option value="">60</option>
                                </select>
                            </div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left">
                                <div class="pull-left text-label"><label for="type">@lang('website.time')：</label></div>
                                <div class="pull-left">
                                    <input type="text" id="start_time" class="form-control" maxlength="19" size="12">
                                </div>
                                <div class="pull-left text-label"> ~ </div>
                                <div class="pull-left">
                                    <input type="text" id="end_time" class="form-control" maxlength="19" size="12">
                                </div>
                            </div>
                            <div class="pull-left"><button type="submit" class="btn btn-default"><span class="fa fa-search"></span> @lang('website.btn_search')</button></div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-success"><i class="fa fa-download fa-lg"></i> @lang('website.btn_export_excel')</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </header>
            <div class="main-box-body clearfix">

            </div>
        </div>
    </div>
</div>
@endsection

@section('js_self')
<script src="{{ asset("vendor/jquery-ui-timepicker/jquery-ui-timepicker.js") }}"></script>
<script src="{{ asset("vendor/i18n/datepicker-".App::getLocale().".js") }}"></script>
<script>
jQuery(document).ready(function ($) {

    $('#start_time, #end_time').restrict({reg: /^[0-9\-:\s]+$/}).datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm:ss',
        beforeShow: function () {
            setTimeout(function () {
                $('.ui-datepicker').css('z-index', 100);
            }, 0);
        }
    });
});
</script>
@endsection