<div class="row">
    <div class="col-lg-12">
        <div id="content-header" class="clearfix">
            <div class="pull-left">
                <ol class="breadcrumb">
                    <li><a href="{{ url('') }}">@lang('menu.home')</a></li>
                    @foreach (Menu::getBreadcrumbs() as $aVal)
                        @if ($aVal['last'] == true)
                            <li class="active"><span>{{$aVal['title']}}</span></li>
                        @else
                            @if ($aVal['url'] != '')
                                <li><a href="{{url('').$aVal['url']}}">{{$aVal['title']}}</a></li>
                            @else
                                <li>{{$aVal['title']}}</li>
                            @endif
                        @endif
                    @endforeach
                </ol>
                <h1>{{Menu::getMenuTitle()}}</h1>
            </div>
        </div>
    </div>
</div>