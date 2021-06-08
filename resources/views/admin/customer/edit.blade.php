@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新Customer</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.customer.update',['id'=>$id])}}" method="post">
                {{ method_field('post') }}
                @include('admin.customer._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.customer._js')
@endsection
