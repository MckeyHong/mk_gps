@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="{{ asset("vendor/ztree/zTreeStyle.css") }}">
<style>
.ztree *{
    font-size: 14px;
}

.ztree li{
    line-height: 21px;
}

.ztree li span.button.ico_open, .ztree li span.button.ico_close{
    margin-top: 2px;
}
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
                <a href="#" class="btn btn-primary pull-right">
                    <i class="fa fa-plus-circle fa-lg"></i> Add product
                </a>
            </header>
            <div class="main-box-body clearfix">
                <ul id="treeDemo" class="ztree"></ul>
            </div>
        </div>
    </div>
</div>
<div id="add-icon" class="hidden">
    <a href="#" class="table-link">
        <span class="fa-stack">
        <i class="fa fa-square fa-stack-2x"></i>
        <i class="fa fa-plus-circle fa-stack-1x fa-inverse"></i>
        </span>
    </a>
</div>
<div id="edit-icon" class="hidden">
    <a href="#" class="table-link">
        <span class="fa-stack">
        <i class="fa fa-square fa-stack-2x"></i>
        <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
        </span>
    </a>
</div>
<div id="delete-icon" class="hidden">
    <a href="#" class="table-link danger">
        <span class="fa-stack">
        <i class="fa fa-square fa-stack-2x"></i>
        <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
        </span>
    </a>
</div>
@endsection

@section('js_self')
<script src="{{ asset("vendor/ztree/jquery.ztree.core-3.5.min.js") }}"></script>
<script type="text/javascript">
    <!--
    var setting = {
        data: {
            simpleData: {
                enable: true
            }
        }
    };

    var zNodes =[
        { id:1, pId:0, name:"台北市", open:true},
        { id:11, pId:1, name:"信義區", open:true},
        { id:111, pId:11, name:"維護組", open:true},
        { id:1111, pId:111, name:"調度工程師", open:true},
        { id:1112, pId:111, name:"維護工程師", open:true},
        { id:112, pId:11, name:"客服組", open:true},
        { id:1121, pId:112, name:"系統客服", open:true},
        { id:1122, pId:112, name:"電話客服", open:true},
        { id:21, pId:1, name:"大安區", open:true},
        { id:211, pId:21, name:"維護組", open:true},
        { id:2111, pId:211, name:"調度工程師", open:true},
        { id:2112, pId:211, name:"維護工程師", open:true},
        { id:212, pId:21, name:"客服組", open:true},
        { id:2121, pId:212, name:"系統客服", open:true},
        { id:2122, pId:212, name:"電話客服", open:true}
    ];

    $(document).ready(function(){
        $.fn.zTree.init($("#treeDemo"), setting, zNodes);
    });
    //-->
</script>
@endsection