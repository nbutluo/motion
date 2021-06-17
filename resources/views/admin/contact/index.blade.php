@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">

            </div>
            <div class="layui-form">
                <div class="layui-input-inline">
                    <input type="text" name="name" id="name" placeholder="请输入名称" class="layui-input">
                </div>
                <div class="layui-input-inline">
                    <input type="text" name="email" id="email" placeholder="请输入邮箱" class="layui-input">
                </div>
                <button class="layui-btn" id="searchBtn">搜 索</button>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    <a class="layui-btn layui-btn-sm" lay-event="edit">查看</a>
{{--                    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>--}}
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
{{--    @can('contact.list')--}}
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
                    , url: "{{ route('admin.contact.data') }}"
                    , page: true //开启分页
                    , cols: [[ //表头
                        {checkbox: true, fixed: true}
                        , {field: 'id', title: 'ID', sort: true, width: 80}
                        , {field: 'name', title: '名称'}
                        , {field: 'email', title: '邮箱'}
                        , {field: 'phone', title: '联系方式'}
                        , {field: 'identity', title: '身份'}
                        , {field: 'remark', title: '留言内容'}
                        , {field: 'created_at', title: '提交时间'}
                        , {fixed: 'right', width: 140, align: 'center', toolbar: '#options'}
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
                        {{--    $.post("{{ route('admin.blog.article.disable') }}", {--}}
                        {{--        _method: 'delete',--}}
                        {{--        ids: [data.post_id]--}}
                        {{--    }, function (res) {--}}
                        {{--        layer.close(load);--}}
                        {{--        if (res.code == 0) {--}}
                        {{--            layer.msg(res.msg, {icon: 1}, function () {--}}
                        {{--                // obj.del();--}}
                        {{--            })--}}
                        {{--        } else {--}}
                        {{--            layer.msg(res.msg, {icon: 2})--}}
                        {{--        }--}}
                        {{--    });--}}
                        {{--});--}}
                    } else if (layEvent === 'edit') {
                        location.href = '/admin/contact/detail/' + data.id;
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

                // //搜索
                $("#searchBtn").click(function () {
                    var email = $("#email").val();
                    var name = $("#name").val();
                    dataTable.reload({
                        where: {email: email, name: name},
                        page: {curr: 1}
                    })
                })
            })
        </script>
{{--    @endcan--}}
@endsection
