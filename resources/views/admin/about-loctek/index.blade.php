@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">
{{--                @can('company.profile.destory')--}}
{{--                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删 除</button>--}}
{{--                @endcan--}}
                @can('about.loctek.create')
                    <a class="layui-btn layui-btn-sm" href="{{route('admin.about.loctek.create')}}">添 加</a>
                @endcan
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('about.loctek.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('about.loctek.destory')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('about.loctek.list')
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
                    , url: "{{ route('admin.about.loctek.data') }}" //数据接口
                    , page: true //开启分页
                    , cols: [[ //表头
                        // {checkbox: true, fixed: true},
                        {field: 'id', title: 'ID', sort: true, width: 80}
                        , {field: 'type', title: '类型', width: 200, templet: function (res) {return (res.type == 1) ? "页面信息" : "展示信息";}}
                        , {field: 'title', title: '标题', width: 200}
                        , {field: 'content', title: '详情', width: 280}
                        , {field: 'media_link', title: '资源链接'}
                        , {field: 'is_active', title: '是否启用', templet: function (res) {return (res.is_active == 0) ? "否" : "是";}}
                        , {field: 'position', title: '位置权重'}
                        , {field: 'created_at', title: '创建时间'}
                        , {field: 'updated_at', title: '更新时间'}
                        , {fixed: 'right',title: '操作', width: 140, align: 'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function (obj) { //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        , layEvent = obj.event; //获得 lay-event 对应的值
                    if (layEvent === 'del') {
                        layer.confirm('确认删除吗？删除后不可恢复!', function (index) {
                            layer.close(index);
                            var load = layer.load();
                            $.post("{{ route('admin.about.loctek.destory') }}", {
                                _method: 'delete',
                                id: data.id
                            }, function (res) {
                                layer.close(load);
                                if (res.code == 0) {
                                    layer.msg(res.msg, {icon: 1}, function () {
                                        obj.del();
                                    })
                                } else {
                                    layer.msg(res.msg, {icon: 2})
                                }
                            });
                        });
                    } else if (layEvent === 'edit') {
                        location.href = data.id + '/edit';
                    }
                });
            })
        </script>
    @endcan
@endsection
