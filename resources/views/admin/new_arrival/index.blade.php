@extends('admin.base')

@section('content')
<div class="layui-card">
    <div class="layui-card-body">
        <table id="dataTable" lay-filter="dataTable"></table>
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
                , {field: 'is_active', title: '是否启用', templet: function (res) {return (res.is_active == 0) ? "否" : "是";}}
                , {field: 'is_active', title: '是否新品', templet: function (res) {return (res.is_new_arrival == 0) ? "否" : "是";}}
                , {field: 'updated_at', title: '更新时间'}
            ]]
        });
    })
</script>
@endcan
@endsection
