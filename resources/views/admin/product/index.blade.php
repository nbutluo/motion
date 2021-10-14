@extends('admin.base')

@section('content')
<div class="layui-card">
    <div class="layui-card-header layuiadmin-card-header-auto">
        <div class="layui-btn-group ">
            {{--                @can('information.article.destroy')--}}
            {{--                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删 除</button>--}}
            {{--                @endcan--}}
            <a class="layui-btn layui-btn-sm" href="{{route('admin.catalog.product.create')}}">添 加</a>
        </div>
        <div class="layui-form">
            <div class="layui-input-inline">
                <select name="category_id" lay-verify="required" id="category_id">
                    <option value="">请选择产品分类</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="layui-input-inline">
                <input type="text" name="sku" id="sku" placeholder="请输入SKU" class="layui-input">
            </div>
            <button class="layui-btn" id="searchBtn">搜 索</button>
        </div>
    </div>
    <div class="layui-card-body">
        <table id="dataTable" lay-filter="dataTable"></table>
        <script type="text/html" id="options">
            <div class="layui-btn-group">
                <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                <a class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del">删除</a>
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
@can('catalog.product')
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
            , url: "{{ route('admin.catalog.product.data') }}" //数据接口
            , page: true //开启分页
            , cols: [[ //表头
                {checkbox: true, fixed: true}
                , {field: 'id', title: 'ID', sort: true, width: 80}
                , {field: 'sku', title: 'SKU'}
                , {field: 'name', title: '产品名称', width: 300}
                , {field: 'category_id', title: '所属分类',width: 150}
                , {field: 'short_description', title: '短描述', width: 200}
                , {field: 'is_active', title: '是否启用', width: 100,templet: function (res) {return (res.is_active == 0) ? "否" : "是";}}
                , {field: 'is_new_arrival', title: '新品', width: 80,templet: function (res) {return (res.is_new_arrival == 1) ? '是' : '';}}
                , {field: 'position', title: '位置权重',width: 90}
                , {field: 'created_at', title: '创建时间',width: 160,}
                , {field: 'updated_at', title: '更新时间',width: 170,}
                , {fixed: 'right',title: '操作', width: 140, align: 'center', toolbar: '#options'}
            ]]
        });

        //监听工具条
        table.on('tool(dataTable)', function (obj) { //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
            var data = obj.data //获得当前行数据
                , layEvent = obj.event; //获得 lay-event 对应的值
            if (layEvent === 'del') {
                layer.confirm('确认删除吗？', function (index) {
                    layer.close(index);
                    $.ajax({
                        type: "post",
                        url: "/admin/product/" + data.id,
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
                location.href = '/admin/product/detail/' + data.id + '/edit';
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
