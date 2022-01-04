@extends('admin.base')

@section('content')
<div class="layui-card">
    <div class="layui-card-header layuiadmin-card-header-auto">
        <div class="layui-form">
            <div class="layui-input-inline">
                <input type="text" name="title" id="title" placeholder="请输入邮箱" class="layui-input">
            </div>
            <button class="layui-btn" id="searchBtn">搜 索</button>
        </div>
    </div>
    <div class="layui-card-body">
        <table id="dataTable" lay-filter="dataTable"></table>
        <script type="text/html" id="options">
            <div class="layui-btn-group">
                <a class="layui-btn layui-btn-sm" lay-event="show">查看</a>
            </div>
        </script>
        <script type="text/html" id="thumb">
            @{{# if(d.thumb){ }}
            <a href="@{{d.thumb}}" target="_blank" title="点击查看">
                <img src="@{{d.thumb}}" alt="" width="28" height="28">
            </a>
            @{{# } }}
        </script>
        <script type="text/html" id="category">
            @{{ d.category.title }}
        </script>
    </div>
</div>
@endsection

@section('script')
@can('information.article')
<script>
    layui.use(['layer', 'table', 'form'], function () {
                var $ = layui.jquery;
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    , autoSort: true
                    , height: 500
                    , url: "{{ route('admin.bulk_order.data') }}" //数据接口
                    , page: true //开启分页
                    , cols: [[ //表头
                        {checkbox: true, fixed: true}
                        , {field: 'id', title: 'ID', sort: true, width: 80}
                        , {field: 'name', title: '姓名'}
                        , {field: 'email', title: '邮箱'}
                        , {field: 'company', title: '公司'}
                        , {field: 'message', title: 'Message',width: 240,}
                        , {field: 'created_at', title: '提交时间'}
                        , {field: 'updated_at', title: '更新时间'}
                        , {fixed: 'right',title: '操作',  align: 'center',width: 100, toolbar: '#options'}
                    ]]
                });

                  //监听工具条
                table.on('tool(dataTable)', function (obj) { //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        , layEvent = obj.event; //获得 lay-event 对应的值
                    if (layEvent === 'show') {
                        location.href = "{{route('admin.bulk_order.show',['bulk_order'=>'xxxx'])}}".replace(/xxxx/,data.id);
                    }
                });

                //搜索
                $("#searchBtn").click(function () {
                    var catId = $("#category_id").val();
                    var title = $("#title").val();
                    dataTable.reload({
                        where: {category_id: catId, title: title},
                        page: {curr: 1}
                    })
                })
            })
</script>
@endcan
@endsection
