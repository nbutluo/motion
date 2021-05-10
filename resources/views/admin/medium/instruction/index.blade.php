@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">
                <a class="layui-btn layui-btn-sm" href="{{route('admin.medium.source.create')}}">添 加</a>
            </div>
            <div class="layui-form">
                <div class="layui-input-inline" style="display: none">
                    <input type="text" name="media_type" id="media_type" class="layui-input" value="4" hidden>
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
                    , url: "{{ route('admin.medium.qcfile.data', ['media_type' => 4]) }}" //数据接口
                    , page: true //开启分页
                    , cols: [[ //表头
                        {checkbox: true, fixed: true}
                        , {field: 'id', title: 'ID', sort: true, width: 80}
                        , {field: 'title', title: '名称', width: 200}
                        , {field: 'description', title: '描述', width: 280}
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
                    var typeId = $("#media_type").val();
                    var title = $("#title").val();
                    dataTable.reload({
                        where: {media_type: typeId, title: title},
                        page: {curr: 1}
                    })
                })
            })
        </script>
    @endcan
@endsection
