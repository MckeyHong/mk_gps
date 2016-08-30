@extends('layouts.main')

@section('content')
<style type="text/css">
.text-label {
    margin:0 2px 0 2px;
}

.station_set {
    text-align: right;
}
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
                <div class="filter-block pull-right">
                    <div class="form-group pull-left list-search-block">
                        <form id="search-form" method="GET">
                            <div class="pull-left text-label"><label for="c">@lang('website.station_city')：</label></div>
                            <div class="pull-left">
                                <select name="c" id="c" class="form-control input-sm">
                                    <option value="">@lang('website.all')</option>
                                    @foreach ($aCity as $sCity)
                                    <option value="{{$sCity}}" @if($aGet['c'] == $sCity) selected @endif>@lang('website.city_'.$sCity)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left text-label"><label for="day">@lang('website.date_type')：</label></div>
                            <div class="pull-left">
                                <select name="day" id="day" class="form-control input-sm">
                                    <option value="">@lang('website.all')</option>
                                    @foreach ($aDay as $iKey => $sDay)
                                    <option value="{{$iKey}}" @if($aGet['day'] == $iKey) selected @endif>@lang('website.'.$sDay)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left text-label"><label for="no">@lang('website.station_no')：</label></div>
                            <div class="pull-left"><input type="text" id="no" name="no" class="form-control input-sm" value="{{$aGet['no']}}" maxlength="10" size="10"></div>
                            <div class="pull-left"><button type="submit" class="btn btn-default"><span class="fa fa-search"></span> @lang('website.btn_search')</button></div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="pull-right">
                        <a id="btn-download" class="btn btn-success">
                            <i class="fa fa-download fa-lg"></i> @lang('website.btn_export_excel')
                        </a>
                        <a class="btn btn-info" data-toggle="modal" data-target="#ExcelModal">
                            <i class="fa fa-upload fa-lg"></i> @lang('website.btn_import_change')
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </header>
            <div class="main-box-body clearfix">
                <div class="table-responsive">
                    <div class="list-btn-div">
                        <input type="button" class="btn btn-primary input-sm btn-edit" value="@lang('website.btn_edit')" />
                    </div>
                    <table id="list-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('website.station_city')</th>
                                <th>@lang('website.station_no')</th>
                                <th>@lang('website.station_name')</th>
                                <th>@lang('website.date_type')</th>
                                <th>@lang('website.setting')( @lang('website.hour') : @lang('website.num_min')/@lang('website.num_max'))</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($aGet['day'] == '')
                            @foreach ($aInfo as $aVal)
                            <tr>
                                <td rowspan="2">@lang('website.city_'.$aVal['city'])</td>
                                <td rowspan="2">{{$aVal['station_no']}}</td>
                                <td rowspan="2">{{$aVal['station_name']}}</td>
                                <td class="text-center">@lang('website.normalday')</td>
                                <td class="text-center">
                                    <div class="inline-center">
                                    <?php
                                        for ($i = 0 ; $i <= 23 ; $i++) {
                                            $str = '<div class="pull-left">
                                                <div class="pull-left text-label">'.sprintf('%02d', $i).'：</div>
                                                <div class="pull-left"><input type="text" class="station_set form-control" value="'.$aVal['set_normalday'][$i]['min'].'" data-sno="'.$aVal['station_no'].'" data-hour="'.$i.'" data-day="normalday" data-type="min" size="2" maxlength="3"></div>
                                                <div class="pull-left text-label"> / </div>
                                                <div class="pull-left"><input type="text" class="station_set form-control" value="'.$aVal['set_normalday'][$i]['max'].'" data-sno="'.$aVal['station_no'].'" data-hour="'.$i.'" data-day="normalday" data-type="max" size="2" maxlength="3"></div>
                                                <div class="clearfix"></div>
                                            </div>';
                                            if (($i+1) % 4 == 0) {
                                                $str .= '<div class="clearfix"></div>';
                                            }
                                            echo $str;
                                        }
                                    ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">@lang('website.weekday')</td>
                                <td class="text-center">
                                    <div class="inline-center">
                                    <?php
                                        for ($i = 0 ; $i <= 23 ; $i++) {
                                            $str = '<div class="pull-left">
                                                <div class="pull-left text-label">'.sprintf('%02d', $i).'：</div>
                                                <div class="pull-left"><input type="text" class="station_set form-control" value="'.$aVal['set_weekday'][$i]['min'].'" data-sno="'.$aVal['station_no'].'" data-hour="'.$i.'" data-day="weekday" data-type="min" size="2" maxlength="3"></div>
                                                <div class="pull-left text-label"> / </div>
                                                <div class="pull-left"><input type="text" class="station_set form-control" value="'.$aVal['set_weekday'][$i]['max'].'" data-sno="'.$aVal['station_no'].'" data-hour="'.$i.'" data-day="weekday" data-type="max" size="2" maxlength="3"></div>
                                                <div class="clearfix"></div>
                                            </div>';
                                            if (($i+1) % 4 == 0) {
                                                $str .= '<div class="clearfix"></div>';
                                            }
                                            echo $str;
                                        }
                                    ?>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @elseif ($aGet['day'] == 1)
                                @foreach ($aInfo as $aVal)
                                <tr>
                                    <td>@lang('website.city_'.$aVal['city'])</td>
                                    <td>{{$aVal['station_no']}}</td>
                                    <td>{{$aVal['station_name']}}</td>
                                    <td class="text-center">@lang('website.normalday')</td>
                                    <td class="text-center">
                                        <div class="inline-center">
                                        <?php
                                            for ($i = 0 ; $i <= 23 ; $i++) {
                                                $str = '<div class="pull-left">
                                                    <div class="pull-left text-label">'.sprintf('%02d', $i).'：</div>
                                                    <div class="pull-left"><input type="text" class="station_set form-control" value="'.$aVal['set_normalday'][$i]['min'].'" data-sno="'.$aVal['station_no'].'" data-hour="'.$i.'" data-day="normalday" data-type="min" size="2" maxlength="3"></div>
                                                    <div class="pull-left text-label"> / </div>
                                                    <div class="pull-left"><input type="text" class="station_set form-control" value="'.$aVal['set_normalday'][$i]['max'].'" data-sno="'.$aVal['station_no'].'" data-hour="'.$i.'" data-day="normalday" data-type="max" size="2" maxlength="3"></div>
                                                    <div class="clearfix"></div>
                                                </div>';
                                                if (($i+1) % 4 == 0) {
                                                    $str .= '<div class="clearfix"></div>';
                                                }
                                                echo $str;
                                            }
                                        ?>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                @foreach ($aInfo as $aVal)
                                <tr>
                                    <td>@lang('website.city_'.$aVal['city'])</td>
                                    <td>{{$aVal['station_no']}}</td>
                                    <td>{{$aVal['station_name']}}</td>
                                    <td class="text-center">@lang('website.weekday')</td>
                                    <td class="text-center">
                                        <div class="inline-center">
                                        <?php
                                            for ($i = 0 ; $i <= 23 ; $i++) {
                                                $str = '<div class="pull-left">
                                                    <div class="pull-left text-label">'.sprintf('%02d', $i).'：</div>
                                                    <div class="pull-left"><input type="text" class="station_set form-control" value="'.$aVal['set_weekday'][$i]['min'].'" size="2" maxlength="3"></div>
                                                    <div class="pull-left text-label"> / </div>
                                                    <div class="pull-left"><input type="text" class="station_set form-control" value="'.$aVal['set_weekday'][$i]['max'].'" size="2" maxlength="3"></div>
                                                    <div class="clearfix"></div>
                                                </div>';
                                                if (($i+1) % 4 == 0) {
                                                    $str .= '<div class="clearfix"></div>';
                                                }
                                                echo $str;
                                            }
                                        ?>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="list-btn-div">
                        <input type="button" class="btn btn-primary input-sm btn-edit" value="@lang('website.btn_edit')" />
                    </div>
                </div>
                @if (count($aInfo) > 0)
                <div>
                    <div class="pagination-count pull-left">
                        @lang('website.data_count')：{{$aInfo->total()}}
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
<form name="data-form" id="data-form" method="post">
    {!! csrf_field() !!}
    <input type="hidden" name="_method" id="_method" value="put">
    <input type="hidden" name="_redirect" id="_redirect" value="{!!Request::fullUrl()!!}">
