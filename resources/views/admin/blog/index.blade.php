@extends('admin.base')

@section('content')
<div class="layui-card">
    <div class="layui-card-header layuiadmin-card-header-auto">
        <div class="layui-btn-group ">
            {{--                @can('information.article.destroy')--}}
            {{--                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删 除</button>--}}
            {{--                @endcan--}}
            @can('information.article.create')
            <a class="layui-btn layui-btn-sm" href="{{route('admin.blog.article.create')}}">添 加</a>
            @endcan
        </div>
        <div class="layui-form">
            <div class="layui-input-inline">
                <select name="category_id" lay-verify="required" id="category_id">
                    <option value="">请选择分类</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->category_id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="layui-input-inline">
                <input type="text" name="title" id="title" placeholder="请输入文章标题" class="layui-input">
            </div>
            <button class="layui-btn" id="searchBtn">搜 索</button>
        </div>
    </div>
    <div class="layui-card-body">
        <table id="dataTable" lay-filter="dataTable"></table>
        <script type="text/html" id="options">
            <div class="layui-btn-group">
                @can('information.article.edit')
                <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                @endcan
                @can('information.article.destroy')
                <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">禁用</a>
                @endcan
            </div>
        </script>
        <script type="text/html" id="thumb">
            @{{#  if(d.thumb){ }}
            <a href="@{{d.thumb}}" target="_blank" title="点击查看">
                <img src="@{{d.thumb}}" alt="" width="28" height="28">
            </a>
            @{{#  } }}
        </script>
        <script type="text/html" id="category">
            @{{ d.category.title }}
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
                    , autoSort: true
                    , height: 500
                    , url: "{{ route('admin.blog.article.data') }}" //数据接口
                    , page: true //开启分页
                    , cols: [[ //表头
                        {checkbox: true, fixed: true}
                        , {field: 'post_id', title: 'ID', sort: true, width: 80}
                        , {field: 'category_id', title: '分类'}
                        , {field: 'title', title: '标题'}
                        , {field: 'identifier', title: '标识', toolbar: '#thumb', width: 100}
                        , {field: 'keywords', title: '关键词'}
                        , {field: 'is_active', title: '是否启用', templet: function (res) {return (res.is_active == 0) ? "否" : "是";}}
                        , {field: 'show_in_home', title: '首页显示', width: 250, templet: function (res) {return (res.show_in_home == 0) ? "否" : "是";}}
                        // , {field: 'views_count', title: '浏览量'}
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
                        layer.confirm('确认禁用吗？', function (index) {
                            layer.close(index);
                            var load = layer.load();
                            $.post("{{ route('admin.blog.article.disable') }}", {
                                _method: 'delete',
                                ids: [data.post_id]
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
                        location.href = '/admin/blog/' + data.post_id + '/edit';
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
                    var title = $("#title").val();
                    dataTable.reload({
                        where: {category_id: catId, title: title},
                        page: {curr: 1}
                    })
                })
            })
</script>
@endcan
@endsection
