@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新banner</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.banner.update',['id'=>$id])}}" method="post">
                {{ method_field('post') }}
                @include('admin.banner._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.banner._js')
@endsection
