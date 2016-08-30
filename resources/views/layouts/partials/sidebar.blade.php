<div id="nav-col">
    <section id="col-left" class="col-left-nano">
        <div id="col-left-inner" class="col-left-nano-content">
            <div class="collapse navbar-collapse navbar-ex1-collapse" id="sidebar-nav">
                <ul class="nav nav-pills nav-stacked">
                    <li class="active">
                        <a href="{{ url('') }}">
                            <i class="fa fa-home"></i>
                            <span>@lang('menu.home')</span>
                        </a>
                    </li>
                    @foreach (Menu::getSidebarMenu() as $iMainKey => $aMainVal)
                    @if (Request::is($iMainKey.'/*'))
                    <li class="open">
                        <a class="dropdown-toggle">
                            <i class="fa {{$aMainVal['icon']}}"></i>
                            <span>@Lang('menu.'.$aMainVal['title'])</span>
                            <i class="fa fa-angle-right drop-icon"></i>
                        </a>
                        <ul class="submenu" style="display:block">
                            @foreach ($aMainVal['child'] as $sChildKey => $aChildVal)
                            <li><a href="{{url('').'/'.$iMainKey.'/'.$sChildKey}}" @if (Request::is($iMainKey.'/'.$sChildKey) || Request::is($iMainKey.'/'.$sChildKey.'/*') ) class="active" @endif>@Lang('menu.'.$aChildVal['title'])</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @else
                    <li>
                        <a class="dropdown-toggle">
                            <i class="fa {{$aMainVal['icon']}}"></i>
                            <span>@Lang('menu.'.$aMainVal['title'])</span>
                            <i class="fa fa-angle-right drop-icon"></i>
                        </a>
                        <ul class="submenu">
                            @foreach ($aMainVal['child'] as $sChildKey => $aChildVal)
                            <li><a href="{{url('').'/'.$iMainKey.'/'.$sChildKey}}">@Lang('menu.'.$aChildVal['title'])</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
    <div id="nav-col-submenu"></div>
</div>