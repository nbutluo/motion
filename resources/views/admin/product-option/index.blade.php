@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">
                <a class="layui-btn layui-btn-sm" href="{{route('admin.catalog.option.create')}}">添 加</a>
            </div>
            <div class="layui-form">
                <div class="layui-input-inline">
                    <input type="text" name="product_id" id="product_id" placeholder="请输入产品ID" class="layui-input">
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="title" id="sku" placeholder="请输入title" class="layui-input">
                </div>
                <button class="layui-btn" id="searchBtn">搜 索</button>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
{{--                    @can('information.article.destroy')--}}
{{--                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">禁用</a>--}}
{{--                    @endcan--}}
                </div>
            </script>
            <script type="text/html" id="thumb">
                @{{#  if(d.thumb){ }}
                <a href="@{{d.thumb}}" target="_blank" title="点击查看">
                    <img src="@{{d.thumb}}" alt="" width="28" height="28">
                </a>
                @{{#  } }}
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('catalog.option')
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
                    , url: "{{ route('admin.catalog.option.data') }}" //数据接口
                    , page: true //开启分页
                    , cols: [[ //表头
                        // {checkbox: true, fixed: true},
                        {field: 'id', title: 'ID', sort: true, width: 80}
                        , {field: 'sku', title: 'SKU', width: 200}
                        , {field: 'title', title: 'Title', width: 200}
                        , {field: 'type', title: '产品选项类型', width: 120, templet: function (res) {
                                $type_string = '未知';
                                // switch (res.type) {
                                //     case 1: $type_string = '桌板颜色'; break;
                                //     case 2: $type_string = 'size尺寸'; break;
                                //     case 3: $type_string = 'desk图片'; break;
                                //     default:break;
                                // }
                                if(res.type == 1) {
                                    $type_string = '桌板颜色';
                                }
                                if(res.type == 2) {
                                    $type_string = 'size尺寸';
                                }
                                if(res.type == 3) {
                                    $type_string = 'desk图片';
                                }
                                return $type_string;
                            }}
                        , {field: 'product_id', title: '所属产品ID', width: 100}
                        , {field: 'description', title: '描述', width: 120}
                        , {field: 'is_active', title: '是否启用', templet: function (res) {return (res.is_active == 0) ? "否" : "是";}}
                        , {field: 'sort_order', title: '位置权重'}
                        , {field: 'created_at', title: '创建时间'}
                        , {field: 'updated_at', title: '更新时间'}
                        , {fixed: 'right',title: '操作', width: 100, align: 'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function (obj) { //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        , layEvent = obj.event; //获得 lay-event 对应的值
                    if (layEvent === 'del') {
                        layer.confirm('确认禁用吗？', function (index) {
                            layer.close(index);
                            var load = layer.load();
                        });
                    } else if (layEvent === 'edit') {
                        location.href = '/admin/product/option/' + data.id + '/edit';
                    }
                });

                //搜索
                $("#searchBtn").click(function () {
                    var productId = $("#product_id").val();
                    var title = $("#title").val();
                    dataTable.reload({
                        where: {product_id: productId, title: title},
                        page: {curr: 1}
                    })
                })
            })
        </script>
    @endcan
@endsection
