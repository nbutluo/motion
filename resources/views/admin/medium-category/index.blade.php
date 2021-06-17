@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">
{{--                @can('company.profile.destory')--}}
{{--                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删 除</button>--}}
{{--                @endcan--}}
                @can('medium.category.create')
                    <a class="layui-btn layui-btn-sm" href="{{route('admin.medium.category.create')}}">添 加</a>
                @endcan
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('medium.category.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
{{--                    @can('medium.category.destory')--}}
{{--                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">禁用</a>--}}
{{--                    @endcan--}}
                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('medium.category.list')
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
                    , url: "{{ route('admin.medium.category.index.data') }}" //数据接口
                    , page: true //开启分页
                    , cols: [[ //表头
                        // {checkbox: true, fixed: true},
                        {field: 'id', title: 'ID', sort: true, width: 80}
                        , {field: 'name', title: '分类名称', width: 200}
                        , {field: 'parent_id', title: '父级分类', width: 280}
                        , {field: 'media_type', title: '资源类型', width: 280, templet: function (res) {
                            $type = '未分配';
                            switch (res.media_type) {
                                case 1: $type = '图片'; break;
                                case 2: $type = '视频'; break;
                                case 3: $type = '宣传册'; break;
                                case 4: $type = '安装信息'; break;
                                case 5: $type = '资质认证'; break;
                                default:break;
                            }
                            return $type;
                        }}
                        , {field: 'is_active', title: '是否启用', templet: function (res) {return (res.is_active == 0) ? "否" : "是";}}
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
                        {{--layer.confirm('确认禁用吗？', function (index) {--}}
                        {{--    layer.close(index);--}}
                        {{--    var load = layer.load();--}}
                        {{--    $.post("{{ route('admin.company.profile.destory') }}", {--}}
                        {{--        _method: 'delete',--}}
                        {{--        ids: [data.id]--}}
                        {{--    }, function (res) {--}}
                        {{--        layer.close(load);--}}
                        {{--        if (res.code == 0) {--}}
                        {{--            layer.msg(res.msg, {icon: 1}, function () {--}}
                        {{--                obj.del();--}}
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
                {{--            $.post("{{ route('admin.article.destroy') }}", {--}}
                {{--                _method: 'delete',--}}
                {{--                ids: ids--}}
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
                {{--        });--}}
                {{--    } else {--}}
                {{--        layer.msg('请选择删除项', {icon: 2})--}}
                {{--    }--}}
                {{--});--}}

                //搜索
                $("#searchBtn").click(function () {
                    var catId = $("#category_id").val();
                    var sku = $("#sku").val();
                    dataTable.reload({
                        where: {category_id: catId, sku: sku},
                        page: {curr: 1}
                    })
                })
            })
        </script>
    @endcan
@endsection
