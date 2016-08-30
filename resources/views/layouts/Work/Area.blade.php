@extends('layouts.main')

@section('content')
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
                            <div class="pull-left text-label"><label for="a">@lang('website.station_area')：</label></div>
                            <div class="pull-left">
                                <select name="a" id="a" class="form-control input-sm">
                                    <option value="">@lang('website.all')</option>
                                    @foreach ($aArea as $sArea)
                                    <option value="{{$sArea}}" @if($aGet['a'] == $sArea) selected @endif>{{$sArea}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="pull-left"><button type="submit" class="btn btn-default"><span class="fa fa-search"></span> @lang('website.btn_search')</button></div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="pull-right">
                        <a id="btn-add-area" class="btn btn-primary">
                            <i class="fa fa-plus-circle fa-lg"></i> @lang('website.btn_add_area')
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </header>
            <div class="main-box-body clearfix">
                <div class="table-responsive">
                    <form name="list-form" id="list-form" action="POST">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" id="_method" value="put">
                        <input type="hidden" name="_redirect" id="_redirect" value="{!!Request::fullUrl()!!}">
                        <div class="list-btn-div">
                            <input type="submit" class="btn btn-primary" value="@lang('website.btn_edit')" />
                        </div>
                        <table id="list-table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>@lang('website.station_city')</th>
                                    <th>@lang('website.station_no')</th>
                                    <th>@lang('website.station_name')</th>
                                    <th width="15%">@lang('website.rope_suggest')</th>
                                    <th width="15%">@lang('website.station_area')</th>
                                    <th>@lang('website.last_modify_date')</th>
                                    <th>@lang('website.staff_no')(@lang('website.account'))</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($aInfo) > 0)
                                    @foreach ($aInfo as $aVal)
                                    <tr data-id="{{$aVal['_id']}}">
                                        <td class="text-center">@lang('website.city_'.$aVal['city'])</td>
                                        <td class="text-center">{{$aVal['station_no']}}</td>
                                        <td class="text-left">{{$aVal['station_name']}}</td>
                                        <td class="text-center"><input type="text" name="rope[]" id="rope_{{$aVal['_id']}}" class="form-control text-right" value="{{$aVal['set_rope']}}" maxlength="5" size="5" /></td>
                                        <td class="text-center">
                                            <select name="area[]" id="area_{{$aVal['_id']}}" class="form-control">
                                                <option value="">@lang('website.pls_select')</option>
                                                @foreach ($aArea as $sArea)
                                                <option value="{{$sArea}}" @if($aVal['set_area'] == $sArea) selected @endif>{{$sArea}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="time text-center">{{$aVal['modify_date']}}</td>
                                        <td class="text-center">{{$aVal['staff']}}</td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td colspan="12" class="text-center">@lang('website.no_data')</td>
                                @endif
                            </tbody>
                        </table>
                    </form>
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
{{-- 新增場站區域 --}}
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
                    <label for="area_name"><span class="text-danger">*</span>@lang('website.station_area')</label>
                    <input type="text" name="area_name" id="area_name" class="form-control" maxlength="10" size="10" />
                    <div class="text-muted">@lang('website.help_alpha_num')</div>
                </div>
            </div>
            <div class="modal-footer">
                {!! csrf_field() !!}
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
var error_area = '@lang('error.area_empty')';
</script>
<script src="{{ asset('js/Work/Area.js') }}"></script>
@endsection