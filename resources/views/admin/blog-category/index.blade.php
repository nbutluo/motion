@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @can('information.category.create')
                    <a class="layui-btn layui-btn-sm" href="{{route('admin.blog.category.create')}}" >添 加</a>
                @endcan
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('information.category.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('information.category.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">禁用</a>
                    @endcan
                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('information.category')
        <script>
            layui.use(['layer', 'table', 'form'], function () {
                var $ = layui.jquery;
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    , autoSort: false
                    , height: 500
                    , url: "{{ route('admin.blog.category.data') }}"
                    , page: true //开启分页
                    , cols: [[ //表头
                        {field: 'category_id', title: 'ID', sort: true}
                        , {field: 'title', title: '名称'}
                        , {field: 'position', title: '序号'}
                        , {field: 'is_active', title: '是否启用', templet: function (res) {return (res.is_active == 0) ? "否" : "是";}}
                        , {field: 'created_at', title: '创建时间'}
                        , {field: 'updated_at', title: '更新时间'}
                        , {fixed: 'right',title: '操作', width: 260, align: 'center', toolbar: '#options'}
                    ]],
                    //数据渲染完的回调
                    // done: function () {
                    //     //关闭加载
                    //     layer.closeAll('loading');
                    // }

                });
                // dataTable(); //调用此函数可重新渲染表格

                //监听工具条
                table.on('tool(dataTable)', function (obj) { //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        , layEvent = obj.event; //获得 lay-event 对应的值
                    if (layEvent === 'del') {
                        layer.confirm('确认禁用吗？', function (index) {
                            layer.close(index);
                            var load = layer.load();
                            $.post("{{ route('admin.blog.category.disable') }}", {
                                _method: 'delete',
                                ids: [data.category_id]
                            }, function (res) {
                                layer.close(load);
                                if (res.code == 0) {
                                    layer.msg(res.msg, {icon: 1}, function () {
                                        // obj.del();
                                    })
                                } else {
                                    layer.msg(res.msg, {icon: 2})
                                }
                            });
                        });
                    } else if (layEvent === 'edit') {
                        location.href = '/admin/blog/category/' + data.category_id + '/edit';
                    }
                });
            })
        </script>
    @endcan
@endsection
