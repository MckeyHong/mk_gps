<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@lang('menu.login') - @lang('config.project')</title>
    <link href="{{ asset('vendor/bootstrap-css/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/jquery-ui/themes/base/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/template_theme/theme_styles.css') }}" rel="stylesheet">
    <link type="image/x-icon" href="{{ asset('favicon.ico') }}" rel="shortcut icon"/>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div id="login-box">
                    <div id="login-box-holder">
                        <div class="row">
                            <div class="col-xs-12">
                                <header id="login-header"><div id="login-logo">@lang('config.project')</div></header>
                                <div id="login-box-inner">
                                    <form id="login-form" name="login-form" role="form" method="post">
                                        @if ($error = $errors->first('username'))
                                        <div class="alert alert-danger">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong>@lang('website.error')!</strong> {{$errors->first('username')}}
                                        </div>
                                        @endif
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span></label>
                                            <input type="text" id="username" name="username" class="form-control" value="{{old('username')}}" placeholder="@lang('website.account')">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                            <input type="password" id="password" name="password" class="form-control" placeholder="@lang('website.password')">
                                        </div>
                                        <div class="row">
                                            {!! csrf_field() !!}
                                            {{ method_field('POST') }}
                                            <div class="col-xs-12"><button type="submit" class="btn btn-success col-xs-12">@lang('website.btn_login')</button></div>
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
    <script>
        var js_confirm_title = '@lang('website.js_confirm_title')', js_confirm_ok = '@lang('website.js_confirm_ok')', js_confirm_cancel = '@lang('website.js_confirm_cancel')', js_alert_title = '@lang('website.js_alert_title')', js_alert_ok = '@lang('website.js_alert_ok')', error_account = '@lang('error.account')', error_password = '@lang('error.password')';
    </script>
    <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-css/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/custom/web.js') }}"></script>
    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>