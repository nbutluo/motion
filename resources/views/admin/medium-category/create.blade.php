@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加资源分类</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.medium.category.add')}}" method="post" >
                @include('admin.medium-category._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.medium-category._js')
@endsection
