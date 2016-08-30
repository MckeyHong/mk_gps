@extends('layouts.main')

@section('content')
<style type="text/css">
.next-item{
    margin:0 8px 0 8px;
    line-height: 32px;
}
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <div class="main-box-body clearfix">
                <div class="table-responsive">
                    <div class="col-lg-12">
                        <div class="main-box">
                            <header class="main-box-header clearfix">
                                <h2>@lang('website.detail_title')</h2>
                            </header>
                            <div class="main-box-body clearfix">
                                <form id="data-form" method="POST">
                                    {!! csrf_field() !!}
                                    <input type="hidden" id="_redirect" name="_redirect" value="{{URL::previous()}}">
                                    <input type="hidden" id="_method" name="_method" value="{{$aInfo['_method']}}">
                                    <div class="form-group">
                                        <span class="text-danger">*</span>
                                        <label for="username">@lang('website.staff_no')(@lang('website.account'))</label>
                                        <input type="text" id="username" name="username" class="form-control" value="{{$aInfo['username']}}" maxlength="15">
                                        <div class="text-muted">@lang('website.help_username')</div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <span class="text-danger">*</span>
                                            <label for="password">@lang('website.password')</label>
                                            <input type="password" id="password" name="password" class="form-control" value="" maxlength="15">
                                            <div class="text-muted">@lang('website.help_password')</div>
                                        </div>
                                        <div class="col-md-6">
                                            <span class="text-danger">*</span>
                                            <label for="password_check">@lang('website.password_check')</label>
                                            <input type="password" id="password_check" name="password_check" class="form-control" value="" maxlength="15">
                                            <div class="text-muted">@lang('website.help_password_again')</div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="form-group">
                                        <span class="text-danger">*</span>
                                        <label for="users_name">@lang('website.users_name')</label>
                                        <input type="text" id="users_name" name="users_name" class="form-control" value="{{$aInfo['users_name']}}" maxlength="20">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6 detail-radio-form-group">
                                            <span class="text-danger">*</span>
                                            <label for="enable_type">@lang('website.account_status')</label>
                                            <div>
                                                <div class="radio pull-left">
                                                    <input type="radio" name="enable_type" id="enable_type_1" value="1" @if ($aInfo['enable_type'] == 1) checked @endif>
                                                    <label for="enable_type_1"><div class="detail-radio-text">@lang('website.status_open')</div></label>
                                                </div>
                                                <div class="radio pull-left">
                                                    <input type="radio" name="enable_type" id="enable_type_2" value="2" @if ($aInfo['enable_type'] == 2) checked @endif>
                                                    <label for="enable_type_2" class="text-danger"><div class="detail-radio-text">@lang('website.status_stop')</div></label>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <span class="text-danger">*</span>
                                            <label for="role_id">@lang('website.role_select')</label>
                                            <select name="role_id" id="role_id" class="form-control">
                                                @if ($aInfo['username'] == '')
                                                <option value="">@lang('website.pls_select')</option>
                                                @endif
                                                @foreach ($aRole as $iKey => $sRole)
                                                <option value="{{$iKey}}" @if ($iKey == $aInfo['role_id']) selected @endif>{{$sRole}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleTextarea"><span class="text-danger">*</span>@lang('website.city')</label>
                                        <div>
                                            @foreach (Auth::user()->city as $sCity)
                                            <div class="checkbox-nice checkbox-inline">
                                                <input type="checkbox" name="city[]" id="city-{{$sCity}}" value="{{$sCity}}" @if (in_array($sCity, $aInfo['city'])) checked @endif>
                                                <label for="city-{{$sCity}}">@lang('website.city_'.$sCity)</label>
                                            </div>
                                            @endforeach
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleTextarea"><span class="text-danger">*</span>@lang('website.belong_dept')</label>
                                        <div>
                                            <div class="pull-left">
                                                <select id="dept_1" name="dept_1" class="form-control">
                                                    <option value="">@lang('website.pls_select')</option>
                                                    @foreach($aDept[1] as $aVal)
                                                    <option value="{{$aVal['_id']}}">{{$aVal['dept_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="pull-left next-item"> > </div>
                                            <div class="pull-left">
                                                <select id="dept_2" name="dept_2" class="form-control">
                                                    <option value="">@lang('website.pls_select')</option>
                                                    @foreach($aDept[2] as $aVal)
                                                    <option value="{{$aVal['_id']}}">{{$aVal['dept_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="pull-left next-item"> > </div>
                                            <div class="pull-left">
                                                <select id="dept_3" name="dept_3" class="form-control">
                                                    <option value="">@lang('website.pls_select')</option>
                                                    @foreach($aDept[3] as $aVal)
                                                    <option value="{{$aVal['_id']}}">{{$aVal['dept_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="pull-left next-item"> > </div>
                                            <div class="pull-left">
                                                <select id="dept_id" name="dept_id" class="form-control">
                                                    <option value="">@lang('website.pls_select')</option>
                                                    @foreach($aDept[4] as $aVal)
                                                    <option value="{{$aVal['_id']}}">{{$aVal['dept_name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="form-group text-center detail-button-block">
                                        <button type="submit" class="btn btn-primary">@lang('website.btn_submit')</button>
                                        <a href="{{ URL::previous() }}" class="btn btn-warning">
                                            @lang('website.btn_cancel_back')
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js_self')
<script>
/*global jQuery, error_acc*/
/*jslint browser : true, devel: true*/
jQuery(document).ready(function ($) {
    'use strict';
    /* 限制輸入 */
    $('#username, #password, #password_check').restrict();

    /* 表單送出 */
    $('#data-form').submit(function () {
        document.location.href = '{{Request::root()}}/Admin/Info';
        return false;
    });

});
</script>
@endsection