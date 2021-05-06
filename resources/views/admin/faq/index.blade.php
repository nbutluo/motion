@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">
                @can('faq.info.create')
                    <a class="layui-btn layui-btn-sm" href="{{route('admin.faq.create')}}">添 加</a>
                @endcan
            </div>
            <div class="layui-form">
                <div class="layui-input-inline">
{{--                    <select name="category_id" lay-verify="required" id="category_id">--}}
{{--                        <option value="">请选择分类</option>--}}
{{--                        @foreach($categories as $category)--}}
{{--                            <option value="{{ $category->category_id }}">{{ $category->title }}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="title" id="title" placeholder="请输入答疑标题" class="layui-input">
                </div>
                <button class="layui-btn" id="searchBtn">搜 索</button>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('faq.info.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('faq.info.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">禁用</a>
                    @endcan
                </div>
            </script>
{{--            <script type="text/html" id="thumb">--}}
{{--                @{{#  if(d.thumb){ }}--}}
{{--                <a href="@{{d.thumb}}" target="_blank" title="点击查看">--}}
{{--                    <img src="@{{d.thumb}}" alt="" width="28" height="28">--}}
{{--                </a>--}}
{{--                @{{#  } }}--}}
{{--            </script>--}}
{{--            <script type="text/html" id="category">--}}
{{--                @{{ d.category.title }}--}}
{{--            </script>--}}
        </div>
    </div>
@endsection

@section('script')
    @can('faq.info')
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
                    , url: "{{ route('admin.faq.info.data') }}" //数据接口
                    , page: true //开启分页
                    , cols: [[ //表头
                        {checkbox: true, fixed: true}
                        , {field: 'id', title: 'ID', sort: true, width: 80}
                        , {field: 'user_id', title: '添加者'}
                        , {field: 'category_id', title: '所属分类', toolbar: '#category'}
                        , {field: 'product_id', title: '所属产品'}
                        , {field: 'title', title: '标题'}
                        , {field: 'short_content', title: '短描述', width: 100}
                        , {field: 'content', title: '正文'}
                        , {field: 'created_at', title: '创建时间'}
                        , {field: 'updated_at', title: '修改时间'}
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

                //搜索
                // $("#searchBtn").click(function () {
                //     var catId = $("#category_id").val();
                //     var title = $("#title").val();
                //     dataTable.reload({
                //         where: {category_id: catId, title: title},
                //         page: {curr: 1}
                //     })
                // })
            })
        </script>
    @endcan
@endsection
