@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>编辑订单</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.order.update',['id'=>$id])}}" method="post">
                {{ method_field('post') }}
                @include('admin.order._form')
            </form>
        </div>
    </div>
@endsection
