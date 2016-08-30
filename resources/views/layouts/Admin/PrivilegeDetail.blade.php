@extends('layouts.main')

@section('css_self')
<link href="{{ asset('css/Admin/PrivilegeDetail.css') }}" rel="stylesheet">
@endsection

@section('content')
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
                                    <div class="form-group">
                                        <span class="text-danger">*</span>
                                        <label for="role_name">@lang('website.role_name')</label>
                                        <input type="text" id="role_name" name="role_name" class="form-control" value="{{$aInfo['role_name']}}" maxlength="15">
                                        <div class="text-muted">@lang('website.help_privilege_name')</div>
                                    </div>
                                    <div class="form-group">
                                        <span class="text-danger">*</span>
                                        <label for="password">@lang('website.privilege_set')</label>
                                        <div class="class_check_all">
                                            <div class="checkbox-nice">
                                                <input type="checkbox" id="chk_all">
                                                <label for="chk_all">
                                                    @lang('website.chk_all')
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th width="20%">@lang('website.main_menu')</th>
                                                        <th>@lang('website.menu')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach( Menu::getAllMenu() as $sKey => $aVal )
                                                    <tr>
                                                        <td>
                                                            <div class="checkbox-nice">
                                                                <input type="checkbox" class="chk_main" id="{{$sKey}}" data-id="{{$sKey}}">
                                                                <label for="{{$sKey}}">
                                                                    @lang('menu.'.$aVal['title'])
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @foreach ($aVal['child'] as $sCKey => $aCVal )
                                                            <div class="checkbox-nice checkbox-inline">
                                                                <input type="checkbox" class="chk_child main_{{$sKey}}" name="role_privilege[]" id="{{$sKey}}_{{$sCKey}}" data-parent="{{$sKey}}" value="{{$sKey}}/{{$sCKey}}" @if (in_array($sKey.'/'.$sCKey, $aInfo['role_privilege']) ) checked @endif>
                                                                <label for="{{$sKey}}_{{$sCKey}}">
                                                                    @lang('menu.'.$aCVal['title'])
                                                                </label>
                                                            </div>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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
var error_role = '@lang('error.role_name_empty')';
</script>
<script src="{{ asset("js/Admin/PrivilegeDetail.js") }}"></script>
@endsection