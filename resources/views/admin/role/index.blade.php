@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
{{--                @can('system.role.destroy')--}}
{{--                    <a class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删除</a>--}}
{{--                @endcan--}}
                @can('system.role.create')
                    <a class="layui-btn layui-btn-sm" href="{{route('admin.role.create')}}">添加</a>
                @endcan
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('system.role.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('system.role.permission')
                        <a class="layui-btn layui-btn-sm" lay-event="permission">权限</a>
                    @endcan
                    @can('system.role.destroy')
                        <a class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('system.role')
        <script>
            layui.use(['layer', 'table', 'form'], function () {
                var $ = layui.jquery;
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    , height: 500
                    , url: "{{ route('admin.role.data') }}" //数据接口
                    , page: true //开启分页
                    , cols: [[ //表头
                        // {checkbox: true, fixed: true},
                        {field: 'id', title: 'ID', sort: true, width: 80},
                        {field: 'name', title: '名称'},
                        {field: 'display_name', title: '显示名称'},
                        {field: 'created_at', title: '创建时间'},
                        {field: 'updated_at', title: '更新时间'},
                        {fixed: 'right',title: 'active', width: 220, align: 'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function (obj) { //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        , layEvent = obj.event; //获得 lay-event 对应的值
                    if (layEvent === 'del') {
                        layer.confirm('确认删除吗？', function (index) {
                            layer.close(index)
                            var load = layer.load();
                            $.post("{{ route('admin.role.destroy') }}", {
                                _method: 'delete',
                                ids: [data.id]
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
                        location.href = '/admin/role/' + data.id + '/edit';
                    } else if (layEvent === 'permission') {
                        location.href = '/admin/role/' + data.id + '/permission';
                    }
                });

                //按钮批量删除
                {{--$("#listDelete").click(function () {--}}
                {{--    var ids = [];--}}
                {{--    var hasCheck = table.checkStatus('dataTable');--}}
                {{--    var hasCheckData = hasCheck.data;--}}
                {{--    if (hasCheckData.length > 0) {--}}
                {{--        $.each(hasCheckData, function (index, element) {--}}
                {{--            ids.push(element.id)--}}
                {{--        })--}}
                {{--    }--}}
                {{--    if (ids.length > 0) {--}}
                {{--        layer.confirm('确认删除吗？', function (index) {--}}
                {{--            layer.close(index);--}}
                {{--            var load = layer.load();--}}
                {{--            $.post("{{ route('admin.role.destroy') }}", {--}}
                {{--                _method: 'delete',--}}
                {{--                ids: ids--}}
                {{--            }, function (result) {--}}
                {{--                layer.close(load);--}}
                {{--                if (res.code == 0) {--}}
                {{--                    layer.msg(res.msg, {icon: 1}, function () {--}}
                {{--                        dataTable.reload({page: {curr: 1}});--}}
                {{--                        // obj.del();--}}
                {{--                    })--}}
                {{--                } else {--}}
                {{--                    layer.msg(res.msg, {icon: 2})--}}
                {{--                }--}}
                {{--            });--}}
                {{--        })--}}
                {{--    } else {--}}
                {{--        layer.msg('请选择删除项', {icon: 2});--}}
                {{--    }--}}
                {{--})--}}
            })
        </script>
    @endcan
@endsection
