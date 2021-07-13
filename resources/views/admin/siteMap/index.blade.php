@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
{{--            <div class="layui-btn-group ">--}}
{{--                @can('siteMap.create')--}}
{{--                    <a class="layui-btn layui-btn-sm" href="{{route('admin.site.map.create')}}">添 加</a>--}}
{{--                @endcan--}}
{{--            </div>--}}
            <div class="layui-form">
                <div class="layui-input-inline">
                    <select name="name" lay-verify="required" id="siteMap-name">
                        <option value="">请选择类型</option>
                        @foreach($type as $ty)
                            <option value="{{ $ty->name }}">{{ $ty->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="layui-btn" id="searchBtn">搜 索</button>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('siteMap.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('siteMap')
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
                    , url: "{{ route('admin.site.map.data') }}" //数据接口
                    , page: true //开启分页
                    , cols: [[ //表头
                        // {checkbox: true, fixed: true},
                        {field: 'id', title: 'ID', sort: true, width: 80}
                        , {field: 'name',sort: true, title: '类型'}
                        , {field: 'url', title: 'url_key', width: 100}
                        , {field: 'origin', title: '源链接'}
                        , {field: 'created_at', title: '创建时间'}
                        , {field: 'updated_at', title: '修改时间'}
                        , {fixed: 'right',title: '操作', width: 140, align: 'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function (obj) { //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        , layEvent = obj.event; //获得 lay-event 对应的值
                    if (layEvent === 'del') {
                        {{--layer.confirm('确认禁用吗？', function (index) {--}}
                        {{--    layer.close(index);--}}
                        {{--    var load = layer.load();--}}
                        {{--    $.post("{{ route('admin.blog.article.disable') }}", {--}}
                        {{--        _method: 'delete',--}}
                        {{--        ids: [data.post_id]--}}
                        {{--    }, function (res) {--}}
                        {{--        layer.close(load);--}}
                        {{--        if (res.code == 0) {--}}
                        {{--            layer.msg(res.msg, {icon: 1}, function () {--}}
                        {{--                // obj.del();--}}
                        {{--            })--}}
                        {{--        } else {--}}
                        {{--            layer.msg(res.msg, {icon: 2})--}}
                        {{--        }--}}
                        {{--    });--}}
                        {{--});--}}
                    } else if (layEvent === 'edit') {
                        location.href = data.id + '/edit';
                    }
                });
                //搜索
                $("#searchBtn").click(function () {
                    var name = $("#siteMap-name").val();
                    dataTable.reload({
                        where: {name: name},
                        page: {curr: 1}
                    })
                })
            })
        </script>
    @endcan
@endsection