</form>
{{-- 資料匯入 --}}
<div class="modal fade" id="ExcelModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form name="excel-form" id="excel-form" method="POST" enctype="multipart/form-data">
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
                    <label>@lang('website.import_data') @lang('excel.i_sation_download')</label>
                    <div>
                        @lang('excel.i_station_set')
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
var error_import = '@lang('error.import_excel')';
$(function () {
    $('#list-table input:text').restrict({reg: /^\d+$/});
    /* 下載 */
    $('#btn-download').click(function () {
        document.location.href = func_url + '/Demo?' + $('#search-form').serialize();
    });

    /* 表單送出 */
    $('.btn-edit').click(function () {
        var aInfo = [];
        $('#list-table input:text').each(function () {
            var oTemp = {sno: $(this).data('sno'), day_type: $(this).data('day'), hour: $(this).data('hour'), set_type: $(this).data('type'), set: $(this).val()};
            aInfo.push(oTemp);
        });
        $.show_loading();
        $.cust_ajax({
            url: func_url,
            data: $('#data-form').serialize() + '&item=' + JSON.stringify(aInfo)
        });
        return false;
    });

    /* 資料匯入新增 */
    $('#excel-form').submit(function () {
        var filename = $('#excel-form #excel').prop('files')[0];
        if ($('#excel-form #excel').val() === '' || filename.size >= import_limit || $.check_import(filename.name) !== true) {
            $.alert({message: error_import});
            return false;
        }
        $.show_loading();
        var form = $('form')[0];
        var form_data = new FormData(form);
        form_data.append('upload_excel', filename);
        form_data.append('_token', $("#excel-form input[name='_token']").val());
        $.cust_ajax({
            url: func_url + '/Import',
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (data) {
                data = JSON.parse(data);
                $.ajax_response_process(data);
            },
            error: function () {
                $.alert({message: 'Ajax error.'});
                $.hide_loading();
            }
        });
        return false;
    });
});
</script>
@endsection