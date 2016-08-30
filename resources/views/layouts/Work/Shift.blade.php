@extends('layouts.main')

@section('css_self')
<link href="{{ asset('css/Work/Shift.css') }}" rel="stylesheet">
@endsection
@section('content')
@include('layouts.Work.ShiftMenu')
<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
                <div class="filter-block pull-right">
                    <div class="form-group pull-left list-search-block">
                        <form id="search-form" name="search-form" method="POST">
                            {!! csrf_field() !!}
                            <div class="pull-left">
                                <div class="pull-left text-label"><label for="year">@lang('website.yearly')：</label></div>
                                <div class="pull-left">
                                    <select id="year" name="year" class="form-control">
                                        @foreach ($aYear as $sYear)
                                        <option value="{{$sYear}}">{{$sYear}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="pull-left text-label">、</div>
                            <div class="pull-left">
                                <div class="pull-left text-label"><label for="year">@lang('website.staff_no')：</label></div>
                                <div class="pull-left">
                                    <input type="text" name="no" id="no" class="form-control" maxlength="15" size="15">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="pull-left">
                                <button type="submit" id="btn-search" class="btn btn-default"><span class="fa fa-search"></span> @lang('website.btn_search')</button>
                                <button type="button" id="btn-reset" class="hide btn btn-warning"><span class="fa fa-share"></span> @lang('website.btn_reset_search')</button>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </header>
            @foreach ($aYear as $sYear)
            <div id="yearly_{{$sYear}}" class="yearly-block hide main-box-body clearfix">
                <div class="btn-month-div row text-center" style="margin-bottom:5px"></div>
                <div class="table-responsive">
                    <table class="table-day table table-bordered text-middle" >
                        <thead>
                            <tr>
                                <th>@lang('website.day_sunday')</th>
                                <th>@lang('website.day_monday')</th>
                                <th>@lang('website.day_tuesday')</th>
                                <th>@lang('website.day_wednesday')</th>
                                <th>@lang('website.day_thursday')</th>
                                <th>@lang('website.day_friday')</th>
                                <th>@lang('website.day_saturday')</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            @endforeach
            <div class="main-box-body clearfix hide">
                <div class="row text-center" style="margin-bottom:5px">
                    @for( $i = 1 ; $i <= 12 ; $i++)
                    <input type="button" class="btn @if ($i == date('m')) btn-success @else btn-default @endif" style="width:7%" value="{{$i}}月">
                    @endfor
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered text-middle" >
                        <thead>
                            <tr>
                                <th>@lang('website.day_sunday')</th>
                                <th>@lang('website.day_monday')</th>
                                <th>@lang('website.day_tuesday')</th>
                                <th>@lang('website.day_wednesday')</th>
                                <th>@lang('website.day_thursday')</th>
                                <th>@lang('website.day_friday')</th>
                                <th>@lang('website.day_saturday')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="bg-danger"></td>
                                <td></td>
                                <td>
                                    <div class="day">1</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td class="bg-info">
                                    <div class="day">2</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">3</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">4</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td class="bg-danger">
                                    <div class="day">5</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">休假</option>
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-danger">
                                    <div class="day">6</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">休假</option>
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">7</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">8</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">9</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">10</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">11</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td class="bg-danger">
                                    <div class="day">12</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">休假</option>
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-danger">
                                    <div class="day">13</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">休假</option>
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">14</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">15</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">16</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">17</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">18</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td class="bg-danger">
                                    <div class="day">19</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">休假</option>
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-danger">
                                    <div class="day">20</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">休假</option>
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">21</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">22</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">23</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">24</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">25</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td class="bg-danger">
                                    <div class="day">26</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">休假</option>
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-danger">
                                    <div class="day">27</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">休假</option>
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">28</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">29</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">30</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="day">31</div>
                                    <div class="text-center">
                                        <select id="" name="" class="form-control">
                                            <option value="">日班</option>
                                            <option value="">晚班</option>
                                        </select>
                                    </div>
                                </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <input type="button" class="btn btn-primary" value="@lang('website.btn_edit')" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js_self')
<script>
var error_account = '@lang('error.account')', error_year = '@lang('error.select_yearly')';
$(function () {
    $('#no').restrict();

    var updateInfo = function (data) {
        if (data.result === true) {
            var year = $('#year').val(), aMonth = data.info.month, aDay = data.info.day, sMonth = '', sDay = '';
            for(var key in aMonth) {
                sMonth += '<input type="button" class="btn ' + aMonth[key]['btn'] + '" style="width:7%" value="' + aMonth[key]['month'] + '月">';
            }
            for(var key in aDay) {
                var iTempNum = parseInt(key, 10);
                if (iTempNum == 0 || (iTempNum%7) == 0) {
                    sDay += '<tr>';
                }
                sDay += '<div class="day">' + aDay[key]['day'] + '</div><div class="text-center"><select id="" name="" class="form-control"><option value="">日班</option><option value="">晚班</option></select></div>';
                if (((iTempNum+1)%7) == 0 || (iTempNum+1) == aDay.length) {
                    sDay += '</tr>';
                }
            }
            console.log(sDay);
            $('#yearly_' + year + ' .btn-month-div').html(sMonth);

            $('#yearly_' + year + ' .table-day tbody').append(sDay);

            $('#yearly_' + year + ', #btn-reset').removeClass('hide');
            $('#search-form input, #search-form select').prop('disabled', true);
            $.hide_loading();
        }
    };

    $('#search-form').submit(function () {
        var sErrorMsg = '', sYear = $.trim($('#year').val()), sAcc = $.trim($('#no').val());
        if ($.validate('alnum', sYear) === false || sYear.length != 4) {
            sErrorMsg += error_year + '<br />';
        }
        if ($.validate('alnum', sAcc) === false || sAcc.length < 4 || sAcc.length > 15) {
            sErrorMsg += error_account + '<br />';
        }

        if (sErrorMsg !== '') {
            $.alert({message: sErrorMsg});
            return false;
        }

        $.show_loading();
        $('.yearly-block, #btn-search').addClass('hide');
        $.cust_ajax({
            url: func_url + '/StaffShifts',
            data: $('#search-form').serialize(),
            success: function (data) {
                $.ajax_response_process(data, updateInfo(data));
            }
        });
        return false;
    });

    $('#btn-reset').click(function () {
        $.show_loading();
        $('.yearly-block, #btn-reset').addClass('hide');
        $('#btn-search').removeClass('hide');
        $('#search-form input, #search-form select').prop('disabled', false);
        $.hide_loading();
    });

});
</script>
@endsection