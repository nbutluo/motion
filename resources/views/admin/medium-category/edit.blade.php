@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新资源分类</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.medium.category.update',['id'=>$id])}}" method="post">
                {{ method_field('post') }}
                @include('admin.medium-category._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.medium-category._js')
@endsection
