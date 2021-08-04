@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">
                @can('customer.create')
                    <a class="layui-btn layui-btn-sm" href="{{route('admin.customer.create')}}">添 加</a>
                @endcan
            </div>
            <div class="layui-form">
{{--                <div class="layui-input-inline">--}}
{{--                    <select name="user_level" lay-verify="required" id="user_level">--}}
{{--                        <option value="">请选择用户等级</option>--}}
{{--                            <option value="0">普通用户</option>--}}
{{--                            <option value="1">一级用户</option>--}}
{{--                            <option value="2">二级用户</option>--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--                <div class="layui-input-inline">--}}
{{--                    <input type="text" name="username" id="username" placeholder="请输入用户名" class="layui-input">--}}
{{--                </div>--}}
{{--                <button class="layui-btn" id="searchBtn">搜 索</button>--}}
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('customer.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
{{--                    @can('customer.destory')--}}
{{--                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">禁用</a>--}}
{{--                    @endcan--}}
                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('customer.list')
        <script>
            layui.use(['layer', 'table', 'form'], function () {
                // var $ = layui.jquery;
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    , autoSort: true
                    , height: 500
                    , url: "{{ route('admin.customer.data') }}" //数据接口
                    , page: true //开启分页
                    , cols: [[ //表头
                        // {checkbox: true, fixed: true},
                        {field: 'id', title: 'ID', sort: true,width:60}
                        , {field: 'username', title: '用户名'}
                        , {field: 'nickname', title: '昵称'}
                        , {field: 'user_level', title: '用户等级',width:100, templet: function (res) {
                            $level = '普通用户';
                            if (res.user_level == 1) {
                                $level = '一级用户';
                            }
                            if (res.user_level == 2) {
                                $level = '二级用户';
                            }
                            return $level;
                        }}
                        , {field: 'avatar', title: '头像',width:100,templet:function(res){
                            return '<div onclick="show_img(this)"><img src="/'+res.avatar+'" alt="" width="60px" height="60px"></div>';
                            }}
                        , {field: 'country', title: '国家'}
                        , {field: 'sex', title: '性别',width:60, templet: function (res) {return (res.sex == 0) ? "女" : "男";}}
                        , {field: 'phone', title: '电话',width:120}
                        , {field: 'salesman', title: '业务员',width:280}
                        , {field: 'created_at', title: '创建时间'}
                        , {field: 'updated_at', title: '更新时间'}
                        , {fixed: 'right',title: '操作', width: 140, align: 'center', toolbar: '#options'}
                    ]]
                    , id: 'customer'
                });

                //监听工具条
                table.on('tool(dataTable)', function (obj) { //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        , layEvent = obj.event; //获得 lay-event 对应的值
                    if (layEvent === 'del') {
                        {{--layer.confirm('确认禁用吗？', function (index) {--}}
                        {{--    layer.close(index);--}}
                        {{--    var load = layer.load();--}}
                        {{--    $.post("{{ route('admin.customer.destory') }}", {--}}
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
            });
            //点击放发图片
            function show_img(t) {
                var t = $(t).find("img");
                //页面层
                layer.open({
                    type: 1,
                    skin: 'layui-layer-rim', //加上边框
                    area: ['80%', '80%'], //宽高
                    shadeClose: true, //开启遮罩关闭
                    end: function (index, layero) {
                        return false;
                    },
                    content: '<div style="text-align:center"><img src="' + $(t).attr('src') + '" /></div>'
                });
            }
        </script>
    @endcan
@endsection
