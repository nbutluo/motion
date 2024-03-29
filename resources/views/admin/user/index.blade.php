@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
{{--                @can('system.user.destroy')--}}
{{--                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">DELETE</button>--}}
{{--                @endcan--}}
                @can('system.user.create')
                    <a class="layui-btn layui-btn-sm" href="{{route('admin.user.create')}}">create</a>
                @endcan
            </div>
        </div>

        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('system.user.role')
                        <a class="layui-btn layui-btn-sm" lay-event="role">角色</a>
                    @endcan
                    @can('system.user.permission')
                        <a class="layui-btn layui-btn-sm" lay-event="permission">权限</a>
                    @endcan
                    @can('system.user.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('system.user')
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
                    , url: "{{ route('admin.user.data') }}"
                    , page: true //开启分页
                    , cols: [[ //表头
                        {checkbox: true, fixed: true}
                        , {field: 'id', title: 'ID', sort: true, width: 80}
                        , {field: 'username', title: '用户名',sort: true}
                        , {field: 'nickname', title: '昵称'}
                        , {field: 'email', title: '邮箱'}
                        , {field: 'phone', title: '电话'}
                        , {field: 'deleted_at', title: '状态',sort: true, templet: function (res) {return (res.deleted_at != null) ? "已删除" : "正常";}}
                        , {field: 'created_at', title: '创建时间',sort: true}
                        , {field: 'updated_at', title: '更新时间',sort: true}
                        , {fixed: 'right',title: '操作', width: 320, align: 'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function (obj) { //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        , layEvent = obj.event; //获得 lay-event 对应的值
                    if (layEvent === 'del') {
                        layer.confirm('确认删除吗？', function (index) {
                            layer.close(index);
                            var load = layer.load();
                            $.post("{{ route('admin.user.destroy') }}", {
                                _method: 'delete',
                                ids: [data.id]
                            }, function (res) {
                                layer.close(load);
                                if (res.code == 0) {
                                    layer.msg(res.msg, {icon: 1});

                                    obj.del(); // 删除当前行
                                } else {
                                    layer.msg(res.msg, {icon: 2})
                                }
                            });
                        });
                    } else if (layEvent === 'edit') {
                        location.href = '/admin/user/' + data.id + '/edit';
                    } else if (layEvent === 'role') {
                        location.href = '/admin/user/' + data.id + '/role';
                    } else if (layEvent === 'permission') {
                        location.href = '/admin/user/' + data.id + '/permission';
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
                {{--            $.post("{{ route('admin.user.destroy') }}", {--}}
                {{--                _method: 'delete',--}}
                {{--                ids: [data.id]--}}
                {{--            }, function (res) {--}}
                {{--                layer.close(load);--}}
                {{--                if (res.code == 0) {--}}
                {{--                    layer.msg(res.msg, {icon: 1}, function () {--}}
                {{--                        dataTable.reload({page: {curr: 1}});--}}
                {{--                    })--}}
                {{--                } else {--}}
                {{--                    layer.msg(res.msg, {icon: 2})--}}
                {{--                }--}}
                {{--            });--}}
                {{--        })--}}
                {{--    } else {--}}
                {{--        layer.msg('请选择删除项', {icon: 2})--}}
                {{--    }--}}
                {{--})--}}
            })
        </script>
    @endcan
@endsection
