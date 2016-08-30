<header class="navbar" id="header-navbar">
    <div class="container">
        <a href="{{ url('') }}" class="navbar-brand">@lang('config.project')</a>

        <div class="clearfix">
        <button class="navbar-toggle" data-target=".navbar-ex1-collapse" data-toggle="collapse" type="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="fa fa-bars"></span>
        </button>

        <div class="nav-no-collapse navbar-left pull-left hidden-sm hidden-xs">
            <ul class="nav navbar-nav pull-left">
                <li>
                    <a class="btn" id="make-small-nav">
                        <i class="fa fa-bars"></i>
                    </a>
                </li>
                <!-- 訊息通知(暫時隱藏)
                <li class="dropdown hidden-xs">
                    <a class="btn dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell"></i>
                        <span class="count">8</span>
                    </a>
                    <ul class="dropdown-menu notifications-list">
                        <li class="pointer">
                            <div class="pointer-inner">
                                <div class="arrow"></div>
                            </div>
                        </li>
                        <li class="item-header">You have 6 new notifications</li>
                        <li class="item">
                            <a href="#">
                                <i class="fa fa-comment"></i>
                                <span class="content">New comment on ‘Awesome P...</span>
                                <span class="time"><i class="fa fa-clock-o"></i>13 min.</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="#">
                                <i class="fa fa-plus"></i>
                                <span class="content">New user registration</span>
                                <span class="time"><i class="fa fa-clock-o"></i>13 min.</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="#">
                                <i class="fa fa-envelope"></i>
                                <span class="content">New Message from George</span>
                                <span class="time"><i class="fa fa-clock-o"></i>13 min.</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="#">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="content">New purchase</span>
                                <span class="time"><i class="fa fa-clock-o"></i>13 min.</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="#">
                                <i class="fa fa-eye"></i>
                                <span class="content">New order</span>
                                <span class="time"><i class="fa fa-clock-o"></i>13 min.</span>
                            </a>
                        </li>
                        <li class="item-footer">
                            <a href="#">
                                View all notifications
                            </a>
                        </li>
                    </ul>
                </li>
                -->
                <li class="dropdown hidden-xs">
                    {{-- 多語系判斷 --}}
                    @if (count(Config::get('website.language')) > 1)
                        <a class="btn dropdown-toggle" data-toggle="dropdown">
                            English
                            <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="item">
                                <a href="#">
                                    Spanish
                                </a>
                            </li>
                            <li class="item">
                                <a href="#">
                                    German
                                </a>
                            </li>
                            <li class="item">
                                <a href="#">
                                    Italian
                                </a>
                            </li>
                        </ul>
                    @endif
                </li>
            </ul>
        </div>

        <div class="nav-no-collapse pull-right" id="header-nav">
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown profile-dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs">{{{ isset(Auth::user()->users_name) ? Auth::user()->users_name : '' }}}</span> <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a data-toggle="modal" data-target="#SystemInfo"><i class="fa fa-file-text"></i>@lang('menu.system_info')</a></li>
                        <li id="open_self_profile"><a><i class="fa fa-user"></i>@lang('menu.self_profile')</a></li>
                    </ul>
                </li>
                <li class="hidden-xxs">
                    <a class="btn" href="{{ url('/auth/logout') }}" title="@lang('website.btn_logout')">
                        <i class="fa fa-power-off"></i>
                    </a>
                </li>
            </ul>
        </div>
        </div>
    </div>
</header>

{{-- 系統資訊 --}}
<div class="modal fade" id="SystemInfo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="@lang('website.close')"><span>&times;</span></button>
                <h4 class="modal-title">@lang('menu.system_info')</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">@lang('website.explanation')</label>
                    <br />@lang('explanation.system_info')
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('website.colse')</button>
            </div>
        </div>
    </div>
</div>
{{-- 個人資訊 --}}
<div class="modal fade" id="SelfProfile">
    <div class="modal-dialog">
        <form name="pwd-form" id="pwd-form" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="@lang('website.close')"><span>&times;</span></button>
                <h4 class="modal-title">@lang('menu.self_profile')</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div  class="col-md-6">
                        <label>@lang('website.account')</label>
                        <div>{{{ Auth::user()->username }}}</div>
                    </div>
                    <div  class="col-md-6">
                        <label>@lang('website.users_name')</label>
                        <div>{{{ Auth::user()->users_name }}}</div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label>@lang('website.city')</label>
                    <div>
                        @foreach(Auth::user()->city as $iKey => $sCity)
                        @if ($iKey != 0) 、@endif
                        @lang('website.city_'.$sCity)
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="self_pwd_old">@lang('website.password_now')</label>
                    <div><input type="password" id="self_pwd_old" name="self_pwd_old" class="form-control" maxlength="15" /></div>
                    <div class="text-muted">@lang('website.help_password_old')</div>
                </div>
                <div class="form-group">
                    <label for="self_pwd">@lang('website.password')</label>
                    <div><input type="password" id="self_pwd" name="self_pwd" class="form-control" maxlength="15" /></div>
                    <div class="text-muted">@lang('website.help_password')</div>
                </div>
                <div class="form-group">
                    <label for="self_pwd_chk">@lang('website.password_check')</label>
                    <div><input type="password" id="self_pwd_chk" name="self_pwd_chk" class="form-control" maxlength="15" /></div>
                    <div class="text-muted">@lang('website.help_password_again')</div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="self_token" name="self_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-primary">@lang('website.btn_change_pwd')</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('website.colse')</button>
            </div>
        </div>
        </form>
    </div>
</div>