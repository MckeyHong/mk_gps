<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{Menu::getMenuTitle()}} - @lang('config.project')</title>
    <link href="{{ asset('vendor/bootstrap-css/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/jquery-ui/themes/base/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/template_theme/theme_styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom/website.css') }}" rel="stylesheet">
    <link type="image/x-icon" href="{{ asset('favicon.ico') }}" rel="shortcut icon"/>
    @yield('css_self')
</head>
<body class="theme-blue-gradient fixed-header pace-done">
    <div id="theme-wrapper">
        @include('layouts.partials.header')
        <div id="page-wrapper" class="container">
            <div class="row">
                @include('layouts.partials.sidebar')
                <div id="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            @include('layouts.partials.breadcrumbs')
                            <div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="main-box">
                                            <div class="main-box-body clearfix">
                                                @yield('content')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer id="footer-bar" class="row">
                        <p id="footer-copyright" class="col-xs-12">
                            Copyright © 2015 Microprogram Co., Ltd. All rights reserved.
                        </p>
                    </footer>
                </div>
            </div>
        </div>
    </div>
    <div id="gotop">Top</div>
    <script>
        var root_url = '{{Request::root()}}/', now_url = '{!!Request::fullUrl()!!}';
        var func_url = root_url + '{{Request::path()}}';
        var js_confirm_title = '@lang('website.js_confirm_title')', js_confirm_ok = '@lang('website.js_confirm_ok')';
        var js_confirm_cancel = '@lang('website.js_confirm_cancel')', js_alert_title = '@lang('website.js_alert_title')', js_alert_ok = '@lang('website.js_alert_ok')';
        var aPwdError = ['@lang('error.pwd_old_format')', '@lang('error.pwd_new_format')', '@lang('error.pwd_chk_match')'];
    </script>
    <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-css/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/custom/modalEffects.js') }}"></script>
    <script src="{{ asset('js/custom/menu.js') }}"></script>
    <script src="{{ asset('js/custom/web.js') }}"></script>
    <script src="{{ asset('js/custom/website.js') }}"></script>
    @yield('js_self')
</body>
</html>