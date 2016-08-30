@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <div class="main-box-body clearfix">
                <div class="table-responsive">
                    <div class="col-lg-12">
                        <div class="main-box">
                            <header class="main-box-header clearfix">
                                <h2>@lang('website.general_road')</h2>
                            </header>
                            <div class="main-box-body clearfix">
                                <form id="data-form" method="POST">
                                    {!! csrf_field() !!}
                                    <input type="hidden" id="_method" name="_method" value="put">
                                    <input type="hidden" id="id" name="id" value="{{$aInfo['_id']}}">
                                    <div class="form-group">
                                        <label for="speed_min">@lang('website.lower_limit')</label>
                                        <input type="text" id="speed_min" name="speed_min" class="form-control" value="{{$aInfo['speed_min']}}" maxlength="3">
                                    </div>
                                    <div class="form-group">
                                        <label for="speed_max">@lang('website.upper_limit')</label>
                                        <input type="text" id="speed_max" name="speed_max" class="form-control" value="{{$aInfo['speed_max']}}" maxlength="3">
                                    </div>
                                    <div class="form-group">
                                        <div class="text-muted">@lang('website.help_car_speed')</div>
                                    </div>
                                    <div class="form-group text-center detail-button-block">
                                        <button type="submit" class="btn btn-primary">@lang('website.btn_submit')</button>
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
var error_min = '@lang('error.speed_min_format')', error_max = '@lang('error.speed_max_format')';
</script>
<script src="{{ asset('js/Car/Speed.js') }}"></script>
@endsection