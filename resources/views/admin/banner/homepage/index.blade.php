@extends('admin.base')

@section('content')
<div class="layui-card">
    <div class="layui-card-header layuiadmin-card-header-auto">
        <div class="layui-btn-group ">
            @can('banner.list.create')
            <a class="layui-btn layui-btn-sm" href="{{route('admin.homepage_banner.create')}}">添 加</a>
            @endcan
        </div>
    </div>
    <div class="layui-card-body">
        <table id="dataTable" lay-filter="dataTable"></table>
        <script type="text/html" id="options">
            <div class="layui-btn-group">
                @can('banner.list.edit')
                <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                <a class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del">删除</a>
                @endcan
            </div>
        </script>
    </div>
</div>
@endsection

@section('script')
@can('banner.list')
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
                    , url: "{{ route('admin.homepage_banner.list') }}" //数据接口
                    , page: true //开启分页
                    , cols: [[ //表头
                        // {checkbox: true, fixed: true},
                        {field: 'id', title: 'ID', sort: true, width: 80}
                        , {field: 'description', title: '描述'}
                        , {field: 'banner_alt', title: '图片alt'}
                        , {field: 'order', title: '排序',width: 80}
                        , {field: 'link_url', title: '跳转链接'}
                        , {field: 'is_active', title: '是否启用',width: 100,
                            templet: function (res) {
                                return (res.is_active == 0) ? "否" : "是";
                            }
                        }
                        , {field: 'created_at', title: '创建时间'}
                        , {field: 'updated_at', title: '修改时间'}
                        , {fixed: 'right',title: '操作', width: 150, align: 'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function (obj) { //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if (layEvent === 'del') {
                        layer.confirm('确认删除吗？', function (index) {
                            console.log(data.id);
                            layer.close(index);
                            $.ajax({
                                type: "post",
                                url: "{{route('admin.homepage_banner.delete',['banner'=>'xxxx'])}}".replace(/xxxx/,data.id),
                                data:{"_token": "{{ csrf_token() }}","_method": "DELETE" },
                                dataType: "json",
                                success: function (res) {
                                        if (res.code == 1) {
                                        layer.msg(res.msg, {icon: 1});
                                        setTimeout(() => {
                                            location.reload();
                                        }, 1000);
                                    } else {
                                        layer.alert(res.msg, {icon: 2});
                                    }
                                }
                            });
                        });
                    } else if (layEvent === 'edit') {
                        location.href = "{{route('admin.homepage_banner.edit',['banner'=>'xxxx'])}}".replace(/xxxx/,data.id);
                    }
                });
            });
</script>
@endcan
@endsection
