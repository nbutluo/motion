@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">
{{--                @can('information.article.destroy')--}}
{{--                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删 除</button>--}}
{{--                @endcan--}}
                <a class="layui-btn layui-btn-sm" href="{{route('admin.medium.source.create')}}">添 加</a>
            </div>
            <div class="layui-form">
                <div class="layui-input-inline">
                    <select name="media_type" lay-verify="required" id="category_id">
                        <option value="">请选择产品分类</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="title" id="title" placeholder="请输入资源名称" class="layui-input">
                </div>
                <button class="layui-btn" id="searchBtn">搜 索</button>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                        <a class="layui-btn layui-btn-sm" lay-event="download">资源下载</a>
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
                    , autoSort: false
                    , height: 500
                    , url: "{{ route('admin.medium.index.data') }}" //数据接口
                    , page: true //开启分页
                    , cols: [[ //表头
                        {checkbox: true, fixed: true}
                        , {field: 'id', title: 'ID', sort: true, width: 80}
                        , {field: 'title', title: '名称', width: 200}
                        , {field: 'description', title: '描述', width: 280}
                        , {field: 'media_type', title: '资源类型'}
                        , {field: 'media_url', title: '资源链接', width: 200}
                        , {field: 'is_active', title: '是否启用', templet: function (res) {return (res.is_active == 0) ? "否" : "是";}}
                        , {field: 'position', title: '位置权值'}
                        , {field: 'updated_at', title: '更新时间'}
                        , {fixed: 'right',title: '操作', width: 160, align: 'center', toolbar: '#options'}
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
                            {{--$.post("{{ route('admin.blog.article.disable') }}", {--}}
                            {{--    _method: 'delete',--}}
                            {{--    ids: [data.post_id]--}}
                            {{--}, function (res) {--}}
                            {{--    layer.close(load);--}}
                            {{--    if (res.code == 0) {--}}
                            {{--        layer.msg(res.msg, {icon: 1}, function () {--}}
                            {{--            // obj.del();--}}
                            {{--        })--}}
                            {{--    } else {--}}
                            {{--        layer.msg(res.msg, {icon: 2})--}}
                            {{--    }--}}
                            {{--});--}}
                        });
                    } else if (layEvent === 'edit') {
                        location.href = '/admin/medium/source/' + data.id + '/edit';
                    } else if (layEvent === 'download') {
                        console.log(data.id);
                        // alert(111);
                        // window.top.open = '/admin/medium/source/download/' + data.id;
                        window.location.href = '/admin/medium/source/download/' + data.id;
                        // window.top.location.href = '/admin/medium/source/download/' + data.id;
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
