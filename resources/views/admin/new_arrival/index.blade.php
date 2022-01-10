@extends('admin.base')

@section('content')
<div class="layui-card">
    <div class="layui-card-body">
        <table id="dataTable" lay-filter="dataTable"></table>
        <script type="text/html" id="options">
            <div class="layui-btn-group">
                <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
            </div>
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
            , url: "{{ route('admin.new_arrival.data') }}" //数据接口
            , cols: [[ //表头
                {checkbox: true, fixed: true}
                , {field: 'id', title: 'ID', sort: true, width: 80}
                , {field: 'name', title: '产品名称', width: 380}
                , {field: 'sku', title: 'sku'}
                , {field: 'is_active', title: '是否新品', templet: function (res) {return (res.is_new_arrival == 0) ? "否" : "是";}}
                , {field: 'new_arrival_order', title: '新品顺序'}
                , {field: 'updated_at', title: '更新时间'}
                , {fixed: 'right',title: '操作', width: 140, align: 'center', toolbar: '#options'}
            ]]
        });

          //监听工具条
          table.on('tool(dataTable)', function (obj) {
            var data = obj.data //获得当前行数据
                , layEvent = obj.event; //获得 lay-event 对应的值
            if (layEvent === 'edit') {
                location.href = "{{route('admin.new_arrival.edit',['product'=>'xxxx'])}}".replace(/xxxx/,data.id);
            }
        });
    })
</script>
@endcan
@endsection
