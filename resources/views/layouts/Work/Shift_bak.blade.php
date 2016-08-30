@extends('layouts.main')

@section('content')
<style>
#edit_start, #edit_end{
    width: 100px;
}

.btn-div{
    margin-right: 5px;
}

.calendar-header{
    margin: 10px 0 10px 0;
}
.calendar-header .pull-left{
    margin-left: 5px;
    line-height: 24px;
}

.calendar-btn{
    border: 1px solid #ccc;
    padding: 3px 12px 5px 12px;
    border-radius: 3px;
    cursor: pointer;
}

.calendar-btn:hover{
    background-color: #CCC;
}

.display-center {
    display: inline-block;
}
</style>
<div class="row text-center">
    @include('layouts.Work.ShiftMenu')
    <div class="clearfix"></div>
    <div class="row text-center calendar-header">
        <div class="display-center">
            <div class="pull-left calendar-btn">«</div>
            <div class="pull-left"><select class="form-control"><option>2015</option></select></div>
            <div class="pull-left"><select class="form-control"><option>10</option></select></div>
            <div class="pull-left calendar-btn">»</div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>
<div class="display-center" style="width:98%">
                    <table class="table table-bordered table-hover text-middle" >
                        <thead>
                            <tr>
                                <th>星期日</th>
                                <th>星期一</th>
                                <th>星期二</th>
                                <th>星期三</th>
                                <th>星期四</th>
                                <th>星期五</th>
                                <th>星期六</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">1</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">2</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">3</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">4</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">5</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">6</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">7</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">8</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">9</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">10</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">11</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">12</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">13</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">14</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">15</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">16</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">17</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">18</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">19</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">20</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">21</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">22</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">23</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">24</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">25</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">26</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">27</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">28</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">29</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">30</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                                <td>
                                    <div style="color:#337ab7;font-weight:bold">31</div>
                                    <div class="text-center">
                                        0911 日班<br>
                                        0912 夜班
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


</div>
@endsection

@section('js_self')

@endsection