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
{{--                        @foreach($categories as $category)--}}
{{--                            <option value="{{ $category->id }}">{{ $category->name }}</option>--}}
{{--                        @endforeach--}}
                        @foreach($categoryData as $category)
                            <option value="{{ $category['id'] }}" disabled>{{ $category['title'] }}</option>
                            @if (isset($category['children']) && !empty($category['children']))
                                @foreach($category['children'] as $firstCategory)
                                    <option value="{{ $firstCategory['id'] }}" disabled>-----{{ $firstCategory['title'] }}</option>
                                    @if (isset($firstCategory['children']) && !empty($firstCategory['children']))
                                        @foreach($firstCategory['children'] as $secondCategory)
                                            <option value="{{ $secondCategory['id'] }}" >----------{{ $secondCategory['title'] }}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="title" id="title" placeholder="请输入完整资源名称" class="layui-input">
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
    @can('medium.list')
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
                    , url: "{{ route('admin.medium.index.data') }}" //数据接口
                    , page: true //开启分页
                    , cols: [[ //表头
                        {checkbox: true, fixed: true}
                        , {field: 'id', title: 'ID', sort: true,width:80,}
                        , {field: 'title', title: '名称',width:200,}
                        , {field: 'description', title: '描述',width:200,}
                        , {field: 'category_id', title: '资源分类',width:200,}
                        , {field: 'media_type', title: '资源类型', templet: function (res) {
                                $type_string = '未知';
                                switch (res.media_type) {
                                    case 1: $type_string = '图片'; break;
                                    case 2: $type_string = '视频'; break;
                                    case 3: $type_string = '宣传册'; break;
                                    case 4: $type_string = '安装信息'; break;
                                    case 5: $type_string = '资质认证'; break;
                                    default:break;
                                }
                            return $type_string;
                        }}
                        , {field: 'media_url', title: '图片链接', width: 100}
                        , {field: 'media_links', title: '文件链接', width: 100}
                        , {field: 'is_active', title: '是否启用',width:100, templet: function (res) {return (res.is_active == 0) ? "否" : "是";}}
                        , {field: 'position', title: '位置权值',width:100,}
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
                        // 后台直接下载方式
                        window.location.href = '/admin/medium/source/download/' + data.id;
                    }
                });

                //搜索
                $("#searchBtn").click(function () {
                    var typeId = $(".layui-anim-upbit").find('.layui-this').attr('lay-value');
                    var title = $("#title").val();
                    dataTable.reload({
                        where: {category_id: typeId, title: title},
                        page: {curr: 1}
                    })
                })
            })
        </script>
    @endcan
@endsection
